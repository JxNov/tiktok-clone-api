<?php

namespace App\Services;

use App\Models\User;

class UsernameGenerator
{
    public static function generateUsername()
    {
        $lastUser = User::orderBy('id', 'desc')->first();

        if (!$lastUser) {
            // Nếu không có user nào, bắt đầu với 'user0000000001'
            return 'user' . str_pad('1', 10, '0', STR_PAD_LEFT);
        }

        $lastUsername = $lastUser->username;

        // Loại bỏ ký tự 'user' ở đầu username
        $coreUsername = substr($lastUsername, 4);

        // Kiểm tra xem phần còn lại của username có phải là số và có độ dài hợp lệ không
        if (is_numeric($coreUsername)) {
            // Tăng giá trị số lên 1 và thêm 'user' vào đầu chuỗi
            $newCoreUsername = str_pad((string) ((int)$coreUsername + 1), strlen($coreUsername), '0', STR_PAD_LEFT);
            $newUsername = 'user' . $newCoreUsername;
        } else {
            // Nếu username không phải số, bắt đầu lại với giá trị mới và chiều dài username là 10 ký tự
            $newCoreUsername = str_pad((string) ($lastUser->id + 1), 10, '0', STR_PAD_LEFT);
            $newUsername = 'user' . $newCoreUsername;
        }

        // Kiểm tra nếu username mới có độ dài lớn hơn chiều dài hiện tại, cần phải xử lý tăng độ dài
        if (strlen($newUsername) > strlen($lastUsername)) {
            $newCoreUsername = substr($newUsername, 4);
            $newUsername = 'user' . str_pad($newCoreUsername, strlen($newCoreUsername), '0', STR_PAD_LEFT);
        }

        return $newUsername;

    }
}
