<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\Console\Helper;

use ECSPrefix20210507\Symfony\Component\Console\Output\OutputInterface;
use ECSPrefix20210507\Symfony\Component\VarDumper\Cloner\ClonerInterface;
use ECSPrefix20210507\Symfony\Component\VarDumper\Cloner\VarCloner;
use ECSPrefix20210507\Symfony\Component\VarDumper\Dumper\CliDumper;
/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class Dumper
{
    private $output;
    private $dumper;
    private $cloner;
    private $handler;
    /**
     * @param \ECSPrefix20210507\Symfony\Component\Console\Output\OutputInterface $output
     * @param \ECSPrefix20210507\Symfony\Component\VarDumper\Dumper\CliDumper $dumper
     * @param \ECSPrefix20210507\Symfony\Component\VarDumper\Cloner\ClonerInterface $cloner
     */
    public function __construct($output, $dumper = null, $cloner = null)
    {
        $this->output = $output;
        $this->dumper = $dumper;
        $this->cloner = $cloner;
        if (\class_exists(CliDumper::class)) {
            $this->handler = function ($var) : string {
                $dumper = isset($this->dumper) ? $this->dumper : ($this->dumper = new CliDumper(null, null, CliDumper::DUMP_LIGHT_ARRAY | CliDumper::DUMP_COMMA_SEPARATOR));
                $dumper->setColors($this->output->isDecorated());
                return \rtrim($dumper->dump((isset($this->cloner) ? $this->cloner : ($this->cloner = new VarCloner()))->cloneVar($var)->withRefHandles(\false), \true));
            };
        } else {
            $this->handler = function ($var) : string {
                switch (\true) {
                    case null === $var:
                        return 'null';
                    case \true === $var:
                        return 'true';
                    case \false === $var:
                        return 'false';
                    case \is_string($var):
                        return '"' . $var . '"';
                    default:
                        return \rtrim(\print_r($var, \true));
                }
            };
        }
    }
    /**
     * @return string
     */
    public function __invoke($var)
    {
        return ($this->handler)($var);
    }
}
