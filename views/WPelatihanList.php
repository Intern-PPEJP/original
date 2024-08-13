<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WPelatihanList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_pelatihanlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fw_pelatihanlist = currentForm = new ew.Form("fw_pelatihanlist", "list");
    fw_pelatihanlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fw_pelatihanlist");
});
var fw_pelatihanlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fw_pelatihanlistsrch = currentSearchForm = new ew.Form("fw_pelatihanlistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_pelatihan")) ?>,
        fields = currentTable.fields;
    fw_pelatihanlistsrch.addFields([
        ["pelatihan_id", [], fields.pelatihan_id.isInvalid],
        ["jenis_pelatihan", [], fields.jenis_pelatihan.isInvalid],
        ["judul_pelatihan", [], fields.judul_pelatihan.isInvalid],
        ["jumlah_hari", [], fields.jumlah_hari.isInvalid],
        ["tempat", [], fields.tempat.isInvalid],
        ["jumlah_peserta", [], fields.jumlah_peserta.isInvalid],
        ["sisa", [], fields.sisa.isInvalid],
        ["harga", [], fields.harga.isInvalid],
        ["tanggal_pelaksanaan", [], fields.tanggal_pelaksanaan.isInvalid],
        ["gambar", [], fields.gambar.isInvalid],
        ["kategori", [], fields.kategori.isInvalid],
        ["Activated", [], fields.Activated.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fw_pelatihanlistsrch.setInvalid();
    });

    // Validate form
    fw_pelatihanlistsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fw_pelatihanlistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_pelatihanlistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_pelatihanlistsrch.lists.jenis_pelatihan = <?= $Page->jenis_pelatihan->toClientList($Page) ?>;

    // Filters
    fw_pelatihanlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fw_pelatihanlistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    // Write your table-specific client script here, no need to add script tags.
    </script>
    <style>
    .ew-extended-search .ew-row { 
    display: inline-table !important;
    }
    .ew-search-option { 
    display: none;
    }
    </style>
    <script>
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
<form name="fw_pelatihanlistsrch" id="fw_pelatihanlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fw_pelatihanlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="w_pelatihan">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->jenis_pelatihan->Visible) { // jenis_pelatihan ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_jenis_pelatihan" class="ew-cell form-group">
        <label for="x_jenis_pelatihan" class="ew-search-caption ew-label"><?= $Page->jenis_pelatihan->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_jenis_pelatihan" id="z_jenis_pelatihan" value="=">
</span>
        <span id="el_w_pelatihan_jenis_pelatihan" class="ew-search-field">
    <select
        id="x_jenis_pelatihan"
        name="x_jenis_pelatihan"
        class="form-control ew-select<?= $Page->jenis_pelatihan->isInvalidClass() ?>"
        data-select2-id="w_pelatihan_x_jenis_pelatihan"
        data-table="w_pelatihan"
        data-field="x_jenis_pelatihan"
        data-value-separator="<?= $Page->jenis_pelatihan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->jenis_pelatihan->getPlaceHolder()) ?>"
        <?= $Page->jenis_pelatihan->editAttributes() ?>>
        <?= $Page->jenis_pelatihan->selectOptionListHtml("x_jenis_pelatihan") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->jenis_pelatihan->getErrorMessage(false) ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_pelatihan_x_jenis_pelatihan']"),
        options = { name: "x_jenis_pelatihan", selectId: "w_pelatihan_x_jenis_pelatihan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.w_pelatihan.fields.jenis_pelatihan.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_pelatihan.fields.jenis_pelatihan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow > 0) { ?>
</div>
    <?php } ?>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> w_pelatihan">
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
<form name="fw_pelatihanlist" id="fw_pelatihanlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_pelatihan">
<div id="gmp_w_pelatihan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_w_pelatihanlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <th data-name="pelatihan_id" class="<?= $Page->pelatihan_id->headerCellClass() ?>"><div id="elh_w_pelatihan_pelatihan_id" class="w_pelatihan_pelatihan_id"><?= $Page->renderSort($Page->pelatihan_id) ?></div></th>
<?php } ?>
<?php if ($Page->jenis_pelatihan->Visible) { // jenis_pelatihan ?>
        <th data-name="jenis_pelatihan" class="<?= $Page->jenis_pelatihan->headerCellClass() ?>"><div id="elh_w_pelatihan_jenis_pelatihan" class="w_pelatihan_jenis_pelatihan"><?= $Page->renderSort($Page->jenis_pelatihan) ?></div></th>
<?php } ?>
<?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
        <th data-name="judul_pelatihan" class="<?= $Page->judul_pelatihan->headerCellClass() ?>"><div id="elh_w_pelatihan_judul_pelatihan" class="w_pelatihan_judul_pelatihan"><?= $Page->renderSort($Page->judul_pelatihan) ?></div></th>
