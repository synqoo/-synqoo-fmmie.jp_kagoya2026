<?php
/**
 * form_id=262（今さら聞けない オカネ初心者のためのやさしい勉強会）の確認画面表示
 * topics/money-seminer01.php の入力順・項目名に合わせる
 */
return [
    'display_order' => [
        'x_bt',
        'u_name',
        'u_kana',
        'u_age',
        'x_fld1',
        'u_zip',
        'u_address',
        'u_address2',
        'u_address3',
        'u_tel',
        'u_email',
        'p_name1',
        'p_age1',
        'p_con1',
        'x_sel',
        'x_fld2',
        'r_message',
        'u_body',
    ],
    'label_overrides' => [
        'x_bt' => '参加希望時間',
        'u_name' => 'お名前',
        'u_kana' => 'フリガナ',
        'u_age' => '年齢',
        'x_fld1' => '職業',
        'u_zip' => '郵便番号',
        'u_address' => '都道府県・市町',
        'u_address2' => '番地',
        'u_address3' => 'マンション等',
        'u_tel' => '電話番号',
        'u_email' => 'メールアドレス',
        'x_sel' => 'お連れ様とのご関係',
        'p_name1' => 'お連れ様の名前',
        'p_age1' => 'お連れ様の年齢',
        'p_con1' => 'お連れ様の職業',
        'x_fld2' => 'どこでこのイベントをお知りになりましたか？',
        'r_message' => '本セミナーへの参加理由・意気込み',
        'u_body' => '多田えりかへのメッセージ',
    ],
    'value_maps' => [
        'x_bt' => [
            '0' => '6月27日(土)10:30～',
            '1' => '6月27日(土)14:30～',
            '2' => '6月27日(土)午前・午後どちらでもOK',
        ],
        'x_sel' => [
            '1' => '家族・パートナー',
            '2' => 'ご友人',
            '3' => 'その他',
        ],
    ],
];
