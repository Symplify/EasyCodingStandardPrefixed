<?php

namespace Symplify\SetConfigResolver;

use Symplify\SetConfigResolver\Contract\SetProviderInterface;
use Symplify\SetConfigResolver\Exception\SetNotFoundException;
use Symplify\SetConfigResolver\ValueObject\Set;
use Symplify\SmartFileSystem\SmartFileInfo;
final class SetResolver
{
    /**
     * @var SetProviderInterface
     */
    private $setProvider;
    /**
     * @param \Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider
     */
    public function __construct($setProvider)
    {
        $this->setProvider = $setProvider;
    }
    /**
     * @param string $setName
     * @return \Symplify\SmartFileSystem\SmartFileInfo
     */
    public function detectFromName($setName)
    {
        $set = $this->setProvider->provideByName($setName);
        if (!$set instanceof Set) {
            $this->reportSetNotFound($setName);
        }
        return $set->getSetFileInfo();
    }
    /**
     * @return void
     * @param string $setName
     */
    private function reportSetNotFound($setName)
    {
        $message = \sprintf('Set "%s" was not found', $setName);
        throw new SetNotFoundException($message, $setName, $this->setProvider->provideSetNames());
    }
}
