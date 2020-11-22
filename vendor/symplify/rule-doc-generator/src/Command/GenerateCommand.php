<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Command;

use _PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputArgument;
use _PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputOption;
use _PhpScoperf3db63c305b2\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter;
use Symplify\RuleDocGenerator\ValueObject\Option;
use Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var DirectoryToMarkdownPrinter
     */
    private $directoryToMarkdownPrinter;
    public function __construct(\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter $directoryToMarkdownPrinter)
    {
        parent::__construct();
        $this->directoryToMarkdownPrinter = $directoryToMarkdownPrinter;
    }
    protected function configure() : void
    {
        $this->setDescription('Generated Markdown documentation based on documented rules found in directory');
        $this->addArgument(\Symplify\RuleDocGenerator\ValueObject\Option::PATHS, \_PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputArgument::REQUIRED | \_PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory of your project');
        $this->addOption(\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE, null, \_PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to output generated markdown file', \getcwd() . '/docs/rules_overview.md');
    }
    protected function execute(\_PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperf3db63c305b2\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument(\Symplify\RuleDocGenerator\ValueObject\Option::PATHS);
        $markdownFileContent = $this->directoryToMarkdownPrinter->print($paths);
        // dump markdown file
        $outputFilePath = (string) $input->getOption(\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE);
        $this->smartFileSystem->dumpFile($outputFilePath, $markdownFileContent);
        $outputFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($outputFilePath);
        $message = \sprintf('File "%s" was created', $outputFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
