<!--
  Topicsブログ 新着記事一覧（MT7 index template）
  カスタムフィールド: title_top, bottom_title, checkit_Thumb, checkitDATE, checkit, EntryDataSort
  カテゴリ色: mt-core.css（program, event, special, recording, news, campaign, sports, music）
  除外: カテゴリ「concert」（basename）のエントリは表示しない
-->
<div class="information-corner-grid topics-listing">
<mt:Entries sort_by="field:EntryDataSort" sort_order="ascend" lastn="20">
<mt:EntriesHeader>
</mt:EntriesHeader>
    <mt:IfCategory name="concert">
    <mt:Else>
    <a href="<$mt:EntryPermalink encode_html="1"$>" class="information-corner">
        <div class="information-corner__thumb">
            <mt:If tag="EntryDatacheckit_Thumb">
            <img src="<$mt:EntryDatacheckit_Thumb regex_replace='/^.*href="([^"]+)".*$/s','$1'$>" alt="<$mt:EntryTitle encode_html="1"$>">
            <mt:Else>
            <img src="/_assets/img/placeholder_<$mt:CategoryBasename$>.png" alt="<$mt:EntryTitle encode_html="1"$>">
            </mt:Else>
        </mt:If>
        </div>
        <div class="information-corner__body">
            <header class="information-corner-header">
                <mt:EntryPrimaryCategory>
                <span class="information-corner-label <$mt:CategoryBasename$>"><$mt:CategoryLabel encode_html="1"$></span>
                </mt:EntryPrimaryCategory>
                <h3 class="information-corner-title">
                    <mt:If tag="EntryDatatitle_top"><span class="topics_small"><$mt:EntryDatatitle_top$></span> </mt:If><$mt:EntryTitle$><mt:If tag="EntryDatabottom_title"> <span class="topics_small"><$mt:EntryDatabottom_title$></span></mt:If>
                </h3>
            </header>
            <mt:If tag="EntryDatacheckitDATE">
            <div class="information-corner-meta">
                <span class="information-corner-meta__item">
                    <span class="information-corner-meta__label"><i class="fa-solid fa-calendar-days"></i></span>
                    <span><$mt:EntryDatacheckitDATE encode_html="1"$></span>
                </span>
            </div>
            </mt:If>
            <mt:If tag="EntryDatacheckit">
            <p class="information-corner-desc">
                <$mt:EntryDatacheckit remove_html="1" encode_html="1"$>
            </p>
            </mt:If>
        </div>
    </a>
    </mt:Else>
    </mt:IfCategory>
<mt:EntriesFooter>
</mt:EntriesFooter>
</mt:Entries>
</div>
