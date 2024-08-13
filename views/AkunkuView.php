<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$AkunkuView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fakunkuview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fakunkuview = currentForm = new ew.Form("fakunkuview", "view");
    loadjs.done("fakunkuview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.akunku) ew.vars.tables.akunku = <?= JsonEncode(GetClientVar("tables", "akunku")) ?>;
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
<form name="fakunkuview" id="fakunkuview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="akunku">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_user_id"><template id="tpc_akunku_user_id"><?= $Page->user_id->caption() ?></template></span></td>
        <td data-name="user_id" <?= $Page->user_id->cellAttributes() ?>>
<template id="tpx_akunku_user_id"><span id="el_akunku_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_email->Visible) { // user_email ?>
    <tr id="r_user_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_user_email"><template id="tpc_akunku_user_email"><?= $Page->user_email->caption() ?></template></span></td>
        <td data-name="user_email" <?= $Page->user_email->cellAttributes() ?>>
<template id="tpx_akunku_user_email"><span id="el_akunku_user_email">
<span<?= $Page->user_email->viewAttributes() ?>>
<?= $Page->user_email->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <tr id="r_no_hp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_no_hp"><template id="tpc_akunku_no_hp"><?= $Page->no_hp->caption() ?></template></span></td>
        <td data-name="no_hp" <?= $Page->no_hp->cellAttributes() ?>>
<template id="tpx_akunku_no_hp"><span id="el_akunku_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_updated_at"><template id="tpc_akunku_updated_at"><?= $Page->updated_at->caption() ?></template></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_akunku_updated_at"><span id="el_akunku_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_updated_by->Visible) { // user_updated_by ?>
    <tr id="r_user_updated_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_user_updated_by"><template id="tpc_akunku_user_updated_by"><?= $Page->user_updated_by->caption() ?></template></span></td>
        <td data-name="user_updated_by" <?= $Page->user_updated_by->cellAttributes() ?>>
<template id="tpx_akunku_user_updated_by"><span id="el_akunku_user_updated_by">
<span<?= $Page->user_updated_by->viewAttributes() ?>>
<?= $Page->user_updated_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
    <tr id="r_nama_peserta">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_nama_peserta"><template id="tpc_akunku_nama_peserta"><?= $Page->nama_peserta->caption() ?></template></span></td>
        <td data-name="nama_peserta" <?= $Page->nama_peserta->cellAttributes() ?>>
<template id="tpx_akunku_nama_peserta"><span id="el_akunku_nama_peserta">
<span<?= $Page->nama_peserta->viewAttributes() ?>>
<?= $Page->nama_peserta->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perusahaan->Visible) { // perusahaan ?>
    <tr id="r_perusahaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_perusahaan"><template id="tpc_akunku_perusahaan"><?= $Page->perusahaan->caption() ?></template></span></td>
        <td data-name="perusahaan" <?= $Page->perusahaan->cellAttributes() ?>>
<template id="tpx_akunku_perusahaan"><span id="el_akunku_perusahaan">
<span<?= $Page->perusahaan->viewAttributes() ?>>
<?= $Page->perusahaan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <tr id="r_jabatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_jabatan"><template id="tpc_akunku_jabatan"><?= $Page->jabatan->caption() ?></template></span></td>
        <td data-name="jabatan" <?= $Page->jabatan->cellAttributes() ?>>
<template id="tpx_akunku_jabatan"><span id="el_akunku_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->provinsi->Visible) { // provinsi ?>
    <tr id="r_provinsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_provinsi"><template id="tpc_akunku_provinsi"><?= $Page->provinsi->caption() ?></template></span></td>
        <td data-name="provinsi" <?= $Page->provinsi->cellAttributes() ?>>
<template id="tpx_akunku_provinsi"><span id="el_akunku_provinsi">
<span<?= $Page->provinsi->viewAttributes() ?>>
<?= $Page->provinsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kota->Visible) { // kota ?>
    <tr id="r_kota">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_kota"><template id="tpc_akunku_kota"><?= $Page->kota->caption() ?></template></span></td>
        <td data-name="kota" <?= $Page->kota->cellAttributes() ?>>
<template id="tpx_akunku_kota"><span id="el_akunku_kota">
<span<?= $Page->kota->viewAttributes() ?>>
<?= $Page->kota->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usaha->Visible) { // usaha ?>
    <tr id="r_usaha">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_usaha"><template id="tpc_akunku_usaha"><?= $Page->usaha->caption() ?></template></span></td>
        <td data-name="usaha" <?= $Page->usaha->cellAttributes() ?>>
<template id="tpx_akunku_usaha"><span id="el_akunku_usaha">
<span<?= $Page->usaha->viewAttributes() ?>>
<?= $Page->usaha->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
    <tr id="r_produk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_produk"><template id="tpc_akunku_produk"><?= $Page->produk->caption() ?></template></span></td>
        <td data-name="produk" <?= $Page->produk->cellAttributes() ?>>
<template id="tpx_akunku_produk"><span id="el_akunku_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_login->Visible) { // last_login ?>
    <tr id="r_last_login">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_akunku_last_login"><template id="tpc_akunku_last_login"><?= $Page->last_login->caption() ?></template></span></td>
        <td data-name="last_login" <?= $Page->last_login->cellAttributes() ?>>
<template id="tpx_akunku_last_login"><span id="el_akunku_last_login">
<span<?= $Page->last_login->viewAttributes() ?>>
<?= $Page->last_login->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_akunkuview" class="ew-custom-template"></div>
<template id="tpm_akunkuview">
<div id="ct_AkunkuView"><?php echo myheader(); ?>
<style>li{padding:5px;a{color:#222222 !important;text-decoration:none;}</style>
<div class="container-fluid " style="background-color: #031A31; padding:10px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">AKUN</h1>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="padding:10px 0px;margin-top:36px;margin-bottom:76px;">
    <div class="container" style="border:1px solid #222222;">
        <div class="row" style="border-bottom:1px solid #222222;">
            <div class="col-md-10">
                <b>Profil</b>
            </div>
            <div class="col-md-2">
                <a href=""><i class="fa fa-cog"></i> Edit Profile</a>
            </div>
        </div>
        <div class="row" style="padding:10px;">
            <div class="col-md-3" style="border-right:1px solid #222222;">
            	<ul style="list-style-type:none;padding:5px;">
            	<li>
                <i class="fa fa-user-circle-o" aria-hidden="true" style="font-size:75px"></i>
                </li>
                <li><?php echo CurrentUserName(); ?></li>
                <li><?php echo "Nama Peserta"; ?><br><br></li>
                <li><a href="">Profile</a></li>
                <li><a href="">Pelatihan</a></li>
                <li><a href="">Evaluasi</a></li>
                <li><a href="logout">Logout</a></li>
            </div>
            <div class="col-md-9">
			<?php 
				$kota = "-";
				if(CurrentUserInfo("kota") > 0) { $kota = CurrentUserInfo("kota"); }
				$propinsi = "-";
				if(CurrentUserInfo("propinsi") > 0) { $kota = CurrentUserInfo("propinsi"); } 
			?>
            	<ul style="list-style-type:none;">
            	<li style="font-weight:bold">Nama</li>
            	<li><?= CurrentUserInfo("nama_peserta") ?></li>
            	<li style="font-weight:bold">Perusahaan</li>
            	<li><?= CurrentUserInfo("perusahaan") ?></li>
            	<li style="font-weight:bold">Nomor HP</li>
            	<li><?= CurrentUserInfo("no_hp") ?></li>
            	<li style="font-weight:bold">Email</li>
            	<li><?= CurrentUserName() ?></li>
            	<li style="font-weight:bold">Jabatan</li>
            	<li><?= CurrentUserInfo("jabatan") ?></li>
            	<li style="font-weight:bold">Provinsi</li>
            	<li><?= $propinsi ?></li>
            	<li style="font-weight:bold">Kota</li>
            	<li><?= $kota ?></li>
            	<li style="font-weight:bold">Sektor Usaha</li>
            	<li><?= CurrentUserInfo("usaha") ?></li>
            	<li style="font-weight:bold">Produk</li>
            	<li><?= CurrentUserInfo("produk") ?></li>
            </div>
        </div>
    </div>
</div>
<?php echo myfooter(); ?>
</div>
</template>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_akunkuview", "tpm_akunkuview", "akunkuview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
