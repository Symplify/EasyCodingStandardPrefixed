<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\Console\EventListener;

use ECSPrefix20210507\Psr\Log\LoggerInterface;
use ECSPrefix20210507\Symfony\Component\Console\ConsoleEvents;
use ECSPrefix20210507\Symfony\Component\Console\Event\ConsoleErrorEvent;
use ECSPrefix20210507\Symfony\Component\Console\Event\ConsoleEvent;
use ECSPrefix20210507\Symfony\Component\Console\Event\ConsoleTerminateEvent;
use ECSPrefix20210507\Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * @author James Halsall <james.t.halsall@googlemail.com>
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class ErrorListener implements EventSubscriberInterface
{
    private $logger;
    /**
     * @param \ECSPrefix20210507\Psr\Log\LoggerInterface $logger
     */
    public function __construct($logger = null)
    {
        $this->logger = $logger;
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\Console\Event\ConsoleErrorEvent $event
     */
    public function onConsoleError($event)
    {
        if (null === $this->logger) {
            return;
        }
        $error = $event->getError();
        if (!($inputString = $this->getInputString($event))) {
            $this->logger->critical('An error occurred while using the console. Message: "{message}"', ['exception' => $error, 'message' => $error->getMessage()]);
            return;
        }
        $this->logger->critical('Error thrown while running command "{command}". Message: "{message}"', ['exception' => $error, 'command' => $inputString, 'message' => $error->getMessage()]);
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\Console\Event\ConsoleTerminateEvent $event
     */
    public function onConsoleTerminate($event)
    {
        if (null === $this->logger) {
            return;
        }
        $exitCode = $event->getExitCode();
        if (0 === $exitCode) {
            return;
        }
        if (!($inputString = $this->getInputString($event))) {
            $this->logger->debug('The console exited with code "{code}"', ['code' => $exitCode]);
            return;
        }
        $this->logger->debug('Command "{command}" exited with code "{code}"', ['command' => $inputString, 'code' => $exitCode]);
    }
    public static function getSubscribedEvents()
    {
        return [ConsoleEvents::ERROR => ['onConsoleError', -128], ConsoleEvents::TERMINATE => ['onConsoleTerminate', -128]];
    }
    /**
     * @return string|null
     * @param \ECSPrefix20210507\Symfony\Component\Console\Event\ConsoleEvent $event
     */
    private static function getInputString($event)
    {
        $commandName = $event->getCommand() ? $event->getCommand()->getName() : null;
        $input = $event->getInput();
        if (\method_exists($input, '__toString')) {
            if ($commandName) {
                return \str_replace(["'{$commandName}'", "\"{$commandName}\""], $commandName, (string) $input);
            }
            return (string) $input;
        }
        return $commandName;
    }
}
