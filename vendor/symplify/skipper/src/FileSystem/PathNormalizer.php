<?php

declare (strict_types=1);
namespace Symplify\Skipper\FileSystem;

use _PhpScopera37d6fb0b1ab\Nette\Utils\Strings;
final class PathNormalizer
{
    /**
     * @var string
     * @see https://regex101.com/r/ZB2dFV/2
     */
    private const ONLY_ENDS_WITH_ASTERISK_REGEX = '#^[^*](.*?)\\*$#';
    /**
     * @var string
     * @see https://regex101.com/r/aVUDjM/2
     */
    private const ONLY_STARTS_WITH_ASTERISK_REGEX = '#^\\*(.*?)[^*]$#';
    /**
     * "value*" → "*value*"
     * "*value" → "*value*"
     */
    public function normalizeForFnmatch(string $path) : string
    {
        // ends with *
        if (\_PhpScopera37d6fb0b1ab\Nette\Utils\Strings::match($path, self::ONLY_ENDS_WITH_ASTERISK_REGEX)) {
            return '*' . $path;
        }
        // starts with *
        if (\_PhpScopera37d6fb0b1ab\Nette\Utils\Strings::match($path, self::ONLY_STARTS_WITH_ASTERISK_REGEX)) {
            return $path . '*';
        }
        if (\_PhpScopera37d6fb0b1ab\Nette\Utils\Strings::contains($path, '..')) {
            $path = \realpath($path);
            if ($path === \false) {
                return '';
            }
        }
        return $path;
    }
}
