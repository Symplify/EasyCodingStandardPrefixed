<?php

declare (strict_types=1);
namespace _PhpScoperfacc742d2745\Migrify\PhpConfigPrinter;

use _PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use _PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use _PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory;
use _PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use _PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter;
use _PhpScoperfacc742d2745\Symfony\Component\Yaml\Parser;
use _PhpScoperfacc742d2745\Symfony\Component\Yaml\Yaml;
/**
 * @source https://raw.githubusercontent.com/archeoprog/maker-bundle/make-convert-services/src/Util/PhpServicesCreator.php
 *
 * @see \Migrify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\YamlToPhpTest
 */
final class YamlToPhpConverter
{
    /**
     * @var string[]
     */
    private const ROUTING_KEYS = ['resource', 'prefix', 'path', 'controller'];
    /**
     * @var Parser
     */
    private $yamlParser;
    /**
     * @var PhpParserPhpConfigPrinter
     */
    private $phpParserPhpConfigPrinter;
    /**
     * @var ContainerConfiguratorReturnClosureFactory
     */
    private $containerConfiguratorReturnClosureFactory;
    /**
     * @var YamlFileContentProviderInterface
     */
    private $yamlFileContentProvider;
    /**
     * @var CheckerServiceParametersShifter
     */
    private $checkerServiceParametersShifter;
    /**
     * @var RoutingConfiguratorReturnClosureFactory
     */
    private $routingConfiguratorReturnClosureFactory;
    public function __construct(\_PhpScoperfacc742d2745\Symfony\Component\Yaml\Parser $yamlParser, \_PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, \_PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory $returnClosureNodesFactory, \_PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory $routingConfiguratorReturnClosureFactory, \_PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface $yamlFileContentProvider, \_PhpScoperfacc742d2745\Migrify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter $checkerServiceParametersShifter)
    {
        $this->yamlParser = $yamlParser;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->containerConfiguratorReturnClosureFactory = $returnClosureNodesFactory;
        $this->yamlFileContentProvider = $yamlFileContentProvider;
        $this->checkerServiceParametersShifter = $checkerServiceParametersShifter;
        $this->routingConfiguratorReturnClosureFactory = $routingConfiguratorReturnClosureFactory;
    }
    public function convert(string $yaml) : string
    {
        $this->yamlFileContentProvider->setContent($yaml);
        /** @var mixed[]|null $yamlArray */
        $yamlArray = $this->yamlParser->parse($yaml, \_PhpScoperfacc742d2745\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS | \_PhpScoperfacc742d2745\Symfony\Component\Yaml\Yaml::PARSE_CONSTANT);
        if ($yamlArray === null) {
            return '';
        }
        return $this->convertYamlArray($yamlArray);
    }
    public function convertYamlArray(array $yamlArray) : string
    {
        if ($this->isRouteYaml($yamlArray)) {
            $return = $this->routingConfiguratorReturnClosureFactory->createFromArrayData($yamlArray);
        } else {
            $yamlArray = $this->checkerServiceParametersShifter->process($yamlArray);
            $return = $this->containerConfiguratorReturnClosureFactory->createFromYamlArray($yamlArray);
        }
        return $this->phpParserPhpConfigPrinter->prettyPrintFile([$return]);
    }
    private function isRouteYaml(array $yaml) : bool
    {
        foreach ($yaml as $value) {
            foreach (self::ROUTING_KEYS as $routeKey) {
                if (isset($value[$routeKey])) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
