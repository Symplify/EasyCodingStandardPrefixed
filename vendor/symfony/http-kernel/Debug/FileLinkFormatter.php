<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper57210e33e43a\Symfony\Component\HttpKernel\Debug;

use _PhpScoper57210e33e43a\Symfony\Component\HttpFoundation\Request;
use _PhpScoper57210e33e43a\Symfony\Component\HttpFoundation\RequestStack;
use _PhpScoper57210e33e43a\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
/**
 * Formats debug file links.
 *
 * @author Jérémy Romey <jeremy@free-agent.fr>
 *
 * @final since Symfony 4.3
 */
class FileLinkFormatter
{
    private $fileLinkFormat;
    private $requestStack;
    private $baseDir;
    private $urlFormat;
    /**
     * @param string|\Closure $urlFormat the URL format, or a closure that returns it on-demand
     */
    public function __construct($fileLinkFormat = null, \_PhpScoper57210e33e43a\Symfony\Component\HttpFoundation\RequestStack $requestStack = null, string $baseDir = null, $urlFormat = null)
    {
        $fileLinkFormat = ($fileLinkFormat ?: \ini_get('xdebug.file_link_format')) ?: \get_cfg_var('xdebug.file_link_format');
        if ($fileLinkFormat && !\is_array($fileLinkFormat)) {
            $i = \strpos($f = $fileLinkFormat, '&', \max(\strrpos($f, '%f'), \strrpos($f, '%l'))) ?: \strlen($f);
            $fileLinkFormat = [\substr($f, 0, $i)] + \preg_split('/&([^>]++)>/', \substr($f, $i), -1, \PREG_SPLIT_DELIM_CAPTURE);
        }
        $this->fileLinkFormat = $fileLinkFormat;
        $this->requestStack = $requestStack;
        $this->baseDir = $baseDir;
        $this->urlFormat = $urlFormat;
    }
    public function format($file, $line)
    {
        if ($fmt = $this->getFileLinkFormat()) {
            for ($i = 1; isset($fmt[$i]); ++$i) {
                if (0 === \strpos($file, $k = $fmt[$i++])) {
                    $file = \substr_replace($file, $fmt[$i], 0, \strlen($k));
                    break;
                }
            }
            return \strtr($fmt[0], ['%f' => $file, '%l' => $line]);
        }
        return \false;
    }
    /**
     * @internal
     */
    public function __sleep() : array
    {
        $this->fileLinkFormat = $this->getFileLinkFormat();
        return ['fileLinkFormat'];
    }
    /**
     * @internal
     */
    public static function generateUrlFormat(\_PhpScoper57210e33e43a\Symfony\Component\Routing\Generator\UrlGeneratorInterface $router, $routeName, $queryString)
    {
        try {
            return $router->generate($routeName) . $queryString;
        } catch (\Throwable $e) {
            return null;
        }
    }
    private function getFileLinkFormat()
    {
        if ($this->fileLinkFormat) {
            return $this->fileLinkFormat;
        }
        if ($this->requestStack && $this->baseDir && $this->urlFormat) {
            $request = $this->requestStack->getMasterRequest();
            if ($request instanceof \_PhpScoper57210e33e43a\Symfony\Component\HttpFoundation\Request && (!$this->urlFormat instanceof \Closure || ($this->urlFormat = ($this->urlFormat)()))) {
                return [$request->getSchemeAndHttpHost() . $this->urlFormat, $this->baseDir . \DIRECTORY_SEPARATOR, ''];
            }
        }
        return null;
    }
}
