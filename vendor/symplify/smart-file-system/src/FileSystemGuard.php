<?php

namespace Symplify\SmartFileSystem;

use Symplify\SmartFileSystem\Exception\DirectoryNotFoundException;
use Symplify\SmartFileSystem\Exception\FileNotFoundException;
final class FileSystemGuard
{
    /**
     * @return void
     * @param string $file
     * @param string $location
     */
    public function ensureFileExists($file, $location)
    {
        if (\file_exists($file)) {
            return;
        }
        throw new FileNotFoundException(\sprintf('File "%s" not found in "%s".', $file, $location));
    }
    /**
     * @return void
     * @param string $directory
     * @param string $extraMessage
     */
    public function ensureDirectoryExists($directory, $extraMessage = '')
    {
        if (\is_dir($directory) && \file_exists($directory)) {
            return;
        }
        $message = \sprintf('Directory "%s" was not found.', $directory);
        if ($extraMessage !== '') {
            $message .= ' ' . $extraMessage;
        }
        throw new DirectoryNotFoundException($message);
    }
}
