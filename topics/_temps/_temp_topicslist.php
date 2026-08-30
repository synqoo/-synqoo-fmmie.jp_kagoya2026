<!--
  Topicsブログ 新着記事一覧（MT7 index template）
  第1ブロック: concert / event 以外を sortdate 降順（最大10件）
  第2ブロック: event カテゴリのみを sortdate 降順（最大10件・末尾に追加）
  除外: カテゴリ「concert」（basename）のエントリは表示しない
  ※ IfCategory の name/label は表示名で比較されるため、CategoryBasename で判定
-->
<div class="information-corner-grid topics-listing">
<mt:Entries sort_by="field:sortdate" sort_order="descend" lastn="50">
<mt:EntryPrimaryCategory><mt:SetVarBlock name="topics_cat_base"><$mt:CategoryBasename$></mt:SetVarBlock></mt:EntryPrimaryCategory>
<mt:If name="topics_cat_base" ne="event"><mt:If name="topics_cat_base" ne="concert"><mt:If name="topics_main_count" lt="10">
    <a href="<$mt:EntryPermalink encode_html="1"$>" class="information-corner">
        <div class="information-corner__thumb"><mt:If tag="EntryDatacheckit_Thumb">
            <img src="<$mt:EntryDatacheckit_Thumb regex_replace='/^.*href="([^"]+)".*$/s','$1'$>" alt="<$mt:EntryTitle encode_html="1"$>"><mt:Else><img src="/_assets/img/placeholder_<$mt:CategoryBasename$>.png" alt="<$mt:EntryTitle encode_html="1"$>"></mt:Else></mt:If>
        </div>
        <div class="information-corner__body">
            <header class="information-corner-header">
                <mt:EntryPrimaryCategory><span class="information-corner-label <$mt:CategoryBasename$>"><$mt:CategoryLabel encode_html="1"$></span></mt:EntryPrimaryCategory>
                <h3 class="information-corner-title">
                    <mt:If tag="EntryDatatitle_top"><span class="topics_small"><$mt:EntryDatatitle_top$></span> </mt:If><$mt:EntryTitle$><mt:If tag="EntryDatabottom_title"> <span class="topics_small"><$mt:EntryDatabottom_title$></span></mt:If>
                </h3>
            </header><mt:If tag="EntryDatacheckitDATE">
            <div class="information-corner-meta">
                <span class="information-corner-meta__item">
                    <span class="information-corner-meta__label"><i class="fa-solid fa-calendar-days"></i></span>
                    <span><$mt:EntryDatacheckitDATE encode_html="1"$></span>
                </span>
            </div></mt:If><mt:If tag="EntryDatacheckit">
            <p class="information-corner-desc"><$mt:EntryDatacheckit remove_html="1" encode_html="1"$></p></mt:If>
        </div>
    </a>
    <mt:SetVarBlock name="topics_main_count"><$mt:Var name="topics_main_count" default="0" op="+" value="1"$></mt:SetVarBlock>
</mt:If></mt:If></mt:If>
</mt:Entries>
<mt:Entries sort_by="field:sortdate" sort_order="descend" lastn="50">
<mt:EntryPrimaryCategory><mt:SetVarBlock name="topics_cat_base"><$mt:CategoryBasename$></mt:SetVarBlock></mt:EntryPrimaryCategory>
<mt:If name="topics_cat_base" eq="event"><mt:If name="topics_event_count" lt="10">
    <a href="<$mt:EntryPermalink encode_html="1"$>" class="information-corner">
        <div class="information-corner__thumb"><mt:If tag="EntryDatacheckit_Thumb">
            <img src="<$mt:EntryDatacheckit_Thumb regex_replace='/^.*href="([^"]+)".*$/s','$1'$>" alt="<$mt:EntryTitle encode_html="1"$>"><mt:Else><img src="/_assets/img/placeholder_<$mt:CategoryBasename$>.png" alt="<$mt:EntryTitle encode_html="1"$>"></mt:Else></mt:If>
        </div>
        <div class="information-corner__body">
            <header class="information-corner-header">
                <mt:EntryPrimaryCategory><span class="information-corner-label <$mt:CategoryBasename$>"><$mt:CategoryLabel encode_html="1"$></span></mt:EntryPrimaryCategory>
                <h3 class="information-corner-title">
                    <mt:If tag="EntryDatatitle_top"><span class="topics_small"><$mt:EntryDatatitle_top$></span> </mt:If><$mt:EntryTitle$><mt:If tag="EntryDatabottom_title"> <span class="topics_small"><$mt:EntryDatabottom_title$></span></mt:If>
                </h3>
            </header><mt:If tag="EntryDatacheckitDATE">
            <div class="information-corner-meta">
                <span class="information-corner-meta__item">
                    <span class="information-corner-meta__label"><i class="fa-solid fa-calendar-days"></i></span>
                    <span><$mt:EntryDatacheckitDATE encode_html="1"$></span>
                </span>
            </div></mt:If><mt:If tag="EntryDatacheckit">
            <p class="information-corner-desc"><$mt:EntryDatacheckit remove_html="1" encode_html="1"$></p></mt:If>
        </div>
    </a>
    <mt:SetVarBlock name="topics_event_count"><$mt:Var name="topics_event_count" default="0" op="+" value="1"$></mt:SetVarBlock>
</mt:If></mt:If>
</mt:Entries>
</div>
