<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Console\Command;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Console\ConfigurationResolver;
use PhpCsFixer\Console\Output\ErrorOutput;
use PhpCsFixer\Console\Output\NullOutput;
use PhpCsFixer\Console\Output\ProcessOutput;
use PhpCsFixer\Error\ErrorsManager;
use PhpCsFixer\Report\ReportSummary;
use PhpCsFixer\Runner\Runner;
use PhpCsFixer\ToolInfoInterface;
use _PhpScopere015d8a3273c\Symfony\Component\Console\Command\Command;
use _PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputArgument;
use _PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption;
use _PhpScopere015d8a3273c\Symfony\Component\Console\Output\ConsoleOutputInterface;
use _PhpScopere015d8a3273c\Symfony\Component\Console\Output\OutputInterface;
use _PhpScopere015d8a3273c\Symfony\Component\Console\Terminal;
use _PhpScopere015d8a3273c\Symfony\Component\EventDispatcher\EventDispatcher;
use _PhpScopere015d8a3273c\Symfony\Component\EventDispatcher\EventDispatcherInterface;
use _PhpScopere015d8a3273c\Symfony\Component\Stopwatch\Stopwatch;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class FixCommand extends \_PhpScopere015d8a3273c\Symfony\Component\Console\Command\Command
{
    protected static $defaultName = 'fix';
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var ErrorsManager
     */
    private $errorsManager;
    /**
     * @var Stopwatch
     */
    private $stopwatch;
    /**
     * @var ConfigInterface
     */
    private $defaultConfig;
    /**
     * @var ToolInfoInterface
     */
    private $toolInfo;
    public function __construct(\PhpCsFixer\ToolInfoInterface $toolInfo)
    {
        parent::__construct();
        $this->defaultConfig = new \PhpCsFixer\Config();
        $this->errorsManager = new \PhpCsFixer\Error\ErrorsManager();
        $this->eventDispatcher = new \_PhpScopere015d8a3273c\Symfony\Component\EventDispatcher\EventDispatcher();
        $this->stopwatch = new \_PhpScopere015d8a3273c\Symfony\Component\Stopwatch\Stopwatch();
        $this->toolInfo = $toolInfo;
    }
    /**
     * {@inheritdoc}
     *
     * Override here to only generate the help copy when used.
     */
    public function getHelp()
    {
        return \PhpCsFixer\Console\Command\HelpCommand::getHelpCopy();
    }
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDefinition([new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputArgument('path', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'The path.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('path-mode', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Specify path mode (can be override or intersection).', 'override'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('allow-risky', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Are risky fixers allowed (can be yes or no).'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('config', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The path to a .php_cs file.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('dry-run', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Only shows which files would have been modified.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('rules', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The rules.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('using-cache', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Does cache should be used (can be yes or no).'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('cache-file', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The path to the cache file.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('diff', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Also produce diff for each file.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('diff-format', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Specify diff format.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('format', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'To output results in other formats.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('stop-on-violation', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Stop execution on first violation.'), new \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption('show-progress', '', \_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Type of progress indicator (none, run-in, estimating, estimating-max or dots).')])->setDescription('Fixes a directory or a file.');
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(\_PhpScopere015d8a3273c\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopere015d8a3273c\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $verbosity = $output->getVerbosity();
        $passedConfig = $input->getOption('config');
        $passedRules = $input->getOption('rules');
        $resolver = new \PhpCsFixer\Console\ConfigurationResolver($this->defaultConfig, ['allow-risky' => $input->getOption('allow-risky'), 'config' => $passedConfig, 'dry-run' => $input->getOption('dry-run'), 'rules' => $passedRules, 'path' => $input->getArgument('path'), 'path-mode' => $input->getOption('path-mode'), 'using-cache' => $input->getOption('using-cache'), 'cache-file' => $input->getOption('cache-file'), 'format' => $input->getOption('format'), 'diff' => $input->getOption('diff'), 'diff-format' => $input->getOption('diff-format'), 'stop-on-violation' => $input->getOption('stop-on-violation'), 'verbosity' => $verbosity, 'show-progress' => $input->getOption('show-progress')], \getcwd(), $this->toolInfo);
        $reporter = $resolver->getReporter();
        $stdErr = $output instanceof \_PhpScopere015d8a3273c\Symfony\Component\Console\Output\ConsoleOutputInterface ? $output->getErrorOutput() : ('txt' === $reporter->getFormat() ? $output : null);
        if (null !== $stdErr) {
            if (null !== $passedConfig && null !== $passedRules) {
                if (\getenv('PHP_CS_FIXER_FUTURE_MODE')) {
                    throw new \RuntimeException('Passing both `config` and `rules` options is not possible. This check was performed as `PHP_CS_FIXER_FUTURE_MODE` env var is set.');
                }
                $stdErr->writeln([\sprintf($stdErr->isDecorated() ? '<bg=yellow;fg=black;>%s</>' : '%s', 'When passing both "--config" and "--rules" the rules within the configuration file are not used.'), \sprintf($stdErr->isDecorated() ? '<bg=yellow;fg=black;>%s</>' : '%s', 'Passing both options is deprecated; version v3.0 PHP-CS-Fixer will exit with a configuration error code.')]);
            }
            $configFile = $resolver->getConfigFile();
            $stdErr->writeln(\sprintf('Loaded config <comment>%s</comment>%s.', $resolver->getConfig()->getName(), null === $configFile ? '' : ' from "' . $configFile . '"'));
            if ($resolver->getUsingCache()) {
                $cacheFile = $resolver->getCacheFile();
                if (\is_file($cacheFile)) {
                    $stdErr->writeln(\sprintf('Using cache file "%s".', $cacheFile));
                }
            }
        }
        $progressType = $resolver->getProgress();
        $finder = $resolver->getFinder();
        if (null !== $stdErr && $resolver->configFinderIsOverridden()) {
            $stdErr->writeln(\sprintf($stdErr->isDecorated() ? '<bg=yellow;fg=black;>%s</>' : '%s', 'Paths from configuration file have been overridden by paths provided as command arguments.'));
        }
        // @TODO 3.0 remove `run-in` and `estimating`
        if ('none' === $progressType || null === $stdErr) {
            $progressOutput = new \PhpCsFixer\Console\Output\NullOutput();
        } elseif ('run-in' === $progressType) {
            $progressOutput = new \PhpCsFixer\Console\Output\ProcessOutput($stdErr, $this->eventDispatcher, null, null);
        } else {
            $finder = new \ArrayIterator(\iterator_to_array($finder));
            $progressOutput = new \PhpCsFixer\Console\Output\ProcessOutput($stdErr, $this->eventDispatcher, 'estimating' !== $progressType ? (new \_PhpScopere015d8a3273c\Symfony\Component\Console\Terminal())->getWidth() : null, \count($finder));
        }
        $runner = new \PhpCsFixer\Runner\Runner($finder, $resolver->getFixers(), $resolver->getDiffer(), 'none' !== $progressType ? $this->eventDispatcher : null, $this->errorsManager, $resolver->getLinter(), $resolver->isDryRun(), $resolver->getCacheManager(), $resolver->getDirectory(), $resolver->shouldStopOnViolation());
        $this->stopwatch->start('fixFiles');
        $changed = $runner->fix();
        $this->stopwatch->stop('fixFiles');
        $progressOutput->printLegend();
        $fixEvent = $this->stopwatch->getEvent('fixFiles');
        $reportSummary = new \PhpCsFixer\Report\ReportSummary($changed, $fixEvent->getDuration(), $fixEvent->getMemory(), \_PhpScopere015d8a3273c\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity(), $resolver->isDryRun(), $output->isDecorated());
        $output->isDecorated() ? $output->write($reporter->generate($reportSummary)) : $output->write($reporter->generate($reportSummary), \false, \_PhpScopere015d8a3273c\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
        $invalidErrors = $this->errorsManager->getInvalidErrors();
        $exceptionErrors = $this->errorsManager->getExceptionErrors();
        $lintErrors = $this->errorsManager->getLintErrors();
        if (null !== $stdErr) {
            $errorOutput = new \PhpCsFixer\Console\Output\ErrorOutput($stdErr);
            if (\count($invalidErrors) > 0) {
                $errorOutput->listErrors('linting before fixing', $invalidErrors);
            }
            if (\count($exceptionErrors) > 0) {
                $errorOutput->listErrors('fixing', $exceptionErrors);
            }
            if (\count($lintErrors) > 0) {
                $errorOutput->listErrors('linting after fixing', $lintErrors);
            }
        }
        $exitStatusCalculator = new \PhpCsFixer\Console\Command\FixCommandExitStatusCalculator();
        return $exitStatusCalculator->calculate($resolver->isDryRun(), \count($changed) > 0, \count($invalidErrors) > 0, \count($exceptionErrors) > 0, \count($lintErrors) > 0);
    }
}
