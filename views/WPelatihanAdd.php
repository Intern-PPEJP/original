<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WPelatihanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_pelatihanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fw_pelatihanadd = currentForm = new ew.Form("fw_pelatihanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_pelatihan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_pelatihan)
        ew.vars.tables.w_pelatihan = currentTable;
    fw_pelatihanadd.addFields([
        ["jenis_pelatihan", [fields.jenis_pelatihan.visible && fields.jenis_pelatihan.required ? ew.Validators.required(fields.jenis_pelatihan.caption) : null], fields.jenis_pelatihan.isInvalid],
        ["judul_pelatihan", [fields.judul_pelatihan.visible && fields.judul_pelatihan.required ? ew.Validators.required(fields.judul_pelatihan.caption) : null], fields.judul_pelatihan.isInvalid],
        ["jumlah_hari", [fields.jumlah_hari.visible && fields.jumlah_hari.required ? ew.Validators.required(fields.jumlah_hari.caption) : null], fields.jumlah_hari.isInvalid],
        ["tempat", [fields.tempat.visible && fields.tempat.required ? ew.Validators.required(fields.tempat.caption) : null], fields.tempat.isInvalid],
        ["jumlah_peserta", [fields.jumlah_peserta.visible && fields.jumlah_peserta.required ? ew.Validators.required(fields.jumlah_peserta.caption) : null, ew.Validators.integer], fields.jumlah_peserta.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.float], fields.harga.isInvalid],
        ["tawal", [fields.tawal.visible && fields.tawal.required ? ew.Validators.required(fields.tawal.caption) : null, ew.Validators.datetime(7)], fields.tawal.isInvalid],
        ["takhir", [fields.takhir.visible && fields.takhir.required ? ew.Validators.required(fields.takhir.caption) : null, ew.Validators.datetime(7)], fields.takhir.isInvalid],
        ["tanggal_pelaksanaan", [fields.tanggal_pelaksanaan.visible && fields.tanggal_pelaksanaan.required ? ew.Validators.required(fields.tanggal_pelaksanaan.caption) : null], fields.tanggal_pelaksanaan.isInvalid],
        ["gambar", [fields.gambar.visible && fields.gambar.required ? ew.Validators.fileRequired(fields.gambar.caption) : null], fields.gambar.isInvalid],
        ["kategori", [fields.kategori.visible && fields.kategori.required ? ew.Validators.required(fields.kategori.caption) : null], fields.kategori.isInvalid],
        ["tujuan", [fields.tujuan.visible && fields.tujuan.required ? ew.Validators.required(fields.tujuan.caption) : null], fields.tujuan.isInvalid],
        ["sub_kategori", [fields.sub_kategori.visible && fields.sub_kategori.required ? ew.Validators.required(fields.sub_kategori.caption) : null], fields.sub_kategori.isInvalid],
        ["topik_bahasan", [fields.topik_bahasan.visible && fields.topik_bahasan.required ? ew.Validators.required(fields.topik_bahasan.caption) : null], fields.topik_bahasan.isInvalid],
        ["catatan", [fields.catatan.visible && fields.catatan.required ? ew.Validators.required(fields.catatan.caption) : null], fields.catatan.isInvalid],
        ["Link", [fields.Link.visible && fields.Link.required ? ew.Validators.required(fields.Link.caption) : null], fields.Link.isInvalid],
        ["Created_Date", [fields.Created_Date.visible && fields.Created_Date.required ? ew.Validators.required(fields.Created_Date.caption) : null], fields.Created_Date.isInvalid],
        ["Activated", [fields.Activated.visible && fields.Activated.required ? ew.Validators.required(fields.Activated.caption) : null], fields.Activated.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_pelatihanadd,
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
    fw_pelatihanadd.validate = function () {
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
    fw_pelatihanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_pelatihanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_pelatihanadd.lists.jenis_pelatihan = <?= $Page->jenis_pelatihan->toClientList($Page) ?>;
    fw_pelatihanadd.lists.Activated = <?= $Page->Activated->toClientList($Page) ?>;
    loadjs.done("fw_pelatihanadd");
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
<form name="fw_pelatihanadd" id="fw_pelatihanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_pelatihan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->jenis_pelatihan->Visible) { // jenis_pelatihan ?>
    <div id="r_jenis_pelatihan" class="form-group row">
        <label id="elh_w_pelatihan_jenis_pelatihan" for="x_jenis_pelatihan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenis_pelatihan->caption() ?><?= $Page->jenis_pelatihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis_pelatihan->cellAttributes() ?>>
<span id="el_w_pelatihan_jenis_pelatihan">
    <select
        id="x_jenis_pelatihan"
        name="x_jenis_pelatihan"
        class="form-control ew-select<?= $Page->jenis_pelatihan->isInvalidClass() ?>"
        data-select2-id="w_pelatihan_x_jenis_pelatihan"
        data-table="w_pelatihan"
        data-field="x_jenis_pelatihan"
        data-value-separator="<?= $Page->jenis_pelatihan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->jenis_pelatihan->getPlaceHolder()) ?>"
        <?= $Page->jenis_pelatihan->editAttributes() ?>>
        <?= $Page->jenis_pelatihan->selectOptionListHtml("x_jenis_pelatihan") ?>
    </select>
    <?= $Page->jenis_pelatihan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->jenis_pelatihan->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_pelatihan_x_jenis_pelatihan']"),
        options = { name: "x_jenis_pelatihan", selectId: "w_pelatihan_x_jenis_pelatihan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.w_pelatihan.fields.jenis_pelatihan.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_pelatihan.fields.jenis_pelatihan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->judul_pelatihan->Visible) { // judul_pelatihan ?>
    <div id="r_judul_pelatihan" class="form-group row">
        <label id="elh_w_pelatihan_judul_pelatihan" for="x_judul_pelatihan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->judul_pelatihan->caption() ?><?= $Page->judul_pelatihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->judul_pelatihan->cellAttributes() ?>>
<span id="el_w_pelatihan_judul_pelatihan">
<input type="<?= $Page->judul_pelatihan->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_judul_pelatihan" name="x_judul_pelatihan" id="x_judul_pelatihan" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->judul_pelatihan->getPlaceHolder()) ?>" value="<?= $Page->judul_pelatihan->EditValue ?>"<?= $Page->judul_pelatihan->editAttributes() ?> aria-describedby="x_judul_pelatihan_help">
<?= $Page->judul_pelatihan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->judul_pelatihan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah_hari->Visible) { // jumlah_hari ?>
    <div id="r_jumlah_hari" class="form-group row">
        <label id="elh_w_pelatihan_jumlah_hari" for="x_jumlah_hari" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah_hari->caption() ?><?= $Page->jumlah_hari->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah_hari->cellAttributes() ?>>
<span id="el_w_pelatihan_jumlah_hari">
<input type="<?= $Page->jumlah_hari->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_jumlah_hari" name="x_jumlah_hari" id="x_jumlah_hari" size="10" maxlength="25" placeholder="<?= HtmlEncode($Page->jumlah_hari->getPlaceHolder()) ?>" value="<?= $Page->jumlah_hari->EditValue ?>"<?= $Page->jumlah_hari->editAttributes() ?> aria-describedby="x_jumlah_hari_help">
<?= $Page->jumlah_hari->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah_hari->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tempat->Visible) { // tempat ?>
    <div id="r_tempat" class="form-group row">
        <label id="elh_w_pelatihan_tempat" for="x_tempat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tempat->caption() ?><?= $Page->tempat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tempat->cellAttributes() ?>>
<span id="el_w_pelatihan_tempat">
<input type="<?= $Page->tempat->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_tempat" name="x_tempat" id="x_tempat" size="20" maxlength="100" placeholder="<?= HtmlEncode($Page->tempat->getPlaceHolder()) ?>" value="<?= $Page->tempat->EditValue ?>"<?= $Page->tempat->editAttributes() ?> aria-describedby="x_tempat_help">
<?= $Page->tempat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tempat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah_peserta->Visible) { // jumlah_peserta ?>
    <div id="r_jumlah_peserta" class="form-group row">
        <label id="elh_w_pelatihan_jumlah_peserta" for="x_jumlah_peserta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah_peserta->caption() ?><?= $Page->jumlah_peserta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah_peserta->cellAttributes() ?>>
<span id="el_w_pelatihan_jumlah_peserta">
<input type="<?= $Page->jumlah_peserta->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_jumlah_peserta" name="x_jumlah_peserta" id="x_jumlah_peserta" size="4" maxlength="4" placeholder="<?= HtmlEncode($Page->jumlah_peserta->getPlaceHolder()) ?>" value="<?= $Page->jumlah_peserta->EditValue ?>"<?= $Page->jumlah_peserta->editAttributes() ?> aria-describedby="x_jumlah_peserta_help">
<?= $Page->jumlah_peserta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah_peserta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <div id="r_sisa" class="form-group row">
        <label id="elh_w_pelatihan_sisa" for="x_sisa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sisa->caption() ?><?= $Page->sisa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sisa->cellAttributes() ?>>
<span id="el_w_pelatihan_sisa">
<input type="<?= $Page->sisa->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_sisa" name="x_sisa" id="x_sisa" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->sisa->getPlaceHolder()) ?>" value="<?= $Page->sisa->EditValue ?>"<?= $Page->sisa->editAttributes() ?> aria-describedby="x_sisa_help">
<?= $Page->sisa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sisa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <div id="r_harga" class="form-group row">
        <label id="elh_w_pelatihan_harga" for="x_harga" class="<?= $Page->LeftColumnClass ?>"><?= $Page->harga->caption() ?><?= $Page->harga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga->cellAttributes() ?>>
<span id="el_w_pelatihan_harga">
<input type="<?= $Page->harga->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_harga" name="x_harga" id="x_harga" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->harga->getPlaceHolder()) ?>" value="<?= $Page->harga->EditValue ?>"<?= $Page->harga->editAttributes() ?> aria-describedby="x_harga_help">
<?= $Page->harga->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->harga->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tawal->Visible) { // tawal ?>
    <div id="r_tawal" class="form-group row">
        <label id="elh_w_pelatihan_tawal" for="x_tawal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tawal->caption() ?><?= $Page->tawal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tawal->cellAttributes() ?>>
<span id="el_w_pelatihan_tawal">
<input type="<?= $Page->tawal->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_tawal" data-format="7" name="x_tawal" id="x_tawal" size="10" maxlength="19" placeholder="<?= HtmlEncode($Page->tawal->getPlaceHolder()) ?>" value="<?= $Page->tawal->EditValue ?>"<?= $Page->tawal->editAttributes() ?> aria-describedby="x_tawal_help">
<?= $Page->tawal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tawal->getErrorMessage() ?></div>
<?php if (!$Page->tawal->ReadOnly && !$Page->tawal->Disabled && !isset($Page->tawal->EditAttrs["readonly"]) && !isset($Page->tawal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fw_pelatihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fw_pelatihanadd", "x_tawal", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->takhir->Visible) { // takhir ?>
    <div id="r_takhir" class="form-group row">
        <label id="elh_w_pelatihan_takhir" for="x_takhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->takhir->caption() ?><?= $Page->takhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->takhir->cellAttributes() ?>>
<span id="el_w_pelatihan_takhir">
<input type="<?= $Page->takhir->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_takhir" data-format="7" name="x_takhir" id="x_takhir" size="10" maxlength="19" placeholder="<?= HtmlEncode($Page->takhir->getPlaceHolder()) ?>" value="<?= $Page->takhir->EditValue ?>"<?= $Page->takhir->editAttributes() ?> aria-describedby="x_takhir_help">
<?= $Page->takhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->takhir->getErrorMessage() ?></div>
<?php if (!$Page->takhir->ReadOnly && !$Page->takhir->Disabled && !isset($Page->takhir->EditAttrs["readonly"]) && !isset($Page->takhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fw_pelatihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fw_pelatihanadd", "x_takhir", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_pelaksanaan->Visible) { // tanggal_pelaksanaan ?>
    <div id="r_tanggal_pelaksanaan" class="form-group row">
        <label id="elh_w_pelatihan_tanggal_pelaksanaan" for="x_tanggal_pelaksanaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_pelaksanaan->caption() ?><?= $Page->tanggal_pelaksanaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_pelaksanaan->cellAttributes() ?>>
<span id="el_w_pelatihan_tanggal_pelaksanaan">
<input type="<?= $Page->tanggal_pelaksanaan->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_tanggal_pelaksanaan" name="x_tanggal_pelaksanaan" id="x_tanggal_pelaksanaan" size="15" maxlength="100" placeholder="<?= HtmlEncode($Page->tanggal_pelaksanaan->getPlaceHolder()) ?>" value="<?= $Page->tanggal_pelaksanaan->EditValue ?>"<?= $Page->tanggal_pelaksanaan->editAttributes() ?> aria-describedby="x_tanggal_pelaksanaan_help">
<?= $Page->tanggal_pelaksanaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_pelaksanaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
    <div id="r_gambar" class="form-group row">
        <label id="elh_w_pelatihan_gambar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gambar->caption() ?><?= $Page->gambar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gambar->cellAttributes() ?>>
<span id="el_w_pelatihan_gambar">
<div id="fd_x_gambar">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->gambar->title() ?>" data-table="w_pelatihan" data-field="x_gambar" name="x_gambar" id="x_gambar" lang="<?= CurrentLanguageID() ?>"<?= $Page->gambar->editAttributes() ?><?= ($Page->gambar->ReadOnly || $Page->gambar->Disabled) ? " disabled" : "" ?> aria-describedby="x_gambar_help">
        <label class="custom-file-label ew-file-label" for="x_gambar"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->gambar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gambar->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_gambar" id= "fn_x_gambar" value="<?= $Page->gambar->Upload->FileName ?>">
<input type="hidden" name="fa_x_gambar" id= "fa_x_gambar" value="0">
<input type="hidden" name="fs_x_gambar" id= "fs_x_gambar" value="255">
<input type="hidden" name="fx_x_gambar" id= "fx_x_gambar" value="<?= $Page->gambar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_gambar" id= "fm_x_gambar" value="<?= $Page->gambar->UploadMaxFileSize ?>">
</div>
<table id="ft_x_gambar" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
    <div id="r_kategori" class="form-group row">
        <label id="elh_w_pelatihan_kategori" for="x_kategori" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kategori->caption() ?><?= $Page->kategori->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategori->cellAttributes() ?>>
<span id="el_w_pelatihan_kategori">
<input type="<?= $Page->kategori->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_kategori" name="x_kategori" id="x_kategori" size="10" maxlength="100" placeholder="<?= HtmlEncode($Page->kategori->getPlaceHolder()) ?>" value="<?= $Page->kategori->EditValue ?>"<?= $Page->kategori->editAttributes() ?> aria-describedby="x_kategori_help">
<?= $Page->kategori->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategori->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tujuan->Visible) { // tujuan ?>
    <div id="r_tujuan" class="form-group row">
        <label id="elh_w_pelatihan_tujuan" for="x_tujuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tujuan->caption() ?><?= $Page->tujuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tujuan->cellAttributes() ?>>
<span id="el_w_pelatihan_tujuan">
<textarea data-table="w_pelatihan" data-field="x_tujuan" name="x_tujuan" id="x_tujuan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->tujuan->getPlaceHolder()) ?>"<?= $Page->tujuan->editAttributes() ?> aria-describedby="x_tujuan_help"><?= $Page->tujuan->EditValue ?></textarea>
<?= $Page->tujuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tujuan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sub_kategori->Visible) { // sub_kategori ?>
    <div id="r_sub_kategori" class="form-group row">
        <label id="elh_w_pelatihan_sub_kategori" for="x_sub_kategori" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sub_kategori->caption() ?><?= $Page->sub_kategori->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sub_kategori->cellAttributes() ?>>
<span id="el_w_pelatihan_sub_kategori">
<input type="<?= $Page->sub_kategori->getInputTextType() ?>" data-table="w_pelatihan" data-field="x_sub_kategori" name="x_sub_kategori" id="x_sub_kategori" size="20" maxlength="150" placeholder="<?= HtmlEncode($Page->sub_kategori->getPlaceHolder()) ?>" value="<?= $Page->sub_kategori->EditValue ?>"<?= $Page->sub_kategori->editAttributes() ?> aria-describedby="x_sub_kategori_help">
<?= $Page->sub_kategori->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sub_kategori->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->topik_bahasan->Visible) { // topik_bahasan ?>
    <div id="r_topik_bahasan" class="form-group row">
        <label id="elh_w_pelatihan_topik_bahasan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->topik_bahasan->caption() ?><?= $Page->topik_bahasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->topik_bahasan->cellAttributes() ?>>
<span id="el_w_pelatihan_topik_bahasan">
<?php $Page->topik_bahasan->EditAttrs->appendClass("editor"); ?>
<textarea data-table="w_pelatihan" data-field="x_topik_bahasan" name="x_topik_bahasan" id="x_topik_bahasan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->topik_bahasan->getPlaceHolder()) ?>"<?= $Page->topik_bahasan->editAttributes() ?> aria-describedby="x_topik_bahasan_help"><?= $Page->topik_bahasan->EditValue ?></textarea>
<?= $Page->topik_bahasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->topik_bahasan->getErrorMessage() ?></div>
<script>
loadjs.ready(["fw_pelatihanadd", "editor"], function() {
	ew.createEditor("fw_pelatihanadd", "x_topik_bahasan", 35, 4, <?= $Page->topik_bahasan->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <div id="r_catatan" class="form-group row">
        <label id="elh_w_pelatihan_catatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->catatan->caption() ?><?= $Page->catatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan->cellAttributes() ?>>
<span id="el_w_pelatihan_catatan">
<?php $Page->catatan->EditAttrs->appendClass("editor"); ?>
<textarea data-table="w_pelatihan" data-field="x_catatan" name="x_catatan" id="x_catatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatan->getPlaceHolder()) ?>"<?= $Page->catatan->editAttributes() ?> aria-describedby="x_catatan_help"><?= $Page->catatan->EditValue ?></textarea>
<?= $Page->catatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan->getErrorMessage() ?></div>
<script>
loadjs.ready(["fw_pelatihanadd", "editor"], function() {
	ew.createEditor("fw_pelatihanadd", "x_catatan", 35, 4, <?= $Page->catatan->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Link->Visible) { // Link ?>
    <div id="r_Link" class="form-group row">
        <label id="elh_w_pelatihan_Link" for="x_Link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Link->caption() ?><?= $Page->Link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Link->cellAttributes() ?>>
<span id="el_w_pelatihan_Link">
<textarea data-table="w_pelatihan" data-field="x_Link" name="x_Link" id="x_Link" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Link->getPlaceHolder()) ?>"<?= $Page->Link->editAttributes() ?> aria-describedby="x_Link_help"><?= $Page->Link->EditValue ?></textarea>
<?= $Page->Link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
    <div id="r_Activated" class="form-group row">
        <label id="elh_w_pelatihan_Activated" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Activated->caption() ?><?= $Page->Activated->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Activated->cellAttributes() ?>>
<span id="el_w_pelatihan_Activated">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->Activated->isInvalidClass() ?>" data-table="w_pelatihan" data-field="x_Activated" name="x_Activated[]" id="x_Activated_185812" value="1"<?= ConvertToBool($Page->Activated->CurrentValue) ? " checked" : "" ?><?= $Page->Activated->editAttributes() ?> aria-describedby="x_Activated_help">
    <label class="custom-control-label" for="x_Activated_185812"></label>
</div>
<?= $Page->Activated->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Activated->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("w_pelatihan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
