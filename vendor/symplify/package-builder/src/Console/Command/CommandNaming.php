<?php

namespace Symplify\PackageBuilder\Console\Command;

use ECSPrefix20210507\Nette\Utils\Strings;
use ECSPrefix20210507\Symfony\Component\Console\Command\Command;
/**
 * @see \Symplify\PackageBuilder\Tests\Console\Command\CommandNamingTest
 */
final class CommandNaming
{
    /**
     * @var string
     * @see https://regex101.com/r/DfCWPx/1
     */
    const BIG_LETTER_REGEX = '#[A-Z]#';
    /**
     * Converts:
     * - "SomeClass\SomeSuperCommand" → "some-super"
     * - "SomeClass\SOMESuperCommand" → "some-super"
     * @param \ECSPrefix20210507\Symfony\Component\Console\Command\Command $command
     * @return string
     */
    public function resolveFromCommand($command)
    {
        $commandClass = \get_class($command);
        return self::classToName($commandClass);
    }
    /**
     * Converts:
     * - "SomeClass\SomeSuperCommand" → "some-super"
     * - "SomeClass\SOMESuperCommand" → "some-super"
     * @param string $class
     * @return string
     */
    public static function classToName($class)
    {
        /** @var string $shortClassName */
        $shortClassName = self::resolveShortName($class);
        $rawCommandName = Strings::substring($shortClassName, 0, -\strlen('Command'));
        // ECSCommand => ecs
        for ($i = 0; $i < \strlen($rawCommandName); ++$i) {
            if (\ctype_upper($rawCommandName[$i]) && self::isFollowedByUpperCaseLetterOrNothing($rawCommandName, $i)) {
                $rawCommandName[$i] = \strtolower($rawCommandName[$i]);
            } else {
                break;
            }
        }
        $rawCommandName = \lcfirst($rawCommandName);
        return Strings::replace($rawCommandName, self::BIG_LETTER_REGEX, function (array $matches) : string {
            return '-' . \strtolower($matches[0]);
        });
    }
    /**
     * @param string $class
     * @return string
     */
    private static function resolveShortName($class)
    {
        $classParts = \explode('\\', $class);
        return \array_pop($classParts);
    }
    /**
     * @param string $string
     * @param int $position
     * @return bool
     */
    private static function isFollowedByUpperCaseLetterOrNothing($string, $position)
    {
        // this is the last letter
        if (!isset($string[$position + 1])) {
            return \true;
        }
        // next letter is uppercase
        return \ctype_upper($string[$position + 1]);
    }
}
