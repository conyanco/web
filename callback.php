
<?php

$accessToken = '+O9PZhDDNsc1w33rE7/U949xa8I7P9uxUShSGR9LFbABjQrYKo3p+xffPlfDfQu/AjIddjC9DtzyYXiA62fCBgF9ElS0gw4i8tK8E3F9RaspQGrcuSYMati25NRNxMOArqUBvqh6mFWj/Jul/9CPbQdB04t89/1O/w1cDnyilFU=';

$jsonString = file_get_contents('php://input');
error_log($jsonString);
$jsonObj = json_decode($jsonString);

$message = $jsonObj->{"events"}[0]->{"message"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

// 送られてきたメッセージの中身からレスポンスのタイプを選択
if ($message->{"text"} == 'こんにちは') {
    // 確認ダイアログタイプ
    $messageData = [
        'type' => 'template',
        'altText' => '確認ダイアログ',
        'template' => [
            'type' => 'confirm',
            'text' => '元気ですか',
            'actions' => [
                [
                    'type' => 'message',
                    'label' => 'はい',
                    'text' => 'はい'
                ],
                [
                    'type' => 'message',
                    'label' => 'いいえ',
                    'text' => 'いいえ'
                ],
            ]
        ]
    ];

} elseif ($message->{"text"} == 'ねこ') {
    // はい
    $messageData = [
        'type' => 'text',
        'text' => $message->{"text"}
    ];
}

$response = [
    'replyToken' => $replyToken,
        'type' => 'text',
        'text' => 'へぇ'
];

} elseif ($message->{"text"} == 'ネコ') {
    // ボタンタイプ
    $messageData = [
        'type' => 'template',
        'altText' => 'ボタン',
        'template' => [
            'type' => 'buttons',
            'title' => 'ネコ🐈は好きか？',
            'text' => '選んでくれたまえ',
            'actions' => [
                [
                    'type' => 'postback',
                    'label' => 'はい',
                    'data' => 'value'
                ],
                [
                    'type' => 'uri',
                    'label' => 'あまり‥',
                    'uri' => 'https://google.com'
                ]
            ]
        ]
    ];
} elseif ($message->{"text"} == 'マタタビ') {
    // カルーセルタイプ
    $messageData = [
        'type' => 'template',
        'altText' => 'カルーセル',
        'template' => [
            'type' => 'carousel',
            'columns' => [
                [
                    'title' => 'カルーセル1',
                    'text' => 'カルーセル1です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => 'マタタビ買って',
                            'uri' => 'https://www.amazon.co.jp/gp/product/B013JFJLIE/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B013JFJLIE&linkCode=as2&tag=nolanuco-22&linkId=40072ec4fab82f73bcfd4953c3c0e5e0'
                        ]
                    ]
                ],
                [
                    'title' => 'カルーセル2',
                    'text' => 'カルーセル2です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => '一家に一台',
                            'uri' => 'https://www.amazon.co.jp/gp/product/B00ONPI95G/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B00ONPI95G&linkCode=as2&tag=seagull-22&linkId=4f9edd741c57e792d0e6f8dcea7f0273'
                        ]
                    ]
                ],
            ]
        ]
    ];
} else {
    // それ以外は送られてきたテキストをオウム返し
    $messageData = [
        'type' => 'text',
        'text' => $message->{"text"}
    ];
}

$response = [
    'replyToken' => $replyToken,
    'messages' => [$messageData]
];
error_log(json_encode($response));

$ch = curl_init('https://api.line.me/v2/bot/message/reply');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
error_log($result);
curl_close($ch);
?>