<?php
namespace Core\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View,File,Theme,CFglobal,AdminFunc;
use Core\Foundation\CoreSystemManager;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

class RLCController extends Controller {
	use CoreSystemManager;
}