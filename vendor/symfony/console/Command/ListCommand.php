<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperd47a2fa2a77e\Symfony\Component\Console\Command;

use _PhpScoperd47a2fa2a77e\Symfony\Component\Console\Helper\DescriptorHelper;
use _PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputArgument;
use _PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputOption;
use _PhpScoperd47a2fa2a77e\Symfony\Component\Console\Output\OutputInterface;
/**
 * ListCommand displays the list of all available commands for the application.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ListCommand extends \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Command\Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('list')->setDefinition([new \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputArgument('namespace', \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'The namespace name'), new \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputOption('raw', null, \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'To output raw command list'), new \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputOption('format', null, \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The output format (txt, xml, json, or md)', 'txt')])->setDescription('List commands')->setHelp(<<<'EOF'
The <info>%command.name%</info> command lists all commands:

  <info>%command.full_name%</info>

You can also display the commands for a specific namespace:

  <info>%command.full_name% test</info>

You can also output the information in other formats by using the <comment>--format</comment> option:

  <info>%command.full_name% --format=xml</info>

It's also possible to get raw list of commands (useful for embedding command runner):

  <info>%command.full_name% --raw</info>
EOF
);
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(\_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $helper = new \_PhpScoperd47a2fa2a77e\Symfony\Component\Console\Helper\DescriptorHelper();
        $helper->describe($output, $this->getApplication(), ['format' => $input->getOption('format'), 'raw_text' => $input->getOption('raw'), 'namespace' => $input->getArgument('namespace')]);
        return 0;
    }
}
