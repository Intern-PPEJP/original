<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WSettingsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_settingsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fw_settingsview = currentForm = new ew.Form("fw_settingsview", "view");
    loadjs.done("fw_settingsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.w_settings) ew.vars.tables.w_settings = <?= JsonEncode(GetClientVar("tables", "w_settings")) ?>;
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
<form name="fw_settingsview" id="fw_settingsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_settings">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_settings_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el_w_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_ID_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->ID->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->ID->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_ID_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Login_Picture->Visible) { // Login_Picture ?>
    <tr id="r_Login_Picture">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_settings_Login_Picture"><?= $Page->Login_Picture->caption() ?></span></td>
        <td data-name="Login_Picture" <?= $Page->Login_Picture->cellAttributes() ?>>
<span id="el_w_settings_Login_Picture">
<span<?= $Page->Login_Picture->viewAttributes() ?>>
<?= $Page->Login_Picture->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Daftar_Picture->Visible) { // Daftar_Picture ?>
    <tr id="r_Daftar_Picture">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_settings_Daftar_Picture"><?= $Page->Daftar_Picture->caption() ?></span></td>
        <td data-name="Daftar_Picture" <?= $Page->Daftar_Picture->cellAttributes() ?>>
<span id="el_w_settings_Daftar_Picture">
<span<?= $Page->Daftar_Picture->viewAttributes() ?>>
<?= $Page->Daftar_Picture->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
    <tr id="r_Logo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_settings_Logo"><?= $Page->Logo->caption() ?></span></td>
        <td data-name="Logo" <?= $Page->Logo->cellAttributes() ?>>
<span id="el_w_settings_Logo">
<span<?= $Page->Logo->viewAttributes() ?>>
<?= $Page->Logo->getViewValue() ?></span>
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
