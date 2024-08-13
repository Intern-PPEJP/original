<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WPagesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_pagesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fw_pagesdelete = currentForm = new ew.Form("fw_pagesdelete", "delete");
    loadjs.done("fw_pagesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.w_pages) ew.vars.tables.w_pages = <?= JsonEncode(GetClientVar("tables", "w_pages")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_pagesdelete" id="fw_pagesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_pages">
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
<?php if ($Page->page_id->Visible) { // page_id ?>
        <th class="<?= $Page->page_id->headerCellClass() ?>"><span id="elh_w_pages_page_id" class="w_pages_page_id"><?= $Page->page_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->page_name->Visible) { // page_name ?>
        <th class="<?= $Page->page_name->headerCellClass() ?>"><span id="elh_w_pages_page_name" class="w_pages_page_name"><?= $Page->page_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->custom_url->Visible) { // custom_url ?>
        <th class="<?= $Page->custom_url->headerCellClass() ?>"><span id="elh_w_pages_custom_url" class="w_pages_custom_url"><?= $Page->custom_url->caption() ?></span></th>
<?php } ?>
<?php if ($Page->external_link->Visible) { // external_link ?>
        <th class="<?= $Page->external_link->headerCellClass() ?>"><span id="elh_w_pages_external_link" class="w_pages_external_link"><?= $Page->external_link->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_date->Visible) { // updated_date ?>
        <th class="<?= $Page->updated_date->headerCellClass() ?>"><span id="elh_w_pages_updated_date" class="w_pages_updated_date"><?= $Page->updated_date->caption() ?></span></th>
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
<?php if ($Page->page_id->Visible) { // page_id ?>
        <td <?= $Page->page_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pages_page_id" class="w_pages_page_id">
<span<?= $Page->page_id->viewAttributes() ?>>
<?= $Page->page_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->page_name->Visible) { // page_name ?>
        <td <?= $Page->page_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pages_page_name" class="w_pages_page_name">
<span<?= $Page->page_name->viewAttributes() ?>>
<?= $Page->page_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->custom_url->Visible) { // custom_url ?>
        <td <?= $Page->custom_url->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pages_custom_url" class="w_pages_custom_url">
<span<?= $Page->custom_url->viewAttributes() ?>>
<?= $Page->custom_url->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->external_link->Visible) { // external_link ?>
        <td <?= $Page->external_link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pages_external_link" class="w_pages_external_link">
<span<?= $Page->external_link->viewAttributes() ?>>
<?= $Page->external_link->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_date->Visible) { // updated_date ?>
        <td <?= $Page->updated_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pages_updated_date" class="w_pages_updated_date">
<span<?= $Page->updated_date->viewAttributes() ?>>
<?= $Page->updated_date->getViewValue() ?></span>
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
