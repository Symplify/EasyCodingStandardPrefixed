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
namespace PhpCsFixer\Fixer\Basic;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * Fixer for rules defined in PSR1 ¶2.2.
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class EncodingFixer extends AbstractFixer
{
    private $BOM;
    public function __construct()
    {
        parent::__construct();
        $this->BOM = \pack('CCC', 0xef, 0xbb, 0xbf);
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('PHP code MUST use only UTF-8 without BOM (remove BOM).', [new CodeSample($this->BOM . '<?php

echo "Hello!";
')]);
    }
    /**
     * {@inheritdoc}
     * @return int
     */
    public function getPriority()
    {
        // must run first (at least before Fixers that using Tokens) - for speed reason of whole fixing process
        return 100;
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
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
        $content = $tokens[0]->getContent();
        if (0 === \strncmp($content, $this->BOM, 3)) {
            /** @var false|string $newContent until support for PHP 5.6 is dropped */
            $newContent = \substr($content, 3);
            if (\false === $newContent) {
                $newContent = '';
                // substr returns false rather than an empty string when starting at the end
            }
            if ('' === $newContent) {
                $tokens->clearAt(0);
            } else {
                $tokens[0] = new Token([$tokens[0]->getId(), $newContent]);
            }
        }
    }
}
