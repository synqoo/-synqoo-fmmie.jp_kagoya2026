<!--Include module="HTMLヘッダー -->
<!-- Open Graph Protocol -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="<$mt:BlogLanguage setvar="blog_lang"$><mt:If name="blog_lang" eq="ja">ja_JP<mt:else><$mt:Var name="blog_lang"$></mt:If>">
    <meta property="og:title" content="<$mt:BlogName encode_html="1"$>">
    <meta property="og:url" content="<$mt:BlogURL encode_html="1"$>">
    <mt:If tag="BlogDescription"><meta property="og:description" content="<$mt:BlogDescription remove_html="1" encode_html="1"$>"></mt:If>
    <meta property="og:site_name" content="<$mt:BlogName encode_html="1"$>">
    <meta property="og:image" content="<mt:Assets type="image" tag="@SITE_ICON" limit="1"><$mt:AssetThumbnailURL width="320px" square="1" encode_html="1"$><mt:Else><$mt:SupportDirectoryURL encode_html="1"$>theme_static/<$mt:BlogThemeID$>/img/siteicon-sample.png</mt:Assets>">
    <!-- Microdata -->
    <mt:If tag="BlogDescription"><meta itemprop="description" content="<$mt:BlogDescription remove_html="1" encede_html="1"$>"></mt:If>
    <meta itemprop="name" content="<$mt:BlogName encode_html="1"$>">

   <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
   <link rel="stylesheet" href="<$mt:Link template="styles" encode_html="1"$><?php echo $themeParam ?? ''; ?>" />