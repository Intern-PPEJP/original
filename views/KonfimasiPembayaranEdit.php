<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$KonfimasiPembayaranEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkonfimasi_pembayaranedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fkonfimasi_pembayaranedit = currentForm = new ew.Form("fkonfimasi_pembayaranedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "konfimasi_pembayaran")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.konfimasi_pembayaran)
        ew.vars.tables.konfimasi_pembayaran = currentTable;
    fkonfimasi_pembayaranedit.addFields([
        ["order_id", [fields.order_id.visible && fields.order_id.required ? ew.Validators.required(fields.order_id.caption) : null], fields.order_id.isInvalid],
        ["judul_pelatihan", [fields.judul_pelatihan.visible && fields.judul_pelatihan.required ? ew.Validators.required(fields.judul_pelatihan.caption) : null], fields.judul_pelatihan.isInvalid],
        ["tanggal_pelaksanaan", [fields.tanggal_pelaksanaan.visible && fields.tanggal_pelaksanaan.required ? ew.Validators.required(fields.tanggal_pelaksanaan.caption) : null], fields.tanggal_pelaksanaan.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null], fields.harga.isInvalid],
        ["tgl_tranfer", [fields.tgl_tranfer.visible && fields.tgl_tranfer.required ? ew.Validators.required(fields.tgl_tranfer.caption) : null, ew.Validators.datetime(0)], fields.tgl_tranfer.isInvalid],
        ["bukti_pembayaran", [fields.bukti_pembayaran.visible && fields.bukti_pembayaran.required ? ew.Validators.fileRequired(fields.bukti_pembayaran.caption) : null], fields.bukti_pembayaran.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null, ew.Validators.integer], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkonfimasi_pembayaranedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fkonfimasi_pembayaranedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fkonfimasi_pembayaranedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkonfimasi_pembayaranedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fkonfimasi_pembayaranedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fkonfimasi_pembayaranedit" id="fkonfimasi_pembayaranedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="konfimasi_pembayaran">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div d-none"><!-- page* -->
<?php if ($Page->order_id->Visible) { // order_id ?>
    <div id="r_order_id" class="form-group row">
        <label id="elh_konfimasi_pembayaran_order_id" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_konfimasi_pembayaran_order_id"><?= $Page->order_id->caption() ?><?= $Page->order_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->order_id->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_order_id"><span id="el_konfimasi_pembayaran_order_id">
<span<?= $Page->order_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->order_id->getDisplayValue($Page->order_id->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="konfimasi_pembayaran" data-field="x_order_id" data-hidden="1" name="x_order_id" id="x_order_id" value="<?= HtmlEncode($Page->order_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
    <div id="r_judul_pelatihan" class="form-group row">
        <label id="elh_konfimasi_pembayaran_judul_pelatihan" for="x_judul_pelatihan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_konfimasi_pembayaran_judul_pelatihan"><?= $Page->judul_pelatihan->caption() ?><?= $Page->judul_pelatihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->judul_pelatihan->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_judul_pelatihan"><span id="el_konfimasi_pembayaran_judul_pelatihan">
<span<?= $Page->judul_pelatihan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->judul_pelatihan->getDisplayValue($Page->judul_pelatihan->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="konfimasi_pembayaran" data-field="x_judul_pelatihan" data-hidden="1" name="x_judul_pelatihan" id="x_judul_pelatihan" value="<?= HtmlEncode($Page->judul_pelatihan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
    <div id="r_tanggal_pelaksanaan" class="form-group row">
        <label id="elh_konfimasi_pembayaran_tanggal_pelaksanaan" for="x_tanggal_pelaksanaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_konfimasi_pembayaran_tanggal_pelaksanaan"><?= $Page->tanggal_pelaksanaan->caption() ?><?= $Page->tanggal_pelaksanaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_pelaksanaan->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_tanggal_pelaksanaan"><span id="el_konfimasi_pembayaran_tanggal_pelaksanaan">
<span<?= $Page->tanggal_pelaksanaan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tanggal_pelaksanaan->getDisplayValue($Page->tanggal_pelaksanaan->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="konfimasi_pembayaran" data-field="x_tanggal_pelaksanaan" data-hidden="1" name="x_tanggal_pelaksanaan" id="x_tanggal_pelaksanaan" value="<?= HtmlEncode($Page->tanggal_pelaksanaan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <div id="r_harga" class="form-group row">
        <label id="elh_konfimasi_pembayaran_harga" for="x_harga" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_konfimasi_pembayaran_harga"><?= $Page->harga->caption() ?><?= $Page->harga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_harga"><span id="el_konfimasi_pembayaran_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->harga->getDisplayValue($Page->harga->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="konfimasi_pembayaran" data-field="x_harga" data-hidden="1" name="x_harga" id="x_harga" value="<?= HtmlEncode($Page->harga->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_tranfer->Visible) { // tgl_tranfer ?>
    <div id="r_tgl_tranfer" class="form-group row">
        <label id="elh_konfimasi_pembayaran_tgl_tranfer" for="x_tgl_tranfer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_konfimasi_pembayaran_tgl_tranfer"><?= $Page->tgl_tranfer->caption() ?><?= $Page->tgl_tranfer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_tranfer->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_tgl_tranfer"><span id="el_konfimasi_pembayaran_tgl_tranfer">
<input type="<?= $Page->tgl_tranfer->getInputTextType() ?>" data-table="konfimasi_pembayaran" data-field="x_tgl_tranfer" name="x_tgl_tranfer" id="x_tgl_tranfer" maxlength="10" placeholder="<?= HtmlEncode($Page->tgl_tranfer->getPlaceHolder()) ?>" value="<?= $Page->tgl_tranfer->EditValue ?>"<?= $Page->tgl_tranfer->editAttributes() ?> aria-describedby="x_tgl_tranfer_help">
<?= $Page->tgl_tranfer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_tranfer->getErrorMessage() ?></div>
<?php if (!$Page->tgl_tranfer->ReadOnly && !$Page->tgl_tranfer->Disabled && !isset($Page->tgl_tranfer->EditAttrs["readonly"]) && !isset($Page->tgl_tranfer->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fkonfimasi_pembayaranedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fkonfimasi_pembayaranedit", "x_tgl_tranfer", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bukti_pembayaran->Visible) { // bukti_pembayaran ?>
    <div id="r_bukti_pembayaran" class="form-group row">
        <label id="elh_konfimasi_pembayaran_bukti_pembayaran" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_konfimasi_pembayaran_bukti_pembayaran"><?= $Page->bukti_pembayaran->caption() ?><?= $Page->bukti_pembayaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bukti_pembayaran->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_bukti_pembayaran"><span id="el_konfimasi_pembayaran_bukti_pembayaran">
<div id="fd_x_bukti_pembayaran">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->bukti_pembayaran->title() ?>" data-table="konfimasi_pembayaran" data-field="x_bukti_pembayaran" name="x_bukti_pembayaran" id="x_bukti_pembayaran" lang="<?= CurrentLanguageID() ?>"<?= $Page->bukti_pembayaran->editAttributes() ?><?= ($Page->bukti_pembayaran->ReadOnly || $Page->bukti_pembayaran->Disabled) ? " disabled" : "" ?> aria-describedby="x_bukti_pembayaran_help">
        <label class="custom-file-label ew-file-label" for="x_bukti_pembayaran"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->bukti_pembayaran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bukti_pembayaran->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_bukti_pembayaran" id= "fn_x_bukti_pembayaran" value="<?= $Page->bukti_pembayaran->Upload->FileName ?>">
<input type="hidden" name="fa_x_bukti_pembayaran" id= "fa_x_bukti_pembayaran" value="<?= (Post("fa_x_bukti_pembayaran") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_bukti_pembayaran" id= "fs_x_bukti_pembayaran" value="255">
<input type="hidden" name="fx_x_bukti_pembayaran" id= "fx_x_bukti_pembayaran" value="<?= $Page->bukti_pembayaran->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_bukti_pembayaran" id= "fm_x_bukti_pembayaran" value="<?= $Page->bukti_pembayaran->UploadMaxFileSize ?>">
</div>
<table id="ft_x_bukti_pembayaran" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_konfimasi_pembayaran_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_konfimasi_pembayaran_status"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<template id="tpx_konfimasi_pembayaran_status"><span id="el_konfimasi_pembayaran_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="konfimasi_pembayaran" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_konfimasi_pembayaranedit" class="ew-custom-template"></div>
<template id="tpm_konfimasi_pembayaranedit">
<div id="ct_KonfimasiPembayaranEdit"><style>
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
</style>
<div class="h-100 mt-5 d-flex align-items-center justify-content-center">
  <div class="row">
      <div class="col-12 alur">Sign in <i class="fa fa-chevron-right"></i> Pilih Pelatihan <i class="fa fa-chevron-right"></i> <span style="font-weight:bold;color:#3A8F53;">Pembayaran</span> <i class="fa fa-chevron-right"></i> Verifikasi Pembayaran</div>
	</div>
</div>
<section class="vh-100 py-5 mb-5">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="images/bg-pil-pelatihan.png"
                alt="pembayaran form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 align-items-center">
              <div class="card-body p-4 text-black">
                  <h5 class="fw-normal mb-3 pb-3 fw-bold" style="letter-spacing: 1px;text-align:center;">KONFIRMASI PEMBAYARAN</h5>
                  <div class="row form-outline mb-3" style="border: 1px solid #CCCCCC;border-radius: 8px;">
                    <div class="col-12">Ringkasan pembelian</div><br><br>
                    <div class="col-4">Nama Pelatihan</div>
                    <div class="col-8 text-right"><?= HtmlEncode(RemoveHtml($Page->judul_pelatihan->getDisplayValue($Page->judul_pelatihan->EditValue))) ?></div>
                    <div class="col-4">Tanggal Pelatihan</div>
                    <div class="col-8 text-right"><?= HtmlEncode(RemoveHtml($Page->tanggal_pelaksanaan->getDisplayValue($Page->tanggal_pelaksanaan->EditValue))) ?></div>
                    <div class="col-4">Nilai Pembelian</div>
                    <div class="col-8 text-right">Rp<?= HtmlEncode(RemoveHtml($Page->harga->getDisplayValue($Page->harga->EditValue))) ?></div>
                  </div>
				  <div class="row form-outline mb-3" style="border: 1px solid #CCCCCC;border-radius: 8px;">
                    <div class="col-12">Metode pembayaran</div><br><br>
					<div class="col-12 mb-3">Transfer ke rekening PPEJP</div>
                    <div class="col-4 mt-1"><img src="images/logo-bank-bri.png"></div>
                    <div class="col-8 text-left mb-3">No. Rek BRI : <b>033801000180306</b><br>Nama rekening : <b>BPN 175 PPEJP</b></div>
                    <div class="col-12">
						<li>Pastikan jumlah transfer sesuai dengan nominal total pembayaran.</li>
						<li>Pembayaran dilakukan maksimal 1 x 24 jam setelah mendaftar</li>
						<li>Sebelum melakukan pembayaran pastikan Anda sudah yakin </li>
						<li>Peserta yang sudah mendaftar diharapkan hadir pada pelatihan sesuai jadwal yang ditentukan </li>
						<li>Pembatalan keikutsertaan setelah melakukan pembayaran tidak diperkenankan</li>
						<li>Apabila batal biaya pelatihan yang sudah dibayarkan tidak dapat dikembalikan</li></ul></div>
                  </div>
				  <p>Upload Bukti Pembayaran <span style="color:#a5a5a5;">(file jpg max 2mb)</span></p>
				  <div class="row">
					<div class="col-6">Total Pembayaran</div>
					<div class="col-6 text-right mb-3">Rp<?= HtmlEncode(RemoveHtml($Page->harga->getDisplayValue($Page->harga->EditValue))) ?></div>
					<div class="col-12"><slot class="ew-slot" name="tpx_konfimasi_pembayaran_tgl_tranfer"></slot></div>
				  </div>
					<div class="col-12"><slot class="ew-slot" name="tpx_konfimasi_pembayaran_bukti_pembayaran" style="border:1px solid #000"></slot></div>
				  </div>
                  <div class="pt-1 mb-4"><?php if (!$Page->IsModal) { ?>
                   <button class="btn btn-success ew-btn" name="btn-action" id="btn-action" type="submit">KONFIRMASI PEMBAYARAN</button>
    <?php } ?>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><br><br>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_konfimasi_pembayaranedit", "tpm_konfimasi_pembayaranedit", "konfimasi_pembayaranedit", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("konfimasi_pembayaran");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
