<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WBeritaEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_beritaedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fw_beritaedit = currentForm = new ew.Form("fw_beritaedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_berita")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_berita)
        ew.vars.tables.w_berita = currentTable;
    fw_beritaedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["judul", [fields.judul.visible && fields.judul.required ? ew.Validators.required(fields.judul.caption) : null], fields.judul.isInvalid],
        ["isi", [fields.isi.visible && fields.isi.required ? ew.Validators.required(fields.isi.caption) : null], fields.isi.isInvalid],
        ["kategori_id", [fields.kategori_id.visible && fields.kategori_id.required ? ew.Validators.required(fields.kategori_id.caption) : null], fields.kategori_id.isInvalid],
        ["tanggal_publikasi", [fields.tanggal_publikasi.visible && fields.tanggal_publikasi.required ? ew.Validators.required(fields.tanggal_publikasi.caption) : null, ew.Validators.datetime(14)], fields.tanggal_publikasi.isInvalid],
        ["penulis", [fields.penulis.visible && fields.penulis.required ? ew.Validators.required(fields.penulis.caption) : null], fields.penulis.isInvalid],
        ["gambar", [fields.gambar.visible && fields.gambar.required ? ew.Validators.fileRequired(fields.gambar.caption) : null], fields.gambar.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid],
        ["user_updated", [fields.user_updated.visible && fields.user_updated.required ? ew.Validators.required(fields.user_updated.caption) : null], fields.user_updated.isInvalid],
        ["publish", [fields.publish.visible && fields.publish.required ? ew.Validators.required(fields.publish.caption) : null], fields.publish.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_beritaedit,
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
    fw_beritaedit.validate = function () {
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
    fw_beritaedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_beritaedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_beritaedit.lists.kategori_id = <?= $Page->kategori_id->toClientList($Page) ?>;
    fw_beritaedit.lists.publish = <?= $Page->publish->toClientList($Page) ?>;
    loadjs.done("fw_beritaedit");
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
<form name="fw_beritaedit" id="fw_beritaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_berita">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_w_berita_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_w_berita_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_berita" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->judul->Visible) { // judul ?>
    <div id="r_judul" class="form-group row">
        <label id="elh_w_berita_judul" for="x_judul" class="<?= $Page->LeftColumnClass ?>"><?= $Page->judul->caption() ?><?= $Page->judul->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->judul->cellAttributes() ?>>
<span id="el_w_berita_judul">
<input type="<?= $Page->judul->getInputTextType() ?>" data-table="w_berita" data-field="x_judul" name="x_judul" id="x_judul" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->judul->getPlaceHolder()) ?>" value="<?= $Page->judul->EditValue ?>"<?= $Page->judul->editAttributes() ?> aria-describedby="x_judul_help">
<?= $Page->judul->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->judul->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isi->Visible) { // isi ?>
    <div id="r_isi" class="form-group row">
        <label id="elh_w_berita_isi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isi->caption() ?><?= $Page->isi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isi->cellAttributes() ?>>
<span id="el_w_berita_isi">
<?php $Page->isi->EditAttrs->appendClass("editor"); ?>
<textarea data-table="w_berita" data-field="x_isi" name="x_isi" id="x_isi" cols="35" rows="8" placeholder="<?= HtmlEncode($Page->isi->getPlaceHolder()) ?>"<?= $Page->isi->editAttributes() ?> aria-describedby="x_isi_help"><?= $Page->isi->EditValue ?></textarea>
<?= $Page->isi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isi->getErrorMessage() ?></div>
<script>
loadjs.ready(["fw_beritaedit", "editor"], function() {
	ew.createEditor("fw_beritaedit", "x_isi", 35, 8, <?= $Page->isi->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategori_id->Visible) { // kategori_id ?>
    <div id="r_kategori_id" class="form-group row">
        <label id="elh_w_berita_kategori_id" for="x_kategori_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kategori_id->caption() ?><?= $Page->kategori_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategori_id->cellAttributes() ?>>
<span id="el_w_berita_kategori_id">
<div class="input-group flex-nowrap">
    <select
        id="x_kategori_id"
        name="x_kategori_id"
        class="form-control ew-select<?= $Page->kategori_id->isInvalidClass() ?>"
        data-select2-id="w_berita_x_kategori_id"
        data-table="w_berita"
        data-field="x_kategori_id"
        data-value-separator="<?= $Page->kategori_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->kategori_id->getPlaceHolder()) ?>"
        <?= $Page->kategori_id->editAttributes() ?>>
        <?= $Page->kategori_id->selectOptionListHtml("x_kategori_id") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "w_kat_berita") && !$Page->kategori_id->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_kategori_id" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->kategori_id->caption() ?>" data-title="<?= $Page->kategori_id->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_kategori_id',url:'<?= GetUrl("wkatberitaaddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<?= $Page->kategori_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategori_id->getErrorMessage() ?></div>
<?= $Page->kategori_id->Lookup->getParamTag($Page, "p_x_kategori_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_berita_x_kategori_id']"),
        options = { name: "x_kategori_id", selectId: "w_berita_x_kategori_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_berita.fields.kategori_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_publikasi->Visible) { // tanggal_publikasi ?>
    <div id="r_tanggal_publikasi" class="form-group row">
        <label id="elh_w_berita_tanggal_publikasi" for="x_tanggal_publikasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_publikasi->caption() ?><?= $Page->tanggal_publikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_publikasi->cellAttributes() ?>>
<span id="el_w_berita_tanggal_publikasi">
<input type="<?= $Page->tanggal_publikasi->getInputTextType() ?>" data-table="w_berita" data-field="x_tanggal_publikasi" data-format="14" name="x_tanggal_publikasi" id="x_tanggal_publikasi" maxlength="19" placeholder="<?= HtmlEncode($Page->tanggal_publikasi->getPlaceHolder()) ?>" value="<?= $Page->tanggal_publikasi->EditValue ?>"<?= $Page->tanggal_publikasi->editAttributes() ?> aria-describedby="x_tanggal_publikasi_help">
<?= $Page->tanggal_publikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_publikasi->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_publikasi->ReadOnly && !$Page->tanggal_publikasi->Disabled && !isset($Page->tanggal_publikasi->EditAttrs["readonly"]) && !isset($Page->tanggal_publikasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fw_beritaedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fw_beritaedit", "x_tanggal_publikasi", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->penulis->Visible) { // penulis ?>
    <div id="r_penulis" class="form-group row">
        <label id="elh_w_berita_penulis" for="x_penulis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->penulis->caption() ?><?= $Page->penulis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->penulis->cellAttributes() ?>>
<span id="el_w_berita_penulis">
<input type="<?= $Page->penulis->getInputTextType() ?>" data-table="w_berita" data-field="x_penulis" name="x_penulis" id="x_penulis" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->penulis->getPlaceHolder()) ?>" value="<?= $Page->penulis->EditValue ?>"<?= $Page->penulis->editAttributes() ?> aria-describedby="x_penulis_help">
<?= $Page->penulis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->penulis->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
    <div id="r_gambar" class="form-group row">
        <label id="elh_w_berita_gambar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gambar->caption() ?><?= $Page->gambar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gambar->cellAttributes() ?>>
<span id="el_w_berita_gambar">
<div id="fd_x_gambar">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->gambar->title() ?>" data-table="w_berita" data-field="x_gambar" name="x_gambar" id="x_gambar" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->gambar->editAttributes() ?><?= ($Page->gambar->ReadOnly || $Page->gambar->Disabled) ? " disabled" : "" ?> aria-describedby="x_gambar_help">
        <label class="custom-file-label ew-file-label" for="x_gambar"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->gambar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gambar->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_gambar" id= "fn_x_gambar" value="<?= $Page->gambar->Upload->FileName ?>">
<input type="hidden" name="fa_x_gambar" id= "fa_x_gambar" value="<?= (Post("fa_x_gambar") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_gambar" id= "fs_x_gambar" value="65535">
<input type="hidden" name="fx_x_gambar" id= "fx_x_gambar" value="<?= $Page->gambar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_gambar" id= "fm_x_gambar" value="<?= $Page->gambar->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_gambar" id= "fc_x_gambar" value="<?= $Page->gambar->UploadMaxFileCount ?>">
</div>
<table id="ft_x_gambar" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->publish->Visible) { // publish ?>
    <div id="r_publish" class="form-group row">
        <label id="elh_w_berita_publish" class="<?= $Page->LeftColumnClass ?>"><?= $Page->publish->caption() ?><?= $Page->publish->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->publish->cellAttributes() ?>>
<span id="el_w_berita_publish">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->publish->isInvalidClass() ?>" data-table="w_berita" data-field="x_publish" name="x_publish[]" id="x_publish_853195" value="1"<?= ConvertToBool($Page->publish->CurrentValue) ? " checked" : "" ?><?= $Page->publish->editAttributes() ?> aria-describedby="x_publish_help">
    <label class="custom-control-label" for="x_publish_853195"></label>
</div>
<?= $Page->publish->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->publish->getErrorMessage() ?></div>
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
    ew.addEventHandlers("w_berita");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
