<?php

namespace _PhpScoper32136251d417\Psr\Log;

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
    public function setLogger(\_PhpScoper32136251d417\Psr\Log\LoggerInterface $logger);
}
