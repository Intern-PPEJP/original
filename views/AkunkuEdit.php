<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$AkunkuEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fakunkuedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fakunkuedit = currentForm = new ew.Form("fakunkuedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "akunku")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.akunku)
        ew.vars.tables.akunku = currentTable;
    fakunkuedit.addFields([
        ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
        ["user_email", [fields.user_email.visible && fields.user_email.required ? ew.Validators.required(fields.user_email.caption) : null], fields.user_email.isInvalid],
        ["no_hp", [fields.no_hp.visible && fields.no_hp.required ? ew.Validators.required(fields.no_hp.caption) : null], fields.no_hp.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid],
        ["user_updated_by", [fields.user_updated_by.visible && fields.user_updated_by.required ? ew.Validators.required(fields.user_updated_by.caption) : null], fields.user_updated_by.isInvalid],
        ["nama_peserta", [fields.nama_peserta.visible && fields.nama_peserta.required ? ew.Validators.required(fields.nama_peserta.caption) : null], fields.nama_peserta.isInvalid],
        ["perusahaan", [fields.perusahaan.visible && fields.perusahaan.required ? ew.Validators.required(fields.perusahaan.caption) : null], fields.perusahaan.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["provinsi", [fields.provinsi.visible && fields.provinsi.required ? ew.Validators.required(fields.provinsi.caption) : null], fields.provinsi.isInvalid],
        ["kota", [fields.kota.visible && fields.kota.required ? ew.Validators.required(fields.kota.caption) : null], fields.kota.isInvalid],
        ["usaha", [fields.usaha.visible && fields.usaha.required ? ew.Validators.required(fields.usaha.caption) : null], fields.usaha.isInvalid],
        ["produk", [fields.produk.visible && fields.produk.required ? ew.Validators.required(fields.produk.caption) : null], fields.produk.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fakunkuedit,
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
    fakunkuedit.validate = function () {
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
    fakunkuedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fakunkuedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fakunkuedit.lists.provinsi = <?= $Page->provinsi->toClientList($Page) ?>;
    fakunkuedit.lists.kota = <?= $Page->kota->toClientList($Page) ?>;
    loadjs.done("fakunkuedit");
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
<form name="fakunkuedit" id="fakunkuedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="akunku">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id" class="form-group row">
        <label id="elh_akunku_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_id->cellAttributes() ?>>
<span id="el_akunku_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_id->getDisplayValue($Page->user_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="akunku" data-field="x_user_id" data-hidden="1" name="x_user_id" id="x_user_id" value="<?= HtmlEncode($Page->user_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_email->Visible) { // user_email ?>
    <div id="r_user_email" class="form-group row">
        <label id="elh_akunku_user_email" for="x_user_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_email->caption() ?><?= $Page->user_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_email->cellAttributes() ?>>
<span id="el_akunku_user_email">
<span<?= $Page->user_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->user_email->getDisplayValue($Page->user_email->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="akunku" data-field="x_user_email" data-hidden="1" name="x_user_email" id="x_user_email" value="<?= HtmlEncode($Page->user_email->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <div id="r_no_hp" class="form-group row">
        <label id="elh_akunku_no_hp" for="x_no_hp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_hp->caption() ?><?= $Page->no_hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_hp->cellAttributes() ?>>
<span id="el_akunku_no_hp">
<input type="<?= $Page->no_hp->getInputTextType() ?>" data-table="akunku" data-field="x_no_hp" name="x_no_hp" id="x_no_hp" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->no_hp->getPlaceHolder()) ?>" value="<?= $Page->no_hp->EditValue ?>"<?= $Page->no_hp->editAttributes() ?> aria-describedby="x_no_hp_help">
<?= $Page->no_hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_hp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
    <div id="r_nama_peserta" class="form-group row">
        <label id="elh_akunku_nama_peserta" for="x_nama_peserta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_peserta->caption() ?><?= $Page->nama_peserta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_peserta->cellAttributes() ?>>
<span id="el_akunku_nama_peserta">
<input type="<?= $Page->nama_peserta->getInputTextType() ?>" data-table="akunku" data-field="x_nama_peserta" name="x_nama_peserta" id="x_nama_peserta" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->nama_peserta->getPlaceHolder()) ?>" value="<?= $Page->nama_peserta->EditValue ?>"<?= $Page->nama_peserta->editAttributes() ?> aria-describedby="x_nama_peserta_help">
<?= $Page->nama_peserta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_peserta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perusahaan->Visible) { // perusahaan ?>
    <div id="r_perusahaan" class="form-group row">
        <label id="elh_akunku_perusahaan" for="x_perusahaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->perusahaan->caption() ?><?= $Page->perusahaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perusahaan->cellAttributes() ?>>
<span id="el_akunku_perusahaan">
<input type="<?= $Page->perusahaan->getInputTextType() ?>" data-table="akunku" data-field="x_perusahaan" name="x_perusahaan" id="x_perusahaan" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->perusahaan->getPlaceHolder()) ?>" value="<?= $Page->perusahaan->EditValue ?>"<?= $Page->perusahaan->editAttributes() ?> aria-describedby="x_perusahaan_help">
<?= $Page->perusahaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->perusahaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_akunku_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_akunku_jabatan">
<input type="<?= $Page->jabatan->getInputTextType() ?>" data-table="akunku" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->jabatan->getPlaceHolder()) ?>" value="<?= $Page->jabatan->EditValue ?>"<?= $Page->jabatan->editAttributes() ?> aria-describedby="x_jabatan_help">
<?= $Page->jabatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->provinsi->Visible) { // provinsi ?>
    <div id="r_provinsi" class="form-group row">
        <label id="elh_akunku_provinsi" for="x_provinsi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->provinsi->caption() ?><?= $Page->provinsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->provinsi->cellAttributes() ?>>
<span id="el_akunku_provinsi">
<?php $Page->provinsi->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_provinsi"
        name="x_provinsi"
        class="form-control ew-select<?= $Page->provinsi->isInvalidClass() ?>"
        data-select2-id="akunku_x_provinsi"
        data-table="akunku"
        data-field="x_provinsi"
        data-value-separator="<?= $Page->provinsi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->provinsi->getPlaceHolder()) ?>"
        <?= $Page->provinsi->editAttributes() ?>>
        <?= $Page->provinsi->selectOptionListHtml("x_provinsi") ?>
    </select>
    <?= $Page->provinsi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->provinsi->getErrorMessage() ?></div>
<?= $Page->provinsi->Lookup->getParamTag($Page, "p_x_provinsi") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='akunku_x_provinsi']"),
        options = { name: "x_provinsi", selectId: "akunku_x_provinsi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.akunku.fields.provinsi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kota->Visible) { // kota ?>
    <div id="r_kota" class="form-group row">
        <label id="elh_akunku_kota" for="x_kota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kota->caption() ?><?= $Page->kota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kota->cellAttributes() ?>>
<span id="el_akunku_kota">
    <select
        id="x_kota"
        name="x_kota"
        class="form-control ew-select<?= $Page->kota->isInvalidClass() ?>"
        data-select2-id="akunku_x_kota"
        data-table="akunku"
        data-field="x_kota"
        data-value-separator="<?= $Page->kota->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->kota->getPlaceHolder()) ?>"
        <?= $Page->kota->editAttributes() ?>>
        <?= $Page->kota->selectOptionListHtml("x_kota") ?>
    </select>
    <?= $Page->kota->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->kota->getErrorMessage() ?></div>
<?= $Page->kota->Lookup->getParamTag($Page, "p_x_kota") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='akunku_x_kota']"),
        options = { name: "x_kota", selectId: "akunku_x_kota", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.akunku.fields.kota.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usaha->Visible) { // usaha ?>
    <div id="r_usaha" class="form-group row">
        <label id="elh_akunku_usaha" for="x_usaha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usaha->caption() ?><?= $Page->usaha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->usaha->cellAttributes() ?>>
<span id="el_akunku_usaha">
<input type="<?= $Page->usaha->getInputTextType() ?>" data-table="akunku" data-field="x_usaha" name="x_usaha" id="x_usaha" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->usaha->getPlaceHolder()) ?>" value="<?= $Page->usaha->EditValue ?>"<?= $Page->usaha->editAttributes() ?> aria-describedby="x_usaha_help">
<?= $Page->usaha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->usaha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
    <div id="r_produk" class="form-group row">
        <label id="elh_akunku_produk" for="x_produk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->produk->caption() ?><?= $Page->produk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk->cellAttributes() ?>>
<span id="el_akunku_produk">
<input type="<?= $Page->produk->getInputTextType() ?>" data-table="akunku" data-field="x_produk" name="x_produk" id="x_produk" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->produk->getPlaceHolder()) ?>" value="<?= $Page->produk->EditValue ?>"<?= $Page->produk->editAttributes() ?> aria-describedby="x_produk_help">
<?= $Page->produk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("akunku");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
