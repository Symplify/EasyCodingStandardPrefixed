<?php

namespace _PhpScoper28ab463fc3ba\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper28ab463fc3ba\Doctrine\Tests\Common\Annotations\Fixtures\Annotation\Secure;
interface TestInterface
{
    /**
     * @Secure
     */
    function foo();
}
