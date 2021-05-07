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
namespace PhpCsFixer\Fixer\LanguageConstruct;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\FixerDefinition\VersionSpecification;
use PhpCsFixer\FixerDefinition\VersionSpecificCodeSample;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Filippo Tessarotto <zoeslam@gmail.com>
 */
final class ExplicitIndirectVariableFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Add curly braces to indirect variables to make them clear to understand. Requires PHP >= 7.0.', [new VersionSpecificCodeSample(<<<'EOT'
<?php

namespace ECSPrefix20210507;

echo ${$foo};
echo ${$foo}['bar'];
echo $foo->{$bar}['baz'];
echo $foo->{$callback}($baz);

EOT
, new VersionSpecification(70000))]);
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return \PHP_VERSION_ID >= 70000 && $tokens->isTokenKindFound(\T_VARIABLE);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        for ($index = $tokens->count() - 1; $index > 1; --$index) {
            $token = $tokens[$index];
            if (!$token->isGivenKind(\T_VARIABLE)) {
                continue;
            }
            $prevIndex = $tokens->getPrevMeaningfulToken($index);
            $prevToken = $tokens[$prevIndex];
            if (!$prevToken->equals('$') && !$prevToken->isObjectOperator()) {
                continue;
            }
            $openingBrace = CT::T_DYNAMIC_VAR_BRACE_OPEN;
            $closingBrace = CT::T_DYNAMIC_VAR_BRACE_CLOSE;
            if ($prevToken->isObjectOperator()) {
                $openingBrace = CT::T_DYNAMIC_PROP_BRACE_OPEN;
                $closingBrace = CT::T_DYNAMIC_PROP_BRACE_CLOSE;
            }
            $tokens->overrideRange($index, $index, [new Token([$openingBrace, '{']), new Token([\T_VARIABLE, $token->getContent()]), new Token([$closingBrace, '}'])]);
        }
    }
}
