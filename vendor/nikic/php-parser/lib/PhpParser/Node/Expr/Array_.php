<?php

declare (strict_types=1);
namespace _PhpScoperaac5f7c652e4\PhpParser\Node\Expr;

use _PhpScoperaac5f7c652e4\PhpParser\Node\Expr;
class Array_ extends \_PhpScoperaac5f7c652e4\PhpParser\Node\Expr
{
    // For use in "kind" attribute
    const KIND_LONG = 1;
    // array() syntax
    const KIND_SHORT = 2;
    // [] syntax
    /** @var (ArrayItem|null)[] Items */
    public $items;
    /**
     * Constructs an array node.
     *
     * @param (ArrayItem|null)[] $items      Items of the array
     * @param array       $attributes Additional attributes
     */
    public function __construct(array $items = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->items = $items;
    }
    public function getSubNodeNames() : array
    {
        return ['items'];
    }
    public function getType() : string
    {
        return 'Expr_Array';
    }
}
