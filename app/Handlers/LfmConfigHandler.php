<?php

namespace App\Handlers;

use UniSharp\LaravelFilemanager\Handlers\ConfigHandler as BaseHandler;

class LfmConfigHandler extends BaseHandler
{
    public function userField()
    {
        // 1. 取得學校代碼
        $school_code = school_code() ?: 'default';

        // 2. 判斷當前請求類型 (photos 或 files)
        $type = strtolower(request('type', 'image'));
        $subFolder = ($type === 'file' || $type === 'files') ? 'files' : 'photos';

        // 3. 取得當前登入使用者 ID (若未登入備用為 guest)
        $userId = auth()->id() ?: 'guest';

        // 4. 回傳路徑：{school_code}/photos/{user_id}
        return $school_code . '/' . $subFolder . '/' . $userId;
    }
}