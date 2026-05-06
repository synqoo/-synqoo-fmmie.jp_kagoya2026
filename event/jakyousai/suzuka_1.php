<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
//error_reporting(0);
session_start();
$_SESSION['reg']=0;
$error=array();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
saveinput($_POST);
$fm_id=257;
// 確認画面の表示制御: 1=確認画面を表示, 0=確認画面をスキップしてregist.phpに直接送信
$confirm=1;
// 任意入力フィールドの折りたたみ機能のON/OFF制御　true: 折りたたみ機能を有効化、false: 常に表示
$enable_optional_fields_toggle = 0;

formz_config($fm_id);
if($_POST['act']==1){
    // 確認画面から「送信」された場合はバリデーションをスキップして登録処理へ
    if (!empty($_POST['formz_do_regist'])) {
        require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_regist.php');
        exit;
    }
    require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_validate.php');
    if (!is_array($error)){
        if ($confirm == 0) {
            // 確認画面をスキップして直接登録
            require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_regist.php');
            exit;
        }
        define('FORMZ_CONFIRM_STEP', true);
        require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_regist.php');
        require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_confirm.php');
        exit;
    }else{
        $_SESSION['reg']=0;
        if(is_array($error)){$enable_optional_fields_toggle = false;
        $_POST['privacy_consent']==0;}
    }
}
?>

<!DOCTYPE html>
<html lang="ja" class="no-dark jak-page">
<head>
    <meta charset="UTF-8">
    <title>鈴鹿会場・応募｜ＪＡ共済 presents 学ぼう防災　親子で作ろう！ ラジオ工作教室</title>
    <meta name="description" content="JA鈴鹿会場のラジオ工作教室。5月23日（土）開催。応募期間4/7（火）～5/1（金）。開催概要と応募フォーム（準備中）をご案内します。" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="color-scheme" content="light">
    <meta name="robots" content="noindex, nofollow" />

    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>

<div class="jak-container">
    <p class="jak-back"><a href="index.php"><i class="fa-solid fa-arrow-left jak-back__icon" aria-hidden="true"></i>イベント概要へ戻る</a></p>

    <header class="jak-title-block">
        <img class="jak-title-block__image" src="images/tops.jpg" alt="ＪＡ共済 presents 学ぼう防災　親子で作ろう！ ラジオ工作教室" loading="eager" decoding="async" />
        <p class="jak-subtitle">応募ページ（ＪＡ鈴鹿会場）</p>
    </header>

    <!--<div class="jak-preperiod-heading" role="status">
        <p class="jak-preperiod-heading__line">応募期間は5/7(木)～6/30(火)です。</p>
        <p class="jak-preperiod-heading__line">期間中に改めてのご応募をお願いいたします。</p>
    </div>-->

    <p class="jak-meta-bar"><strong>応募期間：</strong>4/7（火）～5/1（金）</p>

     <div class="jak-closed">
        <p>ＪＡ鈴鹿会場の応募は締め切りました。</p>
        <p>たくさんのご応募をありがとうございました。</p>
    </div> 
    
    <section class="jak-section" aria-labelledby="jak-overview-heading">
        <h2 id="jak-overview-heading" class="jak-section-title">開催概要</h2>
        <dl class="jak-dl">
            <div><dt>会　　場</dt><dd>ＪＡ鈴鹿 会場（ＪＡ鈴鹿のうきょうまつり）</dd></div>
            <div><dt>日　　時</dt><dd>5月23日（土）<br>午前の部　9：30～11：30　受付開始　9：00～<br>午後の部　13：30～15：30　受付開始　13：00～</dd></div>
            <div><dt>募集人数</dt><dd>各回　小学生のお子様と保護者の方、ペア15組30名様（合計30組60名）</dd></div>
            <div><dt>場　　所</dt><dd>ＪＡ鈴鹿のうきょうまつり　鈴鹿さつき温泉側（鈴鹿市津賀町850－2）
                <div class="jak-map-slot jak-map-slot--embed" role="region" aria-label="会場の地図"><iframe class="jak-map-slot__frame" title="会場の地図（Google マップ）" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3272.692657409733!2d136.51567481207294!3d34.889063272740046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60038b53707cc0a9%3A0xea1257886895468c!2z44CSNTEzLTAwMDIg5LiJ6YeN55yM6Yi06bm_5biC5rSl6LOA55S677yY77yV77yQ4oiS77yS!5e0!3m2!1sja!2sjp!4v1774392646322!5m2!1sja!2sjp" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div><p>※お車でお越しの方はＪＡまつり専用駐車場に駐車ください。</p></dd></div>
            <div><dt></dt><dd>
                <a class="jak-btn-download" href="/event/jakyousai/file/Radio_Suzuka.pdf" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-download" aria-hidden="true"></i>チラシのダウンロード（PDF）</a></dd></div>
                </dl>
    </section>
<!--
    <section class="jak-section" aria-labelledby="jak-elig-heading">
        <h2 id="jak-elig-heading" class="jak-section-title">応募資格</h2>
        <p>小学１年生～６年生</p>
    </section>
                
    <section class="jak-section" aria-labelledby="jak-form-heading">
        <h2 id="jak-form-heading" class="jak-section-title">応募フォーム</h2>-->
        <!-- <div class="jak-form-slot" aria-label="応募フォーム設置予定エリア"> -->
            
        <div class="stack stack-md"  <?php if($submitmode==1){echo 'style="display:none;"';}?>>
        <p class="text-muted"><span class="vad">必須</span> 印は入力必須項目です。 </p>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <div id="formz_input">
        
        <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>参加者募集</h5>
            <div class="form-field">
                <label class="form-field__label">ご希望の時間<span class="vad">必須</span></label>
                <div class="cluster cluster-gap-md">
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="0" <?php if($_POST['x_bt']==0){echo 'checked="checked"';}?> required="required" />
                        <span>1部 9:30～11:30</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="1" <?php if($_POST['x_bt']==1){echo 'checked="checked"';}?> required="required" />
                        <span>2部 13:30～15:30</span>
                    </label>
                </div>
                <?php if (!empty($error['x_bt'])): ?>
                    <p class="form-field__error"><?php echo $error['x_bt'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_email">メールアドレス<span class="vad">必須</span></label>
                <input id="u_email" name="u_email" type="email" value="<?php echo $_POST['u_email'] ?>" required="required" />
                <?php if (!empty($error['u_email'])): ?>
                    <p class="form-field__error"><?php echo $error['u_email'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_name">代表者氏名（保護者）<span class="vad">必須</span></label>
                <input id="u_name" name="u_name" type="text" value="<?php echo $_POST['u_name'] ?>" required="required" />
                <?php if (!empty($error['u_name'])): ?>
                    <p class="form-field__error"><?php echo $error['u_name'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_age">年齢<span class="vad">必須</span></label>
                <div class="cluster cluster-gap-xs">
                    <input id="u_age" name="u_age" type="number" class="input-narrow" value="<?php echo $_POST['u_age'] ?>" required="required" /><span>歳</span>
                </div>
                <?php if (!empty($error['u_age'])): ?>
                    <p class="form-field__error"><?php echo $error['u_age'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="p_name1">同伴者氏名（お子様）<span class="vad">必須</span></label>
                <input id="p_name1" name="p_name1" type="text" value="<?php echo $_POST['p_name1'] ?>" required="required" />
                <?php if (!empty($error['p_name1'])): ?>
                    <p class="form-field__error"><?php echo $error['p_name1'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="x_sel">学年<span class="vad">必須</span></label>
                <select id="x_sel" name="x_sel" required="required">
                    <option <?php if($_POST['x_sel'] == 0){echo 'selected="selected"';} ?> value="0">1年生</option>
                    <option <?php if($_POST['x_sel'] == 1){echo 'selected="selected"';} ?> value="1">2年生</option>
                    <option <?php if($_POST['x_sel'] == 2){echo 'selected="selected"';} ?> value="2">3年生</option>
                    <option <?php if($_POST['x_sel'] == 3){echo 'selected="selected"';} ?> value="3">4年生</option>
                    <option <?php if($_POST['x_sel'] == 4){echo 'selected="selected"';} ?> value="4">5年生</option>
                    <option <?php if($_POST['x_sel'] == 5){echo 'selected="selected"';} ?> value="5">6年生</option>
                </select>
                <?php if (!empty($error['x_sel'])): ?>
                    <p class="form-field__error"><?php echo $error['x_sel'] ?></p>
                <?php endif; ?>
            </div>
            <hr />
            <div class="form-field">
                <label class="form-field__label" for="u_zip">郵便番号<span class="vad">必須</span></label>
                <input id="u_zip" class="input-narrow" name="u_zip" type="text" value="<?php echo $_POST['u_zip'] ?>" onKeyUp="AjaxZip3.zip2addr(this,'','u_address','u_address');" placeholder="例：514-8505" required="required" />
                <?php if (!empty($error['u_zip'])): ?>
                    <p class="form-field__error"><?php echo $error['u_zip'] ?></p>
                <?php endif; ?>
                <p class="form-field__hint">※郵便番号を正しく入力すると住所が自動入力されます</p>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address">都道府県・市町<span class="vad">必須</span></label>
                <input id="u_address" name="u_address" type="text" value="<?php echo $_POST['u_address'] ?>" required="required" />
                <?php if (!empty($error['u_address'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address2">番地<span class="vad">必須</span></label>
                <input id="u_address2" name="u_address2" type="text" value="<?php echo $_POST['u_address2'] ?>" required="required" />
                <?php if (!empty($error['u_address2'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address2'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address3">マンション等</label>
                <input id="u_address3" name="u_address3" type="text" value="<?php echo $_POST['u_address3'] ?>"  />
                <?php if (!empty($error['u_address3'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address3'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_tel">電話番号<span class="vad">必須</span></label>
                <input id="u_tel" name="u_tel" type="tel" value="<?php echo $_POST['u_tel'] ?>" required="required" />
                <?php if (!empty($error['u_tel'])): ?>
                    <p class="form-field__error"><?php echo $error['u_tel'] ?></p>
                <?php endif; ?>
            </div>
            <?php if ($enable_optional_fields_toggle): ?>
            </div><!-- /#optional-fields-container -->
            <?php endif; ?>
            <hr />
            
            <div class="form-field">
                <label class="cluster cluster-gap-xs">
                    <input type="checkbox" name="savedata2" id="savedata2" value="1" <?php if($_POST['savedata2']==1){echo 'checked="checked"';} ?> />
                    <span>次回以降の入力を簡略化するため、お名前などの入力項目をブラウザに保存する。</span>
                </label>
            </div>
            
            <div class="form-field" id="privacy-consent-field">
                <p>▶ 当サイト内で入力された個人情報は、本件の対応のためにのみ利用します。詳しくは<a href="/profiles/privacypolicy.php" target="_blank">プライバシーポリシー</a>をご覧ください。<br />
                    
                <label class="cluster cluster-gap-xs">
                    <input type="checkbox" name="privacy_consentx" id="privacy_consentx" value="1" required="required" <?php if($_POST['privacy_consentx']==1){echo 'checked="checked"';} ?> />
                    <span>個人情報の取り扱いについて同意します<span class="vad">必須</span></span>
                </label>
                <?php if (!empty($error['privacy_consentx'])): ?>
                    <p class="form-field__error"><?php echo $error['privacy_consent'] ?></p>
                <?php endif; ?></p>
            </div>
            
            <!-- 既に同意済みの場合はhidden inputで送信 -->
            <!--<input type="hidden" name="privacy_consent" id="privacy_consent_hidden" value="1" />-->
            
            <input type="hidden" name="form_type" value="2" />
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="form_id" value="257" />
            <input type="hidden" name="form_title" value="学ぼう防災 鈴鹿会場" />
            </div>
            
            <div class="form-actions">
                <?php if($submitmode==0){?>
                    <button class="formz-btn" name="submit" type="submit">送 信</button>
                <?php }else{ ?>
                    <span class="formz-submit-closed"><?= $submit_mess ?></span>
                <?php }?>
            </div>
        </form>
    </div>
    

        <!-- </div> -->
    </section>

    <section class="jak-section" aria-labelledby="jak-notes-heading">
        <h2 id="jak-notes-heading" class="jak-section-title">特記事項（お読みください）</h2>
        <ul class="jak-list-notes">
            <li>応募は１組１回限りとさせていただきます</li>
            <li>保護者１名、小学生１名のペア１組にて応募ください。※ご兄弟姉妹がおみえの際は座席に余裕があれば椅子をお貸しできます。</li>
            <li>応募者多数の場合は抽選となります。</li>
            <li>当選された方は、５月８日（金）［予定］までにＦＭ三重よりメールにて結果を通知いたします。また、落選の方は、５月８日（金）以降にご応募いただいたメールアドレスにご返信させていただきます。</li>
            <li>当日、許可を頂けた方には取材をさせていただく場合ございます。取材の様子は後日ＦＭ三重にて放送させていただきます。（９月予定）</li>
        </ul>
    </section>
</div>

<?php require_once(INCLUDE_FOOTER_PATH); ?>
</body>
</html>
