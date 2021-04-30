<?php

declare (strict_types=1);
namespace _PhpScopera658fe86acec\PackageVersions;

use _PhpScopera658fe86acec\Composer\InstalledVersions;
use OutOfBoundsException;
\class_exists(InstalledVersions::class);
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
    const VERSIONS = array('composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6', 'composer/semver' => '3.2.4@a02fdf930a3c1c3ed3a49b5f63859c0c20e10464', 'composer/xdebug-handler' => '1.4.6@f27e06cd9675801df441b3656569b328e04aa37c', 'doctrine/annotations' => '1.12.1@b17c5014ef81d212ac539f07a1001832df1b6d3b', 'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042', 'friendsofphp/php-cs-fixer' => 'v2.18.6@5fed214993e7863cef88a08f214344891299b9e4', 'jean85/pretty-package-versions' => '2.0.3@b2c4ec2033a0196317a467cb197c7c843b794ddf', 'nette/finder' => 'v2.5.2@4ad2c298eb8c687dd0e74ae84206a4186eeaed50', 'nette/neon' => 'v3.2.2@e4ca6f4669121ca6876b1d048c612480e39a28d5', 'nette/robot-loader' => 'v3.4.0@3973cf3970d1de7b30888fd10b92dac9e0c2fd82', 'nette/utils' => 'v3.2.2@967cfc4f9a1acd5f1058d76715a424c53343c20c', 'php-cs-fixer/diff' => 'v1.3.1@dbd31aeb251639ac0b9e7e29405c1441907f5759', 'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8', 'psr/container' => '1.1.1@8622567409010282b7aeebe4bb841fe98b58dcaf', 'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0', 'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc', 'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b', 'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d', 'squizlabs/php_codesniffer' => '3.6.0@ffced0d2c8fa8e6cdc4d695a743271fab6c38625', 'symfony/cache' => 'v5.2.6@093d69bb10c959553c8beb828b8d4ea250a247dd', 'symfony/cache-contracts' => 'v2.4.0@c0446463729b89dd4fa62e9aeecc80287323615d', 'symfony/config' => 'v5.2.4@212d54675bf203ff8aef7d8cee8eecfb72f4a263', 'symfony/console' => 'v5.2.6@35f039df40a3b335ebf310f244cb242b3a83ac8d', 'symfony/dependency-injection' => 'v5.2.6@1e66194bed2a69fa395d26bf1067e5e34483afac', 'symfony/deprecation-contracts' => 'v2.4.0@5f38c8804a9e97d23e0c8d63341088cd8a22d627', 'symfony/error-handler' => 'v5.2.6@bdb7fb4188da7f4211e4b88350ba0dfdad002b03', 'symfony/event-dispatcher' => 'v5.2.4@d08d6ec121a425897951900ab692b612a61d6240', 'symfony/event-dispatcher-contracts' => 'v2.4.0@69fee1ad2332a7cbab3aca13591953da9cdb7a11', 'symfony/filesystem' => 'v5.2.6@8c86a82f51658188119e62cff0a050a12d09836f', 'symfony/finder' => 'v5.2.4@0d639a0943822626290d169965804f79400e6a04', 'symfony/http-client-contracts' => 'v2.4.0@7e82f6084d7cae521a75ef2cb5c9457bbda785f4', 'symfony/http-foundation' => 'v5.2.4@54499baea7f7418bce7b5ec92770fd0799e8e9bf', 'symfony/http-kernel' => 'v5.2.6@f34de4c61ca46df73857f7f36b9a3805bdd7e3b2', 'symfony/options-resolver' => 'v5.2.4@5d0f633f9bbfcf7ec642a2b5037268e61b0a62ce', 'symfony/polyfill-ctype' => 'v1.22.1@c6c942b1ac76c82448322025e084cadc56048b4e', 'symfony/polyfill-intl-grapheme' => 'v1.22.1@5601e09b69f26c1828b13b6bb87cb07cddba3170', 'symfony/polyfill-intl-normalizer' => 'v1.22.1@43a0283138253ed1d48d352ab6d0bdb3f809f248', 'symfony/polyfill-mbstring' => 'v1.22.1@5232de97ee3b75b0360528dae24e73db49566ab1', 'symfony/polyfill-php70' => 'v1.20.0@5f03a781d984aae42cebd18e7912fa80f02ee644', 'symfony/polyfill-php72' => 'v1.22.1@cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9', 'symfony/polyfill-php73' => 'v1.22.1@a678b42e92f86eca04b7fa4c0f6f19d097fb69e2', 'symfony/polyfill-php80' => 'v1.22.1@dc3063ba22c2a1fd2f45ed856374d79114998f91', 'symfony/process' => 'v5.2.4@313a38f09c77fbcdc1d223e57d368cea76a2fd2f', 'symfony/service-contracts' => 'v2.4.0@f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb', 'symfony/stopwatch' => 'v5.2.4@b12274acfab9d9850c52583d136a24398cdf1a0c', 'symfony/string' => 'v5.2.6@ad0bd91bce2054103f5eaa18ebeba8d3bc2a0572', 'symfony/var-dumper' => 'v5.2.6@89412a68ea2e675b4e44f260a5666729f77f668e', 'symfony/var-exporter' => 'v5.2.4@5aed4875ab514c8cb9b6ff4772baa25fa4c10307', 'symplify/autowire-array-parameter' => 'dev-main@082531e1758f170dec639ec9cd5858f94bc208f6', 'symplify/coding-standard' => 'dev-main@32e5e2ed86a7e793e28adf6af01e9c20cc5e3c0e', 'symplify/composer-json-manipulator' => 'dev-main@a58d9f73bb7f756b720428566761854a44d86641', 'symplify/console-color-diff' => 'dev-main@1572b114d39499757fa2d7d46367fc41ba07e006', 'symplify/console-package-builder' => 'dev-main@072420b8373cd28e617dbccd7abdef4e5a5a2871', 'symplify/easy-testing' => 'dev-main@d12b5b2772dc757b3b6141819fac9b71287095e4', 'symplify/package-builder' => 'dev-main@be792b98451e1d6098dc76fcbcc64a664b597239', 'symplify/rule-doc-generator-contracts' => 'dev-main@b661f9642938eb64d076c4eff25ad4ffc439ef8c', 'symplify/set-config-resolver' => 'dev-main@01defc375e33a7a65f747165afe7ad695f92a0d0', 'symplify/skipper' => 'dev-main@5db8993e3167f28b60516b17de50c937df17ba75', 'symplify/smart-file-system' => 'dev-main@2dea618353e3da36cb4244b28f0ca41387d764f2', 'symplify/symplify-kernel' => 'dev-main@6ce79f29218bd8b90f70b6ed993c227b8d8bd57f', 'symplify/easy-coding-standard' => '9.4.x-dev@');
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
        if (!\class_exists(InstalledVersions::class, \false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }
        return InstalledVersions::getRootPackage()['name'];
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
        if (\class_exists(InstalledVersions::class, \false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName) . '@' . InstalledVersions::getReference($packageName);
        }
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }
        throw new OutOfBoundsException('Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files');
    }
}
