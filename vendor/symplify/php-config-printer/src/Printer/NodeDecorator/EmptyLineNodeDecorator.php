<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Printer\NodeDecorator;

use _PhpScoper246d3630afdd\PhpParser\Node;
use _PhpScoper246d3630afdd\PhpParser\Node\Expr\Assign;
use _PhpScoper246d3630afdd\PhpParser\Node\Expr\Closure;
use _PhpScoper246d3630afdd\PhpParser\Node\Expr\MethodCall;
use _PhpScoper246d3630afdd\PhpParser\Node\Stmt;
use _PhpScoper246d3630afdd\PhpParser\Node\Stmt\Expression;
use _PhpScoper246d3630afdd\PhpParser\Node\Stmt\Nop;
use _PhpScoper246d3630afdd\PhpParser\NodeFinder;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class EmptyLineNodeDecorator
{
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    public function __construct(\_PhpScoper246d3630afdd\PhpParser\NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @param Node[] $stmts
     */
    public function decorate(array $stmts) : void
    {
        $closure = $this->nodeFinder->findFirstInstanceOf($stmts, \_PhpScoper246d3630afdd\PhpParser\Node\Expr\Closure::class);
        if (!$closure instanceof \_PhpScoper246d3630afdd\PhpParser\Node\Expr\Closure) {
            throw new \Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $newStmts = [];
        foreach ($closure->stmts as $key => $closureStmt) {
            if ($this->shouldAddEmptyLineBeforeStatement($key, $closureStmt)) {
                $newStmts[] = new \_PhpScoper246d3630afdd\PhpParser\Node\Stmt\Nop();
            }
            $newStmts[] = $closureStmt;
        }
        $closure->stmts = $newStmts;
    }
    private function shouldAddEmptyLineBeforeStatement(int $key, \_PhpScoper246d3630afdd\PhpParser\Node\Stmt $stmt) : bool
    {
        // do not add space before first item
        if ($key === 0) {
            return \false;
        }
        if (!$stmt instanceof \_PhpScoper246d3630afdd\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        $expr = $stmt->expr;
        if ($expr instanceof \_PhpScoper246d3630afdd\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        return $expr instanceof \_PhpScoper246d3630afdd\PhpParser\Node\Expr\MethodCall;
    }
}
