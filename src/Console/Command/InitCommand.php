<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Console\Command;

use _PhpScoperf053e888b664\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperf053e888b664\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\_PhpScoperf053e888b664\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperf053e888b664\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $rectorConfigFiles = $this->smartFileSystem->exists(\getcwd() . '/ecs.php');
        if (!$rectorConfigFiles) {
            $this->smartFileSystem->copy(__DIR__ . '/../../../ecs.php.dist', \getcwd() . '/ecs.php');
            $this->symfonyStyle->success('ecs.php config file has been generated successfully');
        } else {
            $this->symfonyStyle->error('Config file not generated. A ecs.php configuration file already exists');
        }
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
