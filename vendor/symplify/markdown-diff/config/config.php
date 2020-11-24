<?php

declare (strict_types=1);
namespace _PhpScoperbd5fb781fe24;

use _PhpScoperbd5fb781fe24\SebastianBergmann\Diff\Differ;
use _PhpScoperbd5fb781fe24\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoperbd5fb781fe24\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoperbd5fb781fe24\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoperbd5fb781fe24\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\MarkdownDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperbd5fb781fe24\SebastianBergmann\Diff\Differ::class);
    // markdown
    $services->set('markdownDiffOutputBuilder', \_PhpScoperbd5fb781fe24\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoperbd5fb781fe24\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoperbd5fb781fe24\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoperbd5fb781fe24\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class)->arg('$markdownDiffer', \_PhpScoperbd5fb781fe24\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set(\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
