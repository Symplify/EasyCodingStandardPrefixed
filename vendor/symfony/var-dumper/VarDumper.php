<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera9d6a31d814c\Symfony\Component\VarDumper;

use _PhpScopera9d6a31d814c\Symfony\Component\HttpFoundation\Request;
use _PhpScopera9d6a31d814c\Symfony\Component\HttpFoundation\RequestStack;
use _PhpScopera9d6a31d814c\Symfony\Component\HttpKernel\Debug\FileLinkFormatter;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Caster\ReflectionCaster;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Cloner\VarCloner;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Dumper\CliDumper;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Dumper\ContextProvider\RequestContextProvider;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Dumper\ContextualizedDumper;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use _PhpScopera9d6a31d814c\Symfony\Component\VarDumper\Dumper\ServerDumper;
// Load the global dump() function
require_once __DIR__ . '/Resources/functions/dump.php';
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class VarDumper
{
    private static $handler;
    public static function dump($var)
    {
        if (null === self::$handler) {
            self::register();
        }
        return (self::$handler)($var);
    }
    public static function setHandler(callable $callable = null)
    {
        $prevHandler = self::$handler;
        // Prevent replacing the handler with expected format as soon as the env var was set:
        if (isset($_SERVER['VAR_DUMPER_FORMAT'])) {
            return $prevHandler;
        }
        self::$handler = $callable;
        return $prevHandler;
    }
    private static function register() : void
    {
        $cloner = new VarCloner();
        $cloner->addCasters(ReflectionCaster::UNSET_CLOSURE_FILE_INFO);
        $format = $_SERVER['VAR_DUMPER_FORMAT'] ?? null;
        switch (\true) {
            case 'html' === $format:
                $dumper = new HtmlDumper();
                break;
            case 'cli' === $format:
                $dumper = new CliDumper();
                break;
            case 'server' === $format:
            case 'tcp' === \parse_url($format, \PHP_URL_SCHEME):
                $host = 'server' === $format ? $_SERVER['VAR_DUMPER_SERVER'] ?? '127.0.0.1:9912' : $format;
                $dumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true) ? new CliDumper() : new HtmlDumper();
                $dumper = new ServerDumper($host, $dumper, self::getDefaultContextProviders());
                break;
            default:
                $dumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true) ? new CliDumper() : new HtmlDumper();
        }
        if (!$dumper instanceof ServerDumper) {
            $dumper = new ContextualizedDumper($dumper, [new SourceContextProvider()]);
        }
        self::$handler = function ($var) use($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        };
    }
    private static function getDefaultContextProviders() : array
    {
        $contextProviders = [];
        if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true) && \class_exists(Request::class)) {
            $requestStack = new RequestStack();
            $requestStack->push(Request::createFromGlobals());
            $contextProviders['request'] = new RequestContextProvider($requestStack);
        }
        $fileLinkFormatter = \class_exists(FileLinkFormatter::class) ? new FileLinkFormatter(null, $requestStack ?? null) : null;
        return $contextProviders + ['cli' => new CliContextProvider(), 'source' => new SourceContextProvider(null, null, $fileLinkFormatter)];
    }
}
