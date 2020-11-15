<?php

namespace _PhpScoperd9c3b46af121\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoperd9c3b46af121\Doctrine\Tests\Common\Annotations\Bar\Autoload;
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
namespace _PhpScoperd9c3b46af121\Doctrine\Tests\Common\Annotations\Bar;

/** @Annotation */
class Autoload
{
}
