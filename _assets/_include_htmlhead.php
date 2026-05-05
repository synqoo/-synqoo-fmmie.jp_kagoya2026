  <!-- レスポンシブ -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="format-detection" content="telephone=no" />
  <!-- OGP（必要に応じて編集） -->
  <meta property="og:title" content="レディオキューブFM三重">
  <meta property="og:description" content="Radio3 FM MIE（レディオキューブFM三重）/三重県の県域FMラジオ局/番組 コンサート イベント 音楽情報満載！">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://fmmie.jp/">
  <meta property="og:image" content="https://fmmie.jp/_assets/img/logo_2026.png">
  <meta name="twitter:card" content="summary_large_image">

  <!-- PWA: Web App 対応 -->
  <link rel="manifest" href="/manifest.webmanifest" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <meta name="apple-mobile-web-app-title" content="レディオキューブFM三重" />
  <meta name="theme-color" content="#2B7898" />

  <!-- アイコン類（実ファイルは後で設置） -->
  <link rel="icon" href="/favicon.ico" />
  <link rel="icon" type="image/png" href="/_assets/img/icons/icon.png" />
  <link rel="apple-touch-icon" href="/_assets/img/icons/icon.png" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Font Awesome: CSSで読み込み（scriptより表示が早くキャッシュも効く） -->
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&display=swap" as="style" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'" />
  <noscript><link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&display=swap" rel="stylesheet" /></noscript>
  <!-- Google Fonts（サブフォント） -->
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- ベースCSS -->
  <?php
  // テーマ名をパラメーターとして追加（キャッシュバスティング用／v は ISO 週単位で更新＝おおよそ毎週）
  $themeParam = '?theme=' . urlencode($staticTheme ?? 'default') . '&v=' . date('oW');
  ?>
  <!-- 重要なCSSを優先的に読み込む（FOUC防止） -->
  <link rel="preload" href="https://cdn.jsdelivr.net/npm/modern-normalize/modern-normalize.css" as="style" />
  <link rel="preload" href="/_assets/css/design-tokens.css<?php echo $themeParam; ?>" as="style" />
  <link rel="preload" href="/_assets/css/utilities.css<?php echo $themeParam; ?>" as="style" />
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize/modern-normalize.css" />
  <link rel="stylesheet" href="/_assets/css/design-tokens.css<?php echo $themeParam; ?>" />
  <link rel="stylesheet" href="/_assets/css/utilities.css<?php echo $themeParam; ?>" />
  
  <!-- Google Analytics (gtag) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-MCDXHQQLYL"></script>
  <script src="/_assets/js/utilities.js" defer></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());
    gtag("config", "G-MCDXHQQLYL");
  </script>
  
  <!-- テーマ切り替え: 本番では無効化（必要時のみコメント解除） -->
  <!-- <script src="/_assets/js/static-theme-init.php"></script> -->
