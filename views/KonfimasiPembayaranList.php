<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$KonfimasiPembayaranList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fkonfimasi_pembayaranlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fkonfimasi_pembayaranlist = currentForm = new ew.Form("fkonfimasi_pembayaranlist", "list");
    fkonfimasi_pembayaranlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fkonfimasi_pembayaranlist");
});
var fkonfimasi_pembayaranlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fkonfimasi_pembayaranlistsrch = currentSearchForm = new ew.Form("fkonfimasi_pembayaranlistsrch");

    // Dynamic selection lists

    // Filters
    fkonfimasi_pembayaranlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fkonfimasi_pembayaranlistsrch");
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
<form name="fkonfimasi_pembayaranlistsrch" id="fkonfimasi_pembayaranlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fkonfimasi_pembayaranlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="konfimasi_pembayaran">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> konfimasi_pembayaran">
<form name="fkonfimasi_pembayaranlist" id="fkonfimasi_pembayaranlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="konfimasi_pembayaran">
<div id="gmp_konfimasi_pembayaran" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_konfimasi_pembayaranlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->order_id->Visible) { // order_id ?>
        <th data-name="order_id" class="<?= $Page->order_id->headerCellClass() ?>"><div id="elh_konfimasi_pembayaran_order_id" class="konfimasi_pembayaran_order_id"><?= $Page->renderSort($Page->order_id) ?></div></th>
<?php } ?>
<?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
        <th data-name="judul_pelatihan" class="<?= $Page->judul_pelatihan->headerCellClass() ?>"><div id="elh_konfimasi_pembayaran_judul_pelatihan" class="konfimasi_pembayaran_judul_pelatihan"><?= $Page->renderSort($Page->judul_pelatihan) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
        <th data-name="tanggal_pelaksanaan" class="<?= $Page->tanggal_pelaksanaan->headerCellClass() ?>"><div id="elh_konfimasi_pembayaran_tanggal_pelaksanaan" class="konfimasi_pembayaran_tanggal_pelaksanaan"><?= $Page->renderSort($Page->tanggal_pelaksanaan) ?></div></th>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <th data-name="harga" class="<?= $Page->harga->headerCellClass() ?>"><div id="elh_konfimasi_pembayaran_harga" class="konfimasi_pembayaran_harga"><?= $Page->renderSort($Page->harga) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_tranfer->Visible) { // tgl_tranfer ?>
        <th data-name="tgl_tranfer" class="<?= $Page->tgl_tranfer->headerCellClass() ?>"><div id="elh_konfimasi_pembayaran_tgl_tranfer" class="konfimasi_pembayaran_tgl_tranfer"><?= $Page->renderSort($Page->tgl_tranfer) ?></div></th>
<?php } ?>
<?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
        <th data-name="bukti_pembayaran" class="<?= $Page->bukti_pembayaran->headerCellClass() ?>"><div id="elh_konfimasi_pembayaran_bukti_pembayaran" class="konfimasi_pembayaran_bukti_pembayaran"><?= $Page->renderSort($Page->bukti_pembayaran) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_konfimasi_pembayaran_status" class="konfimasi_pembayaran_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_konfimasi_pembayaran", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->order_id->Visible) { // order_id ?>
        <td data-name="order_id" <?= $Page->order_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_konfimasi_pembayaran_order_id">
<span<?= $Page->order_id->viewAttributes() ?>>
<?= $Page->order_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
        <td data-name="judul_pelatihan" <?= $Page->judul_pelatihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_konfimasi_pembayaran_judul_pelatihan">
<span<?= $Page->judul_pelatihan->viewAttributes() ?>>
<?= $Page->judul_pelatihan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
        <td data-name="tanggal_pelaksanaan" <?= $Page->tanggal_pelaksanaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_konfimasi_pembayaran_tanggal_pelaksanaan">
<span<?= $Page->tanggal_pelaksanaan->viewAttributes() ?>>
<?= $Page->tanggal_pelaksanaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->harga->Visible) { // harga ?>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_konfimasi_pembayaran_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_tranfer->Visible) { // tgl_tranfer ?>
        <td data-name="tgl_tranfer" <?= $Page->tgl_tranfer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_konfimasi_pembayaran_tgl_tranfer">
<span<?= $Page->tgl_tranfer->viewAttributes() ?>>
<?= $Page->tgl_tranfer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
        <td data-name="bukti_pembayaran" <?= $Page->bukti_pembayaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_konfimasi_pembayaran_bukti_pembayaran">
<span<?= $Page->bukti_pembayaran->viewAttributes() ?>>
<?= GetFileViewTag($Page->bukti_pembayaran, $Page->bukti_pembayaran->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_konfimasi_pembayaran_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
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
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("konfimasi_pembayaran");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
