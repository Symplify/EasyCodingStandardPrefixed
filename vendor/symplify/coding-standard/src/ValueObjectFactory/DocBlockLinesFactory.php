<?php

namespace Symplify\CodingStandard\ValueObjectFactory;

use ECSPrefix20210507\Nette\Utils\Strings;
use Symplify\CodingStandard\ValueObject\DocBlockLines;
final class DocBlockLinesFactory
{
    /**
     * @see https://regex101.com/r/CUxOj5/1
     * @var string
     */
    const BEGINNING_OF_DOC_BLOCK_REGEX = '/^(\\/\\*\\*[\\n]?)/';
    /**
     * @see https://regex101.com/r/otQGPe/1
     * @var string
     */
    const END_OF_DOC_BLOCK_REGEX = '/(\\*\\/)$/';
    /**
     * @param string $docBlock
     * @return \Symplify\CodingStandard\ValueObject\DocBlockLines
     */
    public function createFromDocBlock($docBlock)
    {
        // Remove the prefix '/**'
        $docBlock = Strings::replace($docBlock, self::BEGINNING_OF_DOC_BLOCK_REGEX);
        // Remove the suffix '*/'
        $docBlock = Strings::replace($docBlock, self::END_OF_DOC_BLOCK_REGEX);
        // Remove extra whitespace at the end
        $docBlock = \rtrim($docBlock);
        $docBlockLines = $this->splitToLines($docBlock);
        $docBlockLines = \array_map(function (string $line) : string {
            $noWhitespace = Strings::trim($line, Strings::TRIM_CHARACTERS);
            // Remove asterisks on the left side, plus additional whitespace
            return \ltrim($noWhitespace, Strings::TRIM_CHARACTERS . '*');
        }, $docBlockLines);
        return $this->createFromLines($docBlockLines);
    }
    /**
     * @param string[] $docBlockLines
     * @return \Symplify\CodingStandard\ValueObject\DocBlockLines
     */
    private function createFromLines(array $docBlockLines)
    {
        $descriptionLines = [];
        $otherLines = [];
        $collectDescriptionLines = \true;
        foreach ($docBlockLines as $docBlockLine) {
            if (Strings::startsWith($docBlockLine, '@') || Strings::startsWith($docBlockLine, '{@')) {
                // The line has a special meaning (it's an annotation, or something like {@inheritdoc})
                $collectDescriptionLines = \false;
            }
            if ($collectDescriptionLines) {
                $descriptionLines[] = $docBlockLine;
            } else {
                $otherLines[] = $docBlockLine;
            }
        }
        return new DocBlockLines($descriptionLines, $otherLines);
    }
    /**
     * @return mixed[]
     * @param string $string
     */
    private function splitToLines($string)
    {
        return \explode(\PHP_EOL, $string);
    }
}
