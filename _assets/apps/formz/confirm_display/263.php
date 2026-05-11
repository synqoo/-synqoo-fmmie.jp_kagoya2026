<?php
/**
 * form_id=263（ミュージカル『20年後のあなたに会いたくて』応募）の確認画面表示
 * topics/message/musical.php の入力順・項目名に合わせる
 */
return [
    'display_order' => [
        'u_name',
        'u_kana',
        'u_age',
        'u_sex',
        'x_fld1',
        'u_email',
        'u_zip',
        'u_address',
        'u_address2',
        'u_address3',
        'u_tel',
        'x_fld2',
        'r_message',
        'x_fld3',
        'r_attached',
        'r_attached2',
        'x_fld4',
        'x_fld5',
    ],
    'label_overrides' => [
        'u_name' => 'お名前',
        'u_kana' => 'フリガナ',
        'u_age' => '年齢',
        'u_sex' => '性別',
        'x_fld1' => '身長',
        'u_email' => 'メールアドレス',
        'u_zip' => '郵便番号',
        'u_address' => '都道府県・市町',
        'u_address2' => '番地',
        'u_address3' => 'マンション等',
        'u_tel' => '電話番号',
        'x_fld2' => '演劇・ミュージカル・コンサート・ドラマ等　出演歴（あれば）',
        'r_message' => '自己PR（300字以内）',
        'x_fld3' => '自身の最低音域と、最高音域',
        'r_attached' => '写真１（バストアップ）',
        'r_attached2' => '写真２（全身）',
        'x_fld4' => '課題台本演技動画URL',
        'x_fld5' => '課題曲歌唱動画URL',
    ],
    'value_maps' => [
        'x_bt' => [
            '0' => '夫',
            '1' => '妻',
            '2' => '実習生',
        ],
    ],
];
