<?php

namespace Symplify\PackageBuilder\Composer;

use ECSPrefix20210507\Jean85\Exception\ReplacedPackageException;
use ECSPrefix20210507\Jean85\PrettyVersions;
use ECSPrefix20210507\Jean85\Version;
use OutOfBoundsException;
use ECSPrefix20210507\PharIo\Version\InvalidVersionException;
final class PackageVersionProvider
{
    /**
     * Returns current version of package, contains only major and minor.
     * @param string $packageName
     * @return string
     */
    public function provide($packageName)
    {
        try {
            $version = $this->getVersion($packageName, 'symplify/symplify');
            return $version->getPrettyVersion() ?: 'Unknown';
        } catch (OutOfBoundsException $exceptoin) {
            return 'Unknown';
        } catch (InvalidVersionException $exceptoin) {
            return 'Unknown';
        }
    }
    /**
     * Workaround for when the required package is executed in the monorepo or replaced in any other way
     *
     * @see https://github.com/symplify/symplify/pull/2901#issuecomment-771536136
     * @see https://github.com/Jean85/pretty-package-versions/pull/16#issuecomment-620550459
     * @param string $packageName
     * @param string $replacingPackageName
     * @return \ECSPrefix20210507\Jean85\Version
     */
    private function getVersion($packageName, $replacingPackageName)
    {
        try {
            return PrettyVersions::getVersion($packageName);
        } catch (OutOfBoundsException $exception) {
            return PrettyVersions::getVersion($replacingPackageName);
        } catch (ReplacedPackageException $exception) {
            return PrettyVersions::getVersion($replacingPackageName);
        }
    }
}
