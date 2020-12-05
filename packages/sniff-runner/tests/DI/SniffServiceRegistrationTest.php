<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\SniffRunner\Tests\DI;

use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use Symplify\EasyCodingStandard\HttpKernel\EasyCodingStandardKernel;
use Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class SniffServiceRegistrationTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        static::bootKernelWithConfigs(\Symplify\EasyCodingStandard\HttpKernel\EasyCodingStandardKernel::class, [__DIR__ . '/SniffServiceRegistrationSource/easy-coding-standard.php']);
        $sniffFileProcessor = $this->getService(\Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor::class);
        /** @var LineLengthSniff $lineLengthSniff */
        $lineLengthSniff = $sniffFileProcessor->getCheckers()[0];
        $this->assertSame(15, $lineLengthSniff->lineLimit);
        $this->assertSame(['@author'], $lineLengthSniff->absoluteLineLimit);
    }
}
