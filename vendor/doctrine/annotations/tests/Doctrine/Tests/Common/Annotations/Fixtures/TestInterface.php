<?php

namespace _PhpScoperb44a315fec16\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoperb44a315fec16\Doctrine\Tests\Common\Annotations\Fixtures\Annotation\Secure;
interface TestInterface
{
    /**
     * @Secure
     */
    function foo();
}
