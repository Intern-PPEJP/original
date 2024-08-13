<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WBeritaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_beritalist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fw_beritalist = currentForm = new ew.Form("fw_beritalist", "list");
    fw_beritalist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fw_beritalist");
});
var fw_beritalistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fw_beritalistsrch = currentSearchForm = new ew.Form("fw_beritalistsrch");

    // Dynamic selection lists

    // Filters
    fw_beritalistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fw_beritalistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fw_beritalistsrch" id="fw_beritalistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fw_beritalistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="w_berita">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> w_berita">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fw_beritalist" id="fw_beritalist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_berita">
<div id="gmp_w_berita" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_w_beritalist" class="table ew-table d-none"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left", "", "block", $Page->TableVar, "w_beritalist");
?>
<?php if ($Page->judul->Visible) { // judul ?>
        <th data-name="judul" class="<?= $Page->judul->headerCellClass() ?>"><div id="elh_w_berita_judul" class="w_berita_judul"><?= $Page->renderSort($Page->judul) ?></div></th>
<?php } ?>
<?php if ($Page->isi->Visible) { // isi ?>
        <th data-name="isi" class="<?= $Page->isi->headerCellClass() ?>"><div id="elh_w_berita_isi" class="w_berita_isi"><?= $Page->renderSort($Page->isi) ?></div></th>
<?php } ?>
<?php if ($Page->kategori_id->Visible) { // kategori_id ?>
        <th data-name="kategori_id" class="<?= $Page->kategori_id->headerCellClass() ?>"><div id="elh_w_berita_kategori_id" class="w_berita_kategori_id"><?= $Page->renderSort($Page->kategori_id) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_publikasi->Visible) { // tanggal_publikasi ?>
        <th data-name="tanggal_publikasi" class="<?= $Page->tanggal_publikasi->headerCellClass() ?>"><div id="elh_w_berita_tanggal_publikasi" class="w_berita_tanggal_publikasi"><?= $Page->renderSort($Page->tanggal_publikasi) ?></div></th>
<?php } ?>
<?php if ($Page->penulis->Visible) { // penulis ?>
        <th data-name="penulis" class="<?= $Page->penulis->headerCellClass() ?>"><div id="elh_w_berita_penulis" class="w_berita_penulis"><?= $Page->renderSort($Page->penulis) ?></div></th>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <th data-name="gambar" class="<?= $Page->gambar->headerCellClass() ?>"><div id="elh_w_berita_gambar" class="w_berita_gambar"><?= $Page->renderSort($Page->gambar) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_w_berita_created_at" class="w_berita_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->publish->Visible) { // publish ?>
        <th data-name="publish" class="<?= $Page->publish->headerCellClass() ?>"><div id="elh_w_berita_publish" class="w_berita_publish"><?= $Page->renderSort($Page->publish) ?></div></th>
<?php } ?>
<?php if ($Page->gambar2->Visible) { // gambar2 ?>
        <th data-name="gambar2" class="<?= $Page->gambar2->headerCellClass() ?>"><div id="elh_w_berita_gambar2" class="w_berita_gambar2"><?= $Page->renderSort($Page->gambar2) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right", "", "block", $Page->TableVar, "w_beritalist");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_w_berita", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Save row and cell attributes
        $Page->Attrs[$Page->RowCount] = ["row_attrs" => $Page->rowAttributes(), "cell_attrs" => []];
        $Page->Attrs[$Page->RowCount]["cell_attrs"] = $Page->fieldCellAttributes();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount, "single", $Page->TableVar, "w_beritalist");
