<?php

declare (strict_types=1);
namespace _PhpScoper4d3fa30a680b\PhpParser\Node;

use _PhpScoper4d3fa30a680b\PhpParser\NodeAbstract;
class NullableType extends \_PhpScoper4d3fa30a680b\PhpParser\NodeAbstract
{
    /** @var Identifier|Name Type */
    public $type;
    /**
     * Constructs a nullable type (wrapping another type).
     *
     * @param string|Identifier|Name $type       Type
     * @param array                  $attributes Additional attributes
     */
    public function __construct($type, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->type = \is_string($type) ? new \_PhpScoper4d3fa30a680b\PhpParser\Node\Identifier($type) : $type;
    }
    public function getSubNodeNames() : array
    {
        return ['type'];
    }
    public function getType() : string
    {
        return 'NullableType';
    }
}
