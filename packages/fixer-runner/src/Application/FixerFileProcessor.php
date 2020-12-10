<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\FixerRunner\Application;

use PhpCsFixer\Differ\DifferInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\EasyCodingStandard\Application\AbstractFileProcessor;
use Symplify\EasyCodingStandard\Configuration\Configuration;
use Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle;
use Symplify\EasyCodingStandard\Error\ErrorAndDiffCollector;
use Symplify\EasyCodingStandard\FixerRunner\Exception\Application\FixerFailedException;
use Symplify\EasyCodingStandard\FixerRunner\Parser\FileToTokensParser;
use Symplify\Skipper\Skipper\Skipper;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
use Throwable;
/**
 * @see \Symplify\EasyCodingStandard\Tests\Error\ErrorCollector\FixerFileProcessorTest
 */
final class FixerFileProcessor extends \Symplify\EasyCodingStandard\Application\AbstractFileProcessor
{
    /**
     * @var string[]
     */
    private const MARKDOWN_EXCLUDED_FIXERS = [\PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer::class, \PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class, \PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer::class, \PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer::class, \PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer::class];
    /**
     * @var class-string[]
     */
    private $appliedFixers = [];
    /**
     * @var FixerInterface[]
     */
    private $fixers = [];
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    /**
     * @var Skipper
     */
    private $skipper;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var FileToTokensParser
     */
    private $fileToTokensParser;
    /**
     * @var DifferInterface
     */
    private $differ;
    /**
     * @var EasyCodingStandardStyle
     */
    private $easyCodingStandardStyle;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @param FixerInterface[] $fixers
     */
    public function __construct(\Symplify\EasyCodingStandard\Error\ErrorAndDiffCollector $errorAndDiffCollector, \Symplify\EasyCodingStandard\Configuration\Configuration $configuration, \Symplify\EasyCodingStandard\FixerRunner\Parser\FileToTokensParser $fileToTokensParser, \Symplify\Skipper\Skipper\Skipper $skipper, \PhpCsFixer\Differ\DifferInterface $differ, \Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle $easyCodingStandardStyle, \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, array $fixers = [])
    {
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->skipper = $skipper;
        $this->configuration = $configuration;
        $this->fileToTokensParser = $fileToTokensParser;
        $this->differ = $differ;
        $this->fixers = $this->sortFixers($fixers);
        $this->easyCodingStandardStyle = $easyCodingStandardStyle;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return FixerInterface[]
     */
    public function getCheckers() : array
    {
        return $this->fixers;
    }
    public function processFile(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $tokens = $this->fileToTokensParser->parseFromFilePath($smartFileInfo->getRealPath());
        $this->appliedFixers = [];
        foreach ($this->fixers as $fixer) {
            if ($this->shouldSkipForMarkdownHeredocCheck($fixer)) {
                continue;
            }
            $this->processTokensByFixer($smartFileInfo, $tokens, $fixer);
        }
        $contents = $smartFileInfo->getContents();
        if ($this->appliedFixers === []) {
            return $contents;
        }
        $diff = $this->differ->diff($contents, $tokens->generateCode());
        // some fixer with feature overlap can null each other
        if ($diff === '') {
            return $contents;
        }
        // file has changed
        $targetFileInfo = $this->resolveTargetFileInfo($smartFileInfo);
        $this->errorAndDiffCollector->addDiffForFileInfo($targetFileInfo, $diff, $this->appliedFixers);
        $tokenGeneratedCode = $tokens->generateCode();
        if ($this->configuration->isFixer()) {
            $this->smartFileSystem->dumpFile($smartFileInfo->getRealPath(), $tokenGeneratedCode);
        }
        \PhpCsFixer\Tokenizer\Tokens::clearCache();
        return $tokenGeneratedCode;
    }
    /**
     * @param FixerInterface[] $fixers
     * @return FixerInterface[]
     */
    private function sortFixers(array $fixers) : array
    {
        \usort($fixers, function (\PhpCsFixer\Fixer\FixerInterface $firstFixer, \PhpCsFixer\Fixer\FixerInterface $secondFixer) : int {
            return $secondFixer->getPriority() <=> $firstFixer->getPriority();
        });
        return $fixers;
    }
    private function processTokensByFixer(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \PhpCsFixer\Tokenizer\Tokens $tokens, \PhpCsFixer\Fixer\FixerInterface $fixer) : void
    {
        if ($this->shouldSkip($smartFileInfo, $fixer, $tokens)) {
            return;
        }
        // show current fixer in --debug / -vvv
        if ($this->easyCodingStandardStyle->isDebug()) {
            $this->easyCodingStandardStyle->writeln('     [fixer] ' . \get_class($fixer));
        }
        try {
            $fixer->fix($smartFileInfo, $tokens);
        } catch (\Throwable $throwable) {
            throw new \Symplify\EasyCodingStandard\FixerRunner\Exception\Application\FixerFailedException(\sprintf('Fixing of "%s" file by "%s" failed: %s in file %s on line %d', $smartFileInfo->getRelativeFilePath(), \get_class($fixer), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine()), $throwable->getCode(), $throwable);
        }
        if (!$tokens->isChanged()) {
            return;
        }
        $tokens->clearEmptyTokens();
        $tokens->clearChanged();
        $this->appliedFixers[] = \get_class($fixer);
    }
    private function shouldSkip(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \PhpCsFixer\Fixer\FixerInterface $fixer, \PhpCsFixer\Tokenizer\Tokens $tokens) : bool
    {
        if ($this->skipper->shouldSkipElementAndFileInfo($fixer, $smartFileInfo)) {
            return \true;
        }
        if (!$fixer->supports($smartFileInfo)) {
            return \true;
        }
        return !$fixer->isCandidate($tokens);
    }
    /**
     * Is markdown/herenow doc checker → skip useless rules
     */
    private function shouldSkipForMarkdownHeredocCheck(\PhpCsFixer\Fixer\FixerInterface $fixer) : bool
    {
        if ($this->currentParentFileInfoProvider->provide() === null) {
            return \false;
        }
        foreach (self::MARKDOWN_EXCLUDED_FIXERS as $markdownExcludedFixer) {
            if (\is_a($fixer, $markdownExcludedFixer, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
