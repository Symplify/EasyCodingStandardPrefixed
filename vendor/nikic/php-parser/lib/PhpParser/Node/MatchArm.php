<?php

declare (strict_types=1);
namespace _PhpScoperad4605bb9267\PhpParser\Node;

use _PhpScoperad4605bb9267\PhpParser\Node;
use _PhpScoperad4605bb9267\PhpParser\NodeAbstract;
class MatchArm extends \_PhpScoperad4605bb9267\PhpParser\NodeAbstract
{
    /** @var null|Node\Expr[] */
    public $conds;
    /** @var Node\Expr */
    public $body;
    /**
     * @param null|Node\Expr[] $conds
     */
    public function __construct($conds, \_PhpScoperad4605bb9267\PhpParser\Node\Expr $body, array $attributes = [])
    {
        $this->conds = $conds;
        $this->body = $body;
        $this->attributes = $attributes;
    }
    public function getSubNodeNames() : array
    {
        return ['conds', 'body'];
    }
    public function getType() : string
    {
        return 'MatchArm';
    }
}
