<?php

declare (strict_types=1);
namespace _PhpScoper224ae0b86670\PhpParser\Builder;

use _PhpScoper224ae0b86670\PhpParser;
use _PhpScoper224ae0b86670\PhpParser\BuilderHelpers;
use _PhpScoper224ae0b86670\PhpParser\Node;
class Param implements \_PhpScoper224ae0b86670\PhpParser\Builder
{
    protected $name;
    protected $default = null;
    /** @var Node\Identifier|Node\Name|Node\NullableType|null */
    protected $type = null;
    protected $byRef = \false;
    protected $variadic = \false;
    /**
     * Creates a parameter builder.
     *
     * @param string $name Name of the parameter
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Sets default value for the parameter.
     *
     * @param mixed $value Default value to use
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDefault($value)
    {
        $this->default = \_PhpScoper224ae0b86670\PhpParser\BuilderHelpers::normalizeValue($value);
        return $this;
    }
    /**
     * Sets type for the parameter.
     *
     * @param string|Node\Name|Node\NullableType|Node\UnionType $type Parameter type
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setType($type)
    {
        $this->type = \_PhpScoper224ae0b86670\PhpParser\BuilderHelpers::normalizeType($type);
        if ($this->type == 'void') {
            throw new \LogicException('Parameter type cannot be void');
        }
        return $this;
    }
    /**
     * Sets type for the parameter.
     *
     * @param string|Node\Name|Node\NullableType|Node\UnionType $type Parameter type
     *
     * @return $this The builder instance (for fluid interface)
     *
     * @deprecated Use setType() instead
     */
    public function setTypeHint($type)
    {
        return $this->setType($type);
    }
    /**
     * Make the parameter accept the value by reference.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeByRef()
    {
        $this->byRef = \true;
        return $this;
    }
    /**
     * Make the parameter variadic
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeVariadic()
    {
        $this->variadic = \true;
        return $this;
    }
    /**
     * Returns the built parameter node.
     *
     * @return Node\Param The built parameter node
     */
    public function getNode() : \_PhpScoper224ae0b86670\PhpParser\Node
    {
        return new \_PhpScoper224ae0b86670\PhpParser\Node\Param(new \_PhpScoper224ae0b86670\PhpParser\Node\Expr\Variable($this->name), $this->default, $this->type, $this->byRef, $this->variadic);
    }
}
