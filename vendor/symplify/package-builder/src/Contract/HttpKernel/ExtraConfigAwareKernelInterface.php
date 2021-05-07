<?php

namespace Symplify\PackageBuilder\Contract\HttpKernel;

use ECSPrefix20210507\Symfony\Component\HttpKernel\KernelInterface;
use Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     * @return void
     */
    public function setConfigs(array $configs);
}
