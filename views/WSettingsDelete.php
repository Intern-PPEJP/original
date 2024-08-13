<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WSettingsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_settingsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fw_settingsdelete = currentForm = new ew.Form("fw_settingsdelete", "delete");
    loadjs.done("fw_settingsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.w_settings) ew.vars.tables.w_settings = <?= JsonEncode(GetClientVar("tables", "w_settings")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_settingsdelete" id="fw_settingsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_settings">
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
<?php if ($Page->ID->Visible) { // ID ?>
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_w_settings_ID" class="w_settings_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Login_Picture->Visible) { // Login_Picture ?>
        <th class="<?= $Page->Login_Picture->headerCellClass() ?>"><span id="elh_w_settings_Login_Picture" class="w_settings_Login_Picture"><?= $Page->Login_Picture->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Daftar_Picture->Visible) { // Daftar_Picture ?>
        <th class="<?= $Page->Daftar_Picture->headerCellClass() ?>"><span id="elh_w_settings_Daftar_Picture" class="w_settings_Daftar_Picture"><?= $Page->Daftar_Picture->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
        <th class="<?= $Page->Logo->headerCellClass() ?>"><span id="elh_w_settings_Logo" class="w_settings_Logo"><?= $Page->Logo->caption() ?></span></th>
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
<?php if ($Page->ID->Visible) { // ID ?>
        <td <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_ID" class="w_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_ID_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->ID->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->ID->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_ID_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Login_Picture->Visible) { // Login_Picture ?>
        <td <?= $Page->Login_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Login_Picture" class="w_settings_Login_Picture">
<span<?= $Page->Login_Picture->viewAttributes() ?>>
<?= $Page->Login_Picture->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Daftar_Picture->Visible) { // Daftar_Picture ?>
        <td <?= $Page->Daftar_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Daftar_Picture" class="w_settings_Daftar_Picture">
<span<?= $Page->Daftar_Picture->viewAttributes() ?>>
<?= $Page->Daftar_Picture->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
        <td <?= $Page->Logo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Logo" class="w_settings_Logo">
<span<?= $Page->Logo->viewAttributes() ?>>
<?= $Page->Logo->getViewValue() ?></span>
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
