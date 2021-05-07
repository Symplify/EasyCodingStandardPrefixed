<?php

namespace Symplify\Skipper\SkipCriteriaResolver;

use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\Skipper\ValueObject\Option;
final class SkippedMessagesResolver
{
    /**
     * @var array<string, string[]|null>
     */
    private $skippedMessages = [];
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @param \Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider
     */
    public function __construct($parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    /**
     * @return mixed[]
     */
    public function resolve()
    {
        if ($this->skippedMessages !== []) {
            return $this->skippedMessages;
        }
        $skip = $this->parameterProvider->provideArrayParameter(Option::SKIP);
        foreach ($skip as $key => $value) {
            // e.g. [SomeClass::class] → shift values to [SomeClass::class => null]
            if (\is_int($key)) {
                $key = $value;
                $value = null;
            }
            if (!\is_string($key)) {
                continue;
            }
            if (\substr_count($key, ' ') === 0) {
                continue;
            }
            $this->skippedMessages[$key] = $value;
        }
        return $this->skippedMessages;
    }
}
