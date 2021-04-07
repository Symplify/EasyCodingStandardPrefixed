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
namespace PhpCsFixer\Console;

use PhpCsFixer\Console\Command\DescribeCommand;
use PhpCsFixer\Console\Command\FixCommand;
use PhpCsFixer\Console\Command\HelpCommand;
use PhpCsFixer\Console\Command\SelfUpdateCommand;
use PhpCsFixer\Console\SelfUpdate\GithubClient;
use PhpCsFixer\Console\SelfUpdate\NewVersionChecker;
use PhpCsFixer\PharChecker;
use PhpCsFixer\ToolInfo;
use _PhpScoper1ed8518cf1bf\Symfony\Component\Console\Application as BaseApplication;
use _PhpScoper1ed8518cf1bf\Symfony\Component\Console\Command\ListCommand;
use _PhpScoper1ed8518cf1bf\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper1ed8518cf1bf\Symfony\Component\Console\Output\ConsoleOutputInterface;
use _PhpScoper1ed8518cf1bf\Symfony\Component\Console\Output\OutputInterface;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class Application extends \_PhpScoper1ed8518cf1bf\Symfony\Component\Console\Application
{
    const VERSION = '2.18.5';
    const VERSION_CODENAME = 'Remote Void';
    /**
     * @var ToolInfo
     */
    private $toolInfo;
    public function __construct()
    {
        if (!\getenv('PHP_CS_FIXER_FUTURE_MODE')) {
            \error_reporting(\E_ALL & ~\E_DEPRECATED & ~\E_USER_DEPRECATED);
        }
        parent::__construct('PHP CS Fixer', self::VERSION);
        $this->toolInfo = new \PhpCsFixer\ToolInfo();
        $this->add(new \PhpCsFixer\Console\Command\DescribeCommand());
        $this->add(new \PhpCsFixer\Console\Command\FixCommand($this->toolInfo));
        $this->add(new \PhpCsFixer\Console\Command\SelfUpdateCommand(new \PhpCsFixer\Console\SelfUpdate\NewVersionChecker(new \PhpCsFixer\Console\SelfUpdate\GithubClient()), $this->toolInfo, new \PhpCsFixer\PharChecker()));
    }
    /**
     * @return int
     */
    public static function getMajorVersion()
    {
        return (int) \explode('.', self::VERSION)[0];
    }
    /**
     * {@inheritdoc}
     */
    public function doRun(\_PhpScoper1ed8518cf1bf\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper1ed8518cf1bf\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $stdErr = $output instanceof \_PhpScoper1ed8518cf1bf\Symfony\Component\Console\Output\ConsoleOutputInterface ? $output->getErrorOutput() : ($input->hasParameterOption('--format', \true) && 'txt' !== $input->getParameterOption('--format', null, \true) ? null : $output);
        if (null !== $stdErr) {
            $warningsDetector = new \PhpCsFixer\Console\WarningsDetector($this->toolInfo);
            $warningsDetector->detectOldVendor();
            $warningsDetector->detectOldMajor();
            foreach ($warningsDetector->getWarnings() as $warning) {
                $stdErr->writeln(\sprintf($stdErr->isDecorated() ? '<bg=yellow;fg=black;>%s</>' : '%s', $warning));
            }
        }
        return parent::doRun($input, $output);
    }
    /**
     * {@inheritdoc}
     */
    public function getLongVersion()
    {
        $version = \sprintf('%s <info>%s</info> by <comment>Fabien Potencier</comment> and <comment>Dariusz Ruminski</comment>', parent::getLongVersion(), self::VERSION_CODENAME);
        $commit = '@git-commit@';
        if ('@' . 'git-commit@' !== $commit) {
            $version .= ' (' . \substr($commit, 0, 7) . ')';
        }
        return $version;
    }
    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        return [new \PhpCsFixer\Console\Command\HelpCommand(), new \_PhpScoper1ed8518cf1bf\Symfony\Component\Console\Command\ListCommand()];
    }
}
