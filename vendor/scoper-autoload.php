<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('AutoloadIncluder', false) && !interface_exists('AutoloadIncluder', false) && !trait_exists('AutoloadIncluder', false)) {
    spl_autoload_call('_PhpScoper9acecd3612c5\AutoloadIncluder');
}
if (!class_exists('Composer\InstalledVersions', false) && !interface_exists('Composer\InstalledVersions', false) && !trait_exists('Composer\InstalledVersions', false)) {
    spl_autoload_call('_PhpScoper9acecd3612c5\Composer\InstalledVersions');
}
if (!class_exists('ComposerAutoloaderInita1ba0f4afbcb2095ce879b84f1c89920', false) && !interface_exists('ComposerAutoloaderInita1ba0f4afbcb2095ce879b84f1c89920', false) && !trait_exists('ComposerAutoloaderInita1ba0f4afbcb2095ce879b84f1c89920', false)) {
    spl_autoload_call('_PhpScoper9acecd3612c5\ComposerAutoloaderInita1ba0f4afbcb2095ce879b84f1c89920');
}
if (!class_exists('ValidatePEARPackageXML', false) && !interface_exists('ValidatePEARPackageXML', false) && !trait_exists('ValidatePEARPackageXML', false)) {
    spl_autoload_call('_PhpScoper9acecd3612c5\ValidatePEARPackageXML');
}
if (!class_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !interface_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !trait_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false)) {
    spl_autoload_call('_PhpScoper9acecd3612c5\Symfony\Component\DependencyInjection\Extension\ExtensionInterface');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('_PhpScoper9acecd3612c5\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequirea1ba0f4afbcb2095ce879b84f1c89920')) {
    function composerRequirea1ba0f4afbcb2095ce879b84f1c89920() {
        return \_PhpScoper9acecd3612c5\composerRequirea1ba0f4afbcb2095ce879b84f1c89920(...func_get_args());
    }
}
if (!function_exists('sample')) {
    function sample() {
        return \_PhpScoper9acecd3612c5\sample(...func_get_args());
    }
}
if (!function_exists('foo')) {
    function foo() {
        return \_PhpScoper9acecd3612c5\foo(...func_get_args());
    }
}
if (!function_exists('bar')) {
    function bar() {
        return \_PhpScoper9acecd3612c5\bar(...func_get_args());
    }
}
if (!function_exists('baz')) {
    function baz() {
        return \_PhpScoper9acecd3612c5\baz(...func_get_args());
    }
}
if (!function_exists('xyz')) {
    function xyz() {
        return \_PhpScoper9acecd3612c5\xyz(...func_get_args());
    }
}
if (!function_exists('printPHPCodeSnifferTestOutput')) {
    function printPHPCodeSnifferTestOutput() {
        return \_PhpScoper9acecd3612c5\printPHPCodeSnifferTestOutput(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \_PhpScoper9acecd3612c5\setproctitle(...func_get_args());
    }
}
if (!function_exists('xdebug_info')) {
    function xdebug_info() {
        return \_PhpScoper9acecd3612c5\xdebug_info(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \_PhpScoper9acecd3612c5\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \_PhpScoper9acecd3612c5\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \_PhpScoper9acecd3612c5\dd(...func_get_args());
    }
}

return $loader;
