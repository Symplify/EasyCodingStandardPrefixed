<?php

namespace _PhpScopera238de2e9b5a\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScopera238de2e9b5a\Doctrine\Tests\Common\Annotations\Fixtures\Annotation\Secure;
interface TestInterface
{
    /**
     * @Secure
     */
    function foo();
}
