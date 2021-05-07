<?php

namespace Symplify\SetConfigResolver;

use Symplify\SetConfigResolver\Config\SetsParameterResolver;
use Symplify\SetConfigResolver\Contract\SetProviderInterface;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SetConfigResolver\Tests\ConfigResolver\SetAwareConfigResolverTest
 */
final class SetAwareConfigResolver extends \Symplify\SetConfigResolver\AbstractConfigResolver
{
    /**
     * @var SetsParameterResolver
     */
    private $setsParameterResolver;
    /**
     * @param \Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider
     */
    public function __construct($setProvider)
    {
        $setResolver = new \Symplify\SetConfigResolver\SetResolver($setProvider);
        $this->setsParameterResolver = new SetsParameterResolver($setResolver);
        parent::__construct();
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     * @return mixed[]
     */
    public function resolveFromParameterSetsFromConfigFiles(array $fileInfos)
    {
        return $this->setsParameterResolver->resolveFromFileInfos($fileInfos);
    }
}
