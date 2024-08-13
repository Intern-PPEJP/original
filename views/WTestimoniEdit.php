<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WTestimoniEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_testimoniedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fw_testimoniedit = currentForm = new ew.Form("fw_testimoniedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_testimoni")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_testimoni)
        ew.vars.tables.w_testimoni = currentTable;
    fw_testimoniedit.addFields([
        ["testimoni_id", [fields.testimoni_id.visible && fields.testimoni_id.required ? ew.Validators.required(fields.testimoni_id.caption) : null], fields.testimoni_id.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["gambar", [fields.gambar.visible && fields.gambar.required ? ew.Validators.fileRequired(fields.gambar.caption) : null], fields.gambar.isInvalid],
        ["testimoni", [fields.testimoni.visible && fields.testimoni.required ? ew.Validators.required(fields.testimoni.caption) : null], fields.testimoni.isInvalid],
        ["link_testimoni", [fields.link_testimoni.visible && fields.link_testimoni.required ? ew.Validators.required(fields.link_testimoni.caption) : null], fields.link_testimoni.isInvalid],
        ["show", [fields.show.visible && fields.show.required ? ew.Validators.required(fields.show.caption) : null], fields.show.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_testimoniedit,
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
    fw_testimoniedit.validate = function () {
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
    fw_testimoniedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_testimoniedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_testimoniedit.lists.show = <?= $Page->show->toClientList($Page) ?>;
    loadjs.done("fw_testimoniedit");
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
<form name="fw_testimoniedit" id="fw_testimoniedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_testimoni">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->testimoni_id->Visible) { // testimoni_id ?>
    <div id="r_testimoni_id" class="form-group row">
        <label id="elh_w_testimoni_testimoni_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testimoni_id->caption() ?><?= $Page->testimoni_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->testimoni_id->cellAttributes() ?>>
<span id="el_w_testimoni_testimoni_id">
<span<?= $Page->testimoni_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->testimoni_id->getDisplayValue($Page->testimoni_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_testimoni" data-field="x_testimoni_id" data-hidden="1" name="x_testimoni_id" id="x_testimoni_id" value="<?= HtmlEncode($Page->testimoni_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_w_testimoni_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_w_testimoni_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="w_testimoni" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gambar->Visible) { // gambar ?>
    <div id="r_gambar" class="form-group row">
        <label id="elh_w_testimoni_gambar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gambar->caption() ?><?= $Page->gambar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gambar->cellAttributes() ?>>
<span id="el_w_testimoni_gambar">
<div id="fd_x_gambar">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->gambar->title() ?>" data-table="w_testimoni" data-field="x_gambar" name="x_gambar" id="x_gambar" lang="<?= CurrentLanguageID() ?>"<?= $Page->gambar->editAttributes() ?><?= ($Page->gambar->ReadOnly || $Page->gambar->Disabled) ? " disabled" : "" ?> aria-describedby="x_gambar_help">
        <label class="custom-file-label ew-file-label" for="x_gambar"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->gambar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gambar->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_gambar" id= "fn_x_gambar" value="<?= $Page->gambar->Upload->FileName ?>">
<input type="hidden" name="fa_x_gambar" id= "fa_x_gambar" value="<?= (Post("fa_x_gambar") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_gambar" id= "fs_x_gambar" value="200">
<input type="hidden" name="fx_x_gambar" id= "fx_x_gambar" value="<?= $Page->gambar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_gambar" id= "fm_x_gambar" value="<?= $Page->gambar->UploadMaxFileSize ?>">
</div>
<table id="ft_x_gambar" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testimoni->Visible) { // testimoni ?>
    <div id="r_testimoni" class="form-group row">
        <label id="elh_w_testimoni_testimoni" for="x_testimoni" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testimoni->caption() ?><?= $Page->testimoni->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->testimoni->cellAttributes() ?>>
<span id="el_w_testimoni_testimoni">
<input type="<?= $Page->testimoni->getInputTextType() ?>" data-table="w_testimoni" data-field="x_testimoni" name="x_testimoni" id="x_testimoni" size="50" maxlength="200" placeholder="<?= HtmlEncode($Page->testimoni->getPlaceHolder()) ?>" value="<?= $Page->testimoni->EditValue ?>"<?= $Page->testimoni->editAttributes() ?> aria-describedby="x_testimoni_help">
<?= $Page->testimoni->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testimoni->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->link_testimoni->Visible) { // link_testimoni ?>
    <div id="r_link_testimoni" class="form-group row">
        <label id="elh_w_testimoni_link_testimoni" for="x_link_testimoni" class="<?= $Page->LeftColumnClass ?>"><?= $Page->link_testimoni->caption() ?><?= $Page->link_testimoni->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->link_testimoni->cellAttributes() ?>>
<span id="el_w_testimoni_link_testimoni">
<textarea data-table="w_testimoni" data-field="x_link_testimoni" name="x_link_testimoni" id="x_link_testimoni" cols="35" rows="1" placeholder="<?= HtmlEncode($Page->link_testimoni->getPlaceHolder()) ?>"<?= $Page->link_testimoni->editAttributes() ?> aria-describedby="x_link_testimoni_help"><?= $Page->link_testimoni->EditValue ?></textarea>
<?= $Page->link_testimoni->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->link_testimoni->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->show->Visible) { // show ?>
    <div id="r_show" class="form-group row">
        <label id="elh_w_testimoni_show" class="<?= $Page->LeftColumnClass ?>"><?= $Page->show->caption() ?><?= $Page->show->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->show->cellAttributes() ?>>
<span id="el_w_testimoni_show">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->show->isInvalidClass() ?>" data-table="w_testimoni" data-field="x_show" name="x_show[]" id="x_show_200180" value="1"<?= ConvertToBool($Page->show->CurrentValue) ? " checked" : "" ?><?= $Page->show->editAttributes() ?> aria-describedby="x_show_help">
    <label class="custom-control-label" for="x_show_200180"></label>
</div>
<?= $Page->show->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->show->getErrorMessage() ?></div>
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
    ew.addEventHandlers("w_testimoni");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
