<?php
session_start();
$_session['reg']=0;
require_once '../../_app/functions.php';
saveinput($_POST);
$fm_id=252;
formz_config($fm_id);
if($_POST['act']==1){
	require_once '../../_app/formz_validate.php';
	if (!is_array($error)){
        require_once '../../_app/formz_regist.php';
	}else{
		$_session['reg']=0;
	}
}
$phppath = '<$MTGetVar name="config.includephppath"$>'
?>

<!DOCTYPE html>
<html lang="ja" itemscope itemtype="http://schema.org/WebPage">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="ラジオCM制作はお任せください ラジオCM制作はお任せください...">
    <meta name="generator" content="Movable Type 5.2.9">
    <title>ラジオCM制作はお任せください - レディオキューブFM三重 スペシャルサイト</title>
    <link rel="canonical" href="http://fmmie.jp/sp/tokusyusagi/">
    <!-- Open Graph Protocol -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="ラジオCM制作はお任せください">
    <meta property="og:url" content="http://fmmie.jp/sp/tokusyusagi/">
    <meta property="og:description" content="ラジオCM制作はお任せください ラジオCM制作はお任せください...">
    <meta property="og:site_name" content="レディオキューブFM三重 スペシャルサイト">
    <meta property="og:image" content="https://fmmie.jp/_mtos5/mt-static/support/theme_static/classic-website/img/siteicon-sample.png">
    <!-- Metadata -->
    <meta itemprop="description" content="ラジオCM制作はお任せください ラジオCM制作はお任せください...">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<?php
  require_once("/home/kir691871/public_html/fmmie.jp/_include/inc_htmlheader.php");
?>
<link rel="stylesheet" href="/_include/css/jquery.mobile.structure-1.3.0.min.css" />
<link rel="stylesheet" href="/_include/css/contents_style.css" /> 
<link rel="stylesheet" href="styles.css?x=0.1" />
<script src="https://use.fontawesome.com/c1630c0fa9.js"></script>
<link rel="stylesheet" href="/_include/css/formzboot.css">
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<?php if (is_array($error)){?>
<script>
  window.location.hash = "#bootformz";
</script>
<?php } ?>
</head>
<body>
  <?php
require_once("/home/kir691871/public_html/fmmie.jp/_include/inc_header_sp.php");
?>
<div id="content_main">
<section id="cts" class="clearfix">
<article id="main_contents_wide">

  <?php include('page.php'); ?>

  
  <div class="main" >
	<p>　</p>
           <h2>お問い合わせ フォーム</h2>
<!-- formzstrap-->
<div class="bootformz" id="bootformz">
<form  action="" method="post" enctype="multipart/form-data">
            <div id="formz_box">
            <?php echo $error['top'] ?>
            ・入力いただきました個人情報は、[みえツナゲール]受付以外では使用しません。詳しくは、<a href="/company/security.php">プライバシーポリシー</a>をご参照ください。<br />
            ・<span class="vad">*</span>印は入力必須項目です。
            
            <div id="formz_input" <?php if($submitmode==1){echo 'style="display:none;"';}?>>
            <hr class="req_sep_bar" />
                        <div class="form-group">
                        <label class="control-label " for="r_message">お問い合わせ内容</label>
                        <textarea class="form-control" cols="20" id="r_message" name="r_message" rows="10" ><?php echo $_POST['r_message'] ?></textarea>
                        </div>
            <div class="form-group">
                <label class="control-label " for="u_radioname">貴局名・社名<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_radioname'] ?>" id="u_radioname" name="u_radioname" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_radioname'] ?></span>
            </div>
            <div class="form-group">
                <label class="control-label " for="u_name">ご担当者氏名<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_name'] ?>" id="u_name" name="u_name" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_name'] ?></span>
            </div>
            <div class="form-group">
                <label class="control-label " for="u_tel">電話番号<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_tel'] ?>" id="u_tel" name="u_tel" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_tel'] ?></span>
            </div>
            <div class="form-group">
                <label class="control-label " for="u_email">メールアドレス<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_email'] ?>" id="u_email" name="u_email" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_email'] ?></span>
            </div>
            <!-- <hr clear="all" /> -->
            <!-- <div class="form-group">
                <div class="checkbox">
                <label>
                    <input type="checkbox" name="savedata" id="savedata" value="1" <?php if($_POST['savedata']==1){echo 'checked="checked"';} ?> /> お名前などの入力項目をブラウザに保存する。 
                </label>
                </div>
            </div>     -->
            <input type="hidden" name="form_type" value="0" />
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="form_id" value="252" />
            </div>
            <div class="form-group center-block">
            <?php if($submitmode==0){?>
                <button class="btn btn-primary " name="submit" type="submit">送信</button>
            <?php }else{ ?>
                <span class="formz-submit-closed"><?= $submit_mess ?></span>
            <?php }?>
            </div>
            </div>
        </form>
        
    </div>
	<!-- formzstrap-->  
