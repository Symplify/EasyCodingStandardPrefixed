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
namespace PhpCsFixer\RuleSet\Sets;

use PhpCsFixer\RuleSet\AbstractRuleSetDescription;
/**
 * @internal
 */
final class PHPUnit35MigrationRiskySet extends \PhpCsFixer\RuleSet\AbstractRuleSetDescription
{
    public function getRules() : array
    {
        return ['@PHPUnit32Migration:risky' => \true, 'php_unit_dedicate_assert' => ['target' => '3.5']];
    }
    public function getDescription() : string
    {
        return 'Rules to improve tests code for PHPUnit 3.5 compatibility.';
    }
}
