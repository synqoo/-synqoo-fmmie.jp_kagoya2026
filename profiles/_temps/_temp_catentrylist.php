<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="<$mt:BlogLanguage$>" itemscope itemtype="http://schema.org/Article">
  <head>
    <title><$mt:ArchiveTitle$>アーカイブ - <$mt:BlogName encode_html="1"$></title>
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
         
          <article class="card stack card-color">
          <!-- ブログエントリー -->
        <mt:Entries>
  <mt:EntriesHeader>
        
              <header class="entry-header">
                <h1 itemprop="name" class="entry-title"><$mt:ArchiveTitle$></h1>
              </header>
        <div class="entry-content" itemprop="articleBody">
                <ul class="posts-list">
  </mt:EntriesHeader>
                  <li class="posts-list-item">
                    <time datetime="<$mt:EntryDate format_name="iso8601"$>"><$mt:EntryDate format="%Y年%m月%d日"$></time>
                    <a href="<$mt:EntryPermalink encode_html="1"$>"><$mt:EntryTitle$></a>
                  </li>
  <mt:EntriesFooter>
                </ul>
              </div>
  </mt:EntriesFooter>
</mt:Entries>
        

            
          </article>
        </section>
      </div>
    </main>
    
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    
  </body>
</html>
