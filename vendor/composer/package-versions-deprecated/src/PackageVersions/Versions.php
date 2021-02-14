<?php

declare (strict_types=1);
namespace _PhpScoperf361a7d70552\PackageVersions;

use _PhpScoperf361a7d70552\Composer\InstalledVersions;
use OutOfBoundsException;
\class_exists(\_PhpScoperf361a7d70552\Composer\InstalledVersions::class);
/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'symplify/easy-coding-standard';
    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS = array('composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6', 'composer/semver' => '3.2.4@a02fdf930a3c1c3ed3a49b5f63859c0c20e10464', 'composer/xdebug-handler' => '1.4.5@f28d44c286812c714741478d968104c5e604a1d4', 'doctrine/annotations' => '1.11.1@ce77a7ba1770462cd705a91a151b6c3746f9c6ad', 'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042', 'friendsofphp/php-cs-fixer' => 'v2.18.2@18f8c9d184ba777380794a389fabc179896ba913', 'jean85/pretty-package-versions' => '1.6.0@1e0104b46f045868f11942aea058cd7186d6c303', 'nette/finder' => 'v2.5.2@4ad2c298eb8c687dd0e74ae84206a4186eeaed50', 'nette/neon' => 'v3.2.1@a5b3a60833d2ef55283a82d0c30b45d136b29e75', 'nette/robot-loader' => 'v3.3.1@15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b', 'nette/utils' => 'v3.2.1@2bc2f58079c920c2ecbb6935645abf6f2f5f94ba', 'nikic/php-parser' => 'v4.10.4@c6d052fc58cb876152f89f532b95a8d7907e7f0e', 'php-cs-fixer/diff' => 'v1.3.1@dbd31aeb251639ac0b9e7e29405c1441907f5759', 'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8', 'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f', 'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0', 'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc', 'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b', 'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d', 'squizlabs/php_codesniffer' => '3.5.8@9d583721a7157ee997f235f327de038e7ea6dac4', 'symfony/cache' => 'v5.2.3@d6aed6c1bbf6f59e521f46437475a0ff4878d388', 'symfony/cache-contracts' => 'v2.2.0@8034ca0b61d4dd967f3698aaa1da2507b631d0cb', 'symfony/config' => 'v5.2.3@50e0e1314a3b2609d32b6a5a0d0fb5342494c4ab', 'symfony/console' => 'v5.2.3@89d4b176d12a2946a1ae4e34906a025b7b6b135a', 'symfony/dependency-injection' => 'v5.2.3@62f72187be689540385dce6c68a5d4c16f034139', 'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665', 'symfony/error-handler' => 'v5.2.3@48f18b3609e120ea66d59142c23dc53e9562c26d', 'symfony/event-dispatcher' => 'v5.2.3@4f9760f8074978ad82e2ce854dff79a71fe45367', 'symfony/event-dispatcher-contracts' => 'v2.2.0@0ba7d54483095a198fa51781bc608d17e84dffa2', 'symfony/filesystem' => 'v5.2.3@262d033b57c73e8b59cd6e68a45c528318b15038', 'symfony/finder' => 'v5.2.3@4adc8d172d602008c204c2e16956f99257248e03', 'symfony/http-client-contracts' => 'v2.3.1@41db680a15018f9c1d4b23516059633ce280ca33', 'symfony/http-foundation' => 'v5.2.3@20c554c0f03f7cde5ce230ed248470cccbc34c36', 'symfony/http-kernel' => 'v5.2.3@89bac04f29e7b0b52f9fa6a4288ca7a8f90a1a05', 'symfony/options-resolver' => 'v5.2.3@5d0f633f9bbfcf7ec642a2b5037268e61b0a62ce', 'symfony/polyfill-ctype' => 'v1.22.0@c6c942b1ac76c82448322025e084cadc56048b4e', 'symfony/polyfill-intl-grapheme' => 'v1.22.0@267a9adeb8ecb8071040a740930e077cdfb987af', 'symfony/polyfill-intl-normalizer' => 'v1.22.0@6e971c891537eb617a00bb07a43d182a6915faba', 'symfony/polyfill-mbstring' => 'v1.22.0@f377a3dd1fde44d37b9831d68dc8dea3ffd28e13', 'symfony/polyfill-php70' => 'v1.20.0@5f03a781d984aae42cebd18e7912fa80f02ee644', 'symfony/polyfill-php72' => 'v1.22.0@cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9', 'symfony/polyfill-php73' => 'v1.22.0@a678b42e92f86eca04b7fa4c0f6f19d097fb69e2', 'symfony/polyfill-php80' => 'v1.22.0@dc3063ba22c2a1fd2f45ed856374d79114998f91', 'symfony/process' => 'v5.2.3@313a38f09c77fbcdc1d223e57d368cea76a2fd2f', 'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1', 'symfony/stopwatch' => 'v5.2.3@b12274acfab9d9850c52583d136a24398cdf1a0c', 'symfony/string' => 'v5.2.3@c95468897f408dd0aca2ff582074423dd0455122', 'symfony/var-dumper' => 'v5.2.3@72ca213014a92223a5d18651ce79ef441c12b694', 'symfony/var-exporter' => 'v5.2.3@5aed4875ab514c8cb9b6ff4772baa25fa4c10307', 'symfony/yaml' => 'v5.2.3@338cddc6d74929f6adf19ca5682ac4b8e109cdb0', 'symplify/autowire-array-parameter' => 'dev-master@92ad4cd3718a6ad7f143940df7b1b149ccd20d58', 'symplify/coding-standard' => 'dev-master@b5baa7ade91b4e6c0d86f4b9b4f512823bfb6abf', 'symplify/composer-json-manipulator' => 'dev-master@d113f57a9ed82f126628587c833fa9587e39ef58', 'symplify/console-color-diff' => 'dev-master@0614fa1527a5175d262619db42bf5cc6c7aa6de7', 'symplify/console-package-builder' => 'dev-master@dea70cfc0e5b106893515a51eef385554bbaa4a1', 'symplify/easy-testing' => 'dev-master@078db818579ac92bd2b81e0e33ff28f37e4da7ba', 'symplify/markdown-diff' => 'dev-master@4ae3b5c7350298f731cb89d9d3fce79a3d0fd0f7', 'symplify/package-builder' => 'dev-master@cf3252b5d051019c415bdd7f81ddaf749f78645e', 'symplify/php-config-printer' => 'dev-master@317005a42192a503773dabba324f48f0d46859bd', 'symplify/rule-doc-generator' => 'dev-master@662978148beeb1a5a64e8fa5fa68e16bc9c49beb', 'symplify/set-config-resolver' => 'dev-master@80c167c8d11e1ad923e2fbfc31f84f7d63e4326c', 'symplify/skipper' => 'dev-master@bc4152b6e12f1baca6b87a5c2f45fd729e954f7a', 'symplify/smart-file-system' => 'dev-master@037f66ada0d72db2d9f26fab36ade35c24f5586f', 'symplify/symplify-kernel' => 'dev-master@613f8ee0b225f57f6185eb546a3faedac10e7b4d', 'symplify/easy-coding-standard' => '9.2.x-dev@');
    private function __construct()
    {
    }
    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!\class_exists(\_PhpScoperf361a7d70552\Composer\InstalledVersions::class, \false) || !\_PhpScoperf361a7d70552\Composer\InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }
        return \_PhpScoperf361a7d70552\Composer\InstalledVersions::getRootPackage()['name'];
    }
    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName) : string
    {
        if (\class_exists(\_PhpScoperf361a7d70552\Composer\InstalledVersions::class, \false) && \_PhpScoperf361a7d70552\Composer\InstalledVersions::getRawData()) {
            return \_PhpScoperf361a7d70552\Composer\InstalledVersions::getPrettyVersion($packageName) . '@' . \_PhpScoperf361a7d70552\Composer\InstalledVersions::getReference($packageName);
        }
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }
        throw new \OutOfBoundsException('Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files');
    }
}
