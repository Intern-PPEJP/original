<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WBeritaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
    <script>
        var currentForm, currentPageID;
        var fw_beritaview;
        loadjs.ready("head", function() {
            var $ = jQuery;
            // Form object
            currentPageID = ew.PAGE_ID = "view";
            fw_beritaview = currentForm = new ew.Form("fw_beritaview", "view");
            loadjs.done("fw_beritaview");
        });
    </script>
    <script>
        loadjs.ready("head", function() {
            // Write your table-specific client script here, no need to add script tags.
        });
    </script>
<?php } ?>
<script>
    if (!ew.vars.tables.w_berita) ew.vars.tables.w_berita = <?= JsonEncode(GetClientVar("tables", "w_berita")) ?>;
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
<form name="fw_beritaview" id="fw_beritaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
    <?php if (Config("CHECK_TOKEN")) { ?>
        <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
        <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
    <?php } ?>
    <input type="hidden" name="t" value="w_berita">
    <input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
    <table class="table table-striped table-sm ew-view-table">
        <?php if ($Page->id->Visible) { // id 
        ?>
            <tr id="r_id">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_id"><?= $Page->id->caption() ?></span></td>
                <td data-name="id" <?= $Page->id->cellAttributes() ?>>
                    <span id="el_w_berita_id">
                        <span<?= $Page->id->viewAttributes() ?>>
                            <?= $Page->id->getViewValue() ?>
                        </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->judul->Visible) { // judul 
        ?>
            <tr id="r_judul">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_judul"><?= $Page->judul->caption() ?></span></td>
                <td data-name="judul" <?= $Page->judul->cellAttributes() ?>>
                    <span id="el_w_berita_judul">
                        <span<?= $Page->judul->viewAttributes() ?>>
                            <?= $Page->judul->getViewValue() ?>
                    </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->url_berita->Visible) { // url_berita 
        ?>
            <tr id="r_url_berita">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_url_berita"><?= $Page->url_berita->caption() ?></span></td>
                <td data-name="url_berita" <?= $Page->url_berita->cellAttributes() ?>>
                    <span id="el_w_berita_url_berita">
                        <span<?= $Page->url_berita->viewAttributes() ?>>
                            <?= $Page->url_berita->getViewValue() ?>
                    </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->isi->Visible) { // isi 
        ?>
            <tr id="r_isi">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_isi"><?= $Page->isi->caption() ?></span></td>
                <td data-name="isi" <?= $Page->isi->cellAttributes() ?>>
                    <span id="el_w_berita_isi">
                        <span<?= $Page->isi->viewAttributes() ?>>
                            <?= $Page->isi->getViewValue() ?>
                        </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->tanggal_publikasi->Visible) { // tanggal_publikasi 
        ?>
            <tr id="r_tanggal_publikasi">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_tanggal_publikasi"><?= $Page->tanggal_publikasi->caption() ?></span></td>
                <td data-name="tanggal_publikasi" <?= $Page->tanggal_publikasi->cellAttributes() ?>>
                    <span id="el_w_berita_tanggal_publikasi">
                        <span<?= $Page->tanggal_publikasi->viewAttributes() ?>>
                            <?= $Page->tanggal_publikasi->getViewValue() ?>
                    </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->penulis->Visible) { // penulis 
        ?>
            <tr id="r_penulis">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_penulis"><?= $Page->penulis->caption() ?></span></td>
                <td data-name="penulis" <?= $Page->penulis->cellAttributes() ?>>
                    <span id="el_w_berita_penulis">
                        <span<?= $Page->penulis->viewAttributes() ?>>
                            <?= $Page->penulis->getViewValue() ?>
                    </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->gambar_url->Visible) { // gambar_url 
        ?>
            <tr id="r_gambar_url">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_gambar_url"><?= $Page->gambar_url->caption() ?></span></td>
                <td data-name="gambar_url" <?= $Page->gambar_url->cellAttributes() ?>>
                    <span id="el_w_berita_gambar_url">
                        <span<?= $Page->gambar_url->viewAttributes() ?>>
                            <?= $Page->gambar_url->getViewValue() ?>
                    </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->kategori_id->Visible) { // kategori_id 
        ?>
            <tr id="r_kategori_id">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_kategori_id"><?= $Page->kategori_id->caption() ?></span></td>
                <td data-name="kategori_id" <?= $Page->kategori_id->cellAttributes() ?>>
                    <span id="el_w_berita_kategori_id">
                        <span<?= $Page->kategori_id->viewAttributes() ?>>
                            <?= $Page->kategori_id->getViewValue() ?>
                    </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->created_at->Visible) { // created_at 
        ?>
            <tr id="r_created_at">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_created_at"><?= $Page->created_at->caption() ?></span></td>
                <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
                    <span id="el_w_berita_created_at">
                        <span<?= $Page->created_at->viewAttributes() ?>>
                            <?= $Page->created_at->getViewValue() ?>
                    </span>
                    </span>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->updated_at->Visible) { // updated_at 
        ?>
            <tr id="r_updated_at">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_berita_updated_at"><?= $Page->updated_at->caption() ?></span></td>
                <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
                    <span id="el_w_berita_updated_at">
                        <span<?= $Page->updated_at->viewAttributes() ?>>
                            <?= $Page->updated_at->getViewValue() ?>
                    </span>
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
        loadjs.ready("load", function() {
            // Write your table-specific startup script here, no need to add script tags.
        });
    </script>
<?php } ?>