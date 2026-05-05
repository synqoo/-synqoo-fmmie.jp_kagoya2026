<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<?php
error_reporting(0);
session_start();
$_SESSION['reg']=0;
// $error=array();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
saveinput($_POST);
$fm_id=229;
formz_config($fm_id);

// 任意入力フィールドの折りたたみ機能のON/OFF制御
// true: 折りたたみ機能を有効化、false: 常に表示
$enable_optional_fields_toggle = true;
if($_POST['act']==1){
    require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_validate.php');
    if (!is_array($error)){
//require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_regist.php');
echo'sending mail.........';
    }else{
        $_SESSION['reg']=0;
echo'no sending..';
print_r ($error);

    }
}
$phppath = '<$MTGetVar name="config.includephppath"$>';
?>
<$mt:Var name="entries_per_page" value="10"$>
<mt:SetVarBlock name="search_link">
    <$mt:CGIPath$><$mt:SearchScript$>?IncludeBlogs=<$mt:BlogID$>
    &template_id=<$mt:BuildTemplateID$>
    &limit=<$mt:Var name="entries_per_page"$>
    &archive_type=Index
    &page=
</mt:SetVarBlock>

<!DOCTYPE html>
<html lang="<$mt:BlogLanguage$>" itemscope itemtype="http://schema.org/Blog">
  <head>
    <meta charset="<$mt:PublishCharset$>">
    <mt:If tag="BlogDescription"><meta name="description" content="<$mt:BlogDescription remove_html="1" encede_html="1"$>"></mt:If>
    <title>メッセージ - <$mt:BlogName encode_html="1"$> - レディオキューブFM三重</title>
    <link rel="canonical" href="<$mt:BlogURL encode_html="1"$>">
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <$mt:Include module="HTMLヘッダー"$>
   <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</head>
  <body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
<main class="section">
      <div class="index-container stack">
        <section class="stack">
            <$mt:Include module="バナーヘッダー"$>
<article class="entry-card stack card-color container stack-lg" role="main">
    <h2 class="entry-title" itemprop="name">メッセージ</h2>