?>
    <?php if ($Page->judul->Visible) { // judul ?>
        <td data-name="judul" <?= $Page->judul->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_judul"><span id="el<?= $Page->RowCount ?>_w_berita_judul">
<span<?= $Page->judul->viewAttributes() ?>>
<?= $Page->judul->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->isi->Visible) { // isi ?>
        <td data-name="isi" <?= $Page->isi->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_isi"><span id="el<?= $Page->RowCount ?>_w_berita_isi">
<span<?= $Page->isi->viewAttributes() ?>>
<?= $Page->isi->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->kategori_id->Visible) { // kategori_id ?>
        <td data-name="kategori_id" <?= $Page->kategori_id->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_kategori_id"><span id="el<?= $Page->RowCount ?>_w_berita_kategori_id">
<span<?= $Page->kategori_id->viewAttributes() ?>>
<?= $Page->kategori_id->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_publikasi->Visible) { // tanggal_publikasi ?>
        <td data-name="tanggal_publikasi" <?= $Page->tanggal_publikasi->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_tanggal_publikasi"><span id="el<?= $Page->RowCount ?>_w_berita_tanggal_publikasi">
<span<?= $Page->tanggal_publikasi->viewAttributes() ?>>
<?= $Page->tanggal_publikasi->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->penulis->Visible) { // penulis ?>
        <td data-name="penulis" <?= $Page->penulis->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_penulis"><span id="el<?= $Page->RowCount ?>_w_berita_penulis">
<span<?= $Page->penulis->viewAttributes() ?>>
<?= $Page->penulis->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->gambar->Visible) { // gambar ?>
        <td data-name="gambar" <?= $Page->gambar->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_gambar"><span id="el<?= $Page->RowCount ?>_w_berita_gambar">
<span>
<?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
</span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_created_at"><span id="el<?= $Page->RowCount ?>_w_berita_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->publish->Visible) { // publish ?>
        <td data-name="publish" <?= $Page->publish->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_publish"><span id="el<?= $Page->RowCount ?>_w_berita_publish">
<span<?= $Page->publish->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_publish_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->publish->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->publish->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_publish_<?= $Page->RowCount ?>"></label>
</div></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->gambar2->Visible) { // gambar2 ?>
        <td data-name="gambar2" <?= $Page->gambar2->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_w_berita_gambar2"><span id="el<?= $Page->RowCount ?>_w_berita_gambar2">
<span<?= $Page->gambar2->viewAttributes() ?>>
<?= $Page->gambar2->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount, "single", $Page->TableVar, "w_beritalist");
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<div id="tpd_w_beritalist" class="ew-custom-template"></div>
<template id="tpm_w_beritalist">
<div id="ct_WBeritaList"><?php if ($Page->RowCount > 0) { ?>
<style>
.berita td { padding: 15px; }
.w_berita { width:100%; }
.berita a { color:#343a40; }
a.ew-delete { color:red; }
</style>
<table class="table ew-table berita">
    <tbody>
<?php for ($i = $Page->StartRowCount; $i <= $Page->RowCount; $i++) { ?>
	<tr<?= @$Page->Attrs[$i]['row_attrs'] ?>>
	<td width="500px"><slot class="ew-slot" name="tpx<?= $i ?>_w_berita_gambar2"></slot></td>
	<td><h4 class="text-bold"><slot class="ew-slot" name="tpx<?= $i ?>_w_berita_judul"></slot></h4>
		<slot class="ew-slot" name="tpx<?= $i ?>_w_berita_isi"></slot><br><slot class="ew-slot" name="tpx<?= $i ?>_w_berita_tanggal_publikasi"></slot><br><br> <slot class="ew-slot" name="tpob<?= $i ?>_w_berita_delete"></slot>
	</td>
</tr>    
<?php } ?>
</tbody></table>
<?php } ?>
</div>
</template>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_w_beritalist", "tpm_w_beritalist", "w_beritalist", "<?= $Page->CustomExport ?>", ew.templateData);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("w_berita");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $(".ew-add i").after(" Buat Tulisan"),$(".ew-add ").toggleClass("btn-default btn-success"),$(".ew-delete i").after(" Hapus Tulisan");
});
</script>
<?php } ?>
