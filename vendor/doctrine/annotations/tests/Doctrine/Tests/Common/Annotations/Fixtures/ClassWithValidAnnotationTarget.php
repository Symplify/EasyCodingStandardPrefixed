<?php

namespace _PhpScoper7c3fefba1fb9\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper7c3fefba1fb9\Doctrine\Tests\Common\Annotations\Fixtures\AnnotationTargetClass;
use _PhpScoper7c3fefba1fb9\Doctrine\Tests\Common\Annotations\Fixtures\AnnotationTargetAll;
use _PhpScoper7c3fefba1fb9\Doctrine\Tests\Common\Annotations\Fixtures\AnnotationTargetPropertyMethod;
use _PhpScoper7c3fefba1fb9\Doctrine\Tests\Common\Annotations\Fixtures\AnnotationTargetNestedAnnotation;
/**
 * @AnnotationTargetClass("Some data")
 */
class ClassWithValidAnnotationTarget
{
    /**
     * @AnnotationTargetPropertyMethod("Some data")
     */
    public $foo;
    /**
     * @AnnotationTargetAll("Some data",name="Some name")
     */
    public $name;
    /**
     * @AnnotationTargetPropertyMethod("Some data",name="Some name")
     */
    public function someFunction()
    {
    }
    /**
     * @AnnotationTargetAll(@AnnotationTargetAnnotation)
     */
    public $nested;
}
