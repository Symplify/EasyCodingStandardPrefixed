<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\Tests;

use _PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent;
/**
 * StopwatchEventTest.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @group time-sensitive
 */
class StopwatchEventTest extends \_PhpScoper5813f9b171f8\PHPUnit_Framework_TestCase
{
    const DELTA = 37;
    public function testGetOrigin()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(12);
        $this->assertEquals(12, $event->getOrigin());
    }
    public function testGetCategory()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $this->assertEquals('default', $event->getCategory());
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000, 'cat');
        $this->assertEquals('cat', $event->getCategory());
    }
    public function testGetPeriods()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $this->assertEquals(array(), $event->getPeriods());
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        $event->stop();
        $this->assertCount(1, $event->getPeriods());
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        $event->stop();
        $event->start();
        $event->stop();
        $this->assertCount(2, $event->getPeriods());
    }
    public function testLap()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        $event->lap();
        $event->stop();
        $this->assertCount(2, $event->getPeriods());
    }
    public function testDuration()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        \usleep(200000);
        $event->stop();
        $this->assertEquals(200, $event->getDuration(), null, self::DELTA);
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        \usleep(100000);
        $event->stop();
        \usleep(50000);
        $event->start();
        \usleep(100000);
        $event->stop();
        $this->assertEquals(200, $event->getDuration(), null, self::DELTA);
    }
    public function testDurationBeforeStop()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        \usleep(200000);
        $this->assertEquals(200, $event->getDuration(), null, self::DELTA);
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        \usleep(100000);
        $event->stop();
        \usleep(50000);
        $event->start();
        \usleep(100000);
        $this->assertEquals(100, $event->getDuration(), null, self::DELTA);
    }
    /**
     * @expectedException \LogicException
     */
    public function testStopWithoutStart()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->stop();
    }
    public function testIsStarted()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        $this->assertTrue($event->isStarted());
    }
    public function testIsNotStarted()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $this->assertFalse($event->isStarted());
    }
    public function testEnsureStopped()
    {
        // this also test overlap between two periods
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        \usleep(100000);
        $event->start();
        \usleep(100000);
        $event->ensureStopped();
        $this->assertEquals(300, $event->getDuration(), null, self::DELTA);
    }
    public function testStartTime()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $this->assertLessThanOrEqual(0.5, $event->getStartTime());
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        $event->stop();
        $this->assertLessThanOrEqual(1, $event->getStartTime());
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $event->start();
        \usleep(100000);
        $event->stop();
        $this->assertEquals(0, $event->getStartTime(), null, self::DELTA);
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidOriginThrowsAnException()
    {
        new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent('abc');
    }
    public function testHumanRepresentation()
    {
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000);
        $this->assertEquals('default: 0.00 MiB - 0 ms', (string) $event);
        $event->start();
        $event->stop();
        $this->assertEquals(1, \preg_match('/default: [0-9\\.]+ MiB - [0-9]+ ms/', (string) $event));
        $event = new \_PhpScoper5813f9b171f8\Symfony\Component\Stopwatch\StopwatchEvent(\microtime(\true) * 1000, 'foo');
        $this->assertEquals('foo: 0.00 MiB - 0 ms', (string) $event);
    }
}
