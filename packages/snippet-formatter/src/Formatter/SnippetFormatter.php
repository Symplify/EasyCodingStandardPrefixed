<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\SnippetFormatter\Formatter;

use _PhpScoper8583deb8ab74\Nette\Utils\Strings;
use Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor;
use Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor;
use Symplify\EasyCodingStandard\SnippetFormatter\Provider\CurrentParentFileInfoProvider;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
use Throwable;
/**
 * @see \Symplify\EasyCodingStandard\SnippetFormatter\Tests\Markdown\MarkdownSnippetFormatterTest
 * @see \Symplify\EasyCodingStandard\SnippetFormatter\Tests\HeredocNowdoc\HereNowDocSnippetFormatterTest
 */
final class SnippetFormatter
{
    /**
     * @see https://regex101.com/r/MJTq5C/1
     * @var string
     */
    private const DECLARE_REGEX = '#(declare\\(strict\\_types\\=1\\)\\;\\n)#ms';
    /**
     * @see https://regex101.com/r/MJTq5C/3
     * @var string
     */
    private const OPENING_TAG_REGEX = '#^\\<\\?php\\n#ms';
    /**
     * @see https://regex101.com/r/MJTq5C/3
     * @var string
     */
    private const OPENING_TAG_HERENOWDOC_REGEX = '#^\\<\\?php\\n#ms';
    /**
     * @var string
     */
    private const CONTENT = 'content';
    /**
     * @var string
     */
    private const OPENING = 'opening';
    /**
     * @var string
     */
    private const CLOSING = 'closing';
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var FixerFileProcessor
     */
    private $fixerFileProcessor;
    /**
     * @var SniffFileProcessor
     */
    private $sniffFileProcessor;
    /**
     * @var CurrentParentFileInfoProvider
     */
    private $currentParentFileInfoProvider;
    /**
     * @var bool
     */
    private $isPhp73OrAbove = \false;
    public function __construct(\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor $fixerFileProcessor, \Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor $sniffFileProcessor, \Symplify\EasyCodingStandard\SnippetFormatter\Provider\CurrentParentFileInfoProvider $currentParentFileInfoProvider)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->fixerFileProcessor = $fixerFileProcessor;
        $this->sniffFileProcessor = $sniffFileProcessor;
        $this->currentParentFileInfoProvider = $currentParentFileInfoProvider;
        $this->isPhp73OrAbove = \PHP_VERSION_ID >= 70300;
    }
    public function format(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $snippetRegex, string $kind) : string
    {
        $this->currentParentFileInfoProvider->setParentFileInfo($fileInfo);
        return \_PhpScoper8583deb8ab74\Nette\Utils\Strings::replace($fileInfo->getContents(), $snippetRegex, function ($match) use($kind) : string {
            if (\_PhpScoper8583deb8ab74\Nette\Utils\Strings::contains($match[self::CONTENT], '-----')) {
                // do nothing
                return $match[self::OPENING] . $match[self::CONTENT] . $match[self::CLOSING];
            }
            return $this->fixContentAndPreserveFormatting($match, $kind);
        });
    }
    /**
     * @param string[] $match
     */
    private function fixContentAndPreserveFormatting(array $match, string $kind) : string
    {
        if ($this->isPhp73OrAbove) {
            return \str_replace(\PHP_EOL, '', $match[self::OPENING]) . \PHP_EOL . $this->fixContent($match[self::CONTENT], $kind) . \str_replace(\PHP_EOL, '', $match[self::CLOSING]);
        }
        return \rtrim($match[self::OPENING], \PHP_EOL) . \PHP_EOL . $this->fixContent($match[self::CONTENT], $kind) . \ltrim($match[self::CLOSING], \PHP_EOL);
    }
    private function fixContent(string $content, string $kind) : string
    {
        $content = $this->isPhp73OrAbove ? $content : \trim($content);
        $temporaryFilePath = $this->createTemporaryFilePath($content);
        if (!\_PhpScoper8583deb8ab74\Nette\Utils\Strings::startsWith($this->isPhp73OrAbove ? \trim($content) : $content, '<?php')) {
            $content = '<?php' . \PHP_EOL . $content;
        }
        $fileContent = $this->isPhp73OrAbove ? \ltrim($content, \PHP_EOL) : $content;
        $this->smartFileSystem->dumpFile($temporaryFilePath, $fileContent);
        $temporaryFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($temporaryFilePath);
        try {
            $this->fixerFileProcessor->processFile($temporaryFileInfo);
            $this->sniffFileProcessor->processFile($temporaryFileInfo);
            $fileContent = $temporaryFileInfo->getContents();
        } catch (\Throwable $throwable) {
            // Skipped parsed error when processing php temporaryFile
        } finally {
            // remove temporary temporaryFile
            $this->smartFileSystem->remove($temporaryFilePath);
        }
        $fileContent = \rtrim($fileContent, \PHP_EOL) . \PHP_EOL;
        if ($kind === 'markdown') {
            $fileContent = \ltrim($fileContent, \PHP_EOL);
            $fileContent = $this->removeOpeningTagAndStrictTypes($fileContent);
            return \ltrim($fileContent);
        }
        return \_PhpScoper8583deb8ab74\Nette\Utils\Strings::replace($fileContent, self::OPENING_TAG_HERENOWDOC_REGEX, '$1');
    }
    /**
     * It does not have any added value and only clutters the output
     */
    private function removeOpeningTagAndStrictTypes(string $content) : string
    {
        $content = \_PhpScoper8583deb8ab74\Nette\Utils\Strings::replace($content, self::DECLARE_REGEX, '');
        return $this->removeOpeningTag($content);
    }
    private function createTemporaryFilePath(string $content) : string
    {
        $key = \md5($content);
        $fileName = \sprintf('php-code-%s.php', $key);
        return \sys_get_temp_dir() . \DIRECTORY_SEPARATOR . 'ecs_temp' . \DIRECTORY_SEPARATOR . $fileName;
    }
    private function removeOpeningTag(string $fileContent) : string
    {
        return \_PhpScoper8583deb8ab74\Nette\Utils\Strings::replace($fileContent, self::OPENING_TAG_REGEX, '$1');
    }
}
