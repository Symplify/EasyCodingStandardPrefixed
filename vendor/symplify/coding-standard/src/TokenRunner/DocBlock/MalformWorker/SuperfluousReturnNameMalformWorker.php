<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\TokenRunner\DocBlock\MalformWorker;

use _PhpScoperf3dc21757def\Nette\Utils\Strings;
use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\CodingStandard\TokenRunner\Contract\DocBlock\MalformWorkerInterface;
final class SuperfluousReturnNameMalformWorker implements \Symplify\CodingStandard\TokenRunner\Contract\DocBlock\MalformWorkerInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/26Wy7Y/1
     */
    private const RETURN_VARIABLE_NAME_REGEX = '#(?<tag>@return)(?<type>\\s+[|\\\\\\w]+)?(\\s+)(?<' . self::VARIABLE_NAME_PART . '>\\$[\\w]+)#';
    /**
     * @var string[]
     */
    private const ALLOWED_VARIABLE_NAMES = ['$this'];
    /**
     * @var string
     * @see https://regex101.com/r/IE9fA6/1
     */
    private const VARIABLE_NAME_REGEX = '#\\$\\w+#';
    /**
     * @var string
     */
    private const VARIABLE_NAME_PART = 'variableName';
    public function work(string $docContent, \PhpCsFixer\Tokenizer\Tokens $tokens, int $position) : string
    {
        $docBlock = new \PhpCsFixer\DocBlock\DocBlock($docContent);
        $lines = $docBlock->getLines();
        foreach ($lines as $line) {
            $match = \_PhpScoperf3dc21757def\Nette\Utils\Strings::match($line->getContent(), self::RETURN_VARIABLE_NAME_REGEX);
            if ($match === null) {
                continue;
            }
            if ($this->shouldSkip($match, $line->getContent())) {
                continue;
            }
            $newLineContent = \_PhpScoperf3dc21757def\Nette\Utils\Strings::replace($line->getContent(), self::RETURN_VARIABLE_NAME_REGEX, function (array $match) {
                $replacement = $match['tag'];
                if ($match['type'] !== []) {
                    $replacement .= $match['type'];
                }
                return $replacement;
            });
            $line->setContent($newLineContent);
        }
        return $docBlock->getContent();
    }
    /**
     * @param array<string, string> $match
     */
    private function shouldSkip(array $match, string $content) : bool
    {
        if (\in_array($match[self::VARIABLE_NAME_PART], self::ALLOWED_VARIABLE_NAMES, \true)) {
            return \true;
        }
        // has multiple return values? "@return array $one, $two"
        return \count(\_PhpScoperf3dc21757def\Nette\Utils\Strings::matchAll($content, self::VARIABLE_NAME_REGEX)) >= 2;
    }
}
