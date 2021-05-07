<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Tokenizer;

use PhpCsFixer\Utils;
use ECSPrefix20210507\Symfony\Component\Finder\Finder;
use ECSPrefix20210507\Symfony\Component\Finder\SplFileInfo;
/**
 * Collection of Transformer classes.
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class Transformers
{
    /**
     * The registered transformers.
     *
     * @var TransformerInterface[]
     */
    private $items = [];
    /**
     * Register built in Transformers.
     */
    private function __construct()
    {
        $this->registerBuiltInTransformers();
        \usort($this->items, static function (\PhpCsFixer\Tokenizer\TransformerInterface $a, \PhpCsFixer\Tokenizer\TransformerInterface $b) {
            return Utils::cmpInt($b->getPriority(), $a->getPriority());
            // TODO: update to use spaceship operator (PHP 7.0 required)
        });
    }
    /**
     * @return $this
     */
    public static function createSingleton()
    {
        static $instance = null;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }
    /**
     * Transform given Tokens collection through all Transformer classes.
     *
     * @param Tokens $tokens Tokens collection
     * @return void
     */
    public function transform($tokens)
    {
        foreach ($this->items as $transformer) {
            foreach ($tokens as $index => $token) {
                $transformer->process($tokens, $token, $index);
            }
        }
    }
    /**
     * @param TransformerInterface $transformer Transformer
     * @return void
     */
    private function registerTransformer($transformer)
    {
        if (\PHP_VERSION_ID >= $transformer->getRequiredPhpVersionId()) {
            $this->items[] = $transformer;
        }
    }
    /**
     * @return void
     */
    private function registerBuiltInTransformers()
    {
        static $registered = \false;
        if ($registered) {
            return;
        }
        $registered = \true;
        foreach ($this->findBuiltInTransformers() as $transformer) {
            $this->registerTransformer($transformer);
        }
    }
    /**
     * @return mixed[]
     */
    private function findBuiltInTransformers()
    {
        /** @var SplFileInfo $file */
        foreach (Finder::create()->files()->in(__DIR__ . '/Transformer') as $file) {
            $relativeNamespace = $file->getRelativePath();
            $class = __NAMESPACE__ . '\\Transformer\\' . ($relativeNamespace ? $relativeNamespace . '\\' : '') . $file->getBasename('.php');
            (yield new $class());
        }
    }
}
