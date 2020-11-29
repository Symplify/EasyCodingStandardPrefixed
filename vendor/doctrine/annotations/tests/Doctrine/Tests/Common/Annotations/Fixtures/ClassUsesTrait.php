<?php

namespace _PhpScoper9d73a84b09ad\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper9d73a84b09ad\Doctrine\Tests\Common\Annotations\Bar\Autoload;
class ClassUsesTrait
{
    use TraitWithAnnotatedMethod;
    /**
     * @Autoload
     */
    public $aProperty;
    /**
     * @Autoload
     */
    public function someMethod()
    {
    }
}
namespace _PhpScoper9d73a84b09ad\Doctrine\Tests\Common\Annotations\Bar;

/** @Annotation */
class Autoload
{
}
