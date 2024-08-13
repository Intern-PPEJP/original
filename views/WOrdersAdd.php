<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WOrdersAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_ordersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fw_ordersadd = currentForm = new ew.Form("fw_ordersadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_orders")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_orders)
        ew.vars.tables.w_orders = currentTable;
    fw_ordersadd.addFields([
        ["nama_peserta", [fields.nama_peserta.visible && fields.nama_peserta.required ? ew.Validators.required(fields.nama_peserta.caption) : null], fields.nama_peserta.isInvalid],
        ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["nama_perusahaan", [fields.nama_perusahaan.visible && fields.nama_perusahaan.required ? ew.Validators.required(fields.nama_perusahaan.caption) : null], fields.nama_perusahaan.isInvalid],
        ["pelatihan_id", [fields.pelatihan_id.visible && fields.pelatihan_id.required ? ew.Validators.required(fields.pelatihan_id.caption) : null], fields.pelatihan_id.isInvalid],
        ["Biaya", [fields.Biaya.visible && fields.Biaya.required ? ew.Validators.required(fields.Biaya.caption) : null], fields.Biaya.isInvalid],
        ["tgl_tranfer", [fields.tgl_tranfer.visible && fields.tgl_tranfer.required ? ew.Validators.required(fields.tgl_tranfer.caption) : null, ew.Validators.datetime(0)], fields.tgl_tranfer.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_ordersadd,
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
    fw_ordersadd.validate = function () {
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
    fw_ordersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_ordersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_ordersadd.lists._username = <?= $Page->_username->toClientList($Page) ?>;
    fw_ordersadd.lists.pelatihan_id = <?= $Page->pelatihan_id->toClientList($Page) ?>;
    fw_ordersadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fw_ordersadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    $("#btn-action").html("BAYAR SEKARANG");
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fw_ordersadd" id="fw_ordersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_orders">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
    <div id="r_nama_peserta" class="form-group row">
        <label id="elh_w_orders_nama_peserta" for="x_nama_peserta" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_orders_nama_peserta"><?= $Page->nama_peserta->caption() ?><?= $Page->nama_peserta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_peserta->cellAttributes() ?>>
<template id="tpx_w_orders_nama_peserta"><span id="el_w_orders_nama_peserta">
<input type="<?= $Page->nama_peserta->getInputTextType() ?>" data-table="w_orders" data-field="x_nama_peserta" name="x_nama_peserta" id="x_nama_peserta" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->nama_peserta->getPlaceHolder()) ?>" value="<?= $Page->nama_peserta->EditValue ?>"<?= $Page->nama_peserta->editAttributes() ?> aria-describedby="x_nama_peserta_help">
<?= $Page->nama_peserta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_peserta->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
    <div id="r_nama_perusahaan" class="form-group row">
        <label id="elh_w_orders_nama_perusahaan" for="x_nama_perusahaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_orders_nama_perusahaan"><?= $Page->nama_perusahaan->caption() ?><?= $Page->nama_perusahaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_perusahaan->cellAttributes() ?>>
<template id="tpx_w_orders_nama_perusahaan"><span id="el_w_orders_nama_perusahaan">
<input type="<?= $Page->nama_perusahaan->getInputTextType() ?>" data-table="w_orders" data-field="x_nama_perusahaan" name="x_nama_perusahaan" id="x_nama_perusahaan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_perusahaan->getPlaceHolder()) ?>" value="<?= $Page->nama_perusahaan->EditValue ?>"<?= $Page->nama_perusahaan->editAttributes() ?> aria-describedby="x_nama_perusahaan_help">
<?= $Page->nama_perusahaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_perusahaan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
    <div id="r_pelatihan_id" class="form-group row">
        <label id="elh_w_orders_pelatihan_id" for="x_pelatihan_id" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_orders_pelatihan_id"><?= $Page->pelatihan_id->caption() ?><?= $Page->pelatihan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pelatihan_id->cellAttributes() ?>>
<template id="tpx_w_orders_pelatihan_id"><span id="el_w_orders_pelatihan_id">
    <select
        id="x_pelatihan_id"
        name="x_pelatihan_id"
        class="form-control ew-select<?= $Page->pelatihan_id->isInvalidClass() ?>"
        data-select2-id="w_orders_x_pelatihan_id"
        data-table="w_orders"
        data-field="x_pelatihan_id"
        data-value-separator="<?= $Page->pelatihan_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pelatihan_id->getPlaceHolder()) ?>"
        <?= $Page->pelatihan_id->editAttributes() ?>>
        <?= $Page->pelatihan_id->selectOptionListHtml("x_pelatihan_id") ?>
    </select>
    <?= $Page->pelatihan_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pelatihan_id->getErrorMessage() ?></div>
<?= $Page->pelatihan_id->Lookup->getParamTag($Page, "p_x_pelatihan_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_orders_x_pelatihan_id']"),
        options = { name: "x_pelatihan_id", selectId: "w_orders_x_pelatihan_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_orders.fields.pelatihan_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Biaya->Visible) { // Biaya ?>
    <div id="r_Biaya" class="form-group row">
        <label id="elh_w_orders_Biaya" for="x_Biaya" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_orders_Biaya"><?= $Page->Biaya->caption() ?><?= $Page->Biaya->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Biaya->cellAttributes() ?>>
<template id="tpx_w_orders_Biaya"><span id="el_w_orders_Biaya">
<input type="<?= $Page->Biaya->getInputTextType() ?>" data-table="w_orders" data-field="x_Biaya" name="x_Biaya" id="x_Biaya" size="30" maxlength="65530" placeholder="<?= HtmlEncode($Page->Biaya->getPlaceHolder()) ?>" value="<?= $Page->Biaya->EditValue ?>"<?= $Page->Biaya->editAttributes() ?> aria-describedby="x_Biaya_help">
<?= $Page->Biaya->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Biaya->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_tranfer->Visible) { // tgl_tranfer ?>
    <div id="r_tgl_tranfer" class="form-group row">
        <label id="elh_w_orders_tgl_tranfer" for="x_tgl_tranfer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_orders_tgl_tranfer"><?= $Page->tgl_tranfer->caption() ?><?= $Page->tgl_tranfer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_tranfer->cellAttributes() ?>>
<template id="tpx_w_orders_tgl_tranfer"><span id="el_w_orders_tgl_tranfer">
<input type="<?= $Page->tgl_tranfer->getInputTextType() ?>" data-table="w_orders" data-field="x_tgl_tranfer" name="x_tgl_tranfer" id="x_tgl_tranfer" maxlength="10" placeholder="<?= HtmlEncode($Page->tgl_tranfer->getPlaceHolder()) ?>" value="<?= $Page->tgl_tranfer->EditValue ?>"<?= $Page->tgl_tranfer->editAttributes() ?> aria-describedby="x_tgl_tranfer_help">
<?= $Page->tgl_tranfer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_tranfer->getErrorMessage() ?></div>
<?php if (!$Page->tgl_tranfer->ReadOnly && !$Page->tgl_tranfer->Disabled && !isset($Page->tgl_tranfer->EditAttrs["readonly"]) && !isset($Page->tgl_tranfer->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fw_ordersadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fw_ordersadd", "x_tgl_tranfer", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_w_orders_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_orders_status"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<template id="tpx_w_orders_status"><span id="el_w_orders_status">
    <select
        id="x_status"
        name="x_status"
        class="form-control ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="w_orders_x_status"
        data-table="w_orders"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_orders_x_status']"),
        options = { name: "x_status", selectId: "w_orders_x_status", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.w_orders.fields.status.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_orders.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_w_ordersadd" class="ew-custom-template"></div>
<template id="tpm_w_ordersadd">
<div id="ct_WOrdersAdd"><style>
	.ew-form { width: 100% !important; }
	input.form-control,.select2 {
		width:100%;
	}
	.content-header {
		background: #031A31;
		margin-bottom: 15px;
	}
	.content-header h1 {
		color: #ffffff !important
	}
	.breadcrumb, .form-group .offset-sm-2 { display: none; }
</style>
<div class="h-100 mt-5 d-flex align-items-center justify-content-center">
  <div class="row">
      <div class="col-12 alur">Sign in <i class="fa fa-chevron-right"></i> <span style="font-weight:bold;color:#3A8F53;">Pilih Pelatihan</span> <i class="fa fa-chevron-right"></i> Pembayaran <i class="fa fa-chevron-right"></i> Verifikasi Pembayaran</div>
	</div>
</div>
<section class="vh-100 py-5">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="images/bg-pil-pelatihan.png"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 align-items-center">
              <div class="card-body p-4 text-black">
                  <h5 class="fw-normal mb-3 pb-3 fw-bold" style="letter-spacing: 1px;text-align:center;">PILIH PELATIHAN</h5>
                  <div class="form-outline mb-4">
                    <label class="form-label" for="">Nama Peserta</label>
                    <slot class="ew-slot" name="tpx_w_orders_nama_peserta"></slot>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label" for="">Nama Perusahaan</label>
                    <slot class="ew-slot" name="tpx_w_orders_nama_perusahaan"></slot>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label" for="">Pelatihan</label>
                     <slot class="ew-slot" name="tpx_w_orders_pelatihan_id"></slot>
                  </div>
                   <div class="form-outline mb-4">
                    <label class="form-label" for="">Biaya</label>
                     <slot class="ew-slot" name="tpx_w_orders_Biaya"></slot><br>
                     <input type="checkbox" name="s_term" value="1" onchange="document.getElementById('btn-action').disabled = !this.checked;" checked> <span>Saya setuju dengan Syarat & Ketentuan</span>
                  </div>
                  <div class="pt-1 mb-4"><?php if (!$Page->IsModal) { ?>
                   <button class="btn btn-success ew-btn" name="btn-action" id="btn-action" type="submit">BAYAR SEKARANG</button>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_w_ordersadd", "tpm_w_ordersadd", "w_ordersadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("w_orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
