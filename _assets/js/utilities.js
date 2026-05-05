
// トップへ戻るボタンの表示制御
(function() {
  function initToTop() {
    const toTopBtn = document.getElementById('to-top');
    if (!toTopBtn) {
      console.warn('to-top button not found');
      return;
    }
    
    const globalNavHome = document.getElementById('global-nav-home');
    
    function toggleButton() {
      const scrollY = window.pageYOffset || window.scrollY || document.documentElement.scrollTop;
      if (scrollY > 300) {
        toTopBtn.classList.add('visible');
        if (globalNavHome) {
          globalNavHome.classList.add('visible');
        }
      } else {
        toTopBtn.classList.remove('visible');
        if (globalNavHome) {
          globalNavHome.classList.remove('visible');
        }
      }
    }
    
    // スクロール時にチェック
    window.addEventListener('scroll', toggleButton, { passive: true });
    
    // 初期状態をチェック
    toggleButton();
    
    // クリック時の処理
    toTopBtn.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
  
  // DOMContentLoadedで実行
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initToTop);
  } else {
    initToTop();
  }
})();

// 個人情報同意チェックボックスの表示制御
(function() {
  'use strict';
  const CONSENT_KEY = 'privacy_consent_accepted';
  
  function initPrivacyConsent() {
    const consentField = document.getElementById('privacy-consent-field');
    const consentCheckbox = document.getElementById('privacy_consent');
    const consentHidden = document.getElementById('privacy_consent_hidden');
    
    // 要素が存在しない場合は処理をスキップ
    if (!consentField && !consentCheckbox && !consentHidden) {
      return;
    }
    
    // 既に同意済みかチェック
    if (localStorage.getItem(CONSENT_KEY) === 'true') {
      // 同意済みの場合はチェックボックスを非表示
      if (consentField) {
        // consentField.style.display = 'none';
      }
      // required属性を削除してフォーム送信エラーを防ぐ
      if (consentCheckbox) {
        consentCheckbox.removeAttribute('required');
        consentCheckbox.checked = true; // チェック状態にする
      }
      // hidden inputで同意済みであることを送信
      if (consentHidden) {
        consentHidden.value = '1';
      }
    } else {
      // 未同意の場合はhidden inputを削除
      if (consentHidden) {
        consentHidden.remove();
      }
      
      // チェックボックスがチェックされたらlocalStorageに保存
      if (consentCheckbox) {
        consentCheckbox.addEventListener('change', function() {
          if (this.checked) {
            localStorage.setItem(CONSENT_KEY, 'true');
          }
        });
      }
    }
  }
  
  // DOMContentLoadedで実行
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPrivacyConsent);
  } else {
    initPrivacyConsent();
  }
})();

// Oswaldの読み込み完了までglobal-navを一瞬非表示にして、フォントスワップちらつきを防ぐ
(function() {
  'use strict';
  const root = document.documentElement;
  const ready = () => root.classList.add('fonts-oswald-ready');

  // Font Loading APIが無ければ即表示
  if (!document.fonts || typeof document.fonts.load !== 'function') {
    ready();
    return;
  }

  const timeoutMs = 1200;
  const timeout = new Promise((resolve) => setTimeout(resolve, timeoutMs));

  Promise.race([
    document.fonts.load('500 16px \"Oswald\"'),
    timeout,
  ]).then(ready).catch(ready);
})();

// PWA: Service Worker registration
(function() {
  'use strict';
  if (!('serviceWorker' in navigator)) return;
  // Avoid SW on file:// and keep behavior predictable
  if (location.protocol !== 'https:' && location.hostname !== 'localhost') return;

  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/_assets/js/pwa-sw.js').catch(function() {
      // Registration failed; PWA features will be unavailable.
    });
  });
})();