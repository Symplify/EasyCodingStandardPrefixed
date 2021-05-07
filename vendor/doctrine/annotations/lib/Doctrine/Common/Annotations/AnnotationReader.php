<?php

namespace ECSPrefix20210507\Doctrine\Common\Annotations;

use ECSPrefix20210507\Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use ECSPrefix20210507\Doctrine\Common\Annotations\Annotation\Target;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use function array_merge;
use function class_exists;
use function extension_loaded;
use function ini_get;
/**
 * A reader for docblock annotations.
 */
class AnnotationReader implements \ECSPrefix20210507\Doctrine\Common\Annotations\Reader
{
    /**
     * Global map for imports.
     *
     * @var array<string, class-string>
     */
    private static $globalImports = ['ignoreannotation' => \ECSPrefix20210507\Doctrine\Common\Annotations\Annotation\IgnoreAnnotation::class];
    /**
     * A list with annotations that are not causing exceptions when not resolved to an annotation class.
     *
     * The names are case sensitive.
     *
     * @var array<string, true>
     */
    private static $globalIgnoredNames = \ECSPrefix20210507\Doctrine\Common\Annotations\ImplicitlyIgnoredAnnotationNames::LIST;
    /**
     * A list with annotations that are not causing exceptions when not resolved to an annotation class.
     *
     * The names are case sensitive.
     *
     * @var array<string, true>
     */
    private static $globalIgnoredNamespaces = [];
    /**
     * Add a new annotation to the globally ignored annotation names with regard to exception handling.
     *
     * @param string $name
     */
    public static function addGlobalIgnoredName($name)
    {
        self::$globalIgnoredNames[$name] = \true;
    }
    /**
     * Add a new annotation to the globally ignored annotation namespaces with regard to exception handling.
     *
     * @param string $namespace
     */
    public static function addGlobalIgnoredNamespace($namespace)
    {
        self::$globalIgnoredNamespaces[$namespace] = \true;
    }
    /**
     * Annotations parser.
     *
     * @var DocParser
     */
    private $parser;
    /**
     * Annotations parser used to collect parsing metadata.
     *
     * @var DocParser
     */
    private $preParser;
    /**
     * PHP parser used to collect imports.
     *
     * @var PhpParser
     */
    private $phpParser;
    /**
     * In-memory cache mechanism to store imported annotations per class.
     *
     * @psalm-var array<'class'|'function', array<string, array<string, class-string>>>
     */
    private $imports = [];
    /**
     * In-memory cache mechanism to store ignored annotations per class.
     *
     * @psalm-var array<'class'|'function', array<string, array<string, true>>>
     */
    private $ignoredAnnotationNames = [];
    /**
     * Initializes a new AnnotationReader.
     *
     * @throws AnnotationException
     * @param \ECSPrefix20210507\Doctrine\Common\Annotations\DocParser|null $parser
     */
    public function __construct($parser = null)
    {
        if (extension_loaded('Zend Optimizer+') && (ini_get('zend_optimizerplus.save_comments') === '0' || ini_get('opcache.save_comments') === '0')) {
            throw \ECSPrefix20210507\Doctrine\Common\Annotations\AnnotationException::optimizerPlusSaveComments();
        }
        if (extension_loaded('Zend OPcache') && ini_get('opcache.save_comments') === 0) {
            throw \ECSPrefix20210507\Doctrine\Common\Annotations\AnnotationException::optimizerPlusSaveComments();
        }
        // Make sure that the IgnoreAnnotation annotation is loaded
        class_exists(IgnoreAnnotation::class);
        $this->parser = $parser ?: new \ECSPrefix20210507\Doctrine\Common\Annotations\DocParser();
        $this->preParser = new \ECSPrefix20210507\Doctrine\Common\Annotations\DocParser();
        $this->preParser->setImports(self::$globalImports);
        $this->preParser->setIgnoreNotImportedAnnotations(\true);
        $this->preParser->setIgnoredAnnotationNames(self::$globalIgnoredNames);
        $this->phpParser = new \ECSPrefix20210507\Doctrine\Common\Annotations\PhpParser();
    }
    /**
     * {@inheritDoc}
     * @param \ReflectionClass $class
     */
    public function getClassAnnotations($class)
    {
        $this->parser->setTarget(Target::TARGET_CLASS);
        $this->parser->setImports($this->getImports($class));
        $this->parser->setIgnoredAnnotationNames($this->getIgnoredAnnotationNames($class));
        $this->parser->setIgnoredAnnotationNamespaces(self::$globalIgnoredNamespaces);
        return $this->parser->parse($class->getDocComment(), 'class ' . $class->getName());
    }
    /**
     * {@inheritDoc}
     * @param \ReflectionClass $class
     */
    public function getClassAnnotation($class, $annotationName)
    {
        $annotations = $this->getClassAnnotations($class);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return $annotation;
            }
        }
        return null;
    }
    /**
     * {@inheritDoc}
     * @param \ReflectionProperty $property
     */
    public function getPropertyAnnotations($property)
    {
        $class = $property->getDeclaringClass();
        $context = 'property ' . $class->getName() . '::$' . $property->getName();
        $this->parser->setTarget(Target::TARGET_PROPERTY);
        $this->parser->setImports($this->getPropertyImports($property));
        $this->parser->setIgnoredAnnotationNames($this->getIgnoredAnnotationNames($class));
        $this->parser->setIgnoredAnnotationNamespaces(self::$globalIgnoredNamespaces);
        return $this->parser->parse($property->getDocComment(), $context);
    }
    /**
     * {@inheritDoc}
     * @param \ReflectionProperty $property
     */
    public function getPropertyAnnotation($property, $annotationName)
    {
        $annotations = $this->getPropertyAnnotations($property);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return $annotation;
            }
        }
        return null;
    }
    /**
     * {@inheritDoc}
     * @param \ReflectionMethod $method
     */
    public function getMethodAnnotations($method)
    {
        $class = $method->getDeclaringClass();
        $context = 'method ' . $class->getName() . '::' . $method->getName() . '()';
        $this->parser->setTarget(Target::TARGET_METHOD);
        $this->parser->setImports($this->getMethodImports($method));
        $this->parser->setIgnoredAnnotationNames($this->getIgnoredAnnotationNames($class));
        $this->parser->setIgnoredAnnotationNamespaces(self::$globalIgnoredNamespaces);
        return $this->parser->parse($method->getDocComment(), $context);
    }
    /**
     * {@inheritDoc}
     * @param \ReflectionMethod $method
     */
    public function getMethodAnnotation($method, $annotationName)
    {
        $annotations = $this->getMethodAnnotations($method);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return $annotation;
            }
        }
        return null;
    }
    /**
     * Gets the annotations applied to a function.
     *
     * @phpstan-return list<object> An array of Annotations.
     * @param \ReflectionFunction $function
     * @return mixed[]
     */
    public function getFunctionAnnotations($function)
    {
        $context = 'function ' . $function->getName();
        $this->parser->setTarget(Target::TARGET_FUNCTION);
        $this->parser->setImports($this->getImports($function));
        $this->parser->setIgnoredAnnotationNames($this->getIgnoredAnnotationNames($function));
        $this->parser->setIgnoredAnnotationNamespaces(self::$globalIgnoredNamespaces);
        return $this->parser->parse($function->getDocComment(), $context);
    }
    /**
     * Gets a function annotation.
     *
     * @return object|null The Annotation or NULL, if the requested annotation does not exist.
     * @param \ReflectionFunction $function
     * @param string $annotationName
     */
    public function getFunctionAnnotation($function, $annotationName)
    {
        $annotations = $this->getFunctionAnnotations($function);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return $annotation;
            }
        }
        return null;
    }
    /**
     * Returns the ignored annotations for the given class or function.
     *
     * @param ReflectionClass|ReflectionFunction $reflection
     *
     * @return mixed[]
     */
    private function getIgnoredAnnotationNames($reflection)
    {
        $type = $reflection instanceof ReflectionClass ? 'class' : 'function';
        $name = $reflection->getName();
        if (isset($this->ignoredAnnotationNames[$type][$name])) {
            return $this->ignoredAnnotationNames[$type][$name];
        }
        $this->collectParsingMetadata($reflection);
        return $this->ignoredAnnotationNames[$type][$name];
    }
    /**
     * Retrieves imports for a class or a function.
     *
     * @param ReflectionClass|ReflectionFunction $reflection
     *
     * @return mixed[]
     */
    private function getImports($reflection)
    {
        $type = $reflection instanceof ReflectionClass ? 'class' : 'function';
        $name = $reflection->getName();
        if (isset($this->imports[$type][$name])) {
            return $this->imports[$type][$name];
        }
        $this->collectParsingMetadata($reflection);
        return $this->imports[$type][$name];
    }
    /**
     * Retrieves imports for methods.
     *
     * @return array<string, class-string>
     * @param \ReflectionMethod $method
     */
    private function getMethodImports($method)
    {
        $class = $method->getDeclaringClass();
        $classImports = $this->getImports($class);
        $traitImports = [];
        foreach ($class->getTraits() as $trait) {
            if (!$trait->hasMethod($method->getName()) || $trait->getFileName() !== $method->getFileName()) {
                continue;
            }
            $traitImports = array_merge($traitImports, $this->phpParser->parseUseStatements($trait));
        }
        return array_merge($classImports, $traitImports);
    }
    /**
     * Retrieves imports for properties.
     *
     * @return array<string, class-string>
     * @param \ReflectionProperty $property
     */
    private function getPropertyImports($property)
    {
        $class = $property->getDeclaringClass();
        $classImports = $this->getImports($class);
        $traitImports = [];
        foreach ($class->getTraits() as $trait) {
            if (!$trait->hasProperty($property->getName())) {
                continue;
            }
            $traitImports = array_merge($traitImports, $this->phpParser->parseUseStatements($trait));
        }
        return array_merge($classImports, $traitImports);
    }
    /**
     * Collects parsing metadata for a given class or function.
     *
     * @param ReflectionClass|ReflectionFunction $reflection
     * @return void
     */
    private function collectParsingMetadata($reflection)
    {
        $type = $reflection instanceof ReflectionClass ? 'class' : 'function';
        $name = $reflection->getName();
        $ignoredAnnotationNames = self::$globalIgnoredNames;
        $annotations = $this->preParser->parse($reflection->getDocComment(), $type . ' ' . $name);
        foreach ($annotations as $annotation) {
            if (!$annotation instanceof IgnoreAnnotation) {
                continue;
            }
            foreach ($annotation->names as $annot) {
                $ignoredAnnotationNames[$annot] = \true;
            }
        }
        $this->imports[$type][$name] = array_merge(self::$globalImports, $this->phpParser->parseUseStatements($reflection), ['__NAMESPACE__' => $reflection->getNamespaceName(), 'self' => $name]);
        $this->ignoredAnnotationNames[$type][$name] = $ignoredAnnotationNames;
    }
}
