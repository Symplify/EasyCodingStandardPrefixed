<?php

namespace _PhpScoper58a0a169dcfb\Doctrine\Tests\Common\Annotations\Fixtures;

/**
 * @Annotation
 * @Target("ALL")
 */
final class AnnotationEnumLiteralInvalid
{
    const ONE = 1;
    const TWO = 2;
    const THREE = 3;
    /**
     * @var mixed
     *
     * @Enum(
     *      value = {
     *          1,
     *          2
     *      },
     *      literal = {
     *          1 : "AnnotationEnumLiteral::ONE",
     *          2 : "AnnotationEnumLiteral::TWO",
     *          3 : "AnnotationEnumLiteral::THREE"
     *      }
     * )
     */
    public $value;
}
