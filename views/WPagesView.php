<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WPagesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_pagesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fw_pagesview = currentForm = new ew.Form("fw_pagesview", "view");
    loadjs.done("fw_pagesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.w_pages) ew.vars.tables.w_pages = <?= JsonEncode(GetClientVar("tables", "w_pages")) ?>;
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
<form name="fw_pagesview" id="fw_pagesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_pages">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->page_name->Visible) { // page_name ?>
    <tr id="r_page_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pages_page_name"><?= $Page->page_name->caption() ?></span></td>
        <td data-name="page_name" <?= $Page->page_name->cellAttributes() ?>>
<span id="el_w_pages_page_name">
<span<?= $Page->page_name->viewAttributes() ?>>
<?= $Page->page_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->page_content->Visible) { // page_content ?>
    <tr id="r_page_content">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pages_page_content"><?= $Page->page_content->caption() ?></span></td>
        <td data-name="page_content" <?= $Page->page_content->cellAttributes() ?>>
<span id="el_w_pages_page_content">
<span<?= $Page->page_content->viewAttributes() ?>>
<?= $Page->page_content->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->custom_url->Visible) { // custom_url ?>
    <tr id="r_custom_url">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pages_custom_url"><?= $Page->custom_url->caption() ?></span></td>
        <td data-name="custom_url" <?= $Page->custom_url->cellAttributes() ?>>
<span id="el_w_pages_custom_url">
<span<?= $Page->custom_url->viewAttributes() ?>>
<?= $Page->custom_url->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->external_link->Visible) { // external_link ?>
    <tr id="r_external_link">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pages_external_link"><?= $Page->external_link->caption() ?></span></td>
        <td data-name="external_link" <?= $Page->external_link->cellAttributes() ?>>
<span id="el_w_pages_external_link">
<span<?= $Page->external_link->viewAttributes() ?>>
<?= $Page->external_link->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_date->Visible) { // updated_date ?>
    <tr id="r_updated_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pages_updated_date"><?= $Page->updated_date->caption() ?></span></td>
        <td data-name="updated_date" <?= $Page->updated_date->cellAttributes() ?>>
<span id="el_w_pages_updated_date">
<span<?= $Page->updated_date->viewAttributes() ?>>
<?= $Page->updated_date->getViewValue() ?></span>
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
