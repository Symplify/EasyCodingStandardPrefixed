<?php

namespace _PhpScoper91fe47cd7f25\Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(\_PhpScoper91fe47cd7f25\Psr\Log\LoggerInterface $logger);
}
