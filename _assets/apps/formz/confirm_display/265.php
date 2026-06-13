<?php
/**
 * form_id=265（マジメに、三重の森を知ろう！ 応募）の確認画面表示
 * topics/message/miemori-oubo.php の入力順・項目名・選択肢に合わせる
 *
 * 注意:
 * - hidden（form_type / act / form_id / form_title）と同意系（savedata2 /
 *   privacy_consentx）、送信ボタンは display_order に含めない。
 * - x_sel（参加人数）・x_bt（車いす）・p_sex1（託児所）・p_sex2（関心テーマ）は
 *   select / radio のため value_maps で value→表示文言に変換する。
 * - r_message は自由記述（textarea）のため value_maps なし。
 */
return [
    'display_order' => [
        'u_email',
        'u_name',
        'u_age',
        'u_zip',
        'u_address',
        'u_address2',
        'u_address3',
        'u_tel',
        'x_sel',
        'x_bt',
        'p_sex1',
        'p_sex2',
        'r_message',
    ],
    'label_overrides' => [
        'u_email' => 'メールアドレス',
        'u_name' => 'お名前',
        'u_age' => '年齢',
        'u_zip' => '郵便番号',
        'u_address' => '都道府県・市町',
        'u_address2' => '番地',
        'u_address3' => 'マンション等',
        'u_tel' => '電話番号',
        'x_sel' => 'ご本人を含めた合計参加人数',
        'x_bt' => '車いすの使用',
        'p_sex1' => '託児所の使用',
        'p_sex2' => 'Q1',
        'r_message' => 'Q2',
    ],
    'value_maps' => [
        'x_sel' => [
            '0' => '1',
            '1' => '2',
            '2' => '3',
            '3' => '4',
        ],
        'x_bt' => [
            '0' => '無し',
            '1' => '有り',
        ],
        'p_sex1' => [
            '0' => '無し',
            '1' => '有り',
        ],
        'p_sex2' => [
            '1' => '気候変動（地球温暖化）',
            '2' => 'プラスチックごみ・海洋汚染',
            '3' => '大気汚染',
            '4' => '生物多様性の損失',
            '5' => '森林破壊・土地劣化',
        ],
    ],
];
