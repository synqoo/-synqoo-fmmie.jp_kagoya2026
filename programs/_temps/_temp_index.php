<$mt:Var name="entries_per_page" value="3"$>
<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="<$mt:BlogLanguage$>" itemscope itemtype="http://schema.org/Blog">
  <head>
    <title><$mt:BlogName encode_html="1"$> - レディオキューブFM三重</title>
    <mt:If tag="BlogDescription">
      <meta name="description" content="<$mt:BlogDescription remove_html="1" encode_html="1"$>" />
    </mt:If>
    <link rel="canonical" href="<$mt:BlogURL encode_html="1"$>" />
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <$mt:Include module="HTMLヘッダー"$>
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
    
    <!-- メイン -->
    <main class="section">
      <div class="index-container stack">
        <section class="stack">
          
        <$mt:Include module="バナーヘッダー"$>
          
          <!-- ブログエントリー -->
          <div class="entry-card stack">
            <div id="index-main" class="main" role="main">
              <mt:Entries limit="$entries_per_page" search_results="1">
                <article class="card stack stack-sm card-color-nomargin">
                  <h2 class="entry-title"><a href="<$mt:EntryPermalink encode_html="1"$>"><$mt:EntryTitle encode_html="1"$></a></h2>
                  <mt:If tag="EntryDate">
                    <p class="text-muted">
                      <time datetime="<$mt:EntryDate format="%Y-%m-%dT%H:%M:%S"$>"><$mt:EntryDate format="%Y年%m月%d日"$></time>
                    </p>
                  </mt:If>
                  <mt:If tag="EntryExcerpt">
                    <div class="entry-excerpt">
                      <$mt:EntryExcerpt encode_html="1"$>
                    </div>
                  </mt:If>
                  <div class="cluster">
                    <a href="<$mt:EntryPermalink encode_html="1"$>" class="btn btn-primary">続きを読む</a>
                  </div>
                </article>
              </mt:Entries>
              
              <!-- ページネーション -->
              <mt:If tag="IfPreviousResults">
                <div class="cluster">
                  <a href="<$mt:PreviousLink$>" class="btn btn-outline">前のページ</a>
                </div>
              </mt:If>
              <mt:If tag="IfNextResults">
                <div class="cluster">
                  <a href="<$mt:NextLink$>" class="btn btn-outline">次のページ</a>
                </div>
              </mt:If>
            </div>
          </div>
          
        </section>
      </div>
    </main>
    
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    
  </body>
</html>
