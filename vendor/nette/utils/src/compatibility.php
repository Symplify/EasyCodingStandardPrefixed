<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperfde42a25c345\Nette\Utils;

use _PhpScoperfde42a25c345\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\_PhpScoperfde42a25c345\Nette\Utils\IHtmlString::class)) {
    \class_alias(Nette\HtmlStringable::class, \_PhpScoperfde42a25c345\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoperfde42a25c345\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \_PhpScoperfde42a25c345\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\_PhpScoperfde42a25c345\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoperfde42a25c345\Nette\Localization\Translator::class, \_PhpScoperfde42a25c345\Nette\Localization\ITranslator::class);
}
