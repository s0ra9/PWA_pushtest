<?php
// autoload.php を読み込んだら、vendor下のクラスをインスタンス化できるようにする
require_once './vendor/autoload.php';
// json形式でpostされた値を取得して配列化する
$r_post = json_decode(file_get_contents('php://input'), true);
$webPush = new \Minishlink\WebPush\WebPush([
    'VAPID' => [
        'subject' => 'https://s0ra9.github.io/PWA_pushtest/',
        // ↓生成した公開鍵文字列を入れる
        'publicKey' => 'BCaGjW2Ng4iheEakSH_uSlIjoGvAfbUNGhcTogDGbOaGIIluHdqPacqXDl90rVoR1NLqYVBlmIlzsh-4mrVqa7M',
        // ↓生成した秘密鍵文字列を入れる
        'privateKey' => '0DrXYmnbW3vO_2FDv92QHlOyKnYyV5EOLXuVnqMX0Fo',
        // ↑２つのようにもちろんこういったハードコーディングはよくないが、そこらへんはよしなに。。。
    ]
]);
// push通知認証用のデータ
$subscription = \Minishlink\WebPush\Subscription::create([
    // ↓検証ツール > console に表示された endpoint URL を入力
    'endpoint' => 'https://fcm.googleapis.com/fcm/send/e8ayaH-tKNk:APA91bG-XzFcZDZFnVBHWFKHsvMRWFwSk4lUBk-jbO3WT4md-yB6-RoKnruWgJauV_Flb-aRz4X2wmP_IGo5bCvEaav_kydoRIZZhJ6NKL0yD55Nb8bWKvn-l3nWdw4tFY6adVOnXJWV',
    // ↓検証ツール > console に表示された push_public_key を入力
    'publicKey' => 'BLyYgCSEXD2w07fz5wdoEZaJgGy2O0jCGWfUwXs2cxM7NUao2Vctgs5AigS2pj9JfgcT9iBMRL+GOif8rJcPhFI=',
    // ↓検証ツール > console に表示された push_auth_token を入力
    'authToken' => 'nX29Gw8cB2ioQcA7l8pKaA==',
]);
// pushサーバーに通知リクエストをjson形式で送る
$report = $webPush->sendOneNotification(
    $subscription,
    json_encode([
        'title' => 'タイトル',
        'body' => 'PUSH通知のテストです',
        'url' => 'http://localhost/',
    ])
);
$r_response = [
    'status' => 200,
    'body' => '送信' . (($report->isSuccess()) ? '成功' : '失敗')
];
echo json_encode($r_response);
