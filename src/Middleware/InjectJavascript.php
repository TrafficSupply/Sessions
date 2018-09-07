<?php

namespace TrafficSupply\Sessions\Middleware;

use Closure;

class InjectJavascript {

	public function handle($request, Closure $next)
	{
		$javascript = view('sessions::javascript', ['with_set_id' => session()->has('ts_unique_id')])->render();

		$response = $next($request);

		$content = $response->getContent();

		$pos = strripos($content, '</head>');
		if ($pos !== false) {
			$content = substr($content, 0, $pos) . $javascript . substr($content, $pos);
		}
		else {
			$content = $content . $javascript;
		}

		$response->setContent($content);
		$response->headers->remove('Content-Length');

		return $response;
	}
}