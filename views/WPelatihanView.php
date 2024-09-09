<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WPelatihanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
    <style>
    /* Mengatur ukuran dan gaya untuk heading */
    h1, h2, h3 {
        font-family: 'Poppins', sans-serif !important; /* Font Poppins */
        font-weight: 600 !important; /* Font tebal */
    }

    h1 {
        font-size: 25px !important;
        margin-bottom: 15px !important;
    }

    h2 {
        font-size: 20px !important;
        margin-bottom: 12px !important;
    }

    h3 {
        font-size: 18px !important;
        margin-bottom: 10px !important;
    }
        
    /* Teks dalam class text-justify */
    .text-justify {
        text-align: justify !important;
        font-size: 16px !important;
    }
    </style>

    <script>
        var currentForm, currentPageID;
        var fw_pelatihanview;
        loadjs.ready("head", function() {
            var $ = jQuery;
            // Form object
            currentPageID = ew.PAGE_ID = "view";
            fw_pelatihanview = currentForm = new ew.Form("fw_pelatihanview", "view");
            loadjs.done("fw_pelatihanview");
        });
    </script>
    <script>
        loadjs.ready("head", function() {
            // Write your table-specific client script here, no need to add script tags.
        });
    </script>
<?php } ?>
<script>
    if (!ew.vars.tables.w_pelatihan) ew.vars.tables.w_pelatihan = <?= JsonEncode(GetClientVar("tables", "w_pelatihan")) ?>;
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
<form name="fw_pelatihanview" id="fw_pelatihanview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
    <?php if (Config("CHECK_TOKEN")) { ?>
        <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
        <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
    <?php } ?>
    <input type="hidden" name="t" value="w_pelatihan">
    <input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
    <table class="table table-striped table-sm ew-view-table d-none">
        <?php if ($Page->pelatihan_id->Visible) { // pelatihan_id 
        ?>
            <tr id="r_pelatihan_id">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_pelatihan_id"><template id="tpc_w_pelatihan_pelatihan_id"><?= $Page->pelatihan_id->caption() ?></template></span></td>
                <td data-name="pelatihan_id" <?= $Page->pelatihan_id->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_pelatihan_id"><span id="el_w_pelatihan_pelatihan_id">
                            <span<?= $Page->pelatihan_id->viewAttributes() ?>>
                                <?= $Page->pelatihan_id->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->jenis_pelatihan->Visible) { // jenis_pelatihan 
        ?>
            <tr id="r_jenis_pelatihan">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_jenis_pelatihan"><template id="tpc_w_pelatihan_jenis_pelatihan"><?= $Page->jenis_pelatihan->caption() ?></template></span></td>
                <td data-name="jenis_pelatihan" <?= $Page->jenis_pelatihan->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_jenis_pelatihan"><span id="el_w_pelatihan_jenis_pelatihan">
                            <span<?= $Page->jenis_pelatihan->viewAttributes() ?>>
                                <?= $Page->jenis_pelatihan->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan 
        ?>
            <tr id="r_judul_pelatihan">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_judul_pelatihan"><template id="tpc_w_pelatihan_judul_pelatihan"><?= $Page->judul_pelatihan->caption() ?></template></span></td>
                <td data-name="judul_pelatihan" <?= $Page->judul_pelatihan->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_judul_pelatihan"><span id="el_w_pelatihan_judul_pelatihan">
                            <span<?= $Page->judul_pelatihan->viewAttributes() ?>>
                                <?= $Page->judul_pelatihan->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->jumlah_hari->Visible) { // jumlah_hari 
        ?>
            <tr id="r_jumlah_hari">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_jumlah_hari"><template id="tpc_w_pelatihan_jumlah_hari"><?= $Page->jumlah_hari->caption() ?></template></span></td>
                <td data-name="jumlah_hari" <?= $Page->jumlah_hari->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_jumlah_hari"><span id="el_w_pelatihan_jumlah_hari">
                            <span<?= $Page->jumlah_hari->viewAttributes() ?>>
                                <?= $Page->jumlah_hari->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->tempat->Visible) { // tempat 
        ?>
            <tr id="r_tempat">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_tempat"><template id="tpc_w_pelatihan_tempat"><?= $Page->tempat->caption() ?></template></span></td>
                <td data-name="tempat" <?= $Page->tempat->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_tempat"><span id="el_w_pelatihan_tempat">
                            <span<?= $Page->tempat->viewAttributes() ?>>
                                <?= $Page->tempat->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->jumlah_peserta->Visible) { // jumlah_peserta 
        ?>
            <tr id="r_jumlah_peserta">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_jumlah_peserta"><template id="tpc_w_pelatihan_jumlah_peserta"><?= $Page->jumlah_peserta->caption() ?></template></span></td>
                <td data-name="jumlah_peserta" <?= $Page->jumlah_peserta->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_jumlah_peserta"><span id="el_w_pelatihan_jumlah_peserta">
                            <span<?= $Page->jumlah_peserta->viewAttributes() ?>>
                                <?= $Page->jumlah_peserta->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->sisa->Visible) { // sisa 
        ?>
            <tr id="r_sisa">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_sisa"><template id="tpc_w_pelatihan_sisa"><?= $Page->sisa->caption() ?></template></span></td>
                <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_sisa"><span id="el_w_pelatihan_sisa">
                            <span<?= $Page->sisa->viewAttributes() ?>>
                                <?= $Page->sisa->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->harga->Visible) { // harga 
        ?>
            <tr id="r_harga">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_harga"><template id="tpc_w_pelatihan_harga"><?= $Page->harga->caption() ?></template></span></td>
                <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_harga"><span id="el_w_pelatihan_harga">
                            <span<?= $Page->harga->viewAttributes() ?>>
                                <?= $Page->harga->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->tawal->Visible) { // tawal 
        ?>
            <tr id="r_tawal">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_tawal"><template id="tpc_w_pelatihan_tawal"><?= $Page->tawal->caption() ?></template></span></td>
                <td data-name="tawal" <?= $Page->tawal->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_tawal"><span id="el_w_pelatihan_tawal">
                            <span<?= $Page->tawal->viewAttributes() ?>>
                                <?= $Page->tawal->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->takhir->Visible) { // takhir 
        ?>
            <tr id="r_takhir">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_takhir"><template id="tpc_w_pelatihan_takhir"><?= $Page->takhir->caption() ?></template></span></td>
                <td data-name="takhir" <?= $Page->takhir->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_takhir"><span id="el_w_pelatihan_takhir">
                            <span<?= $Page->takhir->viewAttributes() ?>>
                                <?= $Page->takhir->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan 
        ?>
            <tr id="r_tanggal_pelaksanaan">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_tanggal_pelaksanaan"><template id="tpc_w_pelatihan_tanggal_pelaksanaan"><?= $Page->tanggal_pelaksanaan->caption() ?></template></span></td>
                <td data-name="tanggal_pelaksanaan" <?= $Page->tanggal_pelaksanaan->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_tanggal_pelaksanaan"><span id="el_w_pelatihan_tanggal_pelaksanaan">
                            <span<?= $Page->tanggal_pelaksanaan->viewAttributes() ?>>
                                <?= $Page->tanggal_pelaksanaan->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->gambar->Visible) { // gambar 
        ?>
            <tr id="r_gambar">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_gambar"><template id="tpc_w_pelatihan_gambar"><?= $Page->gambar->caption() ?></template></span></td>
                <td data-name="gambar" <?= $Page->gambar->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_gambar"><span id="el_w_pelatihan_gambar">
                            <span>
                                <?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
                            </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->kategori->Visible) { // kategori 
        ?>
            <tr id="r_kategori">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_kategori"><template id="tpc_w_pelatihan_kategori"><?= $Page->kategori->caption() ?></template></span></td>
                <td data-name="kategori" <?= $Page->kategori->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_kategori"><span id="el_w_pelatihan_kategori">
                            <span<?= $Page->kategori->viewAttributes() ?>>
                                <?= $Page->kategori->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->tujuan->Visible) { // tujuan 
        ?>
            <tr id="r_tujuan">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_tujuan"><template id="tpc_w_pelatihan_tujuan"><?= $Page->tujuan->caption() ?></template></span></td>
                <td data-name="tujuan" <?= $Page->tujuan->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_tujuan"><span id="el_w_pelatihan_tujuan">
                            <span<?= $Page->tujuan->viewAttributes() ?>>
                                <?= $Page->tujuan->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->sub_kategori->Visible) { // sub_kategori 
        ?>
            <tr id="r_sub_kategori">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_sub_kategori"><template id="tpc_w_pelatihan_sub_kategori"><?= $Page->sub_kategori->caption() ?></template></span></td>
                <td data-name="sub_kategori" <?= $Page->sub_kategori->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_sub_kategori"><span id="el_w_pelatihan_sub_kategori">
                            <span<?= $Page->sub_kategori->viewAttributes() ?>>
                                <?= $Page->sub_kategori->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->topik_bahasan->Visible) { // topik_bahasan 
        ?>
            <tr id="r_topik_bahasan">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_topik_bahasan"><template id="tpc_w_pelatihan_topik_bahasan"><?= $Page->topik_bahasan->caption() ?></template></span></td>
                <td data-name="topik_bahasan" <?= $Page->topik_bahasan->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_topik_bahasan"><span id="el_w_pelatihan_topik_bahasan">
                            <span<?= $Page->topik_bahasan->viewAttributes() ?>>
                                <?= $Page->topik_bahasan->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->catatan->Visible) { // catatan 
        ?>
            <tr id="r_catatan">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_catatan"><template id="tpc_w_pelatihan_catatan"><?= $Page->catatan->caption() ?></template></span></td>
                <td data-name="catatan" <?= $Page->catatan->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_catatan"><span id="el_w_pelatihan_catatan">
                            <span<?= $Page->catatan->viewAttributes() ?>>
                                <?= $Page->catatan->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->Link->Visible) { // Link 
        ?>
            <tr id="r_Link">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_Link"><template id="tpc_w_pelatihan_Link"><?= $Page->Link->caption() ?></template></span></td>
                <td data-name="Link" <?= $Page->Link->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_Link"><span id="el_w_pelatihan_Link">
                            <span<?= $Page->Link->viewAttributes() ?>>
                                <?= $Page->Link->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->Last_Updated->Visible) { // Last_Updated 
        ?>
            <tr id="r_Last_Updated">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_Last_Updated"><template id="tpc_w_pelatihan_Last_Updated"><?= $Page->Last_Updated->caption() ?></template></span></td>
                <td data-name="Last_Updated" <?= $Page->Last_Updated->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_Last_Updated"><span id="el_w_pelatihan_Last_Updated">
                            <span<?= $Page->Last_Updated->viewAttributes() ?>>
                                <?= $Page->Last_Updated->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->Created_Date->Visible) { // Created_Date 
        ?>
            <tr id="r_Created_Date">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_Created_Date"><template id="tpc_w_pelatihan_Created_Date"><?= $Page->Created_Date->caption() ?></template></span></td>
                <td data-name="Created_Date" <?= $Page->Created_Date->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_Created_Date"><span id="el_w_pelatihan_Created_Date">
                            <span<?= $Page->Created_Date->viewAttributes() ?>>
                                <?= $Page->Created_Date->getViewValue() ?>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
        <?php if ($Page->Activated->Visible) { // Activated 
        ?>
            <tr id="r_Activated">
                <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_w_pelatihan_Activated"><template id="tpc_w_pelatihan_Activated"><?= $Page->Activated->caption() ?></template></span></td>
                <td data-name="Activated" <?= $Page->Activated->cellAttributes() ?>>
                    <template id="tpx_w_pelatihan_Activated"><span id="el_w_pelatihan_Activated">
                            <span<?= $Page->Activated->viewAttributes() ?>>
                                <div class="custom-control custom-checkbox d-inline-block">
                                    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
                                    <label class="custom-control-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
                                </div>
                        </span>
                        </span></template>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div id="tpd_w_pelatihanview" class="ew-custom-template"></div>
    <template id="tpm_w_pelatihanview">
        <div id="ct_WPelatihanView"><?php echo myheader(); ?>
            <style>
                #fw_pelatihanview {
                    width: 100%;
                }

                @media screen and (max-width: 768px) {

                    /* mobile view */
                    .pel-lain {
                        width: 100% !important;
                    }
                }

                .ew-toolbar {
                    display: none;
                }
            </style>
            <?php
            $jenis_pelatihan = ExecuteScalar("SELECT `jenis_pelatihan` FROM `w_pelatihan` WHERE `pelatihan_id` = " . $Page->pelatihan_id->getViewValue());
            if ($jenis_pelatihan == "ecp") {
                $judul_halaman = "EXPORT COACHING PROGRAM";
            } else if ($jenis_pelatihan == "webinar") {
                $judul_halaman = "WEBINAR";
            } else if ($jenis_pelatihan == "obrolan_ekspor") {
                $judul_halaman = "OBROLAN EKSPOR";
            } else if ($jenis_pelatihan == "sert_kompetensi") {
                $judul_halaman = "SERTIFIKASI";
            } else {
                $judul_halaman = "PELATIHAN";
            }
            ?>
            <div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="m-0" style="color: white;font-weight:bold">DETAIL <?= $judul_halaman; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row my-5">
                    <div class="col-md-5">
                        <div class="col-12 mr-3 mb-3" style="box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);padding: 19px">
                            <?= GetFileViewTag($Page->gambar, $Page->gambar->getViewValue(), false) ?>
                            <div class="py-1"><?= $Page->judul_pelatihan->getViewValue() ?></div>
                            <?php if ($jenis_pelatihan != "webinar") { ?>
                                <div class="row mb-1">
                                    <div class="col-1">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-10"><?= $Page->jumlah_hari->getViewValue() ?></div>
                                </div>
                            <?php } //penutup webinar 
                            ?>
                            <div class="row mb-1">
                                <div class="col-1">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                </div>
                                <div class="col-10"><?= $Page->tempat->getViewValue() ?></div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-1">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </div>
                                <div class="col-10"><?= $Page->jumlah_peserta->getViewValue() ?> orang</div>
                            </div>
                            <?php if ($jenis_pelatihan != "webinar") { ?>
                                <div class="row mb-3">
                                    <div class="col-1">
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-10"><?= $Page->harga->getViewValue() ?></div>
                                </div>
                            <?php } //penutup webinar 
                            ?>
                            <hr>
                            <p>Tanggal Pelaksanaan</p>
                            <div class="row mb-3" style="margin:5px;">
                                <div class="col-7" style="font-size:18px;border:1px solid #222222;padding:5px;border-right:none;border-radius:0.25rem 0 0 0.25rem;">
                                    <div class="col-10"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?= $Page->tanggal_pelaksanaan->getViewValue() ?></div>
                                </div>
                                <div class="col-5" style="font-size:18px;border:1px solid #222222;padding:5px;border-radius:0 0.25rem 0.25rem 0;">
                                    <?php
                                    $peserta_terdaftar = ExecuteScalar("SELECT COUNT(1) FROM `w_orders` WHERE `pelatihan_id` = " . $Page->pelatihan_id->getViewValue());
                                    $sisa = $Page->sisa->getViewValue();
                                    ?>
                                    <?php if ($Page->sisa->getViewValue() > 0 && strtotime($Page->tawal->CurrentValue) > strtotime(date("Y-m-d"))) { ?>
                                        <i class="fa fa-user" aria-hidden="true"></i> Sisa <?= $sisa ?> orang
                                    <?php } else { ?>
                                        <i class="fa fa-user" aria-hidden="true"></i> <span class="badge badge-danger">Fully Booked</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if ($Page->sisa->getViewValue() > 0 && strtotime($Page->tawal->CurrentValue) > strtotime(date("Y-m-d"))) { ?>
                                <a href="<?= GetUrl('formpendaftaran?r=' . $Page->pelatihan_id->getViewValue()) ?>" class="btn btn-success btn-block btn-lg">Registrasi</a>
                            <?php } else { ?>
                                <span class="btn btn-danger btn-block" style="pointer-events:none">Registrasi Ditutup</a>
                                <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h2><?= $Page->judul_pelatihan->getViewValue() ?></h2>
                        <div class="mb-2 text-justify">
                            <?php if ($jenis_pelatihan != "webinar") { ?>
                                Kategori : <?= $Page->kategori->getViewValue() ?> <br>
                                Sub Kategori : <?= $Page->sub_kategori->getViewValue() ?> <br><br>
                                <?php if ($Page->tujuan->getViewValue() != NULL) { ?>Tujuan : <br><?= $Page->tujuan->getViewValue() ?> <br><br> <?php } ?>
                        <?php } //penutup webinar 
                        ?>
                        Topik Bahasan : <br><?= $Page->topik_bahasan->getViewValue() ?> <br>
                        <div><?php if ($Page->catatan->getViewValue() != NULL) { ?>Catatan : <br><?= $Page->catatan->getViewValue() ?><?php } ?>
                        </div>
                        </div>
                    </div>
                    <section class="pt-5 pb-2">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a class="btn btn-success mb-3 mr-1" href="#carouselProducts" role="button" data-slide="prev" style="position:absolute;left:12px;top:0;">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                    <h3 class="mb-3 text-bold">Pelatihan Lainnya</h3>
                                    <a class="btn btn-success mb-3" href="#carouselProducts" role="button" data-slide="next" style="position:absolute;right:25px;top:0">
                                        <i class="fa fa-arrow-right"></i>
                                    </a><br>
                                </div>

                                <div id="carouselProducts" class="carousel slide" data-ride="carousel" data-interval="5000">
                                    <div class="carousel-inner" role="listbox">
                                        <?php
                                        $rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`,`tawal`, `jumlah_hari`, `tempat`, `jumlah_peserta`, `sisa`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` 
                        FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') 
                        ORDER BY CASE WHEN `sisa` > 0 THEN 1 ELSE 2 END, `tawal` ASC");
                                        $i = 0;
                                        while ($row = $rs->fetch()) {
                                            if ($i % 3 == 0) { // Membuka item baru setiap 3 container
                                                echo '<div class="carousel-item ' . ($i == 0 ? 'active' : '') . '"><div class="row">';
                                            }
                                        ?>
                                            <div class="col-md-4">
                                                <div class="card" style="padding:0;border:0;box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);">
                                                    <img class="img-fluid" alt="100%x220" style="height:220px !important;border-radius:8px 8px 0 0 !important;" src="files/<?php echo $row["gambar"]; ?>">
                                                    <div class="card-body m-0 p-1">
                                                        <h3 class="card-title" style="height:40px; font-size: 18px; font-weight: bold;"><?php echo $row["judul_pelatihan"]; ?></h3>
                                                        <table class="table p-0 m-0" style="font-size:.8em">
                                                            <tr>
                                                                <td width="60%" valign="middle"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $row["jumlah_hari"]; ?></td>
                                                                <td width="40%" valign="middle"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $row["tempat"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="fa fa-users" aria-hidden="true"></i> <?php echo $row["jumlah_peserta"]; ?> Orang</td>
                                                                <td><i class="fa fa-money" aria-hidden="true"></i> <?php echo rupiah($row["harga"]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?php echo $row["tanggal_pelaksanaan"]; ?></td>
                                                                <td><i class="fa fa-user" aria-hidden="true"></i>
                                                                    <?php if ($row["sisa"] > 0 && strtotime($row["tawal"]) > strtotime(date("Y-m-d"))) { ?>
                                                                        <span class="text-danger">Sisa <?php echo $row["sisa"]; ?> Kursi</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge badge-danger">Fully Booked</span>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="card-footer"><a href="<?= GetUrl('detail-pelatihan/view/' . $row["pelatihan_id"]) ?>" class="btn btn-success stretched-link btn-lg btn-block">Lihat Detail</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            $i++;
                                            if ($i % 3 == 0) { // Menutup item setelah 3 container
                                                echo '</div></div>';
                                            }
                                        }

                                        // Menutup item terakhir jika belum genap 3 container
                                        if ($i % 3 != 0) {
                                            echo '</div></div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                    <div class="row xslim mt-5">
                        <div class="col-12">
                            <h4 class="text-bold">Rekomendasi lainnya<h4>
                        </div>
                    </div>
                    <div class="row flex-nowrap mb-5" style="overflow-x: scroll;width:100%">
                        <?php
                        $rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_hari`,`sisa`, `tempat`, `jumlah_peserta`, `harga`, `tanggal_pelaksanaan`,`Link`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() AND `jenis_pelatihan` LIKE 'obrolan_ekspor' ORDER BY `tawal` DESC");
                        $jumlahpelatihan = 0;
                        while ($row = $rs->fetch()) {
                        ?>
                            <div class="col-md-4 " style="">
                                <a href="<?php echo $row["Link"]; ?>" target="_blank">
                                    <img src="<?= GetUrl('files/' . $row["gambar"]) ?>" style="width: 100%; height: 300px;">
                                </a>
                            </div>
                        <?php
                            $jumlahpelatihan++;
                        }
                        if ($jumlahpelatihan == 0) {
                            echo '<span class="alert alert-warning text-center">Pelatihan belum tersedia</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <script>
                document.title = "Pelatihan<?= $Page->judul_pelatihan->getViewValue() ?>"
            </script>
            <?php echo myfooter(); ?>
        </div>
    </template>
</form>
<script class="ew-apply-template">
    loadjs.ready(["jsrender", "makerjs"], function() {
        ew.templateData = {
            rows: <?= JsonEncode($Page->Rows) ?>
        };
        ew.applyTemplate("tpd_w_pelatihanview", "tpm_w_pelatihanview", "w_pelatihanview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
        loadjs.done("customtemplate");
    });
</script>
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