<?php

declare (strict_types=1);
namespace _PhpScoper5ade29b97028\PhpParser;

use _PhpScoper5ade29b97028\PhpParser\Node\Arg;
use _PhpScoper5ade29b97028\PhpParser\Node\Expr;
use _PhpScoper5ade29b97028\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper5ade29b97028\PhpParser\Node\Identifier;
use _PhpScoper5ade29b97028\PhpParser\Node\Name;
use _PhpScoper5ade29b97028\PhpParser\Node\Scalar\String_;
use _PhpScoper5ade29b97028\PhpParser\Node\Stmt\Use_;
class BuilderFactory
{
    /**
     * Creates a namespace builder.
     *
     * @param null|string|Node\Name $name Name of the namespace
     *
     * @return Builder\Namespace_ The created namespace builder
     */
    public function namespace($name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Namespace_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Namespace_($name);
    }
    /**
     * Creates a class builder.
     *
     * @param string $name Name of the class
     *
     * @return Builder\Class_ The created class builder
     */
    public function class(string $name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Class_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Class_($name);
    }
    /**
     * Creates an interface builder.
     *
     * @param string $name Name of the interface
     *
     * @return Builder\Interface_ The created interface builder
     */
    public function interface(string $name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Interface_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Interface_($name);
    }
    /**
     * Creates a trait builder.
     *
     * @param string $name Name of the trait
     *
     * @return Builder\Trait_ The created trait builder
     */
    public function trait(string $name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Trait_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Trait_($name);
    }
    /**
     * Creates a trait use builder.
     *
     * @param Node\Name|string ...$traits Trait names
     *
     * @return Builder\TraitUse The create trait use builder
     */
    public function useTrait(...$traits) : \_PhpScoper5ade29b97028\PhpParser\Builder\TraitUse
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\TraitUse(...$traits);
    }
    /**
     * Creates a trait use adaptation builder.
     *
     * @param Node\Name|string|null  $trait  Trait name
     * @param Node\Identifier|string $method Method name
     *
     * @return Builder\TraitUseAdaptation The create trait use adaptation builder
     */
    public function traitUseAdaptation($trait, $method = null) : \_PhpScoper5ade29b97028\PhpParser\Builder\TraitUseAdaptation
    {
        if ($method === null) {
            $method = $trait;
            $trait = null;
        }
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\TraitUseAdaptation($trait, $method);
    }
    /**
     * Creates a method builder.
     *
     * @param string $name Name of the method
     *
     * @return Builder\Method The created method builder
     */
    public function method(string $name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Method
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Method($name);
    }
    /**
     * Creates a parameter builder.
     *
     * @param string $name Name of the parameter
     *
     * @return Builder\Param The created parameter builder
     */
    public function param(string $name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Param
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Param($name);
    }
    /**
     * Creates a property builder.
     *
     * @param string $name Name of the property
     *
     * @return Builder\Property The created property builder
     */
    public function property(string $name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Property
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Property($name);
    }
    /**
     * Creates a function builder.
     *
     * @param string $name Name of the function
     *
     * @return Builder\Function_ The created function builder
     */
    public function function(string $name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Function_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Function_($name);
    }
    /**
     * Creates a namespace/class use builder.
     *
     * @param Node\Name|string $name Name of the entity (namespace or class) to alias
     *
     * @return Builder\Use_ The created use builder
     */
    public function use($name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Use_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Use_($name, \_PhpScoper5ade29b97028\PhpParser\Node\Stmt\Use_::TYPE_NORMAL);
    }
    /**
     * Creates a function use builder.
     *
     * @param Node\Name|string $name Name of the function to alias
     *
     * @return Builder\Use_ The created use function builder
     */
    public function useFunction($name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Use_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Use_($name, \_PhpScoper5ade29b97028\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
    }
    /**
     * Creates a constant use builder.
     *
     * @param Node\Name|string $name Name of the const to alias
     *
     * @return Builder\Use_ The created use const builder
     */
    public function useConst($name) : \_PhpScoper5ade29b97028\PhpParser\Builder\Use_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Builder\Use_($name, \_PhpScoper5ade29b97028\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT);
    }
    /**
     * Creates node a for a literal value.
     *
     * @param Expr|bool|null|int|float|string|array $value $value
     *
     * @return Expr
     */
    public function val($value) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr
    {
        return \_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeValue($value);
    }
    /**
     * Creates variable node.
     *
     * @param string|Expr $name Name
     *
     * @return Expr\Variable
     */
    public function var($name) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\Variable
    {
        if (!\is_string($name) && !$name instanceof \_PhpScoper5ade29b97028\PhpParser\Node\Expr) {
            throw new \LogicException('Variable name must be string or Expr');
        }
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\Variable($name);
    }
    /**
     * Normalizes an argument list.
     *
     * Creates Arg nodes for all arguments and converts literal values to expressions.
     *
     * @param array $args List of arguments to normalize
     *
     * @return Arg[]
     */
    public function args(array $args) : array
    {
        $normalizedArgs = [];
        foreach ($args as $arg) {
            if ($arg instanceof \_PhpScoper5ade29b97028\PhpParser\Node\Arg) {
                $normalizedArgs[] = $arg;
            } else {
                $normalizedArgs[] = new \_PhpScoper5ade29b97028\PhpParser\Node\Arg(\_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeValue($arg));
            }
        }
        return $normalizedArgs;
    }
    /**
     * Creates a function call node.
     *
     * @param string|Name|Expr $name Function name
     * @param array            $args Function arguments
     *
     * @return Expr\FuncCall
     */
    public function funcCall($name, array $args = []) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\FuncCall
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\FuncCall(\_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeNameOrExpr($name), $this->args($args));
    }
    /**
     * Creates a method call node.
     *
     * @param Expr                   $var  Variable the method is called on
     * @param string|Identifier|Expr $name Method name
     * @param array                  $args Method arguments
     *
     * @return Expr\MethodCall
     */
    public function methodCall(\_PhpScoper5ade29b97028\PhpParser\Node\Expr $var, $name, array $args = []) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\MethodCall
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\MethodCall($var, \_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeIdentifierOrExpr($name), $this->args($args));
    }
    /**
     * Creates a static method call node.
     *
     * @param string|Name|Expr       $class Class name
     * @param string|Identifier|Expr $name  Method name
     * @param array                  $args  Method arguments
     *
     * @return Expr\StaticCall
     */
    public function staticCall($class, $name, array $args = []) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\StaticCall
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\StaticCall(\_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeNameOrExpr($class), \_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeIdentifierOrExpr($name), $this->args($args));
    }
    /**
     * Creates an object creation node.
     *
     * @param string|Name|Expr $class Class name
     * @param array            $args  Constructor arguments
     *
     * @return Expr\New_
     */
    public function new($class, array $args = []) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\New_
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\New_(\_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeNameOrExpr($class), $this->args($args));
    }
    /**
     * Creates a constant fetch node.
     *
     * @param string|Name $name Constant name
     *
     * @return Expr\ConstFetch
     */
    public function constFetch($name) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\ConstFetch(\_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeName($name));
    }
    /**
     * Creates a property fetch node.
     *
     * @param Expr                   $var  Variable holding object
     * @param string|Identifier|Expr $name Property name
     *
     * @return Expr\PropertyFetch
     */
    public function propertyFetch(\_PhpScoper5ade29b97028\PhpParser\Node\Expr $var, $name) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\PropertyFetch
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\PropertyFetch($var, \_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeIdentifierOrExpr($name));
    }
    /**
     * Creates a class constant fetch node.
     *
     * @param string|Name|Expr  $class Class name
     * @param string|Identifier $name  Constant name
     *
     * @return Expr\ClassConstFetch
     */
    public function classConstFetch($class, $name) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\ClassConstFetch
    {
        return new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\ClassConstFetch(\_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeNameOrExpr($class), \_PhpScoper5ade29b97028\PhpParser\BuilderHelpers::normalizeIdentifier($name));
    }
    /**
     * Creates nested Concat nodes from a list of expressions.
     *
     * @param Expr|string ...$exprs Expressions or literal strings
     *
     * @return Concat
     */
    public function concat(...$exprs) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr\BinaryOp\Concat
    {
        $numExprs = \count($exprs);
        if ($numExprs < 2) {
            throw new \LogicException('Expected at least two expressions');
        }
        $lastConcat = $this->normalizeStringExpr($exprs[0]);
        for ($i = 1; $i < $numExprs; $i++) {
            $lastConcat = new \_PhpScoper5ade29b97028\PhpParser\Node\Expr\BinaryOp\Concat($lastConcat, $this->normalizeStringExpr($exprs[$i]));
        }
        return $lastConcat;
    }
    /**
     * @param string|Expr $expr
     * @return Expr
     */
    private function normalizeStringExpr($expr) : \_PhpScoper5ade29b97028\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper5ade29b97028\PhpParser\Node\Expr) {
            return $expr;
        }
        if (\is_string($expr)) {
            return new \_PhpScoper5ade29b97028\PhpParser\Node\Scalar\String_($expr);
        }
        throw new \LogicException('Expected string or Expr');
    }
}
