<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Finder;

use _PhpScoperb458b528613f\Symfony\Component\Finder\Finder;
use Symplify\EasyCodingStandard\Git\GitDiffProvider;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyCodingStandard\Tests\Finder\SourceFinderTest
 */
final class SourceFinder
{
    /**
     * @var string[]
     */
    private $fileExtensions = [];
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    /**
     * @var GitDiffProvider
     */
    private $gitDiffProvider;
    public function __construct(\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer, \Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Symplify\EasyCodingStandard\Git\GitDiffProvider $gitDiffProvider)
    {
        $this->finderSanitizer = $finderSanitizer;
        $this->fileExtensions = $parameterProvider->provideArrayParameter(\Symplify\EasyCodingStandard\ValueObject\Option::FILE_EXTENSIONS);
        $this->gitDiffProvider = $gitDiffProvider;
    }
    /**
     * @param string[] $source
     * @return SmartFileInfo[]
     */
    public function find(array $source, bool $doesMatchGitDiff = \false) : array
    {
        $fileInfos = [];
        foreach ($source as $singleSource) {
            if (\is_file($singleSource)) {
                $fileInfos[] = new \Symplify\SmartFileSystem\SmartFileInfo($singleSource);
            } else {
                $filesInDirectory = $this->processDirectory($singleSource);
                $fileInfos = \array_merge($fileInfos, $filesInDirectory);
            }
        }
        $fileInfos = $this->filterOutGitDiffFiles($fileInfos, $doesMatchGitDiff);
        \ksort($fileInfos);
        return $fileInfos;
    }
    /**
     * @return SmartFileInfo[]
     */
    private function processDirectory(string $directory) : array
    {
        $normalizedFileExtensions = $this->normalizeFileExtensions($this->fileExtensions);
        $finder = \_PhpScoperb458b528613f\Symfony\Component\Finder\Finder::create()->files()->name($normalizedFileExtensions)->in($directory)->exclude('vendor')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
    /**
     * @param string[] $fileExtensions
     * @return string[]
     */
    private function normalizeFileExtensions(array $fileExtensions) : array
    {
        $normalizedFileExtensions = [];
        foreach ($fileExtensions as $fileExtension) {
            $normalizedFileExtensions[] = '*.' . $fileExtension;
        }
        return $normalizedFileExtensions;
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     * @return SmartFileInfo[]
     */
    private function filterOutGitDiffFiles(array $fileInfos, bool $doesMatchGitDiff) : array
    {
        if (!$doesMatchGitDiff) {
            return $fileInfos;
        }
        $gitDiffFiles = $this->gitDiffProvider->provide();
        $fileInfos = \array_filter($fileInfos, function ($splFile) use($gitDiffFiles) : bool {
            return \in_array($splFile->getRealPath(), $gitDiffFiles, \true);
        });
        return \array_values($fileInfos);
    }
}
