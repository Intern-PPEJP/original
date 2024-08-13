<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WOrdersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_orderslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fw_orderslist = currentForm = new ew.Form("fw_orderslist", "list");
    fw_orderslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fw_orderslist");
});
var fw_orderslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fw_orderslistsrch = currentSearchForm = new ew.Form("fw_orderslistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_orders")) ?>,
        fields = currentTable.fields;
    fw_orderslistsrch.addFields([
        ["nama_peserta", [], fields.nama_peserta.isInvalid],
        ["_username", [], fields._username.isInvalid],
        ["nama_perusahaan", [], fields.nama_perusahaan.isInvalid],
        ["pelatihan_id", [], fields.pelatihan_id.isInvalid],
        ["Biaya", [], fields.Biaya.isInvalid],
        ["tgl_tranfer", [], fields.tgl_tranfer.isInvalid],
        ["bukti_pembayaran", [], fields.bukti_pembayaran.isInvalid],
        ["status", [], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fw_orderslistsrch.setInvalid();
    });

    // Validate form
    fw_orderslistsrch.validate = function () {
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
    fw_orderslistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_orderslistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_orderslistsrch.lists.pelatihan_id = <?= $Page->pelatihan_id->toClientList($Page) ?>;
    fw_orderslistsrch.lists.status = <?= $Page->status->toClientList($Page) ?>;

    // Filters
    fw_orderslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fw_orderslistsrch");
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
<form name="fw_orderslistsrch" id="fw_orderslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fw_orderslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="w_orders">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_pelatihan_id" class="ew-cell form-group">
        <label for="x_pelatihan_id" class="ew-search-caption ew-label"><?= $Page->pelatihan_id->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_pelatihan_id" id="z_pelatihan_id" value="=">
</span>
        <span id="el_w_orders_pelatihan_id" class="ew-search-field">
    <select
        id="x_pelatihan_id"
        name="x_pelatihan_id"
        class="form-control ew-select<?= $Page->pelatihan_id->isInvalidClass() ?>"
        data-select2-id="w_orders_x_pelatihan_id"
        data-table="w_orders"
        data-field="x_pelatihan_id"
        data-value-separator="<?= $Page->pelatihan_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pelatihan_id->getPlaceHolder()) ?>"
        <?= $Page->pelatihan_id->editAttributes() ?>>
        <?= $Page->pelatihan_id->selectOptionListHtml("x_pelatihan_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->pelatihan_id->getErrorMessage(false) ?></div>
<?= $Page->pelatihan_id->Lookup->getParamTag($Page, "p_x_pelatihan_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_orders_x_pelatihan_id']"),
        options = { name: "x_pelatihan_id", selectId: "w_orders_x_pelatihan_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_orders.fields.pelatihan_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_status" class="ew-cell form-group">
        <label for="x_status" class="ew-search-caption ew-label"><?= $Page->status->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status" id="z_status" value="=">
</span>
        <span id="el_w_orders_status" class="ew-search-field">
    <select
        id="x_status"
        name="x_status"
        class="form-control ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="w_orders_x_status"
        data-table="w_orders"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage(false) ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_orders_x_status']"),
        options = { name: "x_status", selectId: "w_orders_x_status", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.w_orders.fields.status.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_orders.fields.status.selectOptions);
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
    <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> w_orders">
<form name="fw_orderslist" id="fw_orderslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_orders">
<div id="gmp_w_orders" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_w_orderslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
        <th data-name="nama_peserta" class="<?= $Page->nama_peserta->headerCellClass() ?>"><div id="elh_w_orders_nama_peserta" class="w_orders_nama_peserta"><?= $Page->renderSort($Page->nama_peserta) ?></div></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Page->_username->headerCellClass() ?>"><div id="elh_w_orders__username" class="w_orders__username"><?= $Page->renderSort($Page->_username) ?></div></th>
<?php } ?>
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
        <th data-name="nama_perusahaan" class="<?= $Page->nama_perusahaan->headerCellClass() ?>"><div id="elh_w_orders_nama_perusahaan" class="w_orders_nama_perusahaan"><?= $Page->renderSort($Page->nama_perusahaan) ?></div></th>
<?php } ?>
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <th data-name="pelatihan_id" class="<?= $Page->pelatihan_id->headerCellClass() ?>"><div id="elh_w_orders_pelatihan_id" class="w_orders_pelatihan_id"><?= $Page->renderSort($Page->pelatihan_id) ?></div></th>
<?php } ?>
<?php if ($Page->Biaya->Visible) { // Biaya ?>
        <th data-name="Biaya" class="<?= $Page->Biaya->headerCellClass() ?>"><div id="elh_w_orders_Biaya" class="w_orders_Biaya"><?= $Page->renderSort($Page->Biaya) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_tranfer->Visible) { // tgl_tranfer ?>
        <th data-name="tgl_tranfer" class="<?= $Page->tgl_tranfer->headerCellClass() ?>"><div id="elh_w_orders_tgl_tranfer" class="w_orders_tgl_tranfer"><?= $Page->renderSort($Page->tgl_tranfer) ?></div></th>
<?php } ?>
<?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
        <th data-name="bukti_pembayaran" class="<?= $Page->bukti_pembayaran->headerCellClass() ?>"><div id="elh_w_orders_bukti_pembayaran" class="w_orders_bukti_pembayaran"><?= $Page->renderSort($Page->bukti_pembayaran) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_w_orders_status" class="w_orders_status"><?= $Page->renderSort($Page->status) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_w_orders", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
        <td data-name="nama_peserta" <?= $Page->nama_peserta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_nama_peserta">
<span<?= $Page->nama_peserta->viewAttributes() ?>>
<?= $Page->nama_peserta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_username->Visible) { // username ?>
        <td data-name="_username" <?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
        <td data-name="nama_perusahaan" <?= $Page->nama_perusahaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_nama_perusahaan">
<span<?= $Page->nama_perusahaan->viewAttributes() ?>>
<?= $Page->nama_perusahaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <td data-name="pelatihan_id" <?= $Page->pelatihan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_pelatihan_id">
<span<?= $Page->pelatihan_id->viewAttributes() ?>>
<?= $Page->pelatihan_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Biaya->Visible) { // Biaya ?>
        <td data-name="Biaya" <?= $Page->Biaya->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_Biaya">
<span<?= $Page->Biaya->viewAttributes() ?>>
<?= $Page->Biaya->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_tranfer->Visible) { // tgl_tranfer ?>
        <td data-name="tgl_tranfer" <?= $Page->tgl_tranfer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_tgl_tranfer">
<span<?= $Page->tgl_tranfer->viewAttributes() ?>>
<?= $Page->tgl_tranfer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
        <td data-name="bukti_pembayaran" <?= $Page->bukti_pembayaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_bukti_pembayaran">
<span>
<?= GetFileViewTag($Page->bukti_pembayaran, $Page->bukti_pembayaran->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_status">
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
    ew.addEventHandlers("w_orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $(".icon-reset-search").after(" Tampilkan Semua"),$(".ew-search-toggle").hide(),$(".ew-action").addClass("btn btn-success");
});
</script>
<?php } ?>
