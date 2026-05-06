<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="ja" itemscope itemtype="http://schema.org/Article">
  <head>
    <title> - eスポ フライデーナイトフィーバー</title>
    
      <meta name="description" content="   * {     box-sizing: border-box;     m..." />
    
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
    <!-- メイン -->
    <main class="section">
      <div class="index-container stack">
        <section class="stack">
        <?php require_once("/home/kir691871/public_html/fmmie.jp/programs/FlidayNightFever/headbanner.php"); ?>
          
          <!-- ブログエントリー -->
          <article id="entry-927" class="entry-card stack" itemscope itemtype="http://schema.org/Article">
          <!-- パンくずリスト -->
          <!--<nav aria-label="パンくずリスト" class="card card-color breadcrumb">
            <a href="https://fmmie.jp/programs/FlidayNightFever/">ホーム</a>
            <span>/</span>
            <span></span>
          </nav>-->
            <header class="entry-header">
              <h2 itemprop="name" class="entry-title"></h2>
            </header>
            <div class="entry-content" itemprop="articleBody">
              <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&family=Orbitron:wght@700;900&display=swap" rel="stylesheet">

<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .efla-wrap {
    font-family: 'Noto Sans JP', sans-serif;
    background: #ffffff;
    color: #1a1a2e;
    padding: 40px 20px 60px;
    max-width: 680px;
    margin: 0 auto;
  }

  /* タイトルエリア */
  .efla-title-area {
    text-align: center;
    margin-bottom: 36px;
  }

  .efla-eyebrow {
    font-family: 'Orbitron', monospace;
    font-size: 11px;
    letter-spacing: 5px;
    color: #5b6aff;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .efla-title {
    font-family: 'Orbitron', monospace;
    font-size: clamp(22px, 5.5vw, 38px);
    font-weight: 900;
    line-height: 1.25;
    background: linear-gradient(120deg, #5b6aff 0%, #ff4081 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
  }

  .efla-badge {
    display: inline-block;
    border: 2px solid #5b6aff;
    border-radius: 8px;
    padding: 4px 18px;
    font-family: 'Orbitron', monospace;
    font-size: 20px;
    color: #5b6aff;
    font-weight: 700;
    letter-spacing: 3px;
    margin-bottom: 14px;
  }

  .efla-start {
    font-size: 13px;
    color: #888;
    margin-bottom: 6px;
  }

  .efla-onair {
    font-size: 19px;
    font-weight: 900;
    color: #ff4081;
    letter-spacing: 1px;
  }

  /* セクション共通 */
  .efla-section {
    border-radius: 18px;
    padding: 24px 22px;
    margin-bottom: 20px;
  }

  .efla-section-label {
    font-family: 'Orbitron', monospace;
    font-size: 11px;
    letter-spacing: 3px;
    margin-bottom: 12px;
    text-transform: uppercase;
  }

  /* eスポーツとは */
  .efla-what {
    background: linear-gradient(135deg, #f0f2ff 0%, #fff5f9 100%);
    border: 1.5px solid #dde0ff;
  }

  .efla-what .efla-section-label {
    color: #5b6aff;
  }

  .efla-what p {
    font-size: 15px;
    line-height: 1.9;
    color: #333;
  }

  .efla-what strong {
    color: #5b6aff;
  }

  /* パーソナリティ */
  .efla-cast {
    background: linear-gradient(135deg, #fff5f9 0%, #f0f2ff 100%);
    border: 1.5px solid #ffd6e4;
  }

  .efla-cast .efla-section-label {
    color: #ff4081;
  }

  .efla-cast-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .efla-cast-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #fff;
    border-radius: 12px;
    padding: 12px 16px;
    box-shadow: 0 2px 8px rgba(91,106,255,0.07);
  }

  .efla-cast-icon {
    font-size: 22px;
    flex-shrink: 0;
    line-height: 1;
    margin-top: 2px;
  }

  .efla-cast-sub {
    font-size: 11px;
    color: #999;
    margin-bottom: 3px;
  }

  .efla-cast-name {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
  }

  .efla-cast-nick {
    color: #ff4081;
  }

  .efla-cast-real {
    color: #5b6aff;
  }

  /* メッセージ */
  .efla-msg {
    background: linear-gradient(135deg, #fffbec 0%, #fff5f9 100%);
    border: 1.5px solid #ffe699;
    text-align: center;
  }

  .efla-msg .efla-section-label {
    color: #e0a000;
  }

  .efla-msg p {
    font-size: 15px;
    line-height: 1.85;
    color: #444;
    margin-bottom: 14px;
  }

  .efla-hashtag-box {
    display: inline-block;
    background: #fff;
    border: 1.5px solid #1da1f2;
    border-radius: 999px;
    padding: 8px 22px;
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
  }

  .efla-hashtag-box .hash {
    color: #1da1f2;
  }

  .efla-hashtag-box .tag {
    color: #ff4081;
    font-family: monospace;
  }

  /* キャッチ */
  .efla-catch {
    text-align: center;
    padding: 24px 10px;
  }

  .efla-catch-sub {
    font-size: 14px;
    color: #999;
    margin-bottom: 8px;
  }

  .efla-catch-main {
    font-size: clamp(17px, 4vw, 22px);
    font-weight: 900;
    background: linear-gradient(90deg, #5b6aff, #ff4081);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1.5;
  }

  /* リンク */
  .efla-links {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .efla-link {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    border-radius: 14px;
    padding: 14px 20px;
    transition: transform 0.15s, box-shadow 0.15s;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  }

  .efla-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
  }

  .efla-link-a {
    background: linear-gradient(135deg, #f0f2ff, #e8ebff);
    border: 1.5px solid #c5caff;
  }

  .efla-link-b {
    background: linear-gradient(135deg, #fff5f9, #ffe8f0);
    border: 1.5px solid #ffb3cc;
  }

  .efla-link-icon {
    font-size: 26px;
    flex-shrink: 0;
  }

  .efla-link-sub {
    font-size: 11px;
    margin-bottom: 2px;
  }

  .efla-link-a .efla-link-sub { color: #5b6aff; }
  .efla-link-b .efla-link-sub { color: #ff4081; }

  .efla-link-title {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
  }

  /* デコライン */
  .efla-divider {
    height: 3px;
    background: linear-gradient(90deg, #5b6aff, #ff4081);
    border-radius: 999px;
    margin: 28px 0;
  }
</style>

<div class="efla-wrap">

  <!-- タイトル -->
  <div class="efla-title-area">
    <div class="efla-eyebrow">eスポーツ専門番組</div>
    <div class="efla-title">eスポ フライデー<br>ナイトフィーバー</div>
    <div class="efla-badge">「eフラ」</div>
    <div class="efla-start">2021年4月スタート</div>
    <div class="efla-onair">毎週（金）21:00〜 放送中！</div>
  </div>

  <div class="efla-divider"></div>

  <!-- eスポーツとは -->
  <div class="efla-section efla-what">
    <div class="efla-section-label">◆ eスポーツとは？</div>
    <p>コンピュータゲーム（ビデオゲーム）などを競技として捉え対戦する、<br><strong>エレクトロニック・スポーツ</strong>のことであ〜る！</p>
  </div>

  <!-- パーソナリティ -->
  <div class="efla-section efla-cast">
    <div class="efla-section-label">◆ パーソナリティ紹介</div>
    <div class="efla-cast-list">
      <div class="efla-cast-item">
        <div class="efla-cast-icon">★</div>
        <div>
          <div class="efla-cast-sub">三重県eスポーツ連合 / eスポーツのことならお任せあれ</div>
          <div class="efla-cast-name"><span class="efla-cast-nick">あののぶたに</span> こと <span class="efla-cast-real">延谷卓哉</span></div>
        </div>
      </div>
      <div class="efla-cast-item">
        <div class="efla-cast-icon">★</div>
        <div>
          <div class="efla-cast-sub">格闘ゲーム界に名を轟かせる</div>
          <div class="efla-cast-name"><span class="efla-cast-nick">るくぷる</span> こと <span class="efla-cast-real">野呂京志</span></div>
        </div>
      </div>
      <div class="efla-cast-item">
        <div class="efla-cast-icon">★</div>
        <div>
          <div class="efla-cast-sub">レディオキューブアナウンサー</div>
          <div class="efla-cast-name"><span class="efla-cast-nick">キヨンセ</span> こと <span class="efla-cast-real">清田のぞみ</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- メッセージ募集 -->
  <div class="efla-section efla-msg">
    <div class="efla-section-label">◆ メッセージ募集中！</div>
    <p>ゲーム・eスポーツの話題、ゲストに呼んで欲しい人、<br>素朴な疑問・質問などなど気軽に送ってください！</p>
    <div class="efla-hashtag-box">
      <span class="hash">
              
              <!-- SNSシェアリンク -->
              <div class="entry-sns-share">
                <p class="entry-sns-share-label">この記事をシェア</p>
                <div class="cluster cluster-gap-md">
                  <a href="https://twitter.com/intent/tweet?url=https%3A%2F%2Ffmmie.jp%2Fprograms%2FFlidayNightFever%2Fpost.php&text=" 
                     target="_blank" 
                     rel="noopener noreferrer"
                     class="sns-share-link sns-share-x"
                     aria-label="X でシェア">
                    <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                    <span class="sr-only">X でシェア</span>
                  </a>
                  <a href="https://social-plugins.line.me/lineit/share?url=https%3A%2F%2Ffmmie.jp%2Fprograms%2FFlidayNightFever%2Fpost.php" 
                     target="_blank" 
                     rel="noopener noreferrer"
                     class="sns-share-link sns-share-line"
                     aria-label="LINEでシェア">
                    <i class="fa-brands fa-line" aria-hidden="true"></i>
                    <span class="sr-only">LINEでシェア</span>
                  </a>
                </div>
              </div>
            </div>
          </article>
        </section>
      </div>
    </main>
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
  </body>
</html>
