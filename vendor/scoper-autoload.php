<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('AutoloadIncluder', false) && !interface_exists('AutoloadIncluder', false) && !trait_exists('AutoloadIncluder', false)) {
    spl_autoload_call('_PhpScoper6b644dbe715d\AutoloadIncluder');
}
if (!class_exists('Composer\InstalledVersions', false) && !interface_exists('Composer\InstalledVersions', false) && !trait_exists('Composer\InstalledVersions', false)) {
    spl_autoload_call('_PhpScoper6b644dbe715d\Composer\InstalledVersions');
}
if (!class_exists('ComposerAutoloaderInit4dd73d03d7af16e08d23818afcd1e896', false) && !interface_exists('ComposerAutoloaderInit4dd73d03d7af16e08d23818afcd1e896', false) && !trait_exists('ComposerAutoloaderInit4dd73d03d7af16e08d23818afcd1e896', false)) {
    spl_autoload_call('_PhpScoper6b644dbe715d\ComposerAutoloaderInit4dd73d03d7af16e08d23818afcd1e896');
}
if (!class_exists('ValidatePEARPackageXML', false) && !interface_exists('ValidatePEARPackageXML', false) && !trait_exists('ValidatePEARPackageXML', false)) {
    spl_autoload_call('_PhpScoper6b644dbe715d\ValidatePEARPackageXML');
}
if (!class_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !interface_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !trait_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false)) {
    spl_autoload_call('_PhpScoper6b644dbe715d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('_PhpScoper6b644dbe715d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequire4dd73d03d7af16e08d23818afcd1e896')) {
    function composerRequire4dd73d03d7af16e08d23818afcd1e896() {
        return \_PhpScoper6b644dbe715d\composerRequire4dd73d03d7af16e08d23818afcd1e896(...func_get_args());
    }
}
if (!function_exists('sample')) {
    function sample() {
        return \_PhpScoper6b644dbe715d\sample(...func_get_args());
    }
}
if (!function_exists('foo')) {
    function foo() {
        return \_PhpScoper6b644dbe715d\foo(...func_get_args());
    }
}
if (!function_exists('bar')) {
    function bar() {
        return \_PhpScoper6b644dbe715d\bar(...func_get_args());
    }
}
if (!function_exists('baz')) {
    function baz() {
        return \_PhpScoper6b644dbe715d\baz(...func_get_args());
    }
}
if (!function_exists('xyz')) {
    function xyz() {
        return \_PhpScoper6b644dbe715d\xyz(...func_get_args());
    }
}
if (!function_exists('printPHPCodeSnifferTestOutput')) {
    function printPHPCodeSnifferTestOutput() {
        return \_PhpScoper6b644dbe715d\printPHPCodeSnifferTestOutput(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \_PhpScoper6b644dbe715d\setproctitle(...func_get_args());
    }
}
if (!function_exists('xdebug_info')) {
    function xdebug_info() {
        return \_PhpScoper6b644dbe715d\xdebug_info(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \_PhpScoper6b644dbe715d\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \_PhpScoper6b644dbe715d\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \_PhpScoper6b644dbe715d\dd(...func_get_args());
    }
}

return $loader;
