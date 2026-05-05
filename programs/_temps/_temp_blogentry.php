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
          
          <!-- ブログエントリー -->
          <article id="entry-<$mt:EntryID$>" class="entry-card stack" itemscope itemtype="http://schema.org/Article">
            <header class="entry-header">
              <h2 itemprop="name" class="entry-title"><$mt:EntryTitle encode_html="1"$></h2>
              
              <footer class="entry-meta">
                <ul class="cluster" style="list-style: none; padding: 0; margin: 0;">
                  <mt:If tag="EntryDate">
                    <li>
                      <time datetime="<$mt:EntryDate format="%Y-%m-%dT%H:%M:%S"$>" itemprop="datePublished" class="text-muted">
                        <$mt:EntryDate format="%Y年%m月%d日"$>
                      </time>
                    </li>
                  </mt:If>
                  
                  <mt:IfArchiveTypeEnabled archive_type="Category">
                    <mt:If tag="EntryPrimaryCategory">
                      <li class="text-muted">
                        カテゴリ: <mt:EntryPrimaryCategory>
                          <a itemprop="articleSection" rel="tag" href="<$mt:CategoryArchiveLink$>"><$mt:CategoryLabel encode_html="1"$></a>
                        </mt:EntryPrimaryCategory>
                      </li>
                    </mt:If>
                  </mt:IfArchiveTypeEnabled>
                </ul>
              </footer>
            </header>
            
            <div class="entry-content" itemprop="articleBody">
              <$mt:EntryBody$>
              <$mt:EntryMore$>
              <$mt:Include module="SNS"$>
            </div>
            
          </article>
        </section>
      </div>
    </main>
    
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    
  </body>
</html>