</div>
	

</article>
</section>
</div>
<script>
    /*
var audioPlayer = document.getElementById('audioPlayer');
var audioButton = document.getElementById('audioButton');
var playIcon = document.getElementById('playIcon');

var audioPlayer2 = document.getElementById('audioPlayer2');
var audioButton2 = document.getElementById('audioButton2');
var playIcon2 = document.getElementById('playIcon2');

var audioPlayer3 = document.getElementById('audioPlayer3');
var audioButton3 = document.getElementById('audioButton3');
var playIcon3 = document.getElementById('playIcon3');

var audioPlayer4 = document.getElementById('audioPlayer4');
var audioButton4 = document.getElementById('audioButton4');
var playIcon4 = document.getElementById('playIcon4');

var audioPlayer5 = document.getElementById('audioPlayer5');
var audioButton5 = document.getElementById('audioButton5');
var playIcon5 = document.getElementById('playIcon5');

var audioPlayer6 = document.getElementById('audioPlayer6');
var audioButton6 = document.getElementById('audioButton6');
var playIcon6 = document.getElementById('playIcon6');

audioButton.addEventListener('click', function() {
  if (audioPlayer.paused) {
    audioPlayer.play();
    playIcon.src = '/sp/cm/images/voice2.png';
    
    audioPlayer2.pause();playIcon2.src = '/sp/cm/images/voice.png';
    audioPlayer3.pause();playIcon3.src = '/sp/cm/images/voice.png';
    audioPlayer4.pause();playIcon4.src = '/sp/cm/images/voice.png';
    audioPlayer5.pause();playIcon5.src = '/sp/cm/images/voice.png';
    audioPlayer6.pause();playIcon6.src = '/sp/cm/images/voice.png';
  } else {
    audioPlayer.pause();
    playIcon.src = '/sp/cm/images/voice.png';
  }
});
audioPlayer.addEventListener('ended', function() {
  playIcon.src = '/sp/cm/images/voice.png';
});


audioButton2.addEventListener('click', function() {
  if (audioPlayer2.paused) {
    audioPlayer2.play();
    playIcon2.src = '/sp/cm/images/voice2.png';
    audioPlayer.pause();playIcon.src = '/sp/cm/images/voice.png';
    audioPlayer3.pause();playIcon3.src = '/sp/cm/images/voice.png';
    audioPlayer4.pause();playIcon4.src = '/sp/cm/images/voice.png';
    audioPlayer5.pause();playIcon5.src = '/sp/cm/images/voice.png';
    audioPlayer6.pause();playIcon6.src = '/sp/cm/images/voice.png';
  } else {
    audioPlayer2.pause();
    playIcon2.src = '/sp/cm/images/voice.png';
  }
});
audioPlayer2.addEventListener('ended', function() {
  playIcon2.src = '/sp/cm/images/voice.png';
});

audioButton3.addEventListener('click', function() {
  if (audioPlayer3.paused) {
    audioPlayer3.play();
    playIcon3.src = '/sp/cm/images/voice2.png';
    audioPlayer.pause();playIcon.src = '/sp/cm/images/voice.png';
    audioPlayer2.pause();playIcon2.src = '/sp/cm/images/voice.png';
    audioPlayer4.pause();playIcon4.src = '/sp/cm/images/voice.png';
    audioPlayer5.pause();playIcon5.src = '/sp/cm/images/voice.png';
    audioPlayer6.pause();playIcon6.src = '/sp/cm/images/voice.png';
  } else {
    audioPlayer3.pause();
    playIcon3.src = '/sp/cm/images/voice.png';
  }
});
audioPlayer3.addEventListener('ended', function() {
  playIcon3.src = '/sp/cm/images/voice.png';
});


audioButton4.addEventListener('click', function() {
  if (audioPlayer4.paused) {
    audioPlayer4.play();
    playIcon4.src = '/sp/cm/images/voice2.png';
    audioPlayer.pause();playIcon.src = '/sp/cm/images/voice.png';
    audioPlayer2.pause();playIcon2.src = '/sp/cm/images/voice.png';
    audioPlayer3.pause();playIcon3.src = '/sp/cm/images/voice.png';
    audioPlayer5.pause();playIcon5.src = '/sp/cm/images/voice.png';
    audioPlayer6.pause();playIcon6.src = '/sp/cm/images/voice.png';
  } else {
    audioPlayer4.pause();
    playIcon4.src = '/sp/cm/images/voice.png';
  }
});
audioPlayer4.addEventListener('ended', function() {
  playIcon4.src = '/sp/cm/images/voice.png';
});

audioButton5.addEventListener('click', function() {
  if (audioPlayer5.paused) {
    audioPlayer5.play();
    playIcon5.src = '/sp/cm/images/voice2.png';
    audioPlayer.pause();playIcon.src = '/sp/cm/images/voice.png';
    audioPlayer2.pause();playIcon2.src = '/sp/cm/images/voice.png';
    audioPlayer3.pause();playIcon3.src = '/sp/cm/images/voice.png';
    audioPlayer4.pause();playIcon4.src = '/sp/cm/images/voice.png';
    audioPlayer6.pause();playIcon6.src = '/sp/cm/images/voice.png';
  } else {
    audioPlayer5.pause();
    playIcon5.src = '/sp/cm/images/voice.png';
  }
});
audioPlayer5.addEventListener('ended', function() {
  playIcon5.src = '/sp/cm/images/voice.png';
});

audioButton6.addEventListener('click', function() {
  if (audioPlayer6.paused) {
    audioPlayer6.play();
    playIcon6.src = '/sp/cm/images/voice2.png';
    audioPlayer.pause();playIcon.src = '/sp/cm/images/voice.png';
    audioPlayer2.pause();playIcon2.src = '/sp/cm/images/voice.png';
    audioPlayer3.pause();playIcon3.src = '/sp/cm/images/voice.png';
    audioPlayer4.pause();playIcon4.src = '/sp/cm/images/voice.png';
    audioPlayer5.pause();playIcon5.src = '/sp/cm/images/voice.png';
  } else {
    audioPlayer6.pause();
    playIcon6.src = '/sp/cm/images/voice.png';
  }
});
audioPlayer6.addEventListener('ended', function() {
  playIcon6.src = '/sp/cm/images/voice.png';
});



    audioPlayer.pause();playIcon.src = '/sp/cm/images/voice.png';
    audioPlayer2.pause();playIcon2.src = '/sp/cm/images/voice.png';
    audioPlayer3.pause();playIcon3.src = '/sp/cm/images/voice.png';
    audioPlayer4.pause();playIcon4.src = '/sp/cm/images/voice.png';
    audioPlayer5.pause();playIcon5.src = '/sp/cm/images/voice.png';
    audioPlayer6.pause();playIcon6.src = '/sp/cm/images/voice.png';

    */ 

var players = [];
var buttons = [];
var icons = [];

// Elements ID should follow this pattern: 'audioPlayer1', 'audioButton1', 'playIcon1', etc.
for (var i = 1; i <= 6; i++) {
    players[i] = document.getElementById('audioPlayer' + i);
    buttons[i] = document.getElementById('audioButton' + i);
    icons[i] = document.getElementById('playIcon' + i);
}

function resetAll() {
    for (var i = 1; i <= 6; i++) {
        players[i].pause();
        icons[i].src = '/sp/cm/images/voice.png';
        /*players[i].currentTime = 0;*/
    }
}

for (var i = 1; i <= 6; i++) {
    (function(i) {
        buttons[i].addEventListener('click', function() {
            if (players[i].paused) {
                resetAll();
                players[i].play();
                icons[i].src = '/sp/cm/images/voice2.png';
            } else {
                players[i].pause();
                icons[i].src = '/sp/cm/images/voice.png';
            }
        });

        players[i].addEventListener('ended', function() {
            icons[i].src = '/sp/cm/images/voice.png';
        });
    })(i);
}

</script>
<?php
require_once("/home/kir691871/public_html/fmmie.jp/_include/inc_footer.php");
?>

