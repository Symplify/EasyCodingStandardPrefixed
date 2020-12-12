<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class RectorRuleCodeSamplePrinter implements \Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var DiffCodeSamplePrinter
     */
    private $diffCodeSamplePrinter;
    /**
     * @var MarkdownCodeWrapper
     */
    private $markdownCodeWrapper;
    /**
     * @var SmartPhpConfigPrinter
     */
    private $smartPhpConfigPrinter;
    public function __construct(\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter, \Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter $smartPhpConfigPrinter)
    {
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->smartPhpConfigPrinter = $smartPhpConfigPrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScoperef870243cfdb\\Rector\\Core\\Contract\\Rector\\RectorInterface', \true);
    }
    /**
     * @return string[]
     */
    public function print(\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample) {
            return $this->printExtraFileCodeSample($codeSample);
        }
        if ($codeSample instanceof \Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample) {
            return $this->printComposerJsonAwareCodeSample($codeSample);
        }
        if ($codeSample instanceof \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->printConfiguredCodeSample($ruleDefinition, $codeSample);
        }
        return $this->diffCodeSamplePrinter->print($codeSample);
    }
    /**
     * @return string[]
     */
    private function printConfiguredCodeSample(\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition, \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample) : array
    {
        $lines = [];
        $configPhpCode = $this->smartPhpConfigPrinter->printConfiguredServices([$ruleDefinition->getRuleClass() => $configuredCodeSample->getConfiguration()]);
        $lines[] = $this->markdownCodeWrapper->printPhpCode($configPhpCode);
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
    /**
     * @return string[]
     */
    private function printComposerJsonAwareCodeSample(\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample $composerJsonAwareCodeSample) : array
    {
        $lines = [];
        $lines[] = '- with `composer.json`:';
        $lines[] = $this->markdownCodeWrapper->printJsonCode($composerJsonAwareCodeSample->getComposerJson());
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($composerJsonAwareCodeSample);
        return \array_merge($lines, $newLines);
    }
    /**
     * @return string[]
     */
    private function printExtraFileCodeSample(\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample $extraFileCodeSample) : array
    {
        $lines = $this->diffCodeSamplePrinter->print($extraFileCodeSample);
        $lines[] = 'Extra file:';
        $lines[] = $this->markdownCodeWrapper->printPhpCode($extraFileCodeSample->getExtraFile());
        return $lines;
    }
}
