<?php

declare (strict_types=1);
namespace _PhpScoperba5852cc6147\PhpParser\Builder;

use _PhpScoperba5852cc6147\PhpParser\Builder;
use _PhpScoperba5852cc6147\PhpParser\BuilderHelpers;
use _PhpScoperba5852cc6147\PhpParser\Node;
use _PhpScoperba5852cc6147\PhpParser\Node\Stmt;
class TraitUse implements \_PhpScoperba5852cc6147\PhpParser\Builder
{
    protected $traits = [];
    protected $adaptations = [];
    /**
     * Creates a trait use builder.
     *
     * @param Node\Name|string ...$traits Names of used traits
     */
    public function __construct(...$traits)
    {
        foreach ($traits as $trait) {
            $this->and($trait);
        }
    }
    /**
     * Adds used trait.
     *
     * @param Node\Name|string $trait Trait name
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function and($trait)
    {
        $this->traits[] = \_PhpScoperba5852cc6147\PhpParser\BuilderHelpers::normalizeName($trait);
        return $this;
    }
    /**
     * Adds trait adaptation.
     *
     * @param Stmt\TraitUseAdaptation|Builder\TraitUseAdaptation $adaptation Trait adaptation
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function with($adaptation)
    {
        $adaptation = \_PhpScoperba5852cc6147\PhpParser\BuilderHelpers::normalizeNode($adaptation);
        if (!$adaptation instanceof \_PhpScoperba5852cc6147\PhpParser\Node\Stmt\TraitUseAdaptation) {
            throw new \LogicException('Adaptation must have type TraitUseAdaptation');
        }
        $this->adaptations[] = $adaptation;
        return $this;
    }
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \_PhpScoperba5852cc6147\PhpParser\Node
    {
        return new \_PhpScoperba5852cc6147\PhpParser\Node\Stmt\TraitUse($this->traits, $this->adaptations);
    }
}
