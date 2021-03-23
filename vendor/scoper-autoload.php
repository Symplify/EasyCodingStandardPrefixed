<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('AutoloadIncluder', false) && !interface_exists('AutoloadIncluder', false) && !trait_exists('AutoloadIncluder', false)) {
    spl_autoload_call('_PhpScoper356bfb655d08\AutoloadIncluder');
}
if (!class_exists('ComposerAutoloaderInitd269764ba6bd6d1ad92024f4e78a1e92', false) && !interface_exists('ComposerAutoloaderInitd269764ba6bd6d1ad92024f4e78a1e92', false) && !trait_exists('ComposerAutoloaderInitd269764ba6bd6d1ad92024f4e78a1e92', false)) {
    spl_autoload_call('_PhpScoper356bfb655d08\ComposerAutoloaderInitd269764ba6bd6d1ad92024f4e78a1e92');
}
if (!class_exists('ValidatePEARPackageXML', false) && !interface_exists('ValidatePEARPackageXML', false) && !trait_exists('ValidatePEARPackageXML', false)) {
    spl_autoload_call('_PhpScoper356bfb655d08\ValidatePEARPackageXML');
}
if (!class_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !interface_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !trait_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false)) {
    spl_autoload_call('_PhpScoper356bfb655d08\Symfony\Component\DependencyInjection\Extension\ExtensionInterface');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('_PhpScoper356bfb655d08\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequired269764ba6bd6d1ad92024f4e78a1e92')) {
    function composerRequired269764ba6bd6d1ad92024f4e78a1e92() {
        return \_PhpScoper356bfb655d08\composerRequired269764ba6bd6d1ad92024f4e78a1e92(...func_get_args());
    }
}
if (!function_exists('sample')) {
    function sample() {
        return \_PhpScoper356bfb655d08\sample(...func_get_args());
    }
}
if (!function_exists('foo')) {
    function foo() {
        return \_PhpScoper356bfb655d08\foo(...func_get_args());
    }
}
if (!function_exists('bar')) {
    function bar() {
        return \_PhpScoper356bfb655d08\bar(...func_get_args());
    }
}
if (!function_exists('baz')) {
    function baz() {
        return \_PhpScoper356bfb655d08\baz(...func_get_args());
    }
}
if (!function_exists('xyz')) {
    function xyz() {
        return \_PhpScoper356bfb655d08\xyz(...func_get_args());
    }
}
if (!function_exists('printPHPCodeSnifferTestOutput')) {
    function printPHPCodeSnifferTestOutput() {
        return \_PhpScoper356bfb655d08\printPHPCodeSnifferTestOutput(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \_PhpScoper356bfb655d08\setproctitle(...func_get_args());
    }
}
if (!function_exists('xdebug_info')) {
    function xdebug_info() {
        return \_PhpScoper356bfb655d08\xdebug_info(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \_PhpScoper356bfb655d08\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \_PhpScoper356bfb655d08\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \_PhpScoper356bfb655d08\dd(...func_get_args());
    }
}

return $loader;
