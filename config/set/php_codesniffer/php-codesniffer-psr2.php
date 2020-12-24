<?php

declare (strict_types=1);
namespace _PhpScopera37d6fb0b1ab;

use PHP_CodeSniffer\Standards\Generic\Sniffs\ControlStructures\InlineControlStructureSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\ByteOrderMarkSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineEndingsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\DisallowMultipleStatementsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\FunctionCallArgumentSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseConstantSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseKeywordSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\DisallowTabIndentSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\ScopeIndentSniff;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\Functions\ValidDefaultValueSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Classes\PropertyDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ElseIfDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\SwitchDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Files\ClosingTagSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Files\EndFileNewlineSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\FunctionCallSignatureSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\FunctionClosingBraceSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\MethodDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Namespaces\NamespaceDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Namespaces\UseDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ControlSignatureSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForEachLoopDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForLoopDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\LowercaseDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\FunctionDeclarationArgumentSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\FunctionDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\LowercaseFunctionKeywordsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\MultiLineFunctionDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\MethodScopeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeClosingBraceSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeKeywordSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SuperfluousWhitespaceSniff;
use _PhpScopera37d6fb0b1ab\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
return static function (\_PhpScopera37d6fb0b1ab\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Namespaces\NamespaceDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Namespaces\UseDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Classes\ClassDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Classes\PropertyDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Files\EndFileNewlineSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Files\ClosingTagSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\SwitchDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ElseIfDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\FunctionCallSignatureSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\MethodDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\FunctionClosingBraceSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\Files\ByteOrderMarkSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineEndingsSniff::class)->property('eolChar', '\\n');
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SuperfluousWhitespaceSniff::class)->property('ignoreBlankLines', \true);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\DisallowMultipleStatementsSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\ScopeIndentSniff::class)->property('ignoreIndentationTokens', ['T_COMMENT', 'T_DOC_COMMENT_OPEN_TAG']);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\DisallowTabIndentSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseKeywordSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseConstantSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\MethodScopeSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeKeywordSpacingSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\FunctionDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\LowercaseFunctionKeywordsSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\FunctionDeclarationArgumentSpacingSniff::class)->property('equalsSpacing', 1);
    $services->set(\PHP_CodeSniffer\Standards\PEAR\Sniffs\Functions\ValidDefaultValueSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\MultiLineFunctionDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\FunctionCallArgumentSpacingSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ControlSignatureSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeClosingBraceSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForEachLoopDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForLoopDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\LowercaseDeclarationSniff::class);
    $services->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\ControlStructures\InlineControlStructureSniff::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::SKIP, [\PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff::class . '.SpacingAfterOpenBrace' => null, \PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff::class . '.SpaceBeforeCloseBrace' => null, \PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff::class . '.LineAfterClose' => null, \PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff::class . '.NoLineAfterClose' => null, \PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\FunctionCallSignatureSniff::class . '.OpeningIndent' => null]);
};
