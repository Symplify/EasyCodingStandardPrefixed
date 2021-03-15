<?php

declare (strict_types=1);
namespace _PhpScoper971ef29294dd\PackageVersions;

use _PhpScoper971ef29294dd\Composer\InstalledVersions;
use OutOfBoundsException;
\class_exists(\_PhpScoper971ef29294dd\Composer\InstalledVersions::class);
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
    const VERSIONS = array('composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6', 'composer/semver' => '3.2.4@a02fdf930a3c1c3ed3a49b5f63859c0c20e10464', 'composer/xdebug-handler' => '1.4.5@f28d44c286812c714741478d968104c5e604a1d4', 'doctrine/annotations' => '1.12.1@b17c5014ef81d212ac539f07a1001832df1b6d3b', 'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042', 'friendsofphp/php-cs-fixer' => 'v2.18.3@ab99202fccff2a9f97592fbe1b5c76dd06df3513', 'jean85/pretty-package-versions' => '2.0.3@b2c4ec2033a0196317a467cb197c7c843b794ddf', 'nette/finder' => 'v2.5.2@4ad2c298eb8c687dd0e74ae84206a4186eeaed50', 'nette/neon' => 'v3.2.2@e4ca6f4669121ca6876b1d048c612480e39a28d5', 'nette/robot-loader' => 'v3.4.0@3973cf3970d1de7b30888fd10b92dac9e0c2fd82', 'nette/utils' => 'v3.2.2@967cfc4f9a1acd5f1058d76715a424c53343c20c', 'nikic/php-parser' => 'v4.10.4@c6d052fc58cb876152f89f532b95a8d7907e7f0e', 'php-cs-fixer/diff' => 'v1.3.1@dbd31aeb251639ac0b9e7e29405c1441907f5759', 'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8', 'psr/container' => '1.1.1@8622567409010282b7aeebe4bb841fe98b58dcaf', 'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0', 'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc', 'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b', 'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d', 'squizlabs/php_codesniffer' => '3.5.8@9d583721a7157ee997f235f327de038e7ea6dac4', 'symfony/cache' => 'v5.2.4@d15fb2576cdbe2c40d7c851e62f85b0faff3dd3d', 'symfony/cache-contracts' => 'v2.2.0@8034ca0b61d4dd967f3698aaa1da2507b631d0cb', 'symfony/config' => 'v5.2.4@212d54675bf203ff8aef7d8cee8eecfb72f4a263', 'symfony/console' => 'v5.2.5@938ebbadae1b0a9c9d1ec313f87f9708609f1b79', 'symfony/dependency-injection' => 'v5.2.5@be0c7926f5729b15e4e79fd2bf917cac584b1970', 'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665', 'symfony/error-handler' => 'v5.2.4@b547d3babcab5c31e01de59ee33e9d9c1421d7d0', 'symfony/event-dispatcher' => 'v5.2.4@d08d6ec121a425897951900ab692b612a61d6240', 'symfony/event-dispatcher-contracts' => 'v2.2.0@0ba7d54483095a198fa51781bc608d17e84dffa2', 'symfony/filesystem' => 'v5.2.4@710d364200997a5afde34d9fe57bd52f3cc1e108', 'symfony/finder' => 'v5.2.4@0d639a0943822626290d169965804f79400e6a04', 'symfony/http-client-contracts' => 'v2.3.1@41db680a15018f9c1d4b23516059633ce280ca33', 'symfony/http-foundation' => 'v5.2.4@54499baea7f7418bce7b5ec92770fd0799e8e9bf', 'symfony/http-kernel' => 'v5.2.5@b8c63ef63c2364e174c3b3e0ba0bf83455f97f73', 'symfony/options-resolver' => 'v5.2.4@5d0f633f9bbfcf7ec642a2b5037268e61b0a62ce', 'symfony/polyfill-ctype' => 'v1.22.1@c6c942b1ac76c82448322025e084cadc56048b4e', 'symfony/polyfill-intl-grapheme' => 'v1.22.1@5601e09b69f26c1828b13b6bb87cb07cddba3170', 'symfony/polyfill-intl-normalizer' => 'v1.22.1@43a0283138253ed1d48d352ab6d0bdb3f809f248', 'symfony/polyfill-mbstring' => 'v1.22.1@5232de97ee3b75b0360528dae24e73db49566ab1', 'symfony/polyfill-php70' => 'v1.20.0@5f03a781d984aae42cebd18e7912fa80f02ee644', 'symfony/polyfill-php72' => 'v1.22.1@cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9', 'symfony/polyfill-php73' => 'v1.22.1@a678b42e92f86eca04b7fa4c0f6f19d097fb69e2', 'symfony/polyfill-php80' => 'v1.22.1@dc3063ba22c2a1fd2f45ed856374d79114998f91', 'symfony/process' => 'v5.2.4@313a38f09c77fbcdc1d223e57d368cea76a2fd2f', 'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1', 'symfony/stopwatch' => 'v5.2.4@b12274acfab9d9850c52583d136a24398cdf1a0c', 'symfony/string' => 'v5.2.4@4e78d7d47061fa183639927ec40d607973699609', 'symfony/var-dumper' => 'v5.2.5@002ab5a36702adf0c9a11e6d8836623253e9045e', 'symfony/var-exporter' => 'v5.2.4@5aed4875ab514c8cb9b6ff4772baa25fa4c10307', 'symfony/yaml' => 'v5.2.5@298a08ddda623485208506fcee08817807a251dd', 'symplify/autowire-array-parameter' => 'dev-main@725320a48156f3972d7d766b70257de1dd86af07', 'symplify/coding-standard' => 'dev-main@6bfc2bb8422269c0143a6c6e77ca663122ab391e', 'symplify/composer-json-manipulator' => 'dev-main@1d07d185c603ac1b1641d4be6009820a6b8bb5ec', 'symplify/console-color-diff' => 'dev-main@92bda09955c8aa0465323996011217a7ad9d9f95', 'symplify/console-package-builder' => 'dev-main@e196e95414e643ad86b82abaa742148fbb588f48', 'symplify/easy-testing' => 'dev-main@25aad51cc54f9fc5fff7aec46b360c41bb913025', 'symplify/markdown-diff' => 'dev-main@b637fc80f9ee7eb19b11bf0399803739e7954712', 'symplify/package-builder' => 'dev-main@0846abe46364a9885a91b0523543cac7646022cf', 'symplify/php-config-printer' => 'dev-main@0f4b573fa10a054f3ce650403e94720c46955a27', 'symplify/rule-doc-generator' => 'dev-main@e57f62ccfce3910cc1d0b729b387a5da811c4ea1', 'symplify/set-config-resolver' => 'dev-main@903b9eb865a456cf52e1af96038f576dfa81adb5', 'symplify/skipper' => 'dev-main@b7ef6bd5188f29ec5632e9c6586a647e022c9f9f', 'symplify/smart-file-system' => 'dev-main@0cab2a1255cdeb0840c16f8d25df02818bf0089c', 'symplify/symplify-kernel' => 'dev-main@242e94bb3e45b8079f8d43cdfc26e072778067af', 'symplify/easy-coding-standard' => '9.3.x-dev@');
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
        if (!\class_exists(\_PhpScoper971ef29294dd\Composer\InstalledVersions::class, \false) || !\_PhpScoper971ef29294dd\Composer\InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }
        return \_PhpScoper971ef29294dd\Composer\InstalledVersions::getRootPackage()['name'];
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
        if (\class_exists(\_PhpScoper971ef29294dd\Composer\InstalledVersions::class, \false) && \_PhpScoper971ef29294dd\Composer\InstalledVersions::getRawData()) {
            return \_PhpScoper971ef29294dd\Composer\InstalledVersions::getPrettyVersion($packageName) . '@' . \_PhpScoper971ef29294dd\Composer\InstalledVersions::getReference($packageName);
        }
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }
        throw new \OutOfBoundsException('Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files');
    }
}
