<?php

declare (strict_types=1);
namespace _PhpScoperc75fd40d7a6e;

use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use _PhpScoperc75fd40d7a6e\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
return static function (\_PhpScoperc75fd40d7a6e\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/php_cs_fixer/php-cs-fixer-psr2.php');
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer::class);
    $services->set(\PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer::class);
    $services->set(\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer::class);
    $services->set(\PhpCsFixer\Fixer\Import\OrderedImportsFixer::class)->call('configure', [['importsOrder' => ['class', 'function', 'const']]]);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer::class)->call('configure', [['space' => 'none']]);
    $services->set(\PhpCsFixer\Fixer\Operator\NewWithBracesFixer::class);
    $services->set(\PhpCsFixer\Fixer\Basic\BracesFixer::class)->call('configure', [['allow_single_line_closure' => \false, 'position_after_functions_and_oop_constructs' => 'next', 'position_after_control_structures' => 'same', 'position_after_anonymous_constructs' => 'same']]);
    $services->set(\PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer::class);
    $services->set(\PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class)->call('configure', [['elements' => ['const', 'method', 'property']]]);
    $services->set(\PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer::class);
    $services->set(\PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer::class);
    $services->set(\PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer::class);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer::class);
    $services->set(\PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer::class);
    $services->set(\PhpCsFixer\Fixer\Operator\ConcatSpaceFixer::class)->call('configure', [['spacing' => 'one']]);
    $services->set(\PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer::class);
    $services->set(\PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer::class);
    $services->set(\PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::SKIP, [\PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer::class => null]);
};
