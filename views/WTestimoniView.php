<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WTestimoniView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_testimoniview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fw_testimoniview = currentForm = new ew.Form("fw_testimoniview", "view");
    loadjs.done("fw_testimoniview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.w_testimoni) ew.vars.tables.w_testimoni = <?= JsonEncode(GetClientVar("tables", "w_testimoni")) ?>;
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
<form name="fw_testimoniview" id="fw_testimoniview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_testimoni">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->testimoni_id->Visible) { // testimoni_id ?>
    <tr id="r_testimoni_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_testimoni_testimoni_id"><?= $Page->testimoni_id->caption() ?></span></td>
        <td data-name="testimoni_id" <?= $Page->testimoni_id->cellAttributes() ?>>
<span id="el_w_testimoni_testimoni_id">
<span<?= $Page->testimoni_id->viewAttributes() ?>>
<?= $Page->testimoni_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_testimoni_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_w_testimoni_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
    <tr id="r_gambar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_testimoni_gambar"><?= $Page->gambar->caption() ?></span></td>
        <td data-name="gambar" <?= $Page->gambar->cellAttributes() ?>>
<span id="el_w_testimoni_gambar">
<span>
<?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testimoni->Visible) { // testimoni ?>
    <tr id="r_testimoni">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_testimoni_testimoni"><?= $Page->testimoni->caption() ?></span></td>
        <td data-name="testimoni" <?= $Page->testimoni->cellAttributes() ?>>
<span id="el_w_testimoni_testimoni">
<span<?= $Page->testimoni->viewAttributes() ?>>
<?= $Page->testimoni->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->show->Visible) { // show ?>
    <tr id="r_show">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_testimoni_show"><?= $Page->show->caption() ?></span></td>
        <td data-name="show" <?= $Page->show->cellAttributes() ?>>
<span id="el_w_testimoni_show">
<span<?= $Page->show->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_show_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->show->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->show->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_show_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_testimoni_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_w_testimoni_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
