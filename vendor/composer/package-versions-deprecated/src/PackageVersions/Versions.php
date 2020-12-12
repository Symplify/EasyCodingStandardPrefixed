<?php

declare (strict_types=1);
namespace _PhpScoperdaf95aff095b\PackageVersions;

use OutOfBoundsException;
/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 */
final class Versions
{
    const ROOT_PACKAGE_NAME = 'symplify/easy-coding-standard';
    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS = array('composer/package-versions-deprecated' => '1.8.0@98df7f1b293c0550bd5b1ce6b60b59bdda23aa47', 'composer/semver' => '1.4.0@84c47f3d8901440403217afc120683c7385aecb8', 'composer/xdebug-handler' => '1.4.0@cbe23383749496fe0f373345208b79568e4bc248', 'dealerdirect/phpcodesniffer-composer-installer' => 'v0.7.0@e8d808670b8f882188368faaf1144448c169c0b7', 'doctrine/annotations' => 'v1.2.0@d9b1a37e9351ddde1f19f09a02e3d6ee92e82efd', 'doctrine/lexer' => 'v1.0@2f708a85bb3aab5d99dab8be435abd73e0b18acb', 'friendsofphp/php-cs-fixer' => 'v2.17.1@5198b7308ed63f26799387fd7f3901c3db6bd7fd', 'jean85/pretty-package-versions' => '1.5.0@e9f4324e88b8664be386d90cf60fbc202e1f7fc9', 'nette/finder' => 'v2.5.0@6be1b83ea68ac558aff189d640abe242e0306fe2', 'nette/neon' => 'v3.2.0@72dd80316595d4b5c5312ea4e9beb53f3ba823d7', 'nette/robot-loader' => 'v3.2.0@0712a0e39ae7956d6a94c0ab6ad41aa842544b5c', 'nette/utils' => 'v3.0.0@ec1e4055c295d73bb9e8ce27be859f434a6f6806', 'nikic/php-parser' => 'v4.10.3@dbe56d23de8fcb157bbc0cfb3ad7c7de0cfb0984', 'paragonie/random_compat' => 'v1.0.0@a1d9f267eb8b8ad560e54e397a5ed1e3b78097d1', 'php-cs-fixer/diff' => 'v1.3.0@78bb099e9c16361126c86ce82ec4405ebab8e756', 'phpstan/phpdoc-parser' => '0.4.5@956e7215c7c740d1226e7c03677140063918ec7d', 'psr/cache' => '1.0.0@9e66031f41fbbdda45ee11e93c45d480ccba3eb3', 'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f', 'psr/log' => '1.0.0@fe0936ee26643249e916849d48e3a51d5f5e278b', 'psr/simple-cache' => '1.0.0@753fa598e8f3b9966c886fe13f370baa45ef0e24', 'sebastian/diff' => '4.0.3@ffc949a1a2aae270ea064453d7535b82e4c32092', 'slevomat/coding-standard' => '6.4.0@bf3a16a630d8245c350b459832a71afa55c02fd3', 'squizlabs/php_codesniffer' => '3.5.6@e97627871a7eab2f70e59166072a6b767d5834e0', 'symfony/cache' => 'v4.4.0@72d5cdc6920f889290beb65fa96b5e9d4515e382', 'symfony/cache-contracts' => 'v1.1.7@af50d14ada9e4e82cfabfabdc502d144f89be0a1', 'symfony/config' => 'v5.1.0@b8623ef3d99fe62a34baf7a111b576216965f880', 'symfony/console' => 'v4.4.0@35d9077f495c6d184d9930f7a7ecbd1ad13c7ab8', 'symfony/debug' => 'v4.4.0@b24b791f817116b29e52a63e8544884cf9a40757', 'symfony/dependency-injection' => 'v5.1.0@6a6791e9584273b32eeb01790da4c7446d87a621', 'symfony/deprecation-contracts' => 'v2.1.0@ede224dcbc36138943a296107db2b8b2a690ac1c', 'symfony/error-handler' => 'v4.4.0@e1acb58dc6a8722617fe56565f742bcf7e8744bf', 'symfony/event-dispatcher' => 'v4.4.0@ab1c43e17fff802bef0a898f3bc088ac33b8e0e1', 'symfony/event-dispatcher-contracts' => 'v1.1.1@8fa2cf2177083dd59cf8e44ea4b6541764fbda69', 'symfony/filesystem' => 'v4.4.0@d12b01cba60be77b583c9af660007211e3909854', 'symfony/finder' => 'v4.4.0@ce8743441da64c41e2a667b8eb66070444ed911e', 'symfony/http-foundation' => 'v4.4.0@502040dd2b0cf0a292defeb6145f4d7a4753c99c', 'symfony/http-kernel' => 'v4.4.0@5a5e7237d928aa98ff8952050cbbf0135899b6b0', 'symfony/mime' => 'v4.3.0@0b166aee243364cd9de05755d2e9651876090abb', 'symfony/options-resolver' => 'v3.0.0@8e68c053a39e26559357cc742f01a7182ce40785', 'symfony/polyfill-ctype' => 'v1.8.0@7cc359f1b7b80fc25ed7796be7d96adc9b354bae', 'symfony/polyfill-intl-idn' => 'v1.20.0@3b75acd829741c768bc8b1f84eb33265e7cc5117', 'symfony/polyfill-intl-normalizer' => 'v1.10.0@f8ed52909fc049b42a772c64ec1e6b31792abad6', 'symfony/polyfill-mbstring' => 'v1.1.0@1289d16209491b584839022f29257ad859b8532d', 'symfony/polyfill-php70' => 'v1.0.0@7f7f3c9c2b9f17722e0cd64fdb4f957330c53146', 'symfony/polyfill-php72' => 'v1.10.0@9050816e2ca34a8e916c3a0ae8b9c2fccf68b631', 'symfony/polyfill-php73' => 'v1.9.0@990ca8fa94736211d2b305178c3fb2527e1fbce1', 'symfony/polyfill-php80' => 'v1.15.0@8854dc880784d2ae32908b75824754339b5c0555', 'symfony/process' => 'v3.3.0@8e30690c67aafb6c7992d6d8eb0d707807dd3eaf', 'symfony/service-contracts' => 'v1.1.6@ea7263d6b6d5f798b56a45a5b8d686725f2719a3', 'symfony/stopwatch' => 'v3.0.0@6aeac8907e3e1340a0033b0a9ec075f8e6524800', 'symfony/var-dumper' => 'v4.4.0@eade2890f8b0eeb279b6cf41b50a10007294490f', 'symfony/var-exporter' => 'v4.2.0@08250457428e06289d21ed52397b0ae336abf54b', 'symfony/yaml' => 'v4.4.0@76de473358fe802578a415d5bb43c296cf09d211', 'symplify/autowire-array-parameter' => 'dev-master@5b94a52bbf62eb1ab84e99a845548e25ab39b12c', 'symplify/coding-standard' => 'dev-master@07907840996fde3588b38093cf57cd8597c491ce', 'symplify/composer-json-manipulator' => 'dev-master@f682db521aa0f7597023c1876995e4393681c0ae', 'symplify/console-color-diff' => 'dev-master@4c0b38dbb383da58b2e4d4faf2fb9c3d7978bc47', 'symplify/easy-testing' => 'dev-master@b46bd7638ffd84e1a6a72757b45c4e51c049ea35', 'symplify/markdown-diff' => 'dev-master@c43ae41935693693a5bd83f44fc36a0fe701abb4', 'symplify/package-builder' => 'dev-master@f1ff447df233c2f739c2ddde560832d99c19fb28', 'symplify/php-config-printer' => 'dev-master@ad20cea3e02905a294b5e6619523f4b4e4a8339b', 'symplify/rule-doc-generator' => 'dev-master@37f8483eacc1cdb86c476e56090ae38b2682a301', 'symplify/set-config-resolver' => 'dev-master@6b0d5aa187556389c80df92cb67a5f862156935f', 'symplify/skipper' => 'dev-master@47bd62ec9aeaa8ec214e4eeecda29b26032a848a', 'symplify/smart-file-system' => 'dev-master@a2a5b85c5eaacf31496f55efbc393e24cd59ff92', 'symplify/symplify-kernel' => 'dev-master@06eef0c69100cb1ea158f02fcf4211779c7886fe', 'doctrine/instantiator' => '1.3.1@f350df0268e904597e3bd9c4685c53e0e333feea', 'myclabs/deep-copy' => '1.10.1@969b211f9a51aa1f6c01d1d2aef56d3bd91598e5', 'phar-io/manifest' => '2.0.1@85265efd3af7ba3ca4b2a2c34dbfc5788dd29133', 'phar-io/version' => '3.0.2@c6bb6825def89e0a32220f88337f8ceaf1975fa0', 'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b', 'phpdocumentor/reflection-docblock' => '5.2.0@3170448f5769fe19f456173d833734e0ff1b84df', 'phpdocumentor/type-resolver' => '1.3.0@e878a14a65245fbe78f8080eba03b47c3b705651', 'phpspec/prophecy' => '1.12.1@8ce87516be71aae9b956f81906aaf0338e0d8a2d', 'phpunit/php-code-coverage' => '9.2.3@6b20e2055f7c29b56cb3870b3de7cc463d7add41', 'phpunit/php-file-iterator' => '3.0.5@aa4be8575f26070b100fccb67faabb28f21f66f8', 'phpunit/php-invoker' => '3.1.1@5a10147d0aaf65b58940a0b72f71c9ac0423cc67', 'phpunit/php-text-template' => '2.0.3@18c887016e60e52477e54534956d7b47bc52cd84', 'phpunit/php-timer' => '5.0.2@c9ff14f493699e2f6adee9fd06a0245b276643b7', 'phpunit/phpunit' => '9.5.0@8e16c225d57c3d6808014df6b1dd7598d0a5bbbe', 'sebastian/cli-parser' => '1.0.1@442e7c7e687e42adc03470c7b668bc4b2402c0b2', 'sebastian/code-unit' => '1.0.6@d3a241b6028ff9d8e97d2b6ebd4090d01f92fad8', 'sebastian/code-unit-reverse-lookup' => '2.0.2@ee51f9bb0c6d8a43337055db3120829fa14da819', 'sebastian/comparator' => '4.0.5@7a8ff306445707539c1a6397372a982a1ec55120', 'sebastian/complexity' => '2.0.0@33fcd6a26656c6546f70871244ecba4b4dced097', 'sebastian/environment' => '5.1.3@388b6ced16caa751030f6a69e588299fa09200ac', 'sebastian/exporter' => '4.0.3@d89cc98761b8cb5a1a235a6b703ae50d34080e65', 'sebastian/global-state' => '5.0.1@ea779cb749a478b22a2564ac41cd7bda79c78dc7', 'sebastian/lines-of-code' => '1.0.0@e02bf626f404b5daec382a7b8a6a4456e49017e5', 'sebastian/object-enumerator' => '4.0.3@f6f5957013d84725427d361507e13513702888a4', 'sebastian/object-reflector' => '2.0.0@f4fd0835cabb0d4a6546d9fe291e5740037aa1e7', 'sebastian/recursion-context' => '4.0.0@cdd86616411fc3062368b720b0425de10bd3d579', 'sebastian/resource-operations' => '3.0.3@0f4443cb3a1d92ce809899753bc0d5d5a8dd19a8', 'sebastian/type' => '2.3.0@fa592377f3923946cb90bf1f6a71ba2e5f229909', 'sebastian/version' => '3.0.2@c6c1022351a901512170118436c764e473f6de8c', 'symplify/easy-coding-standard-tester' => 'dev-master@8c85e8a445c0d9c0bc1009830c791ca37ba3a2de', 'theseer/tokenizer' => '1.2.0@75a63c33a8577608444246075ea0af0d052e452a', 'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389', 'symplify/easy-coding-standard' => '9.1.x-dev@c410f5dd525181b02f1912d471bad939c43b9306');
    private function __construct()
    {
    }
    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     */
    public static function getVersion(string $packageName) : string
    {
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }
        throw new \OutOfBoundsException('Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files');
    }
}
