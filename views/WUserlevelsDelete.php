<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WUserlevelsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_userlevelsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fw_userlevelsdelete = currentForm = new ew.Form("fw_userlevelsdelete", "delete");
    loadjs.done("fw_userlevelsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.w_userlevels) ew.vars.tables.w_userlevels = <?= JsonEncode(GetClientVar("tables", "w_userlevels")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_userlevelsdelete" id="fw_userlevelsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_userlevels">
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
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <th class="<?= $Page->userlevelid->headerCellClass() ?>"><span id="elh_w_userlevels_userlevelid" class="w_userlevels_userlevelid"><?= $Page->userlevelid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
        <th class="<?= $Page->userlevelname->headerCellClass() ?>"><span id="elh_w_userlevels_userlevelname" class="w_userlevels_userlevelname"><?= $Page->userlevelname->caption() ?></span></th>
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
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <td <?= $Page->userlevelid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_userlevels_userlevelid" class="w_userlevels_userlevelid">
<span<?= $Page->userlevelid->viewAttributes() ?>>
<?= $Page->userlevelid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
        <td <?= $Page->userlevelname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_userlevels_userlevelname" class="w_userlevels_userlevelname">
<span<?= $Page->userlevelname->viewAttributes() ?>>
<?= $Page->userlevelname->getViewValue() ?></span>
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
