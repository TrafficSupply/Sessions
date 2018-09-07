<?php

namespace TrafficSupply\Sessions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class SessionsController extends Controller
{
	public function getTSId(Request $request)
	{
		if (! $TSUniqueId = session()->get('ts_unique_id', false))
		{
			if (! $TSUniqueId = $request->cookie('ts_unique_id', false))
			{
				$TSUniqueId = 'ts-' . Uuid::generate();
				session(['ts_unique_id' => $TSUniqueId]);
				cookie('ts_unique_id', $TSUniqueId, 120);
			}
		}

		return response('var ts_unique_id = "'.$TSUniqueId.'";')
			->header('Content-Type', 'application/javascript');
	}

	public function setTSId(Request $request)
	{
		session(['ts_unique_id' => $request->ts_unique_id]);
		return response()
			->json(['message' => 'new TSId is being set'])
			->withCookie('ts_unique_id', $request->ts_unique_id, 120);
	}
}