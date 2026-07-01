<!-- ウェルカムカード -->
          <div class="program_card">
            <div class="program_container">
              <div class="head_pb">
                <div class="pg_head">
                  <h1>
                    <a href="https://fmmie.jp/programs/onthetest/">
                      
                      <img alt="OnTheTest" src="https://fmmie.jp/programs/onthetest/assets_c/2026/03/VRChat_2025-08-21_09-52-14.927_1920x1080-thumb-1920x1080-1175.png">
                      
                    </a>
                  </h1>
                </div>
                <div class="pg_side stack">
                  <div class="pg_side_top">
                    <div class="personality-item">
                      <img src="/program/talkbeyond/images/tb.jpg" alt="橋本やすしげ " class="personality-thumbnail">
                      <div class="personality-name">
                        橋本やすしげ 
                      </div>
                    </div>
                  </div>
                  <div class="pg_side_bottom"> <p class="data2">
                    <?php
                    // ラジコタイムフリーリンクを取得
                    // 金曜日(5) 10:00(1000)
                    $radiko_week = array(5);
                    $radiko_time = array(2130);
                    radiko_timefree($radiko_week, $radiko_time);
                    ?>
                  </p>
                    <a href="https://fmmie.jp/programs/onthetest/message.php" class="nowonair-link message-button">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="5" width="18" height="14" rx="2" fill="currentColor" fill-opacity="0.5"></rect>
                        <path d="M21 7L12 13L3 7M3 5H21C22.1 5 23 5.9 23 7V19C23 20.1 22.1 21 21 21H3C1.9 21 1 20.1 1 19V7C1 5.9 1.9 5 3 5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg> メッセージを送る
                    </a>
                  </div>
                </div>
              </div>
              <div class="pg_description">
                
                  <p><i class="fa fa-microphone" aria-hidden="true"></i> テスト用のテンプレートす</p>
                
              </div>
            </div>
          </div>