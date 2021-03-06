<?php

declare (strict_types=1);
namespace ECSPrefix20210507;

use PhpCsFixer\Fixer\Alias\BacktickToShellExecFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use PhpCsFixer\Fixer\Alias\RandomApiMigrationFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use ECSPrefix20210507\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    \trigger_error('ECS set PHP_80_MIGRATION_RISKY is deprecated. Use more advanced and precise Rector instead (http://github.com/rectorphp/rector)');
    \sleep(3);
    $services = $containerConfigurator->services();
    $services->set(BacktickToShellExecFixer::class);
    $services->set(CombineNestedDirnameFixer::class);
    $services->set(DeclareStrictTypesFixer::class);
    $services->set(ImplodeCallFixer::class);
    $services->set(NoAliasFunctionsFixer::class)->call('configure', [['sets' => ['@all']]]);
    $services->set(NoUnneededFinalMethodFixer::class);
    $services->set(NonPrintableCharacterFixer::class)->call('configure', [['use_escape_sequences_in_strings' => \true]]);
    $services->set(PowToExponentiationFixer::class);
    $services->set(RandomApiMigrationFixer::class)->call('configure', [['replacements' => ['mt_rand' => 'random_int', 'rand' => 'random_int']]]);
    $services->set(VoidReturnFixer::class);
};
