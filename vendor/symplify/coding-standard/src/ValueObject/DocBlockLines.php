<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\ValueObject;

use _PhpScoper6b644dbe715d\Nette\Utils\Strings;
final class DocBlockLines
{
    /**
     * @var array<string>
     */
    private $descriptionLines = [];
    /**
     * @var array<string>
     */
    private $otherLines = [];
    /**
     * @param array<string> $descriptionLines
     * @param array<string> $otherLines
     */
    public function __construct(array $descriptionLines, array $otherLines)
    {
        $this->descriptionLines = $descriptionLines;
        $this->otherLines = $otherLines;
    }
    /**
     * @return array<string>
     */
    public function getDescriptionLines() : array
    {
        return $this->descriptionLines;
    }
    /**
     * @return array<string>
     */
    public function getOtherLines() : array
    {
        return $this->otherLines;
    }
    public function hasListDescriptionLines() : bool
    {
        foreach ($this->descriptionLines as $descriptionLine) {
            if (\_PhpScoper6b644dbe715d\Nette\Utils\Strings::startsWith($descriptionLine, '-')) {
                return \true;
            }
        }
        return \false;
    }
}
