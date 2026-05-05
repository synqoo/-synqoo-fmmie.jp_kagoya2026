/**
 * テーマ切り替えシステム
 * サイト全体のカラーテーマを動的に変更
 */
(function() {
  'use strict';

  // テーマ定義
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

  /**
   * テーマを変更する関数
   * @param {string} themeName - テーマ名（orange, blue, green, purple, pink, teal）
   */
  function changeTheme(themeName) {
    const root = document.documentElement;
    
    // CSSで定義されたテーマ（orange, blue, purple）は data-theme 属性で切り替え
    const cssThemes = ['orange', 'blue', 'purple'];
    if (cssThemes.includes(themeName)) {
      root.setAttribute('data-theme', themeName);
      // SVG背景の色も更新（SVGが存在する場合）
      const triStop1 = document.getElementById('triStop1');
      const triStop2 = document.getElementById('triStop2');
      const triStop3 = document.getElementById('triStop3');
      const bgStop1 = document.getElementById('bgStop1');
      const bgStop2 = document.getElementById('bgStop2');
      const bgStop3 = document.getElementById('bgStop3');
      
      // CSSで定義されたテーマの色を取得（必要に応じて）
      // ここでは SVG の更新のみ行う
      if (triStop1) triStop1.style.stopColor = '';
      if (triStop2) triStop2.style.stopColor = '';
      if (triStop3) triStop3.style.stopColor = '';
      if (bgStop1) bgStop1.style.stopColor = '';
      if (bgStop2) bgStop2.style.stopColor = '';
      if (bgStop3) bgStop3.style.stopColor = '';
    } else if (themes[themeName]) {
      // JavaScriptで定義されたテーマ（green, pink, teal）は従来通りCSS変数を直接設定
      const theme = themes[themeName];
      
      // data-theme 属性を削除（CSSテーマを無効化）
      root.removeAttribute('data-theme');
      
      // CSS変数を更新（サイト全体に反映）
      root.style.setProperty('--primary-light', theme.primary[0]);
      root.style.setProperty('--primary-main', theme.primary[1]);
      root.style.setProperty('--primary-dark', theme.primary[2]);
      root.style.setProperty('--secondary-light', theme.secondary[0]);
      root.style.setProperty('--secondary-main', theme.secondary[1]);
      root.style.setProperty('--secondary-dark', theme.secondary[2]);
      
      // SVG背景の色も更新（SVGが存在する場合）
      const triStop1 = document.getElementById('triStop1');
      const triStop2 = document.getElementById('triStop2');
      const triStop3 = document.getElementById('triStop3');
      const bgStop1 = document.getElementById('bgStop1');
      const bgStop2 = document.getElementById('bgStop2');
      const bgStop3 = document.getElementById('bgStop3');
      
      if (triStop1) triStop1.style.stopColor = theme.primary[0];
      if (triStop2) triStop2.style.stopColor = theme.primary[1];
      if (triStop3) triStop3.style.stopColor = theme.primary[2];
      if (bgStop1) bgStop1.style.stopColor = theme.secondary[0];
      if (bgStop2) bgStop2.style.stopColor = theme.secondary[1];
      if (bgStop3) bgStop3.style.stopColor = theme.secondary[2];
    } else {
      console.warn('Unknown theme:', themeName);
      return;
    }
    
    // アクティブボタンの更新
    document.querySelectorAll('.theme-btn').forEach(btn => {
      btn.classList.remove('active');
      if (btn.classList.contains('theme-' + themeName)) {
        btn.classList.add('active');
      }
    });
    
    // ローカルストレージに保存（オプション）
    try {
      localStorage.setItem('site-theme', themeName);
    } catch (e) {
      console.warn('localStorage is not available');
    }
  }

  /**
   * 初期化
   */
  function init() {
    // ローカルストレージから保存されたテーマを読み込む
    let savedTheme = 'orange';
    try {
      savedTheme = localStorage.getItem('site-theme') || 'orange';
    } catch (e) {
      // localStorageが使用できない場合はデフォルトを使用
    }
    
    // 初期テーマを適用
    changeTheme(savedTheme);
    
    // テーマボタンにイベントリスナーを追加
    document.querySelectorAll('.theme-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        const themeName = this.getAttribute('data-theme') || 
                         this.classList.value.match(/theme-(\w+)/)?.[1];
        if (themeName) {
          changeTheme(themeName);
        }
      });
    });
  }

  // DOMContentLoadedを待つ
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // グローバルに公開（必要に応じて）
  window.changeTheme = changeTheme;
})();

