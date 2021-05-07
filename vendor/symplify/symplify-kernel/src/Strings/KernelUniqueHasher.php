<?php

namespace Symplify\SymplifyKernel\Strings;

use ECSPrefix20210507\Nette\Utils\Strings;
use Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class KernelUniqueHasher
{
    /**
     * @var StringsConverter
     */
    private $stringsConverter;
    public function __construct()
    {
        $this->stringsConverter = new \Symplify\SymplifyKernel\Strings\StringsConverter();
    }
    /**
     * @param string $kernelClass
     * @return string
     */
    public function hashKernelClass($kernelClass)
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);
        $shortClassName = (string) Strings::after($kernelClass, '\\', -1);
        return $this->stringsConverter->camelCaseToGlue($shortClassName, '_');
    }
    /**
     * @return void
     * @param string $kernelClass
     */
    private function ensureIsNotGenericKernelClass($kernelClass)
    {
        if ($kernelClass !== AbstractSymplifyKernel::class) {
            return;
        }
        $message = \sprintf('Instead of "%s", provide final Kernel class', AbstractSymplifyKernel::class);
        throw new TooGenericKernelClassException($message);
    }
}
