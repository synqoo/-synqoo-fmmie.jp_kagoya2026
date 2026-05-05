<?php
/**
 * form_id=257（学ぼう防災 鈴鹿会場等）の確認画面表示
 * formztemp.csv のプレースホルダ項目名・数値値を、フォームHTMLの文言に合わせる
 */
return [
    // event/jakyousai/suzuka_1.php など HTML 上の入力順（formztemp.csv の順序と異なるため）
    'display_order' => [
        'x_bt',
        'u_email',
        'u_name',
        'u_age',
        'p_name1',
        'x_sel',
        'u_zip',
        'u_address',
        'u_address2',
        'u_address3',
        'u_tel',
    ],
    'label_overrides' => [
        'x_sel' => '学年',
        'x_bt' => 'ご希望の時間',
        'p_name1' => '同伴者氏名（お子様）',
        'u_name' => '代表者氏名（保護者）',
    ],
    'value_maps' => [
        'x_sel' => [
            '0' => '１年生',
            '1' => '２年生',
            '2' => '３年生',
            '3' => '４年生',
            '4' => '５年生',
            '5' => '６年生',
        ],
        'x_bt' => [
            '0' => '1部 9:30～11:30',
            '1' => '2部 13:30～15:30',
        ],
    ],
];
