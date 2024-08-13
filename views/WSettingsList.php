<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WSettingsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fw_settingslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fw_settingslist = currentForm = new ew.Form("fw_settingslist", "list");
    fw_settingslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fw_settingslist");
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
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="ew-multi-column-grid">
<form name="fw_settingslist" id="fw_settingslist" class="ew-horizontal ew-form ew-list-form ew-multi-column-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_settings">
<div class="row ew-multi-column-row">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_w_settings", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
<div class="<?= $Page->getMultiColumnClass() ?>" <?= $Page->rowAttributes() ?>>
    <div class="card ew-card">
    <div class="card-body">
    <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
    <table class="table table-striped table-sm ew-view-table">
    <?php } ?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="w_settings_ID"><?= $Page->renderSort($Page->ID) ?></span></td>
            <td <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row w_settings_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->Logo->Visible) { // Logo ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="w_settings_Logo"><?= $Page->renderSort($Page->Logo) ?></span></td>
            <td <?= $Page->Logo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Logo">
<span<?= $Page->Logo->viewAttributes() ?>>
<?= GetFileViewTag($Page->Logo, $Page->Logo->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row w_settings_Logo">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->Logo->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Logo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Logo">
<span<?= $Page->Logo->viewAttributes() ?>>
<?= GetFileViewTag($Page->Logo, $Page->Logo->getViewValue(), false) ?>
</span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->Login_Picture->Visible) { // Login_Picture ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="w_settings_Login_Picture"><?= $Page->renderSort($Page->Login_Picture) ?></span></td>
            <td <?= $Page->Login_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Login_Picture">
<span<?= $Page->Login_Picture->viewAttributes() ?>>
<?= GetFileViewTag($Page->Login_Picture, $Page->Login_Picture->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row w_settings_Login_Picture">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->Login_Picture->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Login_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Login_Picture">
<span<?= $Page->Login_Picture->viewAttributes() ?>>
<?= GetFileViewTag($Page->Login_Picture, $Page->Login_Picture->getViewValue(), false) ?>
</span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->Register_Picture->Visible) { // Register_Picture ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="w_settings_Register_Picture"><?= $Page->renderSort($Page->Register_Picture) ?></span></td>
            <td <?= $Page->Register_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Register_Picture">
<span<?= $Page->Register_Picture->viewAttributes() ?>>
<?= GetFileViewTag($Page->Register_Picture, $Page->Register_Picture->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row w_settings_Register_Picture">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->Register_Picture->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Register_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Register_Picture">
<span<?= $Page->Register_Picture->viewAttributes() ?>>
<?= GetFileViewTag($Page->Register_Picture, $Page->Register_Picture->getViewValue(), false) ?>
</span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->Popup_Show->Visible) { // Popup_Show ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="w_settings_Popup_Show"><?= $Page->renderSort($Page->Popup_Show) ?></span></td>
            <td <?= $Page->Popup_Show->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Popup_Show">
<span<?= $Page->Popup_Show->viewAttributes() ?>>
<?= $Page->Popup_Show->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row w_settings_Popup_Show">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->Popup_Show->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Popup_Show->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Popup_Show">
<span<?= $Page->Popup_Show->viewAttributes() ?>>
<?= $Page->Popup_Show->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->Popup_Picture->Visible) { // Popup_Picture ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="w_settings_Popup_Picture"><?= $Page->renderSort($Page->Popup_Picture) ?></span></td>
            <td <?= $Page->Popup_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Popup_Picture">
<span<?= $Page->Popup_Picture->viewAttributes() ?>>
<?= GetFileViewTag($Page->Popup_Picture, $Page->Popup_Picture->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row w_settings_Popup_Picture">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->Popup_Picture->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Popup_Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Popup_Picture">
<span<?= $Page->Popup_Picture->viewAttributes() ?>>
<?= GetFileViewTag($Page->Popup_Picture, $Page->Popup_Picture->getViewValue(), false) ?>
</span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->Popup_Link->Visible) { // Popup_Link ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="w_settings_Popup_Link"><?= $Page->renderSort($Page->Popup_Link) ?></span></td>
            <td <?= $Page->Popup_Link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Popup_Link">
<span<?= $Page->Popup_Link->viewAttributes() ?>>
<?= $Page->Popup_Link->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row w_settings_Popup_Link">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->Popup_Link->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Popup_Link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_settings_Popup_Link">
<span<?= $Page->Popup_Link->viewAttributes() ?>>
<?= $Page->Popup_Link->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
    </table>
    <?php } ?>
    </div><!-- /.card-body -->
<?php if (!$Page->isExport()) { ?>
    <div class="card-footer">
        <div class="ew-multi-column-list-option">
<?php
// Render list options (body, bottom)
$Page->ListOptions->render("body", "bottom", $Page->RowCount);
?>
        </div><!-- /.ew-multi-column-list-option -->
        <div class="clearfix"></div>
    </div><!-- /.card-footer -->
<?php } ?>
    </div><!-- /.card -->
</div><!-- /.col-* -->
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
<?php } ?>
</div><!-- /.ew-multi-column-row -->
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
<div>
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
</div><!-- /.ew-multi-column-grid -->
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
    ew.addEventHandlers("w_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
