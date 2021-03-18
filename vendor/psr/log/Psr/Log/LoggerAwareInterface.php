<?php

namespace _PhpScoper0b185984cfb7\Psr\Log;

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
    public function setLogger(\_PhpScoper0b185984cfb7\Psr\Log\LoggerInterface $logger);
}
