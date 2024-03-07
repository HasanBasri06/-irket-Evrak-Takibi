<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;
use OpenApi\Attributes as QA;

class CompanyController extends Controller
{
    #[QA\Get(
        path: '/',
        responses: [
            new QA\Response(response: 200, description: 'deneme')
        ]
    )]
    public function index(): JsonResponse {
        $name = Redis::get('name');
        Redis::sadd('tags', 'laravel', 'php', 'vue');

        $tags = Redis::smembers('tags');
        $technologies = ['PHP', 'Laravel', 'Vue'];

        Redis::hmset('user:1', [
            'name' => 'Hasan Basri',
            'age' => 23,
            'technologies' => json_encode($technologies)
         ]);

        $name = Redis::hget('user:1', 'name');

        $getAll = Redis::hgetall('user:1');


        return Response::json([
            'tags' => $tags,
            'name' => $name,
            'user' => $getAll,
            'title' => Cache::get('title')
        ]);
    }
}