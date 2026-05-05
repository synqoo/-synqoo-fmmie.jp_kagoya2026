/**
 * NOW ON AIR Widget Auto Update
 * 5分ごとにNOW ON AIR情報を自動更新
 */
(function() {
  // 更新間隔（分単位、デフォルトは5分）
  const UPDATE_INTERVAL = 1 * 60 * 1000; // 5分 = 300000ms
  
  let updateTimer = null;
  let visibilityHandler = null;
  
  function updateNowOnAir() {
    const widget = document.getElementById('nowonair-widget');
    if (!widget) {
      console.warn('NOW ON AIR widget not found');
      return;
    }
    
    // 現在のページのURLから相対パスで取得
    const url = '/_assets/_include_nowonair.php?t=' + Date.now();
    
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
      })
      .then(html => {
        // レスポンスが空の場合はスキップ
        if (!html || html.trim() === '') {
          console.warn('NOW ON AIR: Empty response');
          return;
        }
        
        // 一時的なコンテナにHTMLを設定
        const temp = document.createElement('div');
        temp.innerHTML = html;
        
        const newWidget = temp.querySelector('#nowonair-widget');
        const newThumb  = temp.querySelector('.nowonair-thumb');
        if (newWidget) {
          // ウィジェットを差し替え
          widget.outerHTML = newWidget.outerHTML;
        } else {
          console.warn('NOW ON AIR widget not found in response. Response:', html.substring(0, 200));
        }

        // サムネイルも差し替え（index-header直下にあるため別途処理）
        if (newThumb) {
          const currentThumb = document.querySelector('.nowonair-thumb');
          if (currentThumb) {
            currentThumb.outerHTML = newThumb.outerHTML;
          }
        }

        // タイトルの長さに応じたクラス付与（再描画後に実行）
        adjustNowOnAirTitle();
      })
      .catch(error => {
        console.error('NOW ON AIR更新エラー:', error);
        // エラーが発生しても既存のウィジェットはそのまま表示
      });
  }
  
  function startAutoUpdate() {
    // 既にタイマーが動いている場合は停止
    if (updateTimer) {
      clearInterval(updateTimer);
    }
    // 初回は即座に実行しない（既に表示されているため）
    updateTimer = setInterval(updateNowOnAir, UPDATE_INTERVAL);
  }
  
  function stopAutoUpdate() {
    if (updateTimer) {
      clearInterval(updateTimer);
      updateTimer = null;
    }
  }
  
  function initAutoUpdate() {
    const widget = document.getElementById('nowonair-widget');
    if (!widget) {
      console.warn('NOW ON AIR widget not found on page load');
      return;
    }
    
    // visibilitychangeイベントリスナーを一度だけ登録
    if (!visibilityHandler) {
      visibilityHandler = function() {
        if (document.hidden) {
          stopAutoUpdate();
        } else {
          startAutoUpdate();
        }
      };
      document.addEventListener('visibilitychange', visibilityHandler);
    }
    
    // 初期化
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', startAutoUpdate);
    } else {
      startAutoUpdate();
    }

    // 初回にタイトル長を調整
    adjustNowOnAirTitle();
  }
  
  // 初期化実行
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAutoUpdate);
  } else {
    initAutoUpdate();
  }
})();

/**
 * NOW ON AIR タイトルの長さでクラスを付け替える
 */
function adjustNowOnAirTitle() {
  const titleEl = document.getElementById('nowonair-title');
  if (!titleEl) return;
  const text = (titleEl.textContent || '').trim();
  if (text.length >= 20) {
    titleEl.classList.add('nowonair-title-long');
  } else {
    titleEl.classList.remove('nowonair-title-long');
  }
}

/**
 * NOW ON AIR 説明ポップアップ機能
 */
(function() {
  'use strict';
  
  function initDescPopup() {
    const toggleBtn = document.getElementById('nowonair-desc-toggle');
    const popup = document.getElementById('nowonair-desc-popup');
    const closeBtn = popup ? popup.querySelector('.nowonair-desc-popup-close') : null;
    
    if (!toggleBtn || !popup) {
      return;
    }
    
    // トグルボタンのクリックイベント
    toggleBtn.addEventListener('click', function(e) {
      e.preventDefault();
      popup.classList.add('active');
    });
    
    // 閉じるボタンのクリックイベント
    if (closeBtn) {
      closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        popup.classList.remove('active');
      });
    }
    
    // ポップアップ外をクリックしたら閉じる
    popup.addEventListener('click', function(e) {
      if (e.target === popup) {
        popup.classList.remove('active');
      }
    });
    
    // ESCキーで閉じる
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && popup.classList.contains('active')) {
        popup.classList.remove('active');
      }
    });
  }
  
  // 初期化実行
  function init() {
    initDescPopup();
    
    // ウィジェットが動的に更新される可能性があるため、MutationObserverで監視
    const observer = new MutationObserver(function(mutations) {
      const toggleBtn = document.getElementById('nowonair-desc-toggle');
      if (toggleBtn) {
        initDescPopup();
        observer.disconnect();
      }
    });
    
    const widget = document.getElementById('nowonair-widget');
    if (widget) {
      observer.observe(widget, { childList: true, subtree: true });
      initDescPopup();
    }
  }
  
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
