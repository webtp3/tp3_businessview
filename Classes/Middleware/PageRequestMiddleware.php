<?php

declare(strict_types=1);

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tp3\Tp3Businessview\Frontend\JsonFeHandler;

final class PageRequestMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly JsonFeHandler $jsonFrontendResponder,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = (string)($request->getUri()->getPath() ?? '');
        $routing = $request->getAttribute('routing');

        $businessviewRequested =
            str_contains($uri, '/tp3Businessview/fejson');

        if ($businessviewRequested) {
            return $this->jsonFrontendResponder->handle($request);
        }

        return $handler->handle($request);
    }
}
