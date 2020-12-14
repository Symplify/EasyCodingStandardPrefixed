<?php

namespace _PhpScoper6224e3b16fcc\Doctrine\Tests\Common\Annotations;

use _PhpScoper6224e3b16fcc\Doctrine\Common\Annotations\SimpleAnnotationReader;
class SimpleAnnotationReaderTest extends \_PhpScoper6224e3b16fcc\Doctrine\Tests\Common\Annotations\AbstractReaderTest
{
    /**
     * Contrary to the behavior of the default annotation reader, we do just ignore
     * these in the simple annotation reader (so, no expected exception here).
     */
    public function testImportDetectsNotImportedAnnotation()
    {
        parent::testImportDetectsNotImportedAnnotation();
    }
    /**
     * Contrary to the behavior of the default annotation reader, we do just ignore
     * these in the simple annotation reader (so, no expected exception here).
     */
    public function testImportDetectsNonExistentAnnotation()
    {
        parent::testImportDetectsNonExistentAnnotation();
    }
    /**
     * Contrary to the behavior of the default annotation reader, we do just ignore
     * these in the simple annotation reader (so, no expected exception here).
     */
    public function testClassWithInvalidAnnotationTargetAtClassDocBlock()
    {
        parent::testClassWithInvalidAnnotationTargetAtClassDocBlock();
    }
    /**
     * Contrary to the behavior of the default annotation reader, we do just ignore
     * these in the simple annotation reader (so, no expected exception here).
     */
    public function testClassWithInvalidAnnotationTargetAtPropertyDocBlock()
    {
        parent::testClassWithInvalidAnnotationTargetAtPropertyDocBlock();
    }
    /**
     * Contrary to the behavior of the default annotation reader, we do just ignore
     * these in the simple annotation reader (so, no expected exception here).
     */
    public function testClassWithInvalidNestedAnnotationTargetAtPropertyDocBlock()
    {
        parent::testClassWithInvalidNestedAnnotationTargetAtPropertyDocBlock();
    }
    /**
     * Contrary to the behavior of the default annotation reader, we do just ignore
     * these in the simple annotation reader (so, no expected exception here).
     */
    public function testClassWithInvalidAnnotationTargetAtMethodDocBlock()
    {
        parent::testClassWithInvalidAnnotationTargetAtMethodDocBlock();
    }
    /**
     * @expectedException \Doctrine\Common\Annotations\AnnotationException
     */
    public function testInvalidAnnotationUsageButIgnoredClass()
    {
        parent::testInvalidAnnotationUsageButIgnoredClass();
    }
    public function testIncludeIgnoreAnnotation()
    {
        $this->markTestSkipped('The simplified annotation reader would always autoload annotations');
    }
    /**
     * @group DDC-1660
     * @group regression
     *
     * Contrary to the behavior of the default annotation reader, @version is not ignored
     */
    public function testInvalidAnnotationButIgnored()
    {
        $reader = $this->getReader();
        $class = new \ReflectionClass('_PhpScoper6224e3b16fcc\\Doctrine\\Tests\\Common\\Annotations\\Fixtures\\ClassDDC1660');
        $this->assertTrue(\class_exists('_PhpScoper6224e3b16fcc\\Doctrine\\Tests\\Common\\Annotations\\Fixtures\\Annotation\\Version'));
        $this->assertCount(1, $reader->getClassAnnotations($class));
        $this->assertCount(1, $reader->getMethodAnnotations($class->getMethod('bar')));
        $this->assertCount(1, $reader->getPropertyAnnotations($class->getProperty('foo')));
    }
    protected function getReader()
    {
        $reader = new \_PhpScoper6224e3b16fcc\Doctrine\Common\Annotations\SimpleAnnotationReader();
        $reader->addNamespace(__NAMESPACE__);
        $reader->addNamespace(__NAMESPACE__ . '\\Fixtures');
        $reader->addNamespace(__NAMESPACE__ . '\\Fixtures\\Annotation');
        return $reader;
    }
}
