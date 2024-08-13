<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WTestimoniDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_testimonidelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fw_testimonidelete = currentForm = new ew.Form("fw_testimonidelete", "delete");
    loadjs.done("fw_testimonidelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.w_testimoni) ew.vars.tables.w_testimoni = <?= JsonEncode(GetClientVar("tables", "w_testimoni")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_testimonidelete" id="fw_testimonidelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_testimoni">
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
<?php if ($Page->testimoni_id->Visible) { // testimoni_id ?>
        <th class="<?= $Page->testimoni_id->headerCellClass() ?>"><span id="elh_w_testimoni_testimoni_id" class="w_testimoni_testimoni_id"><?= $Page->testimoni_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_w_testimoni_nama" class="w_testimoni_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <th class="<?= $Page->gambar->headerCellClass() ?>"><span id="elh_w_testimoni_gambar" class="w_testimoni_gambar"><?= $Page->gambar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testimoni->Visible) { // testimoni ?>
        <th class="<?= $Page->testimoni->headerCellClass() ?>"><span id="elh_w_testimoni_testimoni" class="w_testimoni_testimoni"><?= $Page->testimoni->caption() ?></span></th>
<?php } ?>
<?php if ($Page->show->Visible) { // show ?>
        <th class="<?= $Page->show->headerCellClass() ?>"><span id="elh_w_testimoni_show" class="w_testimoni_show"><?= $Page->show->caption() ?></span></th>
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
<?php if ($Page->testimoni_id->Visible) { // testimoni_id ?>
        <td <?= $Page->testimoni_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_testimoni_testimoni_id" class="w_testimoni_testimoni_id">
<span<?= $Page->testimoni_id->viewAttributes() ?>>
<?= $Page->testimoni_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_testimoni_nama" class="w_testimoni_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <td <?= $Page->gambar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_testimoni_gambar" class="w_testimoni_gambar">
<span>
<?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->testimoni->Visible) { // testimoni ?>
        <td <?= $Page->testimoni->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_testimoni_testimoni" class="w_testimoni_testimoni">
<span<?= $Page->testimoni->viewAttributes() ?>>
<?php if (!EmptyString($Page->testimoni->getViewValue()) && $Page->testimoni->linkAttributes() != "") { ?>
<a<?= $Page->testimoni->linkAttributes() ?>><?= $Page->testimoni->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->testimoni->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->show->Visible) { // show ?>
        <td <?= $Page->show->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_testimoni_show" class="w_testimoni_show">
<span<?= $Page->show->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_show_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->show->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->show->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_show_<?= $Page->RowCount ?>"></label>
</div></span>
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
