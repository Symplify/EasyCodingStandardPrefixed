<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Helpers;

use _PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode;
use _PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use _PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use _PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode;
use function array_merge;
/**
 * @internal
 */
class AnnotationConstantExpressionHelper
{
    /**
     * @param ConstExprNode $contantExpressionNode
     * @return array<int, ConstFetchNode>
     */
    public static function getConstantFetchNodes(\_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $contantExpressionNode) : array
    {
        if ($contantExpressionNode instanceof \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            $constantFetchNodes = [];
            foreach ($contantExpressionNode->items as $itemConstantExpressionNode) {
                $constantFetchNodes = \array_merge($constantFetchNodes, self::getConstantFetchNodes($itemConstantExpressionNode));
            }
            return $constantFetchNodes;
        }
        if ($contantExpressionNode instanceof \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode) {
            $constantFetchNodes = self::getConstantFetchNodes($contantExpressionNode->value);
            if ($contantExpressionNode->key !== null) {
                $constantFetchNodes = \array_merge($constantFetchNodes, self::getConstantFetchNodes($contantExpressionNode->key));
            }
            return $constantFetchNodes;
        }
        if ($contantExpressionNode instanceof \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode) {
            return [$contantExpressionNode];
        }
        return [];
    }
    public static function change(\_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $masterNode, \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $nodeToChange, \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $changedNode) : \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
    {
        if ($masterNode === $nodeToChange) {
            return $changedNode;
        }
        if ($masterNode instanceof \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            $items = [];
            foreach ($masterNode->items as $itemNode) {
                /** @var ConstExprArrayItemNode $changedItemNode */
                $changedItemNode = self::change($itemNode, $nodeToChange, $changedNode);
                $items[] = $changedItemNode;
            }
            return new \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode($items);
        }
        if ($masterNode instanceof \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode) {
            $key = $masterNode->key !== null ? self::change($masterNode->key, $nodeToChange, $changedNode) : null;
            $value = self::change($masterNode->value, $nodeToChange, $changedNode);
            return new \_PhpScoper8e2d8a2760d1\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode($key, $value);
        }
        return clone $masterNode;
    }
}
