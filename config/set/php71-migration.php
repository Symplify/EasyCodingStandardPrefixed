<?php

declare (strict_types=1);
namespace _PhpScoper8a8080b03ed6;

use PhpCsFixer\Fixer\Alias\BacktickToShellExecFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use _PhpScoper8a8080b03ed6\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    \trigger_error('ECS set PHP_71_MIGRATION is deprecated. Use more advanced and precise Rector instead (http://github.com/rectorphp/rector)');
    \sleep(3);
    $services = $containerConfigurator->services();
    $services->set(TernaryToNullCoalescingFixer::class);
    $services->set(VisibilityRequiredFixer::class)->call('configure', [['elements' => ['const', 'method', 'property']]]);
    $services->set(BacktickToShellExecFixer::class);
};
