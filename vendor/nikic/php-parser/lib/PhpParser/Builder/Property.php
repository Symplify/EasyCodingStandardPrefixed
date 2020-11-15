<?php

declare (strict_types=1);
namespace _PhpScoperd9c3b46af121\PhpParser\Builder;

use _PhpScoperd9c3b46af121\PhpParser;
use _PhpScoperd9c3b46af121\PhpParser\BuilderHelpers;
use _PhpScoperd9c3b46af121\PhpParser\Node\Identifier;
use _PhpScoperd9c3b46af121\PhpParser\Node\Name;
use _PhpScoperd9c3b46af121\PhpParser\Node\NullableType;
use _PhpScoperd9c3b46af121\PhpParser\Node\Stmt;
class Property implements \_PhpScoperd9c3b46af121\PhpParser\Builder
{
    protected $name;
    protected $flags = 0;
    protected $default = null;
    protected $attributes = [];
    /** @var null|Identifier|Name|NullableType */
    protected $type;
    /**
     * Creates a property builder.
     *
     * @param string $name Name of the property
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Makes the property public.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePublic()
    {
        $this->flags = \_PhpScoperd9c3b46af121\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
        return $this;
    }
    /**
     * Makes the property protected.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeProtected()
    {
        $this->flags = \_PhpScoperd9c3b46af121\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
        return $this;
    }
    /**
     * Makes the property private.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePrivate()
    {
        $this->flags = \_PhpScoperd9c3b46af121\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
        return $this;
    }
    /**
     * Makes the property static.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeStatic()
    {
        $this->flags = \_PhpScoperd9c3b46af121\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Class_::MODIFIER_STATIC);
        return $this;
    }
    /**
     * Sets default value for the property.
     *
     * @param mixed $value Default value to use
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDefault($value)
    {
        $this->default = \_PhpScoperd9c3b46af121\PhpParser\BuilderHelpers::normalizeValue($value);
        return $this;
    }
    /**
     * Sets doc comment for the property.
     *
     * @param PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment)
    {
        $this->attributes = ['comments' => [\_PhpScoperd9c3b46af121\PhpParser\BuilderHelpers::normalizeDocComment($docComment)]];
        return $this;
    }
    /**
     * Sets the property type for PHP 7.4+.
     *
     * @param string|Name|NullableType|Identifier $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = \_PhpScoperd9c3b46af121\PhpParser\BuilderHelpers::normalizeType($type);
        return $this;
    }
    /**
     * Returns the built class node.
     *
     * @return Stmt\Property The built property node
     */
    public function getNode() : \_PhpScoperd9c3b46af121\PhpParser\Node
    {
        return new \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Property($this->flags !== 0 ? $this->flags : \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC, [new \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\PropertyProperty($this->name, $this->default)], $this->attributes, $this->type);
    }
}
