<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$AkunkuList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fakunkulist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fakunkulist = currentForm = new ew.Form("fakunkulist", "list");
    fakunkulist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fakunkulist");
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
<form name="fakunkulist" id="fakunkulist" class="ew-horizontal ew-form ew-list-form ew-multi-column-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="akunku">
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_akunku", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->user_id->Visible) { // user_id ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_user_id"><?= $Page->renderSort($Page->user_id) ?></span></td>
            <td <?= $Page->user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_user_id">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->user_email->Visible) { // user_email ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_user_email"><?= $Page->renderSort($Page->user_email) ?></span></td>
            <td <?= $Page->user_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_user_email">
<span<?= $Page->user_email->viewAttributes() ?>>
<?= $Page->user_email->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_user_email">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_email->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_user_email">
<span<?= $Page->user_email->viewAttributes() ?>>
<?= $Page->user_email->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->no_hp->Visible) { // no_hp ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_no_hp"><?= $Page->renderSort($Page->no_hp) ?></span></td>
            <td <?= $Page->no_hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_no_hp">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_hp->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_nama_peserta"><?= $Page->renderSort($Page->nama_peserta) ?></span></td>
            <td <?= $Page->nama_peserta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_nama_peserta">
<span<?= $Page->nama_peserta->viewAttributes() ?>>
<?= $Page->nama_peserta->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_nama_peserta">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_peserta->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_peserta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_nama_peserta">
<span<?= $Page->nama_peserta->viewAttributes() ?>>
<?= $Page->nama_peserta->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->perusahaan->Visible) { // perusahaan ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_perusahaan"><?= $Page->renderSort($Page->perusahaan) ?></span></td>
            <td <?= $Page->perusahaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_perusahaan">
<span<?= $Page->perusahaan->viewAttributes() ?>>
<?= $Page->perusahaan->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_perusahaan">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->perusahaan->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perusahaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_perusahaan">
<span<?= $Page->perusahaan->viewAttributes() ?>>
<?= $Page->perusahaan->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->jabatan->Visible) { // jabatan ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_jabatan"><?= $Page->renderSort($Page->jabatan) ?></span></td>
            <td <?= $Page->jabatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_jabatan">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->provinsi->Visible) { // provinsi ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_provinsi"><?= $Page->renderSort($Page->provinsi) ?></span></td>
            <td <?= $Page->provinsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_provinsi">
<span<?= $Page->provinsi->viewAttributes() ?>>
<?= $Page->provinsi->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_provinsi">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->provinsi->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->provinsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_provinsi">
<span<?= $Page->provinsi->viewAttributes() ?>>
<?= $Page->provinsi->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->kota->Visible) { // kota ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_kota"><?= $Page->renderSort($Page->kota) ?></span></td>
            <td <?= $Page->kota->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_kota">
<span<?= $Page->kota->viewAttributes() ?>>
<?= $Page->kota->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_kota">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->kota->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kota->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_kota">
<span<?= $Page->kota->viewAttributes() ?>>
<?= $Page->kota->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->usaha->Visible) { // usaha ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_usaha"><?= $Page->renderSort($Page->usaha) ?></span></td>
            <td <?= $Page->usaha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_usaha">
<span<?= $Page->usaha->viewAttributes() ?>>
<?= $Page->usaha->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_usaha">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->usaha->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->usaha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_usaha">
<span<?= $Page->usaha->viewAttributes() ?>>
<?= $Page->usaha->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->produk->Visible) { // produk ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_produk"><?= $Page->renderSort($Page->produk) ?></span></td>
            <td <?= $Page->produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_produk">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->produk->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->last_login->Visible) { // last_login ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="akunku_last_login"><?= $Page->renderSort($Page->last_login) ?></span></td>
            <td <?= $Page->last_login->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_last_login">
<span<?= $Page->last_login->viewAttributes() ?>>
<?= $Page->last_login->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row akunku_last_login">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_login->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->last_login->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_akunku_last_login">
<span<?= $Page->last_login->viewAttributes() ?>>
<?= $Page->last_login->getViewValue() ?></span>
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
    ew.addEventHandlers("akunku");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
