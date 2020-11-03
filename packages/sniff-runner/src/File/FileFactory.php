<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\SniffRunner\File;

use PHP_CodeSniffer\Fixer;
use Symplify\EasyCodingStandard\Application\AppliedCheckersCollector;
use Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle;
use Symplify\EasyCodingStandard\Error\ErrorAndDiffCollector;
use Symplify\EasyCodingStandard\SniffRunner\ValueObject\File;
use Symplify\Skipper\Skipper\Skipper;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyCodingStandard\SniffRunner\Tests\File\FileFactoryTest
 */
final class FileFactory
{
    /**
     * @var Fixer
     */
    private $fixer;
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    /**
     * @var Skipper
     */
    private $skipper;
    /**
     * @var AppliedCheckersCollector
     */
    private $appliedCheckersCollector;
    /**
     * @var EasyCodingStandardStyle
     */
    private $easyCodingStandardStyle;
    public function __construct(\PHP_CodeSniffer\Fixer $fixer, \Symplify\EasyCodingStandard\Error\ErrorAndDiffCollector $errorAndDiffCollector, \Symplify\Skipper\Skipper\Skipper $skipper, \Symplify\EasyCodingStandard\Application\AppliedCheckersCollector $appliedCheckersCollector, \Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle $easyCodingStandardStyle)
    {
        $this->fixer = $fixer;
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->skipper = $skipper;
        $this->appliedCheckersCollector = $appliedCheckersCollector;
        $this->easyCodingStandardStyle = $easyCodingStandardStyle;
    }
    public function createFromFileInfo(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \Symplify\EasyCodingStandard\SniffRunner\ValueObject\File
    {
        return new \Symplify\EasyCodingStandard\SniffRunner\ValueObject\File($smartFileInfo->getRelativeFilePath(), $smartFileInfo->getContents(), $this->fixer, $this->errorAndDiffCollector, $this->skipper, $this->appliedCheckersCollector, $this->easyCodingStandardStyle);
    }
}