<?php } ?>
<?php if ($Page->jumlah_hari->Visible) { // jumlah_hari ?>
        <th data-name="jumlah_hari" class="<?= $Page->jumlah_hari->headerCellClass() ?>"><div id="elh_w_pelatihan_jumlah_hari" class="w_pelatihan_jumlah_hari"><?= $Page->renderSort($Page->jumlah_hari) ?></div></th>
<?php } ?>
<?php if ($Page->tempat->Visible) { // tempat ?>
        <th data-name="tempat" class="<?= $Page->tempat->headerCellClass() ?>"><div id="elh_w_pelatihan_tempat" class="w_pelatihan_tempat"><?= $Page->renderSort($Page->tempat) ?></div></th>
<?php } ?>
<?php if ($Page->jumlah_peserta->Visible) { // jumlah_peserta ?>
        <th data-name="jumlah_peserta" class="<?= $Page->jumlah_peserta->headerCellClass() ?>"><div id="elh_w_pelatihan_jumlah_peserta" class="w_pelatihan_jumlah_peserta"><?= $Page->renderSort($Page->jumlah_peserta) ?></div></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th data-name="sisa" class="<?= $Page->sisa->headerCellClass() ?>"><div id="elh_w_pelatihan_sisa" class="w_pelatihan_sisa"><?= $Page->renderSort($Page->sisa) ?></div></th>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <th data-name="harga" class="<?= $Page->harga->headerCellClass() ?>"><div id="elh_w_pelatihan_harga" class="w_pelatihan_harga"><?= $Page->renderSort($Page->harga) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
        <th data-name="tanggal_pelaksanaan" class="<?= $Page->tanggal_pelaksanaan->headerCellClass() ?>"><div id="elh_w_pelatihan_tanggal_pelaksanaan" class="w_pelatihan_tanggal_pelaksanaan"><?= $Page->renderSort($Page->tanggal_pelaksanaan) ?></div></th>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <th data-name="gambar" class="<?= $Page->gambar->headerCellClass() ?>"><div id="elh_w_pelatihan_gambar" class="w_pelatihan_gambar"><?= $Page->renderSort($Page->gambar) ?></div></th>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <th data-name="kategori" class="<?= $Page->kategori->headerCellClass() ?>"><div id="elh_w_pelatihan_kategori" class="w_pelatihan_kategori"><?= $Page->renderSort($Page->kategori) ?></div></th>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
        <th data-name="Activated" class="<?= $Page->Activated->headerCellClass() ?>"><div id="elh_w_pelatihan_Activated" class="w_pelatihan_Activated"><?= $Page->renderSort($Page->Activated) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_w_pelatihan", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <td data-name="pelatihan_id" <?= $Page->pelatihan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_pelatihan_id">
<span<?= $Page->pelatihan_id->viewAttributes() ?>>
<?= $Page->pelatihan_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jenis_pelatihan->Visible) { // jenis_pelatihan ?>
        <td data-name="jenis_pelatihan" <?= $Page->jenis_pelatihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_jenis_pelatihan">
<span<?= $Page->jenis_pelatihan->viewAttributes() ?>>
<?= $Page->jenis_pelatihan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
        <td data-name="judul_pelatihan" <?= $Page->judul_pelatihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_judul_pelatihan">
<span<?= $Page->judul_pelatihan->viewAttributes() ?>>
<?= $Page->judul_pelatihan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlah_hari->Visible) { // jumlah_hari ?>
        <td data-name="jumlah_hari" <?= $Page->jumlah_hari->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_jumlah_hari">
<span<?= $Page->jumlah_hari->viewAttributes() ?>>
<?= $Page->jumlah_hari->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tempat->Visible) { // tempat ?>
        <td data-name="tempat" <?= $Page->tempat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_tempat">
<span<?= $Page->tempat->viewAttributes() ?>>
<?= $Page->tempat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlah_peserta->Visible) { // jumlah_peserta ?>
        <td data-name="jumlah_peserta" <?= $Page->jumlah_peserta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_jumlah_peserta">
<span<?= $Page->jumlah_peserta->viewAttributes() ?>>
<?= $Page->jumlah_peserta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisa->Visible) { // sisa ?>
        <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->harga->Visible) { // harga ?>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
        <td data-name="tanggal_pelaksanaan" <?= $Page->tanggal_pelaksanaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_tanggal_pelaksanaan">
<span<?= $Page->tanggal_pelaksanaan->viewAttributes() ?>>
<?= $Page->tanggal_pelaksanaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gambar->Visible) { // gambar ?>
        <td data-name="gambar" <?= $Page->gambar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_gambar">
<span>
<?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kategori->Visible) { // kategori ?>
        <td data-name="kategori" <?= $Page->kategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Activated->Visible) { // Activated ?>
        <td data-name="Activated" <?= $Page->Activated->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_Activated">
<span<?= $Page->Activated->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
</div></span>
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
    ew.addEventHandlers("w_pelatihan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $(".ew-add i").after(" Buat Pelatihan"),$(".ew-add ").toggleClass("btn-default btn-success");
});
</script>
<?php } ?>
