<?php

namespace TrafficSupply\Sessions;

use App\Http\Controllers\Controller;

class AssetController extends Controller {

	public function javascript()
	{
		return view('sessions::javascript');
	}
}