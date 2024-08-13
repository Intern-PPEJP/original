<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$ArtikelView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fartikelview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fartikelview = currentForm = new ew.Form("fartikelview", "view");
    loadjs.done("fartikelview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.artikel) ew.vars.tables.artikel = <?= JsonEncode(GetClientVar("tables", "artikel")) ?>;
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
<form name="fartikelview" id="fartikelview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="artikel">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_artikel_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
    <tr id="r_gambar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_gambar"><?= $Page->gambar->caption() ?></span></td>
        <td data-name="gambar" <?= $Page->gambar->cellAttributes() ?>>
<span id="el_artikel_gambar">
<span>
<?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->judul->Visible) { // judul ?>
    <tr id="r_judul">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_judul"><?= $Page->judul->caption() ?></span></td>
        <td data-name="judul" <?= $Page->judul->cellAttributes() ?>>
<span id="el_artikel_judul">
<span<?= $Page->judul->viewAttributes() ?>>
<?= $Page->judul->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->url_berita->Visible) { // url_berita ?>
    <tr id="r_url_berita">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_url_berita"><?= $Page->url_berita->caption() ?></span></td>
        <td data-name="url_berita" <?= $Page->url_berita->cellAttributes() ?>>
<span id="el_artikel_url_berita">
<span<?= $Page->url_berita->viewAttributes() ?>>
<?= $Page->url_berita->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isi->Visible) { // isi ?>
    <tr id="r_isi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_isi"><?= $Page->isi->caption() ?></span></td>
        <td data-name="isi" <?= $Page->isi->cellAttributes() ?>>
<span id="el_artikel_isi">
<span<?= $Page->isi->viewAttributes() ?>>
<?= $Page->isi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategori_id->Visible) { // kategori_id ?>
    <tr id="r_kategori_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_kategori_id"><?= $Page->kategori_id->caption() ?></span></td>
        <td data-name="kategori_id" <?= $Page->kategori_id->cellAttributes() ?>>
<span id="el_artikel_kategori_id">
<span<?= $Page->kategori_id->viewAttributes() ?>>
<?= $Page->kategori_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_publikasi->Visible) { // tanggal_publikasi ?>
    <tr id="r_tanggal_publikasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_tanggal_publikasi"><?= $Page->tanggal_publikasi->caption() ?></span></td>
        <td data-name="tanggal_publikasi" <?= $Page->tanggal_publikasi->cellAttributes() ?>>
<span id="el_artikel_tanggal_publikasi">
<span<?= $Page->tanggal_publikasi->viewAttributes() ?>>
<?= $Page->tanggal_publikasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->penulis->Visible) { // penulis ?>
    <tr id="r_penulis">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_artikel_penulis"><?= $Page->penulis->caption() ?></span></td>
        <td data-name="penulis" <?= $Page->penulis->cellAttributes() ?>>
<span id="el_artikel_penulis">
<span<?= $Page->penulis->viewAttributes() ?>>
<?= $Page->penulis->getViewValue() ?></span>
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
