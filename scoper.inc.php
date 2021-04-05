<?php

declare (strict_types=1);
namespace _PhpScoper86aebf8cf357;

use _PhpScoper86aebf8cf357\Nette\Utils\Strings;
use _PhpScoper86aebf8cf357\Isolated\Symfony\Component\Finder\Finder;
$finder = new \_PhpScoper86aebf8cf357\Isolated\Symfony\Component\Finder\Finder();
$polyfillFileInfos = $finder->files()->in(__DIR__ . '/vendor/symfony/polyfill-*')->name('*.php')->getIterator();
$polyfillFilePaths = [];
foreach ($polyfillFileInfos as $polyfillFileInfo) {
    $polyfillFilePaths[] = $polyfillFileInfo->getPathname();
}
return ['files-whitelist' => [
    // do not prefix "trigger_deprecation" from symfony - https://github.com/symfony/symfony/commit/0032b2a2893d3be592d4312b7b098fb9d71aca03
    // these paths are relative to this file location, so it should be in the root directory
    'vendor/symfony/deprecation-contracts/function.php',
] + $polyfillFilePaths, 'whitelist' => [
    // needed for autoload, that is not prefixed, since it's in bin/* file
    'Symplify\\*',
    'PhpCsFixer\\*',
    'PHP_CodeSniffer\\*',
    'SlevomatCodingStandard\\*',
    '_PhpScoper86aebf8cf357\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ContainerConfigurator',
    '_PhpScoper86aebf8cf357\\Symfony\\Component\\DependencyInjection\\Extension\\ExtensionInterface',
    '_PhpScoper86aebf8cf357\\Composer\\InstalledVersions',
    'Symfony\\Polyfill\\*',
], 'patchers' => [function (string $filePath, string $prefix, string $content) : string {
    if (!\_PhpScoper86aebf8cf357\Nette\Utils\Strings::endsWith($filePath, 'vendor/jean85/pretty-package-versions/src/PrettyVersions.php')) {
        return $content;
    }
    // see https://regex101.com/r/v8zRMm/1
    return \_PhpScoper86aebf8cf357\Nette\Utils\Strings::replace($content, '#' . $prefix . '\\\\Composer\\\\InstalledVersions#', '_PhpScoper86aebf8cf357\\Composer\\InstalledVersions');
}]];
