<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        //     ->header('Access-Control-Allow-Origin', 'http://localhost:5173')
        //     ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        //     ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        
        // 保留空类或删除整个文件
        return $next($request);
    }
}
