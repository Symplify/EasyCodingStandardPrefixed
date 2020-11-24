<?php

declare (strict_types=1);
namespace Symplify\Skipper\Skipper;

use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use Symplify\Skipper\FileSystem\PathNormalizer;
use Symplify\Skipper\ValueObject\Option;
use Symplify\Skipper\ValueObject\SkipRules;
use Symplify\Skipper\ValueObjectFactory\SkipRulesFactory;
use Symplify\SmartFileSystem\SmartFileInfo;
final class Skipper
{
    /**
     * @var string[]
     */
    private $excludedPaths = [];
    /**
     * @var mixed[]
     */
    private $only = [];
    /**
     * @var SkipRules
     */
    private $skipRules;
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    /**
     * @var ClassLikeExistenceChecker
     */
    private $classLikeExistenceChecker;
    public function __construct(\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Symplify\Skipper\ValueObjectFactory\SkipRulesFactory $skipRulesFactory, \Symplify\Skipper\FileSystem\PathNormalizer $pathNormalizer, \Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker)
    {
        $excludePaths = $parameterProvider->provideArrayParameter(\Symplify\Skipper\ValueObject\Option::EXCLUDE_PATHS);
        $this->skipRules = $skipRulesFactory->create();
        $this->only = $parameterProvider->provideArrayParameter(\Symplify\Skipper\ValueObject\Option::ONLY);
        $this->excludedPaths = $excludePaths;
        $this->pathNormalizer = $pathNormalizer;
        $this->classLikeExistenceChecker = $classLikeExistenceChecker;
    }
    public function shouldSkipElementAndFileInfo($element, \Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : bool
    {
        if (\is_object($element) || $this->classLikeExistenceChecker->doesClassLikeExist($element)) {
            return $this->shouldSkipClassAndFile($element, $fileInfo);
        }
        return \false;
    }
    public function shouldSkipCodeAndFile(string $code, \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return $this->shouldSkipMatchingRuleAndFile($this->skipRules->getSkippedCodes(), $code, $smartFileInfo);
    }
    public function shouldSkipMessageAndFile(string $message, \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return $this->shouldSkipMatchingRuleAndFile($this->skipRules->getSkippedMessages(), $message, $smartFileInfo);
    }
    public function shouldSkipFileInfo(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        foreach ($this->excludedPaths as $excludedPath) {
            if ($this->doesFileMatchPattern($smartFileInfo, $excludedPath)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param object|string $class
     */
    private function shouldSkipClassAndFile($class, \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $doesMatchOnly = $this->doesMatchOnly($class, $smartFileInfo);
        if (\is_bool($doesMatchOnly)) {
            return $doesMatchOnly;
        }
        return $this->doesMatchSkipped($class, $smartFileInfo);
    }
    private function shouldSkipMatchingRuleAndFile(array $skipped, string $key, \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        if (!\array_key_exists($key, $skipped)) {
            return \false;
        }
        // skip regardless the path
        $skippedPaths = $skipped[$key];
        if ($skippedPaths === null) {
            return \true;
        }
        return $this->doesFileMatchSkippedFiles($smartFileInfo, $skippedPaths);
    }
    /**
     * @param object|string $checker
     */
    private function doesMatchOnly($checker, \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?bool
    {
        foreach ($this->only as $onlyClass => $onlyFiles) {
            if (!\is_a($checker, $onlyClass, \true)) {
                continue;
            }
            foreach ($onlyFiles as $onlyFile) {
                if ($this->doesFileMatchPattern($smartFileInfo, $onlyFile)) {
                    return \false;
                }
            }
            return \true;
        }
        return null;
    }
    /**
     * @param object|string $checker
     */
    private function doesMatchSkipped($checker, \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        foreach ($this->skipRules->getSkippedClasses() as $skippedClass => $skippedFiles) {
            if (!\is_a($checker, $skippedClass, \true)) {
                continue;
            }
            // skip everywhere
            if (!\is_array($skippedFiles)) {
                return \true;
            }
            if ($this->doesFileMatchSkippedFiles($smartFileInfo, $skippedFiles)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Supports both relative and absolute $file path.
     * They differ for PHP-CS-Fixer and PHP_CodeSniffer.
     */
    private function doesFileMatchPattern(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $ignoredPath) : bool
    {
        // in ecs.php, the path can be absolute
        if ($smartFileInfo->getRealPath() === $ignoredPath) {
            return \true;
        }
        $ignoredPath = $this->pathNormalizer->normalizeForFnmatch($ignoredPath);
        if ($ignoredPath === "") {
            return \false;
        }
        return $smartFileInfo->endsWith($ignoredPath) || $smartFileInfo->doesFnmatch($ignoredPath);
    }
    /**
     * @param string[] $skippedFiles
     */
    private function doesFileMatchSkippedFiles(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $skippedFiles) : bool
    {
        foreach ($skippedFiles as $skippedFile) {
            if ($this->doesFileMatchPattern($smartFileInfo, $skippedFile)) {
                return \true;
            }
        }
        return \false;
    }
}
