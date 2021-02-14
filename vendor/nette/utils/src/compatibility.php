<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper89c09b8e7101\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoper89c09b8e7101\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoper89c09b8e7101\Nette\HtmlStringable::class, \_PhpScoper89c09b8e7101\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoper89c09b8e7101\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoper89c09b8e7101\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoper89c09b8e7101\Nette\Localization\Translator::class, \_PhpScoper89c09b8e7101\Nette\Localization\ITranslator::class);
}
