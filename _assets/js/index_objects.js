/**
 * トップページ用オブジェクトスクリプト
 * トップバナー横スクロール設定など
 */

// 年だけ自動更新（不要なら削除OK）
(function() {
  const yearEl = document.getElementById("year");
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }
})();

// トップバナー横スクロール設定（Swiper.js使用）
(function() {
  function initSwiper() {
    const swiperEl = document.querySelector('.topbannerz-swiper');
    if (!swiperEl) {
      console.warn('Swiper element not found');
      return;
    }
    
    // Swiperが読み込まれているか確認
    if (typeof Swiper === 'undefined') {
      console.error('Swiper.js is not loaded. Please check if swiper-bundle.min.js is loaded correctly.');
      return;
    }
    
    // Swiperを初期化（#03 基本カード型 03 を参考）
    try {
        const swiper = new Swiper('.topbannerz-swiper', {
          // 表示枚数（slidesPerView）が3の場合、
  // 全体の枚数がそれより多ければループを有効にする
  // loop: slidesCount > 3, 
  // slidesPerView: 3,
  
  // 枚数が足りない時にスライドを中央寄せにしたい場合
  // watchOverflow: true,

        // 自動再生（3秒間隔）
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        // ループ
        loop: true,
        // 【追加】要素の変化を監視して自動更新する
  observer: true, 
  observeParents: true,
        // スライドの横幅は可変
        slidesPerView: 'auto',
        
        centeredSlides: true,
        loopAdditionalSlides: 2,
        loopedSlides: 5,
        spaceBetween: 20,
        loopPreventsSliding: false,
        // スピード
        speed: 300,
        
        // ナビゲーションボタン
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        
        // ページネーション
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          type: 'bullets',
        },
        
        //レスポンシブ設定
        breakpoints: {
          320: {
            spaceBetween: 12,
          },
          768: {
            spaceBetween: 16,
          },
          1024: {
            spaceBetween: 20,
          },
        },

        
      });
      
      console.log('Swiper initialized successfully', swiper);
    } catch (error) {
      console.error('Error initializing Swiper:', error);
    }
  }
  
  // DOMContentLoadedを待つ
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSwiper);
  } else {
    initSwiper();
  }
})();

