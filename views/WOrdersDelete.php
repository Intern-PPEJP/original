<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WOrdersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_ordersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fw_ordersdelete = currentForm = new ew.Form("fw_ordersdelete", "delete");
    loadjs.done("fw_ordersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.w_orders) ew.vars.tables.w_orders = <?= JsonEncode(GetClientVar("tables", "w_orders")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_ordersdelete" id="fw_ordersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_orders">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
        <th class="<?= $Page->nama_peserta->headerCellClass() ?>"><span id="elh_w_orders_nama_peserta" class="w_orders_nama_peserta"><?= $Page->nama_peserta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
        <th class="<?= $Page->nama_perusahaan->headerCellClass() ?>"><span id="elh_w_orders_nama_perusahaan" class="w_orders_nama_perusahaan"><?= $Page->nama_perusahaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <th class="<?= $Page->pelatihan_id->headerCellClass() ?>"><span id="elh_w_orders_pelatihan_id" class="w_orders_pelatihan_id"><?= $Page->pelatihan_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Biaya->Visible) { // Biaya ?>
        <th class="<?= $Page->Biaya->headerCellClass() ?>"><span id="elh_w_orders_Biaya" class="w_orders_Biaya"><?= $Page->Biaya->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
        <th class="<?= $Page->bukti_pembayaran->headerCellClass() ?>"><span id="elh_w_orders_bukti_pembayaran" class="w_orders_bukti_pembayaran"><?= $Page->bukti_pembayaran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_w_orders_status" class="w_orders_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
        <td <?= $Page->nama_peserta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_nama_peserta" class="w_orders_nama_peserta">
<span<?= $Page->nama_peserta->viewAttributes() ?>>
<?= $Page->nama_peserta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
        <td <?= $Page->nama_perusahaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_nama_perusahaan" class="w_orders_nama_perusahaan">
<span<?= $Page->nama_perusahaan->viewAttributes() ?>>
<?= $Page->nama_perusahaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <td <?= $Page->pelatihan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_pelatihan_id" class="w_orders_pelatihan_id">
<span<?= $Page->pelatihan_id->viewAttributes() ?>>
<?= $Page->pelatihan_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Biaya->Visible) { // Biaya ?>
        <td <?= $Page->Biaya->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_Biaya" class="w_orders_Biaya">
<span<?= $Page->Biaya->viewAttributes() ?>>
<?= $Page->Biaya->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
        <td <?= $Page->bukti_pembayaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_bukti_pembayaran" class="w_orders_bukti_pembayaran">
<span>
<?= GetFileViewTag($Page->bukti_pembayaran, $Page->bukti_pembayaran->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_orders_status" class="w_orders_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
