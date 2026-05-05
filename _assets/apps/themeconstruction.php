<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>テーマカラー構築ツール - Theme Construction Tool</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
  <link rel="stylesheet" href="/_assets/css/theme-switcher.css" />
  <script src="/_assets/js/theme-switcher.js" defer></script>
  
  <style>
    body {
      background: var(--color-bg);
      /* padding: var(--space-lg); */
    }
    
    .tool-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: var(--space-lg);
    }
    
    .tool-header {
      margin-bottom: var(--space-xl);
      text-align: center;
    }
    
    .tool-header h1 {
      font-size: var(--font-size-h1);
      margin-bottom: var(--space-sm);
    }
    
    .tool-header p {
      color: var(--color-muted);
      font-size: var(--font-size-base);
    }
    
    .color-picker-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: var(--space-lg);
      margin-bottom: var(--space-xl);
    }
    
    .color-group {
      background: var(--color-bg-elevated);
      border: 1px solid var(--color-border);
      border-radius: var(--radius-lg);
      padding: var(--space-lg);
      box-shadow: var(--shadow-soft);
    }
    
    .color-group h2 {
      font-size: var(--font-size-h2);
      margin-bottom: var(--space-md);
      color: var(--color-fg);
    }
    
    .color-item {
      margin-bottom: var(--space-md);
    }
    
    .color-item label {
      display: block;
      font-weight: 600;
      margin-bottom: var(--space-xs);
      color: var(--color-fg);
      font-size: var(--font-size-base);
    }
    
    .color-picker-wrapper {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
    }
    
    .color-picker {
      width: 60px;
      height: 60px;
      border: 2px solid var(--color-border);
      border-radius: var(--radius-md);
      cursor: pointer;
      transition: transform 0.2s;
    }
    
    .color-picker:hover {
      transform: scale(1.05);
    }
    
    input[type="color"] {
      width: 60px;
      height: 60px;
      border: 2px solid var(--color-border);
      border-radius: var(--radius-md);
      cursor: pointer;
      padding: 0;
    }
    
    /* Webkit系ブラウザ（Chrome, Safari, Edge） */
    input[type="color"]::-webkit-color-swatch-wrapper {
      padding: 0;
    }
    
    input[type="color"]::-webkit-color-swatch {
      border: none;
      border-radius: var(--radius-md);
    }
    
    .color-value {
      flex: 1;
      font-family: var(--font-mono);
      font-size: 0.875rem;
      padding: var(--space-sm);
      background: var(--color-bg);
      border: 1px solid var(--color-border);
      border-radius: var(--radius-sm);
      color: var(--color-fg);
    }
    
    .code-output {
      background: var(--color-bg-elevated);
      border: 1px solid var(--color-border);
      border-radius: var(--radius-lg);
      padding: var(--space-lg);
      margin-bottom: var(--space-lg);
      box-shadow: var(--shadow-soft);
    }
    
    .code-output h3 {
      font-size: var(--font-size-h3);
      margin-bottom: var(--space-md);
      color: var(--color-fg);
    }
    
    .code-block {
      background: #1e1e1e;
      color: #d4d4d4;
      padding: var(--space-md);
      border-radius: var(--radius-md);
      font-family: var(--font-mono);
      font-size: 0.875rem;
      line-height: 1.6;
      overflow-x: auto;
      margin-bottom: var(--space-sm);
    }
    
    .copy-button {
      background: var(--primary-main, var(--color-accent));
      color: #fff;
      border: none;
      padding: var(--space-sm) var(--space-md);
      border-radius: var(--radius-md);
      cursor: pointer;
      font-weight: 600;
      transition: background-color var(--transition-fast);
      margin-top: var(--space-xs);
    }
    
    .copy-button:hover {
      background: var(--primary-dark, var(--color-accent));
    }
    
    .preview-section {
      background: var(--color-bg-elevated);
      border: 1px solid var(--color-border);
      border-radius: var(--radius-lg);
      padding: var(--space-lg);
      box-shadow: var(--shadow-soft);
    }
    
    .preview-section h3 {
      font-size: var(--font-size-h3);
      margin-bottom: var(--space-md);
      color: var(--color-fg);
    }
    
    .preview-components {
      display: grid;
      gap: var(--space-md);
    }
    
    .preview-button {
      display: inline-block;
      padding: var(--space-sm) var(--space-md);
      border-radius: var(--radius-md);
      text-decoration: none;
      font-weight: 600;
      transition: all var(--transition-fast);
    }
    
    .preview-button-primary {
      background: var(--primary-main, var(--color-accent));
      color: #fff;
    }
    
    .preview-button-primary:hover {
      background: var(--primary-dark, var(--color-accent));
    }
    
    .preview-link {
      color: var(--primary-dark, var(--color-accent));
      text-decoration: underline;
    }
    
    .preview-link:hover {
      color: var(--primary-main, var(--color-accent));
    }
    
    .preview-card {
      background: var(--color-bg-elevated);
      border: 1px solid var(--color-border);
      border-radius: var(--radius-md);
      padding: var(--space-md);
    }
    
    .preview-card-accent {
      background: var(--primary-main, var(--color-accent));
      color: #fff;
    }
    
    @media (min-width: 768px) {
      .color-picker-section {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  </style>
</head>
<body>
  <svg class="background-svg" viewBox="0 0 1400 800" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="triangleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" id="triStop1" />
      <stop offset="40%" id="triStop2" />
      <stop offset="100%" id="triStop3" />
    </linearGradient>
    
    <linearGradient id="bgGradient" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" id="bgStop1" />
      <stop offset="50%" id="bgStop2" />
      <stop offset="100%" id="bgStop3" />
    </linearGradient>
  </defs>
  
  <rect width="1400" height="800" fill="url(#bgGradient)"/>
  <polygon points="0,100 0,750 1350,750" fill="url(#triangleGradient)"/>
</svg>
  <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
  
  <div class="tool-container">
    <div class="tool-header">
      <h1>🎨 テーマカラー構築ツール</h1>
      <p>6色のカラーパレットを選択して、CSS変数とJavaScript定義コードを生成します</p>
      
      <div style="margin-top: var(--space-md); max-width: 400px; margin-left: auto; margin-right: auto;">
        <label for="theme-name" style="display: block; font-weight: 600; margin-bottom: var(--space-xs);">テーマ名（英語）:</label>
        <input type="text" id="theme-name" value="themename" 
               style="width: 100%; padding: var(--space-sm); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: var(--font-size-base);"
               placeholder="例: orange, blue, green" />
        <p style="font-size: 0.875rem; color: var(--color-muted); margin-top: var(--space-xs);">テーマ名は英語で入力してください（小文字推奨）</p>
      </div>
    </div>
    
    <div class="color-picker-section">
      <!-- Primaryカラー -->
      <div class="color-group">
        <h2>Primaryカラー</h2>
        
        <div class="color-item">
          <label for="primary-light">Primary Light（明るい色）</label>
          <div class="color-picker-wrapper">
            <input type="color" id="primary-light" value="#FFB366" />
            <input type="text" class="color-value" id="primary-light-value" value="#FFB366" readonly />
          </div>
        </div>
        
        <div class="color-item">
          <label for="primary-main">Primary Main（メインカラー）</label>
          <div class="color-picker-wrapper">
            <input type="color" id="primary-main" value="#FFA347" />
            <input type="text" class="color-value" id="primary-main-value" value="#FFA347" readonly />
          </div>
        </div>
        
        <div class="color-item">
          <label for="primary-dark">Primary Dark（濃い色）</label>
          <div class="color-picker-wrapper">
            <input type="color" id="primary-dark" value="#FF8C42" />
            <input type="text" class="color-value" id="primary-dark-value" value="#FF8C42" readonly />
          </div>
        </div>
      </div>
      
      <!-- Secondaryカラー -->
      <div class="color-group">
        <h2>Secondaryカラー</h2>
        
        <div class="color-item">
          <label for="secondary-light">Secondary Light（明るい色）</label>
          <div class="color-picker-wrapper">
            <input type="color" id="secondary-light" value="#FF7B7B" />
            <input type="text" class="color-value" id="secondary-light-value" value="#FF7B7B" readonly />
          </div>
        </div>
        
        <div class="color-item">
          <label for="secondary-main">Secondary Main（メインカラー）</label>
          <div class="color-picker-wrapper">
            <input type="color" id="secondary-main" value="#FF6B6B" />
            <input type="text" class="color-value" id="secondary-main-value" value="#FF6B6B" readonly />
          </div>
        </div>
        
        <div class="color-item">
          <label for="secondary-dark">Secondary Dark（濃い色）</label>
          <div class="color-picker-wrapper">
            <input type="color" id="secondary-dark" value="#FF5C5C" />
            <input type="text" class="color-value" id="secondary-dark-value" value="#FF5C5C" readonly />
          </div>
        </div>
      </div>
    </div>
    
    <!-- プレビューセクション -->
    <div class="preview-section">
      <h3>👁️ プレビュー</h3>
      <div class="preview-components">
        <div>
          <button class="preview-button preview-button-primary">Primary Button</button>
        </div>
        <div>
          <a href="#" class="preview-link">リンクテキストのサンプル</a>
        </div>
        <div class="preview-card">
          <h4 style="margin: 0 0 var(--space-xs) 0;">通常のカード</h4>
          <p style="margin: 0; color: var(--color-muted);">カードコンテンツのサンプル</p>
        </div>
        <div class="preview-card preview-card-accent">
          <h4 style="margin: 0 0 var(--space-xs) 0; color: #fff;">アクセントカード</h4>
          <p style="margin: 0; color: rgba(255, 255, 255, 0.9);">Primaryカラーを使用したカード</p>
        </div>
      </div>
    </div>
    
    <!-- コード出力セクション -->
    <div class="code-output">
      <h3>📋 生成されたコード</h3>
      
      <div>
        <h4 style="font-size: var(--font-size-h4); margin-bottom: var(--space-sm);">CSS変数（:root用）</h4>
        <div class="code-block" id="css-output">
          /* テーマ切り替えシステム用変数 */
          --primary-light: #FFB366;
          --primary-main: #FFA347;
          --primary-dark: #FF8C42;
          --secondary-light: #FF7B7B;
          --secondary-main: #FF6B6B;
          --secondary-dark: #FF5C5C;
        </div>
        <button class="copy-button" onclick="copyToClipboard('css-output')">CSSコードをコピー</button>
      </div>
      
      <div style="margin-top: var(--space-lg);">
        <h4 style="font-size: var(--font-size-h4); margin-bottom: var(--space-sm);">JavaScript定義（theme-switcher.js用）</h4>
        <div class="code-block" id="js-output">
          themename: {
            primary: ['#FFB366', '#FFA347', '#FF8C42'],
            secondary: ['#FF7B7B', '#FF6B6B', '#FF5C5C']
          },
        </div>
        <button class="copy-button" onclick="copyToClipboard('js-output')">JavaScriptコードをコピー</button>
      </div>
      
      <div style="margin-top: var(--space-lg);">
        <h4 style="font-size: var(--font-size-h4); margin-bottom: var(--space-sm);">テーマパネル用CSS（theme-switcher.css用）</h4>
        <div class="code-block" id="css-theme-output">
          .theme-themename { background: linear-gradient(135deg, #FFB366, #FF8C42); }
        </div>
        <button class="copy-button" onclick="copyToClipboard('css-theme-output')">テーマパネルCSSをコピー</button>
      </div>
      
      <div style="margin-top: var(--space-lg);">
        <h4 style="font-size: var(--font-size-h4); margin-bottom: var(--space-sm);">テーマパネル用HTML（_include_footer.php用）</h4>
        <div class="code-block" id="html-output">
          <div class="theme-btn theme-themename" data-theme="themename" title="Themename"></div>
        </div>
        <button class="copy-button" onclick="copyToClipboard('html-output')">HTMLコードをコピー</button>
      </div>
    </div>
  </div>
  
  <script>
    // カラーピッカーの値を取得
    function getColorValue(id) {
      const input = document.getElementById(id);
      return input.value.toUpperCase();
    }
    
    // すべての色を取得
    function getAllColors() {
      return {
        primaryLight: getColorValue('primary-light'),
        primaryMain: getColorValue('primary-main'),
        primaryDark: getColorValue('primary-dark'),
        secondaryLight: getColorValue('secondary-light'),
        secondaryMain: getColorValue('secondary-main'),
        secondaryDark: getColorValue('secondary-dark')
      };
    }
    
    // CSS変数コードを生成
    function generateCSSCode(colors) {
      return `/* テーマ切り替えシステム用変数 */
  --primary-light: ${colors.primaryLight};
  --primary-main: ${colors.primaryMain};
  --primary-dark: ${colors.primaryDark};
  --secondary-light: ${colors.secondaryLight};
  --secondary-main: ${colors.secondaryMain};
  --secondary-dark: ${colors.secondaryDark};`;
    }
    
    // JavaScript定義コードを生成
    function generateJSCode(colors, themeName = 'themename') {
      return `${themeName}: {
    primary: ['${colors.primaryLight}', '${colors.primaryMain}', '${colors.primaryDark}'],
    secondary: ['${colors.secondaryLight}', '${colors.secondaryMain}', '${colors.secondaryDark}']
  },`;
    }
    
    // テーマパネル用CSSコードを生成
    function generateThemePanelCSS(colors, themeName = 'themename') {
      return `.theme-${themeName} { background: linear-gradient(135deg, ${colors.primaryLight}, ${colors.primaryDark}); }`;
    }
    
    // テーマパネル用HTMLコードを生成
    function generateHTMLCode(themeName = 'themename', themeTitle = 'Themename') {
      return `<div class="theme-btn theme-${themeName}" data-theme="${themeName}" title="${themeTitle}"></div>`;
    }
    
    // コードを更新
    function updateCodes() {
      const colors = getAllColors();
      const themeName = document.getElementById('theme-name').value || 'themename';
      const themeTitle = themeName.charAt(0).toUpperCase() + themeName.slice(1);
      
      // CSS変数コード
      document.getElementById('css-output').textContent = generateCSSCode(colors);
      
      // JavaScript定義コード
      document.getElementById('js-output').textContent = generateJSCode(colors, themeName);
      
      // テーマパネル用CSS
      document.getElementById('css-theme-output').textContent = generateThemePanelCSS(colors, themeName);
      
      // テーマパネル用HTML
      document.getElementById('html-output').textContent = generateHTMLCode(themeName, themeTitle);
      
      // CSS変数を実際に適用（プレビュー用）
      const root = document.documentElement;
      root.style.setProperty('--primary-light', colors.primaryLight);
      root.style.setProperty('--primary-main', colors.primaryMain);
      root.style.setProperty('--primary-dark', colors.primaryDark);
      root.style.setProperty('--secondary-light', colors.secondaryLight);
      root.style.setProperty('--secondary-main', colors.secondaryMain);
      root.style.setProperty('--secondary-dark', colors.secondaryDark);
      root.style.setProperty('--color-accent', colors.primaryMain);
    }
    
    // カラーピッカーの変更を監視
    const colorInputs = [
      'primary-light', 'primary-main', 'primary-dark',
      'secondary-light', 'secondary-main', 'secondary-dark'
    ];
    
    colorInputs.forEach(id => {
      const input = document.getElementById(id);
      const valueInput = document.getElementById(id + '-value');
      
      input.addEventListener('input', function() {
        valueInput.value = this.value.toUpperCase();
        updateCodes();
      });
      
      // テキスト入力でも変更可能にする
      valueInput.addEventListener('input', function() {
        if (/^#[0-9A-F]{6}$/i.test(this.value)) {
          input.value = this.value;
          updateCodes();
        }
      });
    });
    
    // テーマ名の変更を監視
    document.getElementById('theme-name').addEventListener('input', function() {
      updateCodes();
    });
    
    // テーマ定義（theme-switcher.jsと同じ）
    const themes = {
      orange: {
        primary: ['#FFB366', '#FFA347', '#FF8C42'],
        secondary: ['#FF7B7B', '#FF6B6B', '#FF5C5C']
      },
      blue: {
        primary: ['#66B3FF', '#4785FF', '#4285FF'],
        secondary: ['#7B9BFF', '#6B8BFF', '#5C7BFF']
      },
      green: {
        primary: ['#66FFB3', '#47FFA3', '#42FF8C'],
        secondary: ['#7BFF9B', '#6BFF8B', '#5CFF7B']
      },
      purple: {
        primary: ['#B366FF', '#A347FF', '#8542FF'],
        secondary: ['#9B7BFF', '#8B6BFF', '#7B5CFF']
      },
      pink: {
        primary: ['#FF66B3', '#FF47A3', '#FF4285'],
        secondary: ['#FF7B9B', '#FF6B8B', '#FF5C7B']
      },
      teal: {
        primary: ['#66FFF0', '#47FFE8', '#42FFE0'],
        secondary: ['#7BFFF5', '#6BFFED', '#5CFFE5']
      }
    };
    
    // テーマ切り替え時にカラーピッカーを更新する関数
    function updateColorPickersFromTheme(themeName) {
      const theme = themes[themeName];
      if (!theme) return;
      
      // カラーピッカーの値を更新
      const primaryLightInput = document.getElementById('primary-light');
      const primaryMainInput = document.getElementById('primary-main');
      const primaryDarkInput = document.getElementById('primary-dark');
      const secondaryLightInput = document.getElementById('secondary-light');
      const secondaryMainInput = document.getElementById('secondary-main');
      const secondaryDarkInput = document.getElementById('secondary-dark');
      
      if (primaryLightInput) {
        primaryLightInput.value = theme.primary[0];
        document.getElementById('primary-light-value').value = theme.primary[0];
      }
      if (primaryMainInput) {
        primaryMainInput.value = theme.primary[1];
        document.getElementById('primary-main-value').value = theme.primary[1];
      }
      if (primaryDarkInput) {
        primaryDarkInput.value = theme.primary[2];
        document.getElementById('primary-dark-value').value = theme.primary[2];
      }
      
      if (secondaryLightInput) {
        secondaryLightInput.value = theme.secondary[0];
        document.getElementById('secondary-light-value').value = theme.secondary[0];
      }
      if (secondaryMainInput) {
        secondaryMainInput.value = theme.secondary[1];
        document.getElementById('secondary-main-value').value = theme.secondary[1];
      }
      if (secondaryDarkInput) {
        secondaryDarkInput.value = theme.secondary[2];
        document.getElementById('secondary-dark-value').value = theme.secondary[2];
      }
      
      // テーマ名も更新
      const themeNameInput = document.getElementById('theme-name');
      if (themeNameInput) {
        themeNameInput.value = themeName;
      }
      
      // コードを更新
      updateCodes();
    }
    
    // テーマ切り替えイベントを監視
    function watchThemeChange() {
      // テーマパネルのボタンに直接イベントリスナーを追加
      function attachThemeButtonListeners() {
        const themeButtons = document.querySelectorAll('.theme-btn');
        
        themeButtons.forEach(function(btn) {
          // 既にリスナーが追加されているかチェック
          if (btn.dataset.themeToolListener) return;
          btn.dataset.themeToolListener = 'true';
          
          btn.addEventListener('click', function(e) {
            const themeName = this.dataset.theme || 
                             this.classList.value.match(/theme-(\w+)/)?.[1];
            if (themeName) {
              // 即座にカラーピッカーを更新
              setTimeout(function() {
                updateColorPickersFromTheme(themeName);
              }, 50);
            }
          }, true); // capture phaseで実行
        });
      }
      
      // 初期実行
      attachThemeButtonListeners();
      
      // ボタンが動的に追加される可能性があるため、定期的にチェック
      const checkInterval = setInterval(function() {
        attachThemeButtonListeners();
      }, 500);
      
      // 5秒後にチェックを停止
      setTimeout(function() {
        clearInterval(checkInterval);
      }, 5000);
      
      // changeTheme関数をフック（theme-switcher.jsが読み込まれた後）
      function hookChangeTheme() {
        if (window.changeTheme && !window.changeTheme._themeToolHooked) {
          const originalChangeTheme = window.changeTheme;
          window.changeTheme = function(themeName) {
            const result = originalChangeTheme(themeName);
            // 少し遅延させて、theme-switcher.jsの処理が完了してから実行
            setTimeout(function() {
              updateColorPickersFromTheme(themeName);
            }, 100);
            return result;
          };
          window.changeTheme._themeToolHooked = true;
          return true;
        }
        return false;
      }
      
      // changeThemeが定義されるまで待つ
      let attempts = 0;
      const maxAttempts = 50; // 5秒間待つ
      const hookInterval = setInterval(function() {
        attempts++;
        if (hookChangeTheme() || attempts >= maxAttempts) {
          clearInterval(hookInterval);
        }
      }, 100);
    }
    
    // クリップボードにコピー
    function copyToClipboard(elementId) {
      const element = document.getElementById(elementId);
      const text = element.textContent;
      
      navigator.clipboard.writeText(text).then(() => {
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'コピーしました！';
        button.style.background = '#4ade80';
        
        setTimeout(() => {
          button.textContent = originalText;
          button.style.background = '';
        }, 2000);
      }).catch(err => {
        console.error('コピーに失敗しました:', err);
        alert('コピーに失敗しました。手動でコピーしてください。');
      });
    }
    
    // 初期化
    updateCodes();
    
    // ページ読み込み時に、現在のテーマを反映
    function initThemeTool() {
      const savedTheme = localStorage.getItem('site-theme') || 'orange';
      updateColorPickersFromTheme(savedTheme);
      watchThemeChange();
    }
    
    // window.loadを待つ（theme-switcher.jsがdeferで読み込まれるため）
    if (document.readyState === 'loading') {
      window.addEventListener('load', function() {
        setTimeout(initThemeTool, 100); // theme-switcher.jsの初期化を待つ
      });
    } else {
      // 既に読み込み済みの場合
      setTimeout(initThemeTool, 200);
    }
  </script>
  
  <?php require_once(INCLUDE_FOOTER_PATH); ?>
    <!-- テーマ切り替えパネル -->
    <div class="theme-panel">
    <h4>?? カラーテーマ</h4>
    <div class="theme-buttons">
      <div class="theme-btn theme-orange active" data-theme="orange" title="オレンジ"></div>
      <div class="theme-btn theme-blue" data-theme="blue" title="ブルー"></div>
      <div class="theme-btn theme-green" data-theme="green" title="グリーン"></div>
      <div class="theme-btn theme-purple" data-theme="purple" title="パープル"></div>
      <div class="theme-btn theme-pink" data-theme="pink" title="ピンク"></div>
      <div class="theme-btn theme-teal" data-theme="teal" title="ティール"></div>
    </div>
  </div>

</body>
</html>

