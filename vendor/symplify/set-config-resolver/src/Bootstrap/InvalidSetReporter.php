<?php

namespace Symplify\SetConfigResolver\Bootstrap;

use ECSPrefix20210507\Nette\Utils\ObjectHelpers;
use ECSPrefix20210507\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use Symplify\SetConfigResolver\Exception\SetNotFoundException;
/**
 * @see \Symplify\SetConfigResolver\Tests\Bootstrap\InvalidSetReporterTest
 */
final class InvalidSetReporter
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct()
    {
        $symfonyStyleFactory = new SymfonyStyleFactory();
        $this->symfonyStyle = $symfonyStyleFactory->create();
    }
    /**
     * @return void
     * @param \Symplify\SetConfigResolver\Exception\SetNotFoundException $setNotFoundException
     */
    public function report($setNotFoundException)
    {
        $message = $setNotFoundException->getMessage();
        $suggestedSet = ObjectHelpers::getSuggestion($setNotFoundException->getAvailableSetNames(), $setNotFoundException->getSetName());
        if ($suggestedSet !== null) {
            $message .= \sprintf('. Did you mean "%s"?', $suggestedSet);
            $this->symfonyStyle->error($message);
        } elseif ($setNotFoundException->getAvailableSetNames() !== []) {
            $this->symfonyStyle->error($message);
            $this->symfonyStyle->note('Pick one of:');
            $this->symfonyStyle->listing($setNotFoundException->getAvailableSetNames());
        }
    }
}
