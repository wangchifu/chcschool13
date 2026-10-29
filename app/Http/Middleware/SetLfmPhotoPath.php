<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL; // 1. 必須引入 Facade

class SetLfmPhotoPath
{
    public function handle(Request $request, Closure $next)
    {
        // 2. 必須使用 getSchemeAndHttpHost() 才能精準取得：
        // 通訊協定 (http/https) + 網域 (s079999.localhost) + 通訊埠 (:8084)
        $baseUrl = $request->getSchemeAndHttpHost();

        // 3. 強制 URL 產生器與公用 Storage 使用當前請求的完整網域
        URL::forceRootUrl($baseUrl);

        config([
            'app.url' => $baseUrl,
            'filesystems.disks.public.url' => $baseUrl . '/storage',
        ]);
        //改中文語系
        app()->setLocale('zh-TW');

        return $next($request);
    }
}