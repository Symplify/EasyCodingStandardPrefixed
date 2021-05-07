<?php

namespace Symplify\SmartFileSystem\Json;

use ECSPrefix20210507\Nette\Utils\Arrays;
use ECSPrefix20210507\Nette\Utils\Json;
use Symplify\SmartFileSystem\FileSystemGuard;
use Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Symplify\SmartFileSystem\Tests\Json\JsonFileSystem\JsonFileSystemTest
 */
final class JsonFileSystem
{
    /**
     * @var FileSystemGuard
     */
    private $fileSystemGuard;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @param \Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard
     * @param \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem
     */
    public function __construct($fileSystemGuard, $smartFileSystem)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return mixed[]
     * @param string $filePath
     */
    public function loadFilePathToJson($filePath)
    {
        $this->fileSystemGuard->ensureFileExists($filePath, __METHOD__);
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return Json::decode($fileContent, Json::FORCE_ARRAY);
    }
    /**
     * @param array<string, mixed> $jsonArray
     * @return void
     * @param string $filePath
     */
    public function writeJsonToFilePath(array $jsonArray, $filePath)
    {
        $jsonContent = Json::encode($jsonArray, Json::PRETTY) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
    }
    /**
     * @param array<string, mixed> $newJsonArray
     * @return void
     * @param string $filePath
     */
    public function mergeArrayToJsonFile($filePath, array $newJsonArray)
    {
        $jsonArray = $this->loadFilePathToJson($filePath);
        $newComposerJsonArray = Arrays::mergeTree($jsonArray, $newJsonArray);
        $this->writeJsonToFilePath($newComposerJsonArray, $filePath);
    }
}
