<?php

declare (strict_types=1);
namespace _PhpScoperb44a315fec16\PhpParser\Node\Stmt;

use _PhpScoperb44a315fec16\PhpParser\Node\Stmt;
class InlineHTML extends \_PhpScoperb44a315fec16\PhpParser\Node\Stmt
{
    /** @var string String */
    public $value;
    /**
     * Constructs an inline HTML node.
     *
     * @param string $value      String
     * @param array  $attributes Additional attributes
     */
    public function __construct(string $value, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->value = $value;
    }
    public function getSubNodeNames() : array
    {
        return ['value'];
    }
    public function getType() : string
    {
        return 'Stmt_InlineHTML';
    }
}
