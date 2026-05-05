<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="<$mt:BlogLanguage$>" itemscope itemtype="http://schema.org/Article">
  <head>
    <title><$mt:EntryTitle encode_html="1"$> - <$mt:BlogName encode_html="1"$></title>
    <mt:If tag="EntryExcerpt">
      <meta name="description" content="<$mt:EntryExcerpt remove_html="1" encode_html="1"$>" />
    </mt:If>
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
          <!-- パンくずリスト -->
          <!-- <nav aria-label="パンくずリスト" class="card card-color breadcrumb">
            <a href="<$mt:BlogURL encode_html="1"$>">ホーム</a>
            <span>/</span>
            <span><$mt:EntryTitle encode_html="1"$></span>
          </nav> -->
        
<article id="main_contents" class="card stack card-color" >
            <div id="datebased-main" class="main" role="main">
<mt:Entries>
  <mt:EntriesHeader>
              <section id="posts">
                <h2 class="asset-name entry-title"><$mt:ArchiveTitle$>アーカイブ</h2>
                <ul class="posts-list">
  </mt:EntriesHeader>
                  <li class="posts-list-item">
                    <time datetime="<$mt:EntryDate format_name="iso8601"$>"><$mt:EntryDate format="%x"$></time>
                    <a href="<$mt:EntryPermalink encode_html="1"$>"><$mt:EntryTitle$></a>
                  </li>
  <mt:EntriesFooter>
                </ul>
              </section>
  </mt:EntriesFooter>
</mt:Entries>
          </div>
</article>

        </section>
      </div>
    </main>
    
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    
  </body>
</html>
