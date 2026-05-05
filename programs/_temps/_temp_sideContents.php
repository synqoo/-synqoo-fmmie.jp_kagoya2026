<nav class="card card-color widget-recent-entries widget">
<img src="/program/talkbeyond/images/tb.jpg" width="20px" height="20px"  />
<p>橋本やすしげ</p>


<mt:If tag="BlogEntryCount">
  <mt:Entries lastn="10">
    <mt:EntriesHeader>

  <h3 class="widget-header"><i class="fa fa-list" aria-hidden="true"></i> 最近のブログ記事</h3>
  <div class="widget-content">
    <ul class="widget-list">
    </mt:EntriesHeader>
      <li class="widget-list-item"><a href="<$mt:EntryPermalink$>"><$mt:EntryTitle$></a></li>
    <mt:EntriesFooter>
    </ul>
  </div>
    </mt:EntriesFooter>
  </mt:Entries>
</mt:If>

<mt:IfArchiveTypeEnabled archive_type="Monthly">
  <mt:ArchiveList archive_type="Monthly">
    <mt:ArchiveListHeader>
  <h3 class="widget-header"><i class="fa fa-archive" aria-hidden="true"></i> アーカイブ</h3>
  <div class="widget-content">
    <select onChange="document.location = this.value" >
      <option>月を選択...</option>
    </mt:ArchiveListHeader>
      <option value="<$mt:ArchiveLink encode_html="1"$>"><$mt:ArchiveTitle$></option>
    <mt:ArchiveListFooter>
    </select>
  </div>
    </mt:ArchiveListFooter>
  </mt:ArchiveList>
</mt:IfArchiveTypeEnabled>
</nav>