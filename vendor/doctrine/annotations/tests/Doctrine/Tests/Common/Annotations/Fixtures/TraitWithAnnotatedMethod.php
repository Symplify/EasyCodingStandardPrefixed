<?php

namespace _PhpScoper8b97b0dd6f5b\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper8b97b0dd6f5b\Doctrine\Tests\Common\Annotations\Fixtures\Annotation\Autoload;
trait TraitWithAnnotatedMethod
{
    /**
     * @Autoload
     */
    public $traitProperty;
    /**
     * @Autoload
     */
    public function traitMethod()
    {
    }
}
