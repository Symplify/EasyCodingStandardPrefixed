<?php

declare (strict_types=1);
namespace _PhpScopera1f11cc38772\PhpParser\Builder;

use _PhpScopera1f11cc38772\PhpParser;
use _PhpScopera1f11cc38772\PhpParser\BuilderHelpers;
use _PhpScopera1f11cc38772\PhpParser\Node;
class Param implements \_PhpScopera1f11cc38772\PhpParser\Builder
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
        $this->default = \_PhpScopera1f11cc38772\PhpParser\BuilderHelpers::normalizeValue($value);
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
        $this->type = \_PhpScopera1f11cc38772\PhpParser\BuilderHelpers::normalizeType($type);
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
    public function getNode() : \_PhpScopera1f11cc38772\PhpParser\Node
    {
        return new \_PhpScopera1f11cc38772\PhpParser\Node\Param(new \_PhpScopera1f11cc38772\PhpParser\Node\Expr\Variable($this->name), $this->default, $this->type, $this->byRef, $this->variadic);
    }
}
