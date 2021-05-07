<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\Console\Descriptor;

use ECSPrefix20210507\Symfony\Component\Console\Application;
use ECSPrefix20210507\Symfony\Component\Console\Command\Command;
use ECSPrefix20210507\Symfony\Component\Console\Exception\InvalidArgumentException;
use ECSPrefix20210507\Symfony\Component\Console\Input\InputArgument;
use ECSPrefix20210507\Symfony\Component\Console\Input\InputDefinition;
use ECSPrefix20210507\Symfony\Component\Console\Input\InputOption;
use ECSPrefix20210507\Symfony\Component\Console\Output\OutputInterface;
/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
abstract class Descriptor implements \ECSPrefix20210507\Symfony\Component\Console\Descriptor\DescriptorInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * {@inheritdoc}
     * @param \ECSPrefix20210507\Symfony\Component\Console\Output\OutputInterface $output
     */
    public function describe($output, $object, array $options = [])
    {
        $this->output = $output;
        switch (\true) {
            case $object instanceof InputArgument:
                $this->describeInputArgument($object, $options);
                break;
            case $object instanceof InputOption:
                $this->describeInputOption($object, $options);
                break;
            case $object instanceof InputDefinition:
                $this->describeInputDefinition($object, $options);
                break;
            case $object instanceof Command:
                $this->describeCommand($object, $options);
                break;
            case $object instanceof Application:
                $this->describeApplication($object, $options);
                break;
            default:
                throw new InvalidArgumentException(\sprintf('Object of type "%s" is not describable.', \get_debug_type($object)));
        }
    }
    /**
     * Writes content to output.
     * @param string $content
     * @param bool $decorated
     */
    protected function write($content, $decorated = \false)
    {
        $this->output->write($content, \false, $decorated ? OutputInterface::OUTPUT_NORMAL : OutputInterface::OUTPUT_RAW);
    }
    /**
     * Describes an InputArgument instance.
     * @param \ECSPrefix20210507\Symfony\Component\Console\Input\InputArgument $argument
     */
    protected abstract function describeInputArgument($argument, array $options = []);
    /**
     * Describes an InputOption instance.
     * @param \ECSPrefix20210507\Symfony\Component\Console\Input\InputOption $option
     */
    protected abstract function describeInputOption($option, array $options = []);
    /**
     * Describes an InputDefinition instance.
     * @param \ECSPrefix20210507\Symfony\Component\Console\Input\InputDefinition $definition
     */
    protected abstract function describeInputDefinition($definition, array $options = []);
    /**
     * Describes a Command instance.
     * @param \ECSPrefix20210507\Symfony\Component\Console\Command\Command $command
     */
    protected abstract function describeCommand($command, array $options = []);
    /**
     * Describes an Application instance.
     * @param \ECSPrefix20210507\Symfony\Component\Console\Application $application
     */
    protected abstract function describeApplication($application, array $options = []);
}
