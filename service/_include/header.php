
    <meta charset="UTF-8">
    <title>みえツナゲール - 人と人をつなぐイベントサービス</title>
  <!-- レスポンシブ -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="format-detection" content="telephone=no" />
  <!-- 説明文 -->
  <meta name="description" content="" />
  <meta name="color-scheme" content="light"> 

  <!-- OGP（必要に応じて編集） -->
  <meta property="og:title" content="">
  <meta property="og:description" content="">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta name="twitter:card" content="summary_large_image">

  <!-- PWA: Web App 対応 -->
  <link rel="manifest" href="/manifest.webmanifest" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <meta name="apple-mobile-web-app-title" content="My App" />
  <meta name="theme-color" content="#ffffff" />

  <!-- アイコン類（実ファイルは後で設置） -->
  <link rel="icon" href="/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="/icons/icon-180.png" />

  <!-- Google Fonts：日本語でよく使われる3種 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Noto Sans JP（UI向け、読みやすい） -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet" />
  <!-- Noto Serif JP（文章・見出し用） -->
  <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;600;700&display=swap" rel="stylesheet" /> -->
  <!-- Roboto Flex（欧文UI） -->
  <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,300;8..144,500;8..144,700&display=swap" rel="stylesheet" /> -->
  <!-- Oswald Regular -->
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
  <!-- 必要時のみStardos Stencil -->
  <link href="https://fonts.googleapis.com/css2?family=Stardos+Stencil:wght@400;700&display=swap" rel="stylesheet">
  <!-- 必要時のみ小杉丸廻想体（Webフォント：Fontopo提供）-->
  <link href="https://fontopo.com/webfont/kaiso.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

  <!-- ベースCSS -->
  <!-- <link rel="stylesheet" href="_include/css/_blank.css" />  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize/modern-normalize.css" />
  <link rel="stylesheet" href="/service/_include/css/design-tokens.css" />
  <link rel="stylesheet" href="/service/_include/css/utilities.css" />
  <link rel="stylesheet" href="/service/_include/css/base.css" />
  <link rel="stylesheet" href="/service/tsunagale/css/styles.css" />
  <script src="https://kit.fontawesome.com/61528c36c0.js" crossorigin="anonymous"></script>
  <!-- Google Analytics (gtag) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());
    gtag("config", "GA_MEASUREMENT_ID");
  </script>

  <script>
  // 年だけ自動更新（既存）
  document.getElementById("year").textContent =
    new Date().getFullYear();

  // PWA: Service Worker 登録
  if ("serviceWorker" in navigator) {
    window.addEventListener("load", function () {
      navigator.serviceWorker
        .register("_include/js/sw.js")
        .then(function (registration) {
          console.log("ServiceWorker registration successful with scope: ", registration.scope);
        })
        .catch(function (error) {
          console.log("ServiceWorker registration failed: ", error);
        });
    });
  }
</script>
<style>
  /* このページだけはダークモードを無効化してライトのトークンを固定 */
  html.no-dark {
    color-scheme: light;
  }

  @media (prefers-color-scheme: dark) {
    html.no-dark {
      color-scheme: light;
      --color-bg: #f2f2f0;
      --color-bg-elevated: #f5f5f7;
      --color-fg: #111111;
      --color-muted: #6b7280;
      --color-border: #e5e7eb;
      --color-accent: #4E7AFF;
      --color-accent-soft: rgba(37, 99, 235, 0.12);
      --color-danger: #E23C39;
      --shadow-soft: 0 18px 40px rgba(15, 23, 42, 0.08);
      background: #fff;
      color: #111111;
    }

    html.no-dark body {
      background: var(--color-bg);
      color: var(--color-fg);
    }
  }
</style>
