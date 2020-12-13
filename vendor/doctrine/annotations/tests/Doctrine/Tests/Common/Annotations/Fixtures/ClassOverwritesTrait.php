<?php

namespace _PhpScoper78af57a363a0\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper78af57a363a0\Doctrine\Tests\Common\Annotations\Bar2\Autoload;
class ClassOverwritesTrait
{
    use TraitWithAnnotatedMethod;
    /**
     * @Autoload
     */
    public function traitMethod()
    {
    }
}
namespace _PhpScoper78af57a363a0\Doctrine\Tests\Common\Annotations\Bar2;

/** @Annotation */
class Autoload
{
}
