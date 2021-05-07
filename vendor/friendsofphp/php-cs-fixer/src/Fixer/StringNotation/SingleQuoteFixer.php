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
namespace PhpCsFixer\Fixer\StringNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Gregor Harlan <gharlan@web.de>
 */
final class SingleQuoteFixer extends AbstractFixer implements ConfigurableFixerInterface
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        $codeSample = <<<'EOF'
<?php

namespace ECSPrefix20210507;

$a = "sample";
$b = "sample with 'single-quotes'";

EOF;
        return new FixerDefinition('Convert double quotes to single quotes for simple strings.', [new CodeSample($codeSample), new CodeSample($codeSample, ['strings_containing_single_quote_chars' => \true])]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run after BacktickToShellExecFixer, EscapeImplicitBackslashesFixer.
     * @return int
     */
    public function getPriority()
    {
        return 0;
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound(\T_CONSTANT_ENCAPSED_STRING);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(\T_CONSTANT_ENCAPSED_STRING)) {
                continue;
            }
            $content = $token->getContent();
            $prefix = '';
            if ('b' === \strtolower($content[0])) {
                $prefix = $content[0];
                $content = \substr($content, 1);
            }
            if ('"' === $content[0] && (\true === $this->configuration['strings_containing_single_quote_chars'] || \false === \strpos($content, "'")) && !Preg::match('/(?<!\\\\)(?:\\\\{2})*\\\\(?!["$\\\\])/', $content)) {
                $content = \substr($content, 1, -1);
                $content = \str_replace(['\\"', '\\$', '\''], ['"', '$', '\\\''], $content);
                $tokens[$index] = new Token([\T_CONSTANT_ENCAPSED_STRING, $prefix . '\'' . $content . '\'']);
            }
        }
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface
     */
    protected function createConfigurationDefinition()
    {
        return new FixerConfigurationResolver([(new FixerOptionBuilder('strings_containing_single_quote_chars', 'Whether to fix double-quoted strings that contains single-quotes.'))->setAllowedTypes(['bool'])->setDefault(\false)->getOption()]);
    }
}
