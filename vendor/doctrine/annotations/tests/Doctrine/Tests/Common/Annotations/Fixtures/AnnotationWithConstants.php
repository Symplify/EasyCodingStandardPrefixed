<?php

namespace _PhpScoper279cf54b77ad\Doctrine\Tests\Common\Annotations\Fixtures;

/**
 * @Annotation
 * @Target("ALL")
 */
final class AnnotationWithConstants
{
    const INTEGER = 1;
    const FLOAT = 1.2;
    const STRING = '1.2.3';
    /**
     * @var mixed
     */
    public $value;
}
