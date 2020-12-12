<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use _PhpScoperbd5c5a045153\GuzzleHttp\ClientInterface;
use _PhpScoperbd5c5a045153\GuzzleHttp\Exception\BadResponseException;
use _PhpScoperbd5c5a045153\GuzzleHttp\Psr7\Request;
use _PhpScoperbd5c5a045153\Nette\Utils\Json;
use _PhpScoperbd5c5a045153\Nette\Utils\JsonException;
use _PhpScoperbd5c5a045153\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScoperbd5c5a045153\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScoperbd5c5a045153\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScoperbd5c5a045153\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScoperbd5c5a045153\Nette\Utils\Json::decode($content, \_PhpScoperbd5c5a045153\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScoperbd5c5a045153\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScoperbd5c5a045153\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScoperbd5c5a045153\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
