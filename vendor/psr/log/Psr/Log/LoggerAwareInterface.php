<?php

namespace _PhpScopere4fa57261c04\Psr\Log;

/**
 * Describes a logger-aware instance
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(\_PhpScopere4fa57261c04\Psr\Log\LoggerInterface $logger);
}
