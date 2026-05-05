<!-- ウェルカムカード -->
          <div class="program_card">
            <div class="program_container">
              <div class="head_pb">
                <div class="pg_head">
                  <h1>
                    <a href="https://fmmie.jp/programs/FlidayNightFever/">
                      
                      <img alt="eスポ フライデーナイトフィーバー" src="https://fmmie.jp/programs/FlidayNightFever/assets_c/2026/02/main-thumb-640x400-1078.jpg">
                      
                    </a>
                  </h1>
                </div>
                <div class="pg_side stack">
                  <div class="pg_side_top">
                    <div class="personality-item">
                      <img src="/personalities/profile_photos/kiyotanozomi_sq.jpg" alt="清田のぞみ" class="personality-thumbnail">
                      <div class="personality-name">
                        <a href="/personalities/announcer/kiyotaNozomi.php">清田のぞみ</a>
                      </div>
                    </div>
                    <!--<div class="personality-item">
                      <img src="/personalities/profile_photos/mikatamiho3.jpg" alt="目加田 美桜" class="personality-thumbnail">
                      <div class="personality-name">
                        <a href="/personalities/mekatamio.php">あののぶたに★延谷卓哉(三重県ｅスポーツ連合)</a>
                      </div>
                    </div>
                  <div class="personality-item">
                      <img src="/personalities/profile_photos/mikatamiho3.jpg" alt="目加田 美桜" class="personality-thumbnail">
                      <div class="personality-name">
                        <a href="/personalities/mekatamio.php">るくぷる★野呂京志(三重県ｅスポーツ連合)</a>
                      </div>
                    </div>-->
                  </div>

                  <div class="pg_side_bottom"> <p class="data2">
                  毎週金曜日21:00~21:30<br />
                    <?php
                    // ラジコタイムフリーリンクを取得 / 金曜日(5) 10:00(1000)
                    $radiko_week = array(5);
                    $radiko_time = array(2100);
                    radiko_timefree($radiko_week, $radiko_time);
                    ?>
                  </p>
                    <a href="https://fmmie.jp/programs/FlidayNightFever/message.php" class="nowonair-link message-button">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="5" width="18" height="14" rx="2" fill="currentColor" fill-opacity="0.5"></rect>
                        <path d="M21 7L12 13L3 7M3 5H21C22.1 5 23 5.9 23 7V19C23 20.1 22.1 21 21 21H3C1.9 21 1 20.1 1 19V7C1 5.9 1.9 5 3 5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg> メッセージを送る
                    </a>
                  </div>
                </div>
              </div>
              <div class="pg_description">
                
                  <p><i class="fa fa-microphone" aria-hidden="true"></i> ゲーム情報はもちろん、ｅスポーツの大会情報まで詰まった盛りだくさんの内容でお届けします。
eスポーツってなんなの？な人から、ゲーマーと呼ばれる人までフィーバーしちゃう30分！
フライデーナイトフィーバー！！</p>
                
              </div>
            </div>
          </div>