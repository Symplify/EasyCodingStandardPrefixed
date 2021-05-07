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
namespace PhpCsFixer\Fixer\ClassNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;
final class OrderedTraitsFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Trait `use` statements must be sorted alphabetically.', [new CodeSample("<?php class Foo { \nuse Z; use A; }\n")], null, 'Risky when depending on order of the imports.');
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound(CT::T_USE_TRAIT);
    }
    /**
     * {@inheritdoc}
     * @return bool
     */
    public function isRisky()
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        foreach ($this->findUseStatementsGroups($tokens) as $uses) {
            $this->sortUseStatements($tokens, $uses);
        }
    }
    /**
     * @return mixed[]
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    private function findUseStatementsGroups($tokens)
    {
        $uses = [];
        for ($index = 1, $max = \count($tokens); $index < $max; ++$index) {
            $token = $tokens[$index];
            if ($token->isWhitespace() || $token->isComment()) {
                continue;
            }
            if (!$token->isGivenKind(CT::T_USE_TRAIT)) {
                if (\count($uses) > 0) {
                    (yield $uses);
                    $uses = [];
                }
                continue;
            }
            $endIndex = $tokens->getNextTokenOfKind($index, [';', '{']);
            if ($tokens[$endIndex]->equals('{')) {
                $endIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $endIndex);
            }
            $use = [];
            for ($i = $index; $i <= $endIndex; ++$i) {
                $use[] = $tokens[$i];
            }
            $uses[$index] = Tokens::fromArray($use);
            $index = $endIndex;
        }
    }
    /**
     * @param array<int, Tokens> $uses
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    private function sortUseStatements($tokens, array $uses)
    {
        foreach ($uses as $use) {
            $this->sortMultipleTraitsInStatement($use);
        }
        $this->sort($tokens, $uses);
    }
    /**
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $use
     */
    private function sortMultipleTraitsInStatement($use)
    {
        $traits = [];
        $indexOfName = null;
        $name = [];
        for ($index = 0, $max = \count($use); $index < $max; ++$index) {
            $token = $use[$index];
            if ($token->isGivenKind([\T_STRING, \T_NS_SEPARATOR])) {
                $name[] = $token;
                if (null === $indexOfName) {
                    $indexOfName = $index;
                }
                continue;
            }
            if ($token->equalsAny([',', ';', '{'])) {
                $traits[$indexOfName] = Tokens::fromArray($name);
                $name = [];
                $indexOfName = null;
            }
            if ($token->equals('{')) {
                $index = $use->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $index);
            }
        }
        $this->sort($use, $traits);
    }
    /**
     * @param array<int, Tokens> $elements
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    private function sort($tokens, array $elements)
    {
        /**
         * @return string
         */
        $toTraitName = static function (Tokens $use) {
            $string = '';
            foreach ($use as $token) {
                if ($token->equalsAny([';', '{'])) {
                    break;
                }
                if ($token->isGivenKind([\T_NS_SEPARATOR, \T_STRING])) {
                    $string .= $token->getContent();
                }
            }
            return \ltrim($string, '\\');
        };
        $sortedElements = $elements;
        \uasort($sortedElements, static function (Tokens $useA, Tokens $useB) use($toTraitName) {
            return \strcasecmp($toTraitName($useA), $toTraitName($useB));
        });
        $sortedElements = \array_combine(\array_keys($elements), \array_values($sortedElements));
        foreach (\array_reverse($sortedElements, \true) as $index => $tokensToInsert) {
            $tokens->overrideRange($index, $index + \count($elements[$index]) - 1, $tokensToInsert);
        }
    }
}
