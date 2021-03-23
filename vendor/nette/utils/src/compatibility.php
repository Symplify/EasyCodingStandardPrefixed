<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper35ec99c463ee\Nette\Utils;

use _PhpScoper35ec99c463ee\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \_PhpScoper35ec99c463ee\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\_PhpScoper35ec99c463ee\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoper35ec99c463ee\Nette\HtmlStringable::class, \_PhpScoper35ec99c463ee\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoper35ec99c463ee\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \_PhpScoper35ec99c463ee\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\_PhpScoper35ec99c463ee\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoper35ec99c463ee\Nette\Localization\Translator::class, \_PhpScoper35ec99c463ee\Nette\Localization\ITranslator::class);
}
