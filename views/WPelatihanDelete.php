<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WPelatihanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_pelatihandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fw_pelatihandelete = currentForm = new ew.Form("fw_pelatihandelete", "delete");
    loadjs.done("fw_pelatihandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.w_pelatihan) ew.vars.tables.w_pelatihan = <?= JsonEncode(GetClientVar("tables", "w_pelatihan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_pelatihandelete" id="fw_pelatihandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_pelatihan">
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
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <th class="<?= $Page->pelatihan_id->headerCellClass() ?>"><span id="elh_w_pelatihan_pelatihan_id" class="w_pelatihan_pelatihan_id"><?= $Page->pelatihan_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jenis_pelatihan->Visible) { // jenis_pelatihan ?>
        <th class="<?= $Page->jenis_pelatihan->headerCellClass() ?>"><span id="elh_w_pelatihan_jenis_pelatihan" class="w_pelatihan_jenis_pelatihan"><?= $Page->jenis_pelatihan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
        <th class="<?= $Page->judul_pelatihan->headerCellClass() ?>"><span id="elh_w_pelatihan_judul_pelatihan" class="w_pelatihan_judul_pelatihan"><?= $Page->judul_pelatihan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah_hari->Visible) { // jumlah_hari ?>
        <th class="<?= $Page->jumlah_hari->headerCellClass() ?>"><span id="elh_w_pelatihan_jumlah_hari" class="w_pelatihan_jumlah_hari"><?= $Page->jumlah_hari->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tempat->Visible) { // tempat ?>
        <th class="<?= $Page->tempat->headerCellClass() ?>"><span id="elh_w_pelatihan_tempat" class="w_pelatihan_tempat"><?= $Page->tempat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah_peserta->Visible) { // jumlah_peserta ?>
        <th class="<?= $Page->jumlah_peserta->headerCellClass() ?>"><span id="elh_w_pelatihan_jumlah_peserta" class="w_pelatihan_jumlah_peserta"><?= $Page->jumlah_peserta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th class="<?= $Page->sisa->headerCellClass() ?>"><span id="elh_w_pelatihan_sisa" class="w_pelatihan_sisa"><?= $Page->sisa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <th class="<?= $Page->harga->headerCellClass() ?>"><span id="elh_w_pelatihan_harga" class="w_pelatihan_harga"><?= $Page->harga->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
        <th class="<?= $Page->tanggal_pelaksanaan->headerCellClass() ?>"><span id="elh_w_pelatihan_tanggal_pelaksanaan" class="w_pelatihan_tanggal_pelaksanaan"><?= $Page->tanggal_pelaksanaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <th class="<?= $Page->gambar->headerCellClass() ?>"><span id="elh_w_pelatihan_gambar" class="w_pelatihan_gambar"><?= $Page->gambar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <th class="<?= $Page->kategori->headerCellClass() ?>"><span id="elh_w_pelatihan_kategori" class="w_pelatihan_kategori"><?= $Page->kategori->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
        <th class="<?= $Page->Activated->headerCellClass() ?>"><span id="elh_w_pelatihan_Activated" class="w_pelatihan_Activated"><?= $Page->Activated->caption() ?></span></th>
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
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
        <td <?= $Page->pelatihan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_pelatihan_id" class="w_pelatihan_pelatihan_id">
<span<?= $Page->pelatihan_id->viewAttributes() ?>>
<?= $Page->pelatihan_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jenis_pelatihan->Visible) { // jenis_pelatihan ?>
        <td <?= $Page->jenis_pelatihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_jenis_pelatihan" class="w_pelatihan_jenis_pelatihan">
<span<?= $Page->jenis_pelatihan->viewAttributes() ?>>
<?= $Page->jenis_pelatihan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
        <td <?= $Page->judul_pelatihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_judul_pelatihan" class="w_pelatihan_judul_pelatihan">
<span<?= $Page->judul_pelatihan->viewAttributes() ?>>
<?= $Page->judul_pelatihan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah_hari->Visible) { // jumlah_hari ?>
        <td <?= $Page->jumlah_hari->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_jumlah_hari" class="w_pelatihan_jumlah_hari">
<span<?= $Page->jumlah_hari->viewAttributes() ?>>
<?= $Page->jumlah_hari->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tempat->Visible) { // tempat ?>
        <td <?= $Page->tempat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_tempat" class="w_pelatihan_tempat">
<span<?= $Page->tempat->viewAttributes() ?>>
<?= $Page->tempat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah_peserta->Visible) { // jumlah_peserta ?>
        <td <?= $Page->jumlah_peserta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_jumlah_peserta" class="w_pelatihan_jumlah_peserta">
<span<?= $Page->jumlah_peserta->viewAttributes() ?>>
<?= $Page->jumlah_peserta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <td <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_sisa" class="w_pelatihan_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <td <?= $Page->harga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_harga" class="w_pelatihan_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
        <td <?= $Page->tanggal_pelaksanaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_tanggal_pelaksanaan" class="w_pelatihan_tanggal_pelaksanaan">
<span<?= $Page->tanggal_pelaksanaan->viewAttributes() ?>>
<?= $Page->tanggal_pelaksanaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <td <?= $Page->gambar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_gambar" class="w_pelatihan_gambar">
<span>
<?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <td <?= $Page->kategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_kategori" class="w_pelatihan_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
        <td <?= $Page->Activated->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_pelatihan_Activated" class="w_pelatihan_Activated">
<span<?= $Page->Activated->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
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
