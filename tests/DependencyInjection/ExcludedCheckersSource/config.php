<?php

declare (strict_types=1);
namespace _PhpScopera48d5dbb002d;

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use _PhpScopera48d5dbb002d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SKIP, [NoUnusedImportsFixer::class => null]);
    $services = $containerConfigurator->services();
    $services->set(NoUnusedImportsFixer::class);
};
