<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WOrdersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_ordersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fw_ordersview = currentForm = new ew.Form("fw_ordersview", "view");
    loadjs.done("fw_ordersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.w_orders) ew.vars.tables.w_orders = <?= JsonEncode(GetClientVar("tables", "w_orders")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_ordersview" id="fw_ordersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_orders">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->order_id->Visible) { // order_id ?>
    <tr id="r_order_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_orders_order_id"><?= $Page->order_id->caption() ?></span></td>
        <td data-name="order_id" <?= $Page->order_id->cellAttributes() ?>>
<span id="el_w_orders_order_id">
<span<?= $Page->order_id->viewAttributes() ?>>
<?= $Page->order_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
    <tr id="r_nama_peserta">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_orders_nama_peserta"><?= $Page->nama_peserta->caption() ?></span></td>
        <td data-name="nama_peserta" <?= $Page->nama_peserta->cellAttributes() ?>>
<span id="el_w_orders_nama_peserta">
<span<?= $Page->nama_peserta->viewAttributes() ?>>
<?= $Page->nama_peserta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
    <tr id="r_nama_perusahaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_orders_nama_perusahaan"><?= $Page->nama_perusahaan->caption() ?></span></td>
        <td data-name="nama_perusahaan" <?= $Page->nama_perusahaan->cellAttributes() ?>>
<span id="el_w_orders_nama_perusahaan">
<span<?= $Page->nama_perusahaan->viewAttributes() ?>>
<?= $Page->nama_perusahaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
    <tr id="r_pelatihan_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_orders_pelatihan_id"><?= $Page->pelatihan_id->caption() ?></span></td>
        <td data-name="pelatihan_id" <?= $Page->pelatihan_id->cellAttributes() ?>>
<span id="el_w_orders_pelatihan_id">
<span<?= $Page->pelatihan_id->viewAttributes() ?>>
<?= $Page->pelatihan_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Biaya->Visible) { // Biaya ?>
    <tr id="r_Biaya">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_orders_Biaya"><?= $Page->Biaya->caption() ?></span></td>
        <td data-name="Biaya" <?= $Page->Biaya->cellAttributes() ?>>
<span id="el_w_orders_Biaya">
<span<?= $Page->Biaya->viewAttributes() ?>>
<?= $Page->Biaya->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
    <tr id="r_bukti_pembayaran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_orders_bukti_pembayaran"><?= $Page->bukti_pembayaran->caption() ?></span></td>
        <td data-name="bukti_pembayaran" <?= $Page->bukti_pembayaran->cellAttributes() ?>>
<span id="el_w_orders_bukti_pembayaran">
<span>
<?= GetFileViewTag($Page->bukti_pembayaran, $Page->bukti_pembayaran->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_orders_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_w_orders_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
