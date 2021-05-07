<?php

namespace Symplify\SymplifyKernel\Console;

use ECSPrefix20210507\Symfony\Component\Console\Command\Command;
use Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use Symplify\PackageBuilder\Composer\PackageVersionProvider;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileSystem;
use Symplify\SymplifyKernel\Strings\StringsConverter;
final class ConsoleApplicationFactory
{
    /**
     * @var Command[]
     */
    private $commands = [];
    /**
     * @var StringsConverter
     */
    private $stringsConverter;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @param Command[] $commands
     * @param \Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider
     * @param \Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory
     * @param \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem
     */
    public function __construct(array $commands, $parameterProvider, $composerJsonFactory, $smartFileSystem)
    {
        $this->commands = $commands;
        $this->stringsConverter = new StringsConverter();
        $this->parameterProvider = $parameterProvider;
        $this->composerJsonFactory = $composerJsonFactory;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return \Symplify\SymplifyKernel\Console\AutowiredConsoleApplication
     */
    public function create()
    {
        $autowiredConsoleApplication = new \Symplify\SymplifyKernel\Console\AutowiredConsoleApplication($this->commands);
        $this->decorateApplicationWithNameAndVersion($autowiredConsoleApplication);
        return $autowiredConsoleApplication;
    }
    /**
     * @return void
     * @param \Symplify\SymplifyKernel\Console\AutowiredConsoleApplication $autowiredConsoleApplication
     */
    private function decorateApplicationWithNameAndVersion($autowiredConsoleApplication)
    {
        $projectDir = $this->parameterProvider->provideStringParameter('kernel.project_dir');
        $packageComposerJsonFilePath = $projectDir . \DIRECTORY_SEPARATOR . 'composer.json';
        if (!$this->smartFileSystem->exists($packageComposerJsonFilePath)) {
            return;
        }
        // name
        $composerJson = $this->composerJsonFactory->createFromFilePath($packageComposerJsonFilePath);
        $shortName = $composerJson->getShortName();
        if ($shortName === null) {
            return;
        }
        $projectName = $this->stringsConverter->dashedToCamelCaseWithGlue($shortName, ' ');
        $autowiredConsoleApplication->setName($projectName);
        // version
        $packageName = $composerJson->getName();
        if ($packageName === null) {
            return;
        }
        $packageVersionProvider = new PackageVersionProvider();
        $version = $packageVersionProvider->provide($packageName);
        $autowiredConsoleApplication->setVersion($version);
    }
}
