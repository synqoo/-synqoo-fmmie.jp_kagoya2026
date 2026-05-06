<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="ja" itemscope itemtype="http://schema.org/Blog">
  <head>
    <title>eスポ フライデーナイトフィーバー - レディオキューブFM三重</title>
    
      <meta name="description" content="ゲーム情報はもちろん、ｅスポーツの大会情報まで詰まった盛りだくさんの内容でお届けします。
eスポーツってなんなの？な人から、ゲーマーと呼ばれる人までフィーバーしちゃう30分！
フライデーナイトフィーバー！！" />
    
    <link rel="canonical" href="https://fmmie.jp/programs/FlidayNightFever/" />
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <!--Include module="HTMLヘッダー -->
<!-- Open Graph Protocol -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="eスポ フライデーナイトフィーバー">
    <meta property="og:url" content="https://fmmie.jp/programs/FlidayNightFever/">
    <meta property="og:description" content="ゲーム情報はもちろん、ｅスポーツの大会情報まで詰まった盛りだくさんの内容でお届けします。
eスポーツってなんなの？な人から、ゲーマーと呼ばれる人までフィーバーしちゃう30分！
フライデーナイトフィーバー！！">
    <meta property="og:site_name" content="eスポ フライデーナイトフィーバー">
    <meta property="og:image" content="/mt7/mt-static/support/theme_static/theme-from-pomie/img/siteicon-sample.png">
    <!-- Microdata -->
    <meta itemprop="description" content="ゲーム情報はもちろん、ｅスポーツの大会情報まで詰まった盛りだくさんの内容でお届けします。
eスポーツってなんなの？な人から、ゲーマーと呼ばれる人までフィーバーしちゃう30分！
フライデーナイトフィーバー！！">
    <meta itemprop="name" content="eスポ フライデーナイトフィーバー">

   <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
   <link rel="stylesheet" href="https://fmmie.jp/programs/FlidayNightFever/styles.css<?php echo $themeParam ?? ''; ?>" />
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
 <?php $topview =0;?>
    <!-- メイン -->
    <main class="section">
      <div class="index-container stack">
        <section class="stack">
        <?php require_once("/home/kir691871/public_html/fmmie.jp/programs/FlidayNightFever/headbanner.php"); ?>
 <?php if($topview ==0){ ?>
<!-- ページエントリー -->
          <div class="entry-card stack">
            <div id="index-main" class="main" role="main">
                <article class="card stack stack-sm card-color-nomargin">
                
                <h2 class="entry-title"></h2>
                <div class="entry-excerpt">
                 
                 ＝＝＝ここに自由にコンテンツ＝＝＝
                </div>
                 
<?php }else{?>
<!-- ブログエントリー -->
          <div class="entry-card stack">
            <div id="index-main" class="main" role="main">
              
              
              <!-- ページネーション -->
              
              
            </div>
          </div>
<?php } ?>
        </section>
      </div>
    </main>
    
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    
  </body>
</html>
