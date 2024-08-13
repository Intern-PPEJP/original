<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WBeritaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_beritadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fw_beritadelete = currentForm = new ew.Form("fw_beritadelete", "delete");
    loadjs.done("fw_beritadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.w_berita) ew.vars.tables.w_berita = <?= JsonEncode(GetClientVar("tables", "w_berita")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_beritadelete" id="fw_beritadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_berita">
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
<?php if ($Page->judul->Visible) { // judul ?>
        <th class="<?= $Page->judul->headerCellClass() ?>"><span id="elh_w_berita_judul" class="w_berita_judul"><?= $Page->judul->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isi->Visible) { // isi ?>
        <th class="<?= $Page->isi->headerCellClass() ?>"><span id="elh_w_berita_isi" class="w_berita_isi"><?= $Page->isi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kategori_id->Visible) { // kategori_id ?>
        <th class="<?= $Page->kategori_id->headerCellClass() ?>"><span id="elh_w_berita_kategori_id" class="w_berita_kategori_id"><?= $Page->kategori_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_publikasi->Visible) { // tanggal_publikasi ?>
        <th class="<?= $Page->tanggal_publikasi->headerCellClass() ?>"><span id="elh_w_berita_tanggal_publikasi" class="w_berita_tanggal_publikasi"><?= $Page->tanggal_publikasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->penulis->Visible) { // penulis ?>
        <th class="<?= $Page->penulis->headerCellClass() ?>"><span id="elh_w_berita_penulis" class="w_berita_penulis"><?= $Page->penulis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <th class="<?= $Page->gambar->headerCellClass() ?>"><span id="elh_w_berita_gambar" class="w_berita_gambar"><?= $Page->gambar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_w_berita_created_at" class="w_berita_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->publish->Visible) { // publish ?>
        <th class="<?= $Page->publish->headerCellClass() ?>"><span id="elh_w_berita_publish" class="w_berita_publish"><?= $Page->publish->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gambar2->Visible) { // gambar2 ?>
        <th class="<?= $Page->gambar2->headerCellClass() ?>"><span id="elh_w_berita_gambar2" class="w_berita_gambar2"><?= $Page->gambar2->caption() ?></span></th>
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
<?php if ($Page->judul->Visible) { // judul ?>
        <td <?= $Page->judul->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_judul" class="w_berita_judul">
<span<?= $Page->judul->viewAttributes() ?>>
<?= $Page->judul->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isi->Visible) { // isi ?>
        <td <?= $Page->isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_isi" class="w_berita_isi">
<span<?= $Page->isi->viewAttributes() ?>>
<?= $Page->isi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kategori_id->Visible) { // kategori_id ?>
        <td <?= $Page->kategori_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_kategori_id" class="w_berita_kategori_id">
<span<?= $Page->kategori_id->viewAttributes() ?>>
<?= $Page->kategori_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_publikasi->Visible) { // tanggal_publikasi ?>
        <td <?= $Page->tanggal_publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_tanggal_publikasi" class="w_berita_tanggal_publikasi">
<span<?= $Page->tanggal_publikasi->viewAttributes() ?>>
<?= $Page->tanggal_publikasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->penulis->Visible) { // penulis ?>
        <td <?= $Page->penulis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_penulis" class="w_berita_penulis">
<span<?= $Page->penulis->viewAttributes() ?>>
<?= $Page->penulis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
        <td <?= $Page->gambar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_gambar" class="w_berita_gambar">
<span>
<?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_created_at" class="w_berita_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->publish->Visible) { // publish ?>
        <td <?= $Page->publish->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_publish" class="w_berita_publish">
<span<?= $Page->publish->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_publish_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->publish->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->publish->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_publish_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gambar2->Visible) { // gambar2 ?>
        <td <?= $Page->gambar2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_w_berita_gambar2" class="w_berita_gambar2">
<span<?= $Page->gambar2->viewAttributes() ?>>
<?= $Page->gambar2->getViewValue() ?></span>
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
