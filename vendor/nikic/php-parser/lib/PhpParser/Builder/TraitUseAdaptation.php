<?php

declare (strict_types=1);
namespace _PhpScoperf361a7d70552\PhpParser\Builder;

use _PhpScoperf361a7d70552\PhpParser\Builder;
use _PhpScoperf361a7d70552\PhpParser\BuilderHelpers;
use _PhpScoperf361a7d70552\PhpParser\Node;
use _PhpScoperf361a7d70552\PhpParser\Node\Stmt;
class TraitUseAdaptation implements \_PhpScoperf361a7d70552\PhpParser\Builder
{
    const TYPE_UNDEFINED = 0;
    const TYPE_ALIAS = 1;
    const TYPE_PRECEDENCE = 2;
    /** @var int Type of building adaptation */
    protected $type;
    protected $trait;
    protected $method;
    protected $modifier = null;
    protected $alias = null;
    protected $insteadof = [];
    /**
     * Creates a trait use adaptation builder.
     *
     * @param Node\Name|string|null  $trait  Name of adaptated trait
     * @param Node\Identifier|string $method Name of adaptated method
     */
    public function __construct($trait, $method)
    {
        $this->type = self::TYPE_UNDEFINED;
        $this->trait = \is_null($trait) ? null : \_PhpScoperf361a7d70552\PhpParser\BuilderHelpers::normalizeName($trait);
        $this->method = \_PhpScoperf361a7d70552\PhpParser\BuilderHelpers::normalizeIdentifier($method);
    }
    /**
     * Sets alias of method.
     *
     * @param Node\Identifier|string $alias Alias for adaptated method
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function as($alias)
    {
        if ($this->type === self::TYPE_UNDEFINED) {
            $this->type = self::TYPE_ALIAS;
        }
        if ($this->type !== self::TYPE_ALIAS) {
            throw new \LogicException('Cannot set alias for not alias adaptation buider');
        }
        $this->alias = $alias;
        return $this;
    }
    /**
     * Sets adaptated method public.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePublic()
    {
        $this->setModifier(\_PhpScoperf361a7d70552\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
        return $this;
    }
    /**
     * Sets adaptated method protected.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeProtected()
    {
        $this->setModifier(\_PhpScoperf361a7d70552\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
        return $this;
    }
    /**
     * Sets adaptated method private.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePrivate()
    {
        $this->setModifier(\_PhpScoperf361a7d70552\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
        return $this;
    }
    /**
     * Adds overwritten traits.
     *
     * @param Node\Name|string ...$traits Traits for overwrite
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function insteadof(...$traits)
    {
        if ($this->type === self::TYPE_UNDEFINED) {
            if (\is_null($this->trait)) {
                throw new \LogicException('Precedence adaptation must have trait');
            }
            $this->type = self::TYPE_PRECEDENCE;
        }
        if ($this->type !== self::TYPE_PRECEDENCE) {
            throw new \LogicException('Cannot add overwritten traits for not precedence adaptation buider');
        }
        foreach ($traits as $trait) {
            $this->insteadof[] = \_PhpScoperf361a7d70552\PhpParser\BuilderHelpers::normalizeName($trait);
        }
        return $this;
    }
    protected function setModifier(int $modifier)
    {
        if ($this->type === self::TYPE_UNDEFINED) {
            $this->type = self::TYPE_ALIAS;
        }
        if ($this->type !== self::TYPE_ALIAS) {
            throw new \LogicException('Cannot set access modifier for not alias adaptation buider');
        }
        if (\is_null($this->modifier)) {
            $this->modifier = $modifier;
        } else {
            throw new \LogicException('Multiple access type modifiers are not allowed');
        }
    }
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \_PhpScoperf361a7d70552\PhpParser\Node
    {
        switch ($this->type) {
            case self::TYPE_ALIAS:
                return new \_PhpScoperf361a7d70552\PhpParser\Node\Stmt\TraitUseAdaptation\Alias($this->trait, $this->method, $this->modifier, $this->alias);
            case self::TYPE_PRECEDENCE:
                return new \_PhpScoperf361a7d70552\PhpParser\Node\Stmt\TraitUseAdaptation\Precedence($this->trait, $this->method, $this->insteadof);
            default:
                throw new \LogicException('Type of adaptation is not defined');
        }
    }
}
