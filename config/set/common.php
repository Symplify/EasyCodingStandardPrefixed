<?php

declare (strict_types=1);
namespace _PhpScopera9d6a31d814c;

use _PhpScopera9d6a31d814c\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/common/*.php');
};