<!-- formzstrap-->
    <div class="stack stack-md">
        <p class="text-muted">
            ・<span class="vad">必須</span>印は入力必須項目です。
        </p>
        
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <div id="formz_input" <?php if($submitmode==1){echo 'style="display:none;"';}?>><?php //prezsource(); ?>
            
            <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>メッセージ</h5>
            
            <div class="form-field">
                <label class="form-field__label" for="u_radioname">ラジオネーム<span class="vad">*</span></label>
                <input id="u_radioname" name="u_radioname" type="text" value="<?php echo $_POST['u_radioname'] ?>" required="required" />
                <?php if (!empty($error['u_radioname'])): ?>
                    <p class="form-field__error"><?php echo $error['u_radioname'] ?></p>
                <?php endif; ?>
            </div>
            
            <div class="form-field">
                <label class="form-field__label" for="r_message">メッセージ</label>
                <textarea id="r_message" name="r_message" rows="10"><?php echo $_POST['r_message'] ?></textarea>
            </div>
            
            <div class="form-field">
                <label class="form-field__label">写真などがあれば、ファイルを選択してください</label>
                <input type="file" name="r_attached" value="1" />
            </div>
            
            <hr />
            
            <div class="form-field">
                <label class="form-field__label" for="u_email">メールアドレス<span class="vad">*</span></label>
                <input id="u_email" name="u_email" type="email" value="<?php echo $_POST['u_email'] ?>" required="required" />
                <?php if (!empty($error['u_email'])): ?>
                    <p class="form-field__error"><?php echo $error['u_email'] ?></p>
                <?php endif; ?>
            </div>
            
            <div class="form-field">
                <label class="form-field__label" for="u_name">お名前<span class="vad">*</span></label>
                <input id="u_name" name="u_name" type="text" value="<?php echo $_POST['u_name'] ?>" required="required" />
                <?php if (!empty($error['u_name'])): ?>
                    <p class="form-field__error"><?php echo $error['u_name'] ?></p>
                <?php endif; ?>
            </div>
            
            <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>性別や住所など、よろしければお書き添えください</h5>
            
            
            
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
                    <input id="u_age" name="u_age" type="number" value="<?php echo $_POST['u_age'] ?>" />
                    <span>歳</span>
                </div>
                <?php if (!empty($error['u_age'])): ?>
                    <p class="form-field__error"><?php echo $error['u_age'] ?></p>
                <?php endif; ?>
            </div>
            
            <div class="form-field">
                <label class="form-field__label" for="u_zip">郵便番号</label>
                <input id="u_zip" name="u_zip" type="text" value="<?php echo $_POST['u_zip'] ?>" onKeyUp="AjaxZip3.zip2addr(this,'','u_address','u_address');" placeholder="例：514-8505" />
                <?php if (!empty($error['u_zip'])): ?>
                    <p class="form-field__error"><?php echo $error['u_zip'] ?></p>
                <?php endif; ?>
                <p class="form-field__hint">※郵便番号を正しく入力すると住所が自動入力されます</p>
            </div>
            
            <div class="form-field">
                <label class="form-field__label" for="u_address">都道府県・市町</label>
                <input id="u_address" name="u_address" type="text" value="<?php echo $_POST['u_address'] ?>" />
                <?php if (!empty($error['u_address'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address'] ?></p>
                <?php endif; ?>
            </div>
            
            <div class="form-field">
                <label class="form-field__label" for="u_address2">番地</label>
                <input id="u_address2" name="u_address2" type="text" value="<?php echo $_POST['u_address2'] ?>" />
                <?php if (!empty($error['u_address2'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address2'] ?></p>
                <?php endif; ?>
            </div>
            
            <div class="form-field">
                <label class="form-field__label" for="u_address3">マンション等</label>
                <input id="u_address3" name="u_address3" type="text" value="<?php echo $_POST['u_address3'] ?>" />
                <?php if (!empty($error['u_address3'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address3'] ?></p>
                <?php endif; ?>
            </div>
            
            <div class="form-field">
                <label class="form-field__label" for="u_tel">電話番号</label>
                <input id="u_tel" name="u_tel" type="tel" value="<?php echo $_POST['u_tel'] ?>" />
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
                    <input type="checkbox" name="savedata" id="savedata" value="1" <?php if($_POST['savedata']==1){echo 'checked="checked"';} ?> />
                    <span>次回以降の入力を簡略化するため、お名前などの入力項目をブラウザに保存する。</span>
                </label>
            </div>
            
            <div class="form-field" id="privacy-consent-field">
                <p>▶ 当サイト内で入力された個人情報は、本件の対応のためにのみ利用します。詳しくは<a href="/privacy.php" target="_blank" class="text-primary">プライバシーポリシー</a>をご覧ください。<br />
                    
                <label class="cluster cluster-gap-xs">  
                    <input type="checkbox" name="privacy_consent" id="privacy_consent" value="1" required="required" <?php if($_POST['privacy_consent']==1){echo 'checked="checked"';} ?> />
                    <span>個人情報の取り扱いについて同意します<span class="vad">*</span></span>
                </label>
                <?php if (!empty($error['privacy_consent'])): ?>
                    <p class="form-field__error"><?php echo $error['privacy_consent'] ?></p>
                <?php endif; ?></p>
            </div>
            
            <!-- 既に同意済みの場合はhidden inputで送信 -->
            <input type="hidden" name="privacy_consent" id="privacy_consent_hidden" value="1" />
            
            <input type="hidden" name="form_type" value="0" />
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="form_id" value="229" />
            </div>
            
            <div class="form-actions">
                <?php if($submitmode==0){?>
                    <button class="formz-btn" name="submit" type="submit">送信</button>
                <?php }else{ ?>
                    <span class="formz-submit-closed"><?= $submit_mess ?></span>
                <?php }?>
            </div>
        </form>
    </div>
	<!-- formzstrap-->  
            </div>
        </article>
        </section>
      </div>
    </main>
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    
    <?php if ($enable_optional_fields_toggle): ?>    
    <script>
    (function() {
        'use strict';
        
        const toggleBtn = document.getElementById('optional-fields-toggle-btn');
        const container = document.getElementById('optional-fields-container');
        const gradient = document.getElementById('optional-fields-gradient');
        
        if (!toggleBtn || !container) {
            return;
        }
        
        toggleBtn.addEventListener('click', function() {
            // コンテナを表示
            container.style.display = 'block';
            container.classList.add('show');
            
            // ボタンを非表示
            toggleBtn.style.display = 'none';
            
            // グラデーションを非表示
            if (gradient) {
                gradient.style.display = 'none';
            }
        });
    })();
    </script>
    <?php endif; ?>
  </body>
</html>