<?php

declare (strict_types=1);
namespace Symplify\SetConfigResolver\Tests\Bootstrap;

use _PhpScopere24d949bf310\PHPUnit\Framework\TestCase;
use Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter;
use Symplify\SetConfigResolver\Exception\SetNotFoundException;
final class InvalidSetReporterTest extends \_PhpScopere24d949bf310\PHPUnit\Framework\TestCase
{
    /**
     * @var InvalidSetReporter
     */
    private $invalidSetReporter;
    protected function setUp() : void
    {
        $this->invalidSetReporter = new \Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function test() : void
    {
        $setNotFoundException = new \Symplify\SetConfigResolver\Exception\SetNotFoundException('not found', 'one', ['two', 'three']);
        $this->invalidSetReporter->report($setNotFoundException);
    }
}
