<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('AutoloadIncluder', false) && !interface_exists('AutoloadIncluder', false) && !trait_exists('AutoloadIncluder', false)) {
    spl_autoload_call('_PhpScoper85e989d55df2\AutoloadIncluder');
}
if (!class_exists('Composer\InstalledVersions', false) && !interface_exists('Composer\InstalledVersions', false) && !trait_exists('Composer\InstalledVersions', false)) {
    spl_autoload_call('_PhpScoper85e989d55df2\Composer\InstalledVersions');
}
if (!class_exists('ComposerAutoloaderInita43900a89b221416fa5529dc33d7b8b1', false) && !interface_exists('ComposerAutoloaderInita43900a89b221416fa5529dc33d7b8b1', false) && !trait_exists('ComposerAutoloaderInita43900a89b221416fa5529dc33d7b8b1', false)) {
    spl_autoload_call('_PhpScoper85e989d55df2\ComposerAutoloaderInita43900a89b221416fa5529dc33d7b8b1');
}
if (!class_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !interface_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !trait_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false)) {
    spl_autoload_call('_PhpScoper85e989d55df2\Symfony\Component\DependencyInjection\Extension\ExtensionInterface');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('_PhpScoper85e989d55df2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequirea43900a89b221416fa5529dc33d7b8b1')) {
    function composerRequirea43900a89b221416fa5529dc33d7b8b1() {
        return \_PhpScoper85e989d55df2\composerRequirea43900a89b221416fa5529dc33d7b8b1(...func_get_args());
    }
}
if (!function_exists('sample')) {
    function sample() {
        return \_PhpScoper85e989d55df2\sample(...func_get_args());
    }
}
if (!function_exists('foo')) {
    function foo() {
        return \_PhpScoper85e989d55df2\foo(...func_get_args());
    }
}
if (!function_exists('bar')) {
    function bar() {
        return \_PhpScoper85e989d55df2\bar(...func_get_args());
    }
}
if (!function_exists('baz')) {
    function baz() {
        return \_PhpScoper85e989d55df2\baz(...func_get_args());
    }
}
if (!function_exists('xyz')) {
    function xyz() {
        return \_PhpScoper85e989d55df2\xyz(...func_get_args());
    }
}
if (!function_exists('printPHPCodeSnifferTestOutput')) {
    function printPHPCodeSnifferTestOutput() {
        return \_PhpScoper85e989d55df2\printPHPCodeSnifferTestOutput(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \_PhpScoper85e989d55df2\setproctitle(...func_get_args());
    }
}
if (!function_exists('xdebug_info')) {
    function xdebug_info() {
        return \_PhpScoper85e989d55df2\xdebug_info(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \_PhpScoper85e989d55df2\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \_PhpScoper85e989d55df2\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \_PhpScoper85e989d55df2\dd(...func_get_args());
    }
}

return $loader;
