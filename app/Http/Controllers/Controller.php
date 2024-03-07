<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as QA;

/**
 * @QA\Info(
 *  title="My First Api Documentation",
 *  version="0.1",
 *      @QA\Contact(
 *          email="info@example.com"
 *      ),
 * ),
 * @QA\Server(
 *  description="learning new",
 *  url="http://127.0.0.1:8000/api/" 
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
