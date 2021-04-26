<?php

declare (strict_types=1);
namespace _PhpScoper917c99b6aa4c;

use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SemicolonSpacingSniff;
use _PhpScoper917c99b6aa4c\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::LINE_ENDING, "\r\n");
    $services = $containerConfigurator->services();
    $services->set(SemicolonSpacingSniff::class);
};
