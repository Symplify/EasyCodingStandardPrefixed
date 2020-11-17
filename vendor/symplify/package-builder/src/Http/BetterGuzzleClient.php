<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use _PhpScoper967c4b7e296e\GuzzleHttp\ClientInterface;
use _PhpScoper967c4b7e296e\GuzzleHttp\Exception\BadResponseException;
use _PhpScoper967c4b7e296e\GuzzleHttp\Psr7\Request;
use _PhpScoper967c4b7e296e\Nette\Utils\Json;
use _PhpScoper967c4b7e296e\Nette\Utils\JsonException;
use _PhpScoper967c4b7e296e\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScoper967c4b7e296e\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScoper967c4b7e296e\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScoper967c4b7e296e\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScoper967c4b7e296e\Nette\Utils\Json::decode($content, \_PhpScoper967c4b7e296e\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScoper967c4b7e296e\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScoper967c4b7e296e\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScoper967c4b7e296e\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
