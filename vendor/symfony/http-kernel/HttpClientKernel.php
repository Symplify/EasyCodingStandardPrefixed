<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\HttpKernel;

use ECSPrefix20210507\Symfony\Component\HttpClient\HttpClient;
use ECSPrefix20210507\Symfony\Component\HttpFoundation\Request;
use ECSPrefix20210507\Symfony\Component\HttpFoundation\Response;
use ECSPrefix20210507\Symfony\Component\HttpFoundation\ResponseHeaderBag;
use ECSPrefix20210507\Symfony\Component\Mime\Part\AbstractPart;
use ECSPrefix20210507\Symfony\Component\Mime\Part\DataPart;
use ECSPrefix20210507\Symfony\Component\Mime\Part\Multipart\FormDataPart;
use ECSPrefix20210507\Symfony\Component\Mime\Part\TextPart;
use ECSPrefix20210507\Symfony\Contracts\HttpClient\HttpClientInterface;
// Help opcache.preload discover always-needed symbols
\class_exists(ResponseHeaderBag::class);
class AnonymousFor_HttpClientKernel extends ResponseHeaderBag
{
    protected function computeCacheControlValue() : string
    {
        return $this->getCacheControlHeader();
        // preserve the original value
    }
}
/**
 * An implementation of a Symfony HTTP kernel using a "real" HTTP client.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class HttpClientKernel implements \ECSPrefix20210507\Symfony\Component\HttpKernel\HttpKernelInterface
{
    private $client;
    /**
     * @param \ECSPrefix20210507\Symfony\Contracts\HttpClient\HttpClientInterface $client
     */
    public function __construct($client = null)
    {
        if (null === $client && !\class_exists(HttpClient::class)) {
            throw new \LogicException(\sprintf('You cannot use "%s" as the HttpClient component is not installed. Try running "composer require symfony/http-client".', __CLASS__));
        }
        $this->client = isset($client) ? $client : HttpClient::create();
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpFoundation\Request $request
     * @param int $type
     * @param bool $catch
     * @return \ECSPrefix20210507\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, $type = \ECSPrefix20210507\Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST, $catch = \true)
    {
        $headers = $this->getHeaders($request);
        $body = '';
        if (null !== ($part = $this->getBody($request))) {
            $headers = \array_merge($headers, $part->getPreparedHeaders()->toArray());
            $body = $part->bodyToIterable();
        }
        $response = $this->client->request($request->getMethod(), $request->getUri(), ['headers' => $headers, 'body' => $body] + $request->attributes->get('http_client_options', []));
        $response = new Response($response->getContent(!$catch), $response->getStatusCode(), $response->getHeaders(!$catch));
        $response->headers->remove('X-Body-File');
        $response->headers->remove('X-Body-Eval');
        $response->headers->remove('X-Content-Digest');
        $response->headers = new AnonymousFor_HttpClientKernel($response->headers->all());
        return $response;
    }
    /**
     * @return \ECSPrefix20210507\Symfony\Component\Mime\Part\AbstractPart|null
     * @param \ECSPrefix20210507\Symfony\Component\HttpFoundation\Request $request
     */
    private function getBody($request)
    {
        if (\in_array($request->getMethod(), ['GET', 'HEAD'])) {
            return null;
        }
        if (!\class_exists(AbstractPart::class)) {
            throw new \LogicException('You cannot pass non-empty bodies as the Mime component is not installed. Try running "composer require symfony/mime".');
        }
        if ($content = $request->getContent()) {
            return new TextPart($content, 'utf-8', 'plain', '8bit');
        }
        $fields = $request->request->all();
        foreach ($request->files->all() as $name => $file) {
            $fields[$name] = DataPart::fromPath($file->getPathname(), $file->getClientOriginalName(), $file->getClientMimeType());
        }
        return new FormDataPart($fields);
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpFoundation\Request $request
     * @return mixed[]
     */
    private function getHeaders($request)
    {
        $headers = [];
        foreach ($request->headers as $key => $value) {
            $headers[$key] = $value;
        }
        $cookies = [];
        foreach ($request->cookies->all() as $name => $value) {
            $cookies[] = $name . '=' . $value;
        }
        if ($cookies) {
            $headers['cookie'] = \implode('; ', $cookies);
        }
        return $headers;
    }
}
