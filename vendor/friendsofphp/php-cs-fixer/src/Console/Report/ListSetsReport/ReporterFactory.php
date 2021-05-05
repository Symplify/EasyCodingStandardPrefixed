<?php

declare (strict_types=1);
/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Console\Report\ListSetsReport;

use _PhpScoper7e6a1331d94a\Symfony\Component\Finder\Finder as SymfonyFinder;
use _PhpScoper7e6a1331d94a\Symfony\Component\Finder\SplFileInfo;
/**
 * @author Boris Gorbylev <ekho@ekho.name>
 *
 * @internal
 */
final class ReporterFactory
{
    /** @var ReporterInterface[] */
    private $reporters = [];
    public function registerBuiltInReporters()
    {
        /** @var null|string[] $builtInReporters */
        static $builtInReporters;
        if (null === $builtInReporters) {
            $builtInReporters = [];
            /** @var SplFileInfo $file */
            foreach (SymfonyFinder::create()->files()->name('*Reporter.php')->in(__DIR__) as $file) {
                $relativeNamespace = $file->getRelativePath();
                $builtInReporters[] = \sprintf('%s\\%s%s', __NAMESPACE__, $relativeNamespace ? $relativeNamespace . '\\' : '', $file->getBasename('.php'));
            }
        }
        foreach ($builtInReporters as $reporterClass) {
            $this->registerReporter(new $reporterClass());
        }
        return $this;
    }
    /**
     * @return $this
     */
    public function registerReporter(\PhpCsFixer\Console\Report\ListSetsReport\ReporterInterface $reporter)
    {
        $format = $reporter->getFormat();
        if (isset($this->reporters[$format])) {
            throw new \UnexpectedValueException(\sprintf('Reporter for format "%s" is already registered.', $format));
        }
        $this->reporters[$format] = $reporter;
        return $this;
    }
    /**
     * @return string[]
     */
    public function getFormats()
    {
        $formats = \array_keys($this->reporters);
        \sort($formats);
        return $formats;
    }
    /**
     * @param string $format
     *
     * @return ReporterInterface
     */
    public function getReporter($format)
    {
        if (!isset($this->reporters[$format])) {
            throw new \UnexpectedValueException(\sprintf('Reporter for format "%s" is not registered.', $format));
        }
        return $this->reporters[$format];
    }
}
