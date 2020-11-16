<?php

declare (strict_types=1);
namespace _PhpScoper4d05106cc3c0;

use _PhpScoper4d05106cc3c0\SebastianBergmann\Diff\Differ;
use _PhpScoper4d05106cc3c0\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper4d05106cc3c0\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use function _PhpScoper4d05106cc3c0\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper4d05106cc3c0\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper4d05106cc3c0\SebastianBergmann\Diff\Differ::class);
    $services->set(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoper4d05106cc3c0\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoper4d05106cc3c0\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
};
