<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$KonfimasiPembayaranView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fkonfimasi_pembayaranview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fkonfimasi_pembayaranview = currentForm = new ew.Form("fkonfimasi_pembayaranview", "view");
    loadjs.done("fkonfimasi_pembayaranview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.konfimasi_pembayaran) ew.vars.tables.konfimasi_pembayaran = <?= JsonEncode(GetClientVar("tables", "konfimasi_pembayaran")) ?>;
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
<form name="fkonfimasi_pembayaranview" id="fkonfimasi_pembayaranview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="konfimasi_pembayaran">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->order_id->Visible) { // order_id ?>
    <tr id="r_order_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfimasi_pembayaran_order_id"><template id="tpc_konfimasi_pembayaran_order_id"><?= $Page->order_id->caption() ?></template></span></td>
        <td data-name="order_id" <?= $Page->order_id->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_order_id"><span id="el_konfimasi_pembayaran_order_id">
<span<?= $Page->order_id->viewAttributes() ?>>
<?= $Page->order_id->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
    <tr id="r_judul_pelatihan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfimasi_pembayaran_judul_pelatihan"><template id="tpc_konfimasi_pembayaran_judul_pelatihan"><?= $Page->judul_pelatihan->caption() ?></template></span></td>
        <td data-name="judul_pelatihan" <?= $Page->judul_pelatihan->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_judul_pelatihan"><span id="el_konfimasi_pembayaran_judul_pelatihan">
<span<?= $Page->judul_pelatihan->viewAttributes() ?>>
<?= $Page->judul_pelatihan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
    <tr id="r_tanggal_pelaksanaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfimasi_pembayaran_tanggal_pelaksanaan"><template id="tpc_konfimasi_pembayaran_tanggal_pelaksanaan"><?= $Page->tanggal_pelaksanaan->caption() ?></template></span></td>
        <td data-name="tanggal_pelaksanaan" <?= $Page->tanggal_pelaksanaan->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_tanggal_pelaksanaan"><span id="el_konfimasi_pembayaran_tanggal_pelaksanaan">
<span<?= $Page->tanggal_pelaksanaan->viewAttributes() ?>>
<?= $Page->tanggal_pelaksanaan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <tr id="r_harga">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfimasi_pembayaran_harga"><template id="tpc_konfimasi_pembayaran_harga"><?= $Page->harga->caption() ?></template></span></td>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_harga"><span id="el_konfimasi_pembayaran_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_tranfer->Visible) { // tgl_tranfer ?>
    <tr id="r_tgl_tranfer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfimasi_pembayaran_tgl_tranfer"><template id="tpc_konfimasi_pembayaran_tgl_tranfer"><?= $Page->tgl_tranfer->caption() ?></template></span></td>
        <td data-name="tgl_tranfer" <?= $Page->tgl_tranfer->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_tgl_tranfer"><span id="el_konfimasi_pembayaran_tgl_tranfer">
<span<?= $Page->tgl_tranfer->viewAttributes() ?>>
<?= $Page->tgl_tranfer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
    <tr id="r_bukti_pembayaran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfimasi_pembayaran_bukti_pembayaran"><template id="tpc_konfimasi_pembayaran_bukti_pembayaran"><?= $Page->bukti_pembayaran->caption() ?></template></span></td>
        <td data-name="bukti_pembayaran" <?= $Page->bukti_pembayaran->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_bukti_pembayaran"><span id="el_konfimasi_pembayaran_bukti_pembayaran">
<span<?= $Page->bukti_pembayaran->viewAttributes() ?>>
<?= GetFileViewTag($Page->bukti_pembayaran, $Page->bukti_pembayaran->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konfimasi_pembayaran_status"><template id="tpc_konfimasi_pembayaran_status"><?= $Page->status->caption() ?></template></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_status"><span id="el_konfimasi_pembayaran_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_konfimasi_pembayaranview" class="ew-custom-template"></div>
<template id="tpm_konfimasi_pembayaranview">
<div id="ct_KonfimasiPembayaranView"><?php if($Page->bukti_pembayaran->CurrentValue != "") { ?>
<style>
	.ew-form { width: 100% !important; }
	input.form-control,.select2, #fd_x_bukti_pembayaran .input-group {
		width:100% !important;
	}
	.content-header {
		background: #031A31;
		margin-bottom: 15px;
	}
	.content-header h1 {
		color: #ffffff !important
	}
	.breadcrumb, .form-group .offset-sm-2, .text-muted { display: none; }
	h4,h5 { font-weight: bold; }
</style>
<div class="h-100 mt-5 d-flex align-items-center justify-content-center">
  <div class="row">
      <div class="col-12 alur">Sign in <i class="fa fa-chevron-right"></i> Pilih Pelatihan <i class="fa fa-chevron-right"></i> Pembayaran <i class="fa fa-chevron-right"></i> <span style="font-weight:bold;color:#3A8F53;">Verifikasi Pembayaran</span></div>
	</div>
</div>
<section class="vh-100 py-5 mb-5">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col col-xl-10">
        <div class="card p-3" style="border-radiussss: 1rem;">
          <div class="row g-0">
            <div class="col-md-7 col-lg-6 d-none d-md-block">
              <img src="../images/bg-verifikasi-pembayaran.png"
                alt="verifikasi form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-5 col-lg-6 align-items-center" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15); border-radius: 4px;">
				<div class="card-body p-4 text-black">
                  <h4 class="fw-normal pb-3 fw-bold text-center" style="letter-spacing: 1px;">VERIFIKASI PEMBAYARAN</h4>
                  <div class="row form-outline mb-3 text-justify" style="border: 1px solid #CCCCCC;border-radius: 8px;">
                    <div class="col-12">Terimakasih sudah melakukan pembayaran. Tim kami akan memverifikasi pembayaran anda. Setelah pembayaran anda terverifikasi, kami akan mengirimkan notifikasi pemberitahuan ke email terdaftar dan halaman profil anda</div><br>
                  </div>
					<h5><i class="fab fa-whatsapp fa-lg"></i> 0813 8835 6060</h5>
					<h5><i class="far fa-envelope fa-lg"></i> promosi.ppejp@kemendag.go.id</h5><br>
                   <center><a class="btn btn-success ew-btn btn-lg" href="../akun?r=pel">CEK STATUS PELATIHAN</a></center>
				</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } else {
	header("Location: ../konfimasipembayaranedit?order_id=". urlencode($Page->order_id->CurrentValue));die();
	}
?>
</div>
</template>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_konfimasi_pembayaranview", "tpm_konfimasi_pembayaranview", "konfimasi_pembayaranview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
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
