<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
//error_reporting(0);
session_start();
$_SESSION['reg']=0;
$error=array();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
saveinput($_POST);
$fm_id=243;
// 確認画面の表示制御: 1=確認画面を表示, 0=確認画面をスキップしてregist.phpに直接送信
$confirm=0;
// 任意入力フィールドの折りたたみ機能のON/OFF制御　true: 折りたたみ機能を有効化、false: 常に表示
$enable_optional_fields_toggle = true;

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
<html lang="ja" itemscope itemtype="http://schema.org/Blog">
  <head>
    <meta charset="UTF-8">
    
    <title>メッセージ - 特番・イベント - レディオキューブFM三重</title>
    <link rel="canonical" href="https://fmmie.jp/topics/">
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <!--Include module="HTMLヘッダー -->
<!-- Open Graph Protocol -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="特番・イベント">
    <meta property="og:url" content="https://fmmie.jp/topics/">
    
    <meta property="og:site_name" content="特番・イベント">
    <meta property="og:image" content="/mt7/mt-static/support/theme_static/rainier/img/siteicon-sample.png">
    <!-- Microdata -->
    
    <meta itemprop="name" content="特番・イベント">

   <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam; ?>" />
   <link rel="stylesheet" href="/topics/styles.css<?php echo $themeParam; ?>" />
   <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</head>
  <body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
<main class="section">
      <div class="index-container stack">
        <section class="stack">
<article class="entry-card stack card-color container stack-lg" role="main">
    <h2 class="entry-title" itemprop="name">今夜はとくに眠れない　メッセージ</h2>
<?php echo $error['top'] ?>
<!-- formzstrap-->
    <div class="stack stack-md"  <?php if($submitmode==1){echo 'style="display:none;"';}?>>
        <p class="text-muted"><span class="vad">必須</span> 印は入力必須項目です。 </p>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <div id="formz_input"><?php prezsource(); ?>
        
        <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>メッセージ</h5>
            <div class="form-field">
                <label class="form-field__label" for="u_radioname">ラジオネーム<span class="vad">必須</span></label>
                <input id="u_radioname" name="u_radioname" type="text" value="<?php echo $_POST['u_radioname'] ?>" required="required" />
                <?php if (!empty($error['u_radioname'])): ?>
                    <p class="form-field__error"><?php echo $error['u_radioname'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="r_message">メッセージ</label>
                <textarea id="r_message" name="r_message" rows="10" ><?php echo $_POST['r_message'] ?></textarea>
                <?php if (!empty($error['r_message'])): ?>
                    <p class="form-field__error"><?php echo $error['r_message'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label">写真などがあれば、ファイルを選択してください</label>
                <input type="file" name="r_attached" value="1" />
            </div>
            <hr />
            <div class="form-field">
                <label class="form-field__label" for="u_email">メールアドレス<span class="vad">必須</span></label>
                <input id="u_email" name="u_email" type="email" value="<?php echo $_POST['u_email'] ?>" required="required" />
                <?php if (!empty($error['u_email'])): ?>
                    <p class="form-field__error"><?php echo $error['u_email'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_name">お名前 <span class="vad">必須</span></label>
                <input id="u_name" name="u_name" type="text" value="<?php echo $_POST['u_name'] ?>" required="required" />
                <?php if (!empty($error['u_name'])): ?>
                    <p class="form-field__error"><?php echo $error['u_name'] ?></p>
                <?php endif; ?>
            </div>
        
        <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>よろしければお書き添えください</h5>
            <div class="form-field">
                <label class="form-field__label">性別</label>
                <div class="cluster cluster-gap-md">
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="u_sex" value="女性" <?php if($_POST['u_sex']=='女性'){echo 'checked="checked"';}?> />
                        <span>女性</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="u_sex" value="男性" <?php if($_POST['u_sex']=='男性'){echo 'checked="checked"';}?> />
                        <span>男性</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="u_sex" value="無回答" <?php if($_POST['u_sex']=='無回答'){echo 'checked="checked"';}?> />
                        <span>無回答</span>
                    </label>
                </div>
                <?php if (!empty($error['u_sex'])): ?>
                    <p class="form-field__error"><?php echo $error['u_sex'] ?></p>
                <?php endif; ?>
            </div>
            <?php if ($enable_optional_fields_toggle): ?>
            <!-- 任意入力フィールドの折りたたみ機能 -->
            <div id="optional-fields-toggle-wrapper">
                <button type="button" id="optional-fields-toggle-btn" class="optional-fields-toggle-btn">
                    <i class="fa fa-chevron-down" aria-hidden="true"></i> 下に開く
                </button>
                <div id="optional-fields-gradient" class="optional-fields-gradient"></div>
            </div>
            <div id="optional-fields-container" class="optional-fields-container" style="display: none;">
            <?php endif; ?>
            
            <div class="form-field">
                <label class="form-field__label" for="u_age">年齢</label>
                <div class="cluster cluster-gap-xs">
                    <input id="u_age" name="u_age" type="number" class="input-narrow" value="<?php echo $_POST['u_age'] ?>"  /><span>歳</span>
                </div>
                <?php if (!empty($error['u_age'])): ?>
                    <p class="form-field__error"><?php echo $error['u_age'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_zip">郵便番号</label>
                <input id="u_zip" class="input-narrow" name="u_zip" type="text" value="<?php echo $_POST['u_zip'] ?>" onKeyUp="AjaxZip3.zip2addr(this,'','u_address','u_address');" placeholder="例：514-8505"  />
                <?php if (!empty($error['u_zip'])): ?>
                    <p class="form-field__error"><?php echo $error['u_zip'] ?></p>
                <?php endif; ?>
                <p class="form-field__hint">※郵便番号を正しく入力すると住所が自動入力されます</p>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address">都道府県・市町</label>
                <input id="u_address" name="u_address" type="text" value="<?php echo $_POST['u_address'] ?>"  />
                <?php if (!empty($error['u_address'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address2">番地</label>
                <input id="u_address2" name="u_address2" type="text" value="<?php echo $_POST['u_address2'] ?>"  />
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
                <label class="form-field__label" for="u_tel">電話番号</label>
                <input id="u_tel" name="u_tel" type="tel" value="<?php echo $_POST['u_tel'] ?>"  />
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
                <p>? 当サイト内で入力された個人情報は、本件の対応のためにのみ利用します。詳しくは<a href="/profiles/privacypolicy.php" target="_blank">プライバシーポリシー</a>をご覧ください。<br />
                    
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
            
            <input type="hidden" name="form_type" value="1" />
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="form_id" value="243" />
            <input type="hidden" name="form_title" value="今夜はとくに眠れない" />
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
    
<?php if($submitmode==1){?> <span class="formz-submit-closed"><?= $submit_mess ?></span><?php }?>
    	<!-- formzstrap-->  
            </div>
        </article>
        </section>
      </div>
    </main>
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    <?php if ($enable_optional_fields_toggle): ?>    
    <script src="/_assets/js/formz_optional_toggle.js"></script>
    <?php endif; ?>
  </body>
</html>