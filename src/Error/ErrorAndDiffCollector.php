<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Error;

use _PhpScopercda2b863d098\Nette\Utils\Strings;
use PHP_CodeSniffer\Sniffs\Sniff;
use PhpCsFixer\Fixer\FixerInterface;
use Symplify\EasyCodingStandard\ChangedFilesDetector\ChangedFilesDetector;
use Symplify\EasyCodingStandard\Exception\NotSniffNorFixerException;
use Symplify\EasyCodingStandard\SnippetFormatter\Provider\CurrentParentFileInfoProvider;
use Symplify\EasyCodingStandard\ValueObject\Error\CodingStandardError;
use Symplify\EasyCodingStandard\ValueObject\Error\FileDiff;
use Symplify\EasyCodingStandard\ValueObject\Error\SystemError;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ErrorAndDiffCollector
{
    /**
     * @var CodingStandardError[]
     */
    private $codingStandardErrors = [];
    /**
     * @var SystemError[]
     */
    private $systemErrors = [];
    /**
     * @var FileDiff[]
     */
    private $fileDiffs = [];
    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;
    /**
     * @var FileDiffFactory
     */
    private $fileDiffFactory;
    /**
     * @var ErrorFactory
     */
    private $errorFactory;
    /**
     * @var CurrentParentFileInfoProvider
     */
    private $currentParentFileInfoProvider;
    public function __construct(\Symplify\EasyCodingStandard\ChangedFilesDetector\ChangedFilesDetector $changedFilesDetector, \Symplify\EasyCodingStandard\Error\FileDiffFactory $fileDiffFactory, \Symplify\EasyCodingStandard\Error\ErrorFactory $errorFactory, \Symplify\EasyCodingStandard\SnippetFormatter\Provider\CurrentParentFileInfoProvider $currentParentFileInfoProvider)
    {
        $this->changedFilesDetector = $changedFilesDetector;
        $this->fileDiffFactory = $fileDiffFactory;
        $this->errorFactory = $errorFactory;
        $this->currentParentFileInfoProvider = $currentParentFileInfoProvider;
    }
    /**
     * @param class-string $sourceClass
     */
    public function addErrorMessage(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, int $line, string $message, string $sourceClass) : void
    {
        if ($this->currentParentFileInfoProvider->provide() !== null) {
            // skip sniff errors
            return;
        }
        $this->ensureIsFixerOrChecker($sourceClass);
        $this->changedFilesDetector->invalidateFileInfo($fileInfo);
        $codingStandardError = $this->errorFactory->create($line, $message, $sourceClass, $fileInfo);
        $this->codingStandardErrors[] = $codingStandardError;
    }
    public function addSystemErrorMessage(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, int $line, string $message) : void
    {
        $this->changedFilesDetector->invalidateFileInfo($smartFileInfo);
        $this->systemErrors[] = new \Symplify\EasyCodingStandard\ValueObject\Error\SystemError($line, $message, $smartFileInfo);
    }
    /**
     * @return CodingStandardError[]
     */
    public function getErrors() : array
    {
        return $this->codingStandardErrors;
    }
    /**
     * @return SystemError[]
     */
    public function getSystemErrors() : array
    {
        return $this->systemErrors;
    }
    /**
     * @param class-string[] $appliedCheckers
     */
    public function addDiffForFileInfo(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $diff, array $appliedCheckers) : void
    {
        $this->changedFilesDetector->invalidateFileInfo($smartFileInfo);
        foreach ($appliedCheckers as $appliedChecker) {
            $this->ensureIsFixerOrChecker($appliedChecker);
        }
        $this->fileDiffs[] = $this->fileDiffFactory->createFromDiffAndAppliedCheckers($smartFileInfo, $diff, $appliedCheckers);
    }
    /**
     * @return FileDiff[]
     */
    public function getFileDiffs() : array
    {
        return $this->fileDiffs;
    }
    /**
     * Used by external sniff/fixer testing classes
     */
    public function resetCounters() : void
    {
        $this->codingStandardErrors = [];
        $this->fileDiffs = [];
    }
    private function ensureIsFixerOrChecker(string $sourceClass) : void
    {
        // remove dot suffix of "."
        if (\_PhpScopercda2b863d098\Nette\Utils\Strings::contains($sourceClass, '.')) {
            $sourceClass = (string) \_PhpScopercda2b863d098\Nette\Utils\Strings::before($sourceClass, '.', 1);
        }
        if (\is_a($sourceClass, \PhpCsFixer\Fixer\FixerInterface::class, \true)) {
            return;
        }
        if (\is_a($sourceClass, \PHP_CodeSniffer\Sniffs\Sniff::class, \true)) {
            return;
        }
        $message = \sprintf('Source class "%s" must be "%s" or "%s"', $sourceClass, \PhpCsFixer\Fixer\FixerInterface::class, \PHP_CodeSniffer\Sniffs\Sniff::class);
        throw new \Symplify\EasyCodingStandard\Exception\NotSniffNorFixerException($message);
    }
}
