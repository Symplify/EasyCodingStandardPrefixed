<?php

namespace _PhpScoperfacc742d2745\Psr\Log;

/**
 * Basic Implementation of LoggerAwareInterface.
 */
trait LoggerAwareTrait
{
    /** @var LoggerInterface */
    protected $logger;
    /**
     * Sets a logger.
     * 
     * @param LoggerInterface $logger
     */
    public function setLogger(\_PhpScoperfacc742d2745\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
