<?php

declare (strict_types=1);
namespace _PhpScoper807f8e74693b;

use PhpCsFixer\Differ\DifferInterface;
use PhpCsFixer\Differ\UnifiedDiffer;
use _PhpScoper807f8e74693b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor;
return static function (\_PhpScoper807f8e74693b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\EasyCodingStandard\\FixerRunner\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception', __DIR__ . '/../src/ValueObject']);
    $services->set(\PhpCsFixer\Differ\UnifiedDiffer::class);
    $services->alias(\PhpCsFixer\Differ\DifferInterface::class, \PhpCsFixer\Differ\UnifiedDiffer::class);
    $services->set(\Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor::class);
};
