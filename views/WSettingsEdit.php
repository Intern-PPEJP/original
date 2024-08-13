<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WSettingsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_settingsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fw_settingsedit = currentForm = new ew.Form("fw_settingsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_settings")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_settings)
        ew.vars.tables.w_settings = currentTable;
    fw_settingsedit.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Logo", [fields.Logo.visible && fields.Logo.required ? ew.Validators.fileRequired(fields.Logo.caption) : null], fields.Logo.isInvalid],
        ["Login_Picture", [fields.Login_Picture.visible && fields.Login_Picture.required ? ew.Validators.fileRequired(fields.Login_Picture.caption) : null], fields.Login_Picture.isInvalid],
        ["Register_Picture", [fields.Register_Picture.visible && fields.Register_Picture.required ? ew.Validators.fileRequired(fields.Register_Picture.caption) : null], fields.Register_Picture.isInvalid],
        ["Popup_Show", [fields.Popup_Show.visible && fields.Popup_Show.required ? ew.Validators.required(fields.Popup_Show.caption) : null], fields.Popup_Show.isInvalid],
        ["Popup_Picture", [fields.Popup_Picture.visible && fields.Popup_Picture.required ? ew.Validators.fileRequired(fields.Popup_Picture.caption) : null], fields.Popup_Picture.isInvalid],
        ["Popup_Link", [fields.Popup_Link.visible && fields.Popup_Link.required ? ew.Validators.required(fields.Popup_Link.caption) : null], fields.Popup_Link.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_settingsedit,
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
    fw_settingsedit.validate = function () {
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
    fw_settingsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_settingsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Multi-Page
    fw_settingsedit.multiPage = new ew.MultiPage("fw_settingsedit");

    // Dynamic selection lists
    fw_settingsedit.lists.Popup_Show = <?= $Page->Popup_Show->toClientList($Page) ?>;
    loadjs.done("fw_settingsedit");
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
<form name="fw_settingsedit" id="fw_settingsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_settings">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav-tabs" id="Page"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navStyle() ?>">
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(1) ?>" href="#tab_w_settings1" data-toggle="tab"><?= $Page->pageCaption(1) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(2) ?>" href="#tab_w_settings2" data-toggle="tab"><?= $Page->pageCaption(2) ?></a></li>
    </ul>
    <div class="tab-content"><!-- multi-page tabs .tab-content -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(1) ?>" id="tab_w_settings1"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Logo->Visible) { // Logo ?>
    <div id="r_Logo" class="form-group row">
        <label id="elh_w_settings_Logo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Logo->caption() ?><?= $Page->Logo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Logo->cellAttributes() ?>>
<span id="el_w_settings_Logo">
<div id="fd_x_Logo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->Logo->title() ?>" data-table="w_settings" data-field="x_Logo" data-page="1" name="x_Logo" id="x_Logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->Logo->editAttributes() ?><?= ($Page->Logo->ReadOnly || $Page->Logo->Disabled) ? " disabled" : "" ?> aria-describedby="x_Logo_help">
        <label class="custom-file-label ew-file-label" for="x_Logo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->Logo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Logo" id= "fn_x_Logo" value="<?= $Page->Logo->Upload->FileName ?>">
<input type="hidden" name="fa_x_Logo" id= "fa_x_Logo" value="<?= (Post("fa_x_Logo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_Logo" id= "fs_x_Logo" value="20">
<input type="hidden" name="fx_x_Logo" id= "fx_x_Logo" value="<?= $Page->Logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Logo" id= "fm_x_Logo" value="<?= $Page->Logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Logo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Login_Picture->Visible) { // Login_Picture ?>
    <div id="r_Login_Picture" class="form-group row">
        <label id="elh_w_settings_Login_Picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Login_Picture->caption() ?><?= $Page->Login_Picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Login_Picture->cellAttributes() ?>>
<span id="el_w_settings_Login_Picture">
<div id="fd_x_Login_Picture">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->Login_Picture->title() ?>" data-table="w_settings" data-field="x_Login_Picture" data-page="1" name="x_Login_Picture" id="x_Login_Picture" lang="<?= CurrentLanguageID() ?>"<?= $Page->Login_Picture->editAttributes() ?><?= ($Page->Login_Picture->ReadOnly || $Page->Login_Picture->Disabled) ? " disabled" : "" ?> aria-describedby="x_Login_Picture_help">
        <label class="custom-file-label ew-file-label" for="x_Login_Picture"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->Login_Picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Login_Picture->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Login_Picture" id= "fn_x_Login_Picture" value="<?= $Page->Login_Picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_Login_Picture" id= "fa_x_Login_Picture" value="<?= (Post("fa_x_Login_Picture") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_Login_Picture" id= "fs_x_Login_Picture" value="20">
<input type="hidden" name="fx_x_Login_Picture" id= "fx_x_Login_Picture" value="<?= $Page->Login_Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Login_Picture" id= "fm_x_Login_Picture" value="<?= $Page->Login_Picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Login_Picture" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Register_Picture->Visible) { // Register_Picture ?>
    <div id="r_Register_Picture" class="form-group row">
        <label id="elh_w_settings_Register_Picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Register_Picture->caption() ?><?= $Page->Register_Picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Register_Picture->cellAttributes() ?>>
<span id="el_w_settings_Register_Picture">
<div id="fd_x_Register_Picture">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->Register_Picture->title() ?>" data-table="w_settings" data-field="x_Register_Picture" data-page="1" name="x_Register_Picture" id="x_Register_Picture" lang="<?= CurrentLanguageID() ?>"<?= $Page->Register_Picture->editAttributes() ?><?= ($Page->Register_Picture->ReadOnly || $Page->Register_Picture->Disabled) ? " disabled" : "" ?> aria-describedby="x_Register_Picture_help">
        <label class="custom-file-label ew-file-label" for="x_Register_Picture"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->Register_Picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Register_Picture->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Register_Picture" id= "fn_x_Register_Picture" value="<?= $Page->Register_Picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_Register_Picture" id= "fa_x_Register_Picture" value="<?= (Post("fa_x_Register_Picture") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_Register_Picture" id= "fs_x_Register_Picture" value="20">
<input type="hidden" name="fx_x_Register_Picture" id= "fx_x_Register_Picture" value="<?= $Page->Register_Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Register_Picture" id= "fm_x_Register_Picture" value="<?= $Page->Register_Picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Register_Picture" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(2) ?>" id="tab_w_settings2"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Popup_Show->Visible) { // Popup_Show ?>
    <div id="r_Popup_Show" class="form-group row">
        <label id="elh_w_settings_Popup_Show" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Popup_Show->caption() ?><?= $Page->Popup_Show->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Popup_Show->cellAttributes() ?>>
<span id="el_w_settings_Popup_Show">
<template id="tp_x_Popup_Show">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="w_settings" data-field="x_Popup_Show" name="x_Popup_Show" id="x_Popup_Show"<?= $Page->Popup_Show->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_Popup_Show" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_Popup_Show"
    name="x_Popup_Show"
    value="<?= HtmlEncode($Page->Popup_Show->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Popup_Show"
    data-target="dsl_x_Popup_Show"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Popup_Show->isInvalidClass() ?>"
    data-table="w_settings"
    data-field="x_Popup_Show"
    data-page="2"
    data-value-separator="<?= $Page->Popup_Show->displayValueSeparatorAttribute() ?>"
    <?= $Page->Popup_Show->editAttributes() ?>>
<?= $Page->Popup_Show->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Popup_Show->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Popup_Picture->Visible) { // Popup_Picture ?>
    <div id="r_Popup_Picture" class="form-group row">
        <label id="elh_w_settings_Popup_Picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Popup_Picture->caption() ?><?= $Page->Popup_Picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Popup_Picture->cellAttributes() ?>>
<span id="el_w_settings_Popup_Picture">
<div id="fd_x_Popup_Picture">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->Popup_Picture->title() ?>" data-table="w_settings" data-field="x_Popup_Picture" data-page="2" name="x_Popup_Picture" id="x_Popup_Picture" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->Popup_Picture->editAttributes() ?><?= ($Page->Popup_Picture->ReadOnly || $Page->Popup_Picture->Disabled) ? " disabled" : "" ?> aria-describedby="x_Popup_Picture_help">
        <label class="custom-file-label ew-file-label" for="x_Popup_Picture"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->Popup_Picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Popup_Picture->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Popup_Picture" id= "fn_x_Popup_Picture" value="<?= $Page->Popup_Picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_Popup_Picture" id= "fa_x_Popup_Picture" value="<?= (Post("fa_x_Popup_Picture") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_Popup_Picture" id= "fs_x_Popup_Picture" value="65535">
<input type="hidden" name="fx_x_Popup_Picture" id= "fx_x_Popup_Picture" value="<?= $Page->Popup_Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Popup_Picture" id= "fm_x_Popup_Picture" value="<?= $Page->Popup_Picture->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_Popup_Picture" id= "fc_x_Popup_Picture" value="<?= $Page->Popup_Picture->UploadMaxFileCount ?>">
</div>
<table id="ft_x_Popup_Picture" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Popup_Link->Visible) { // Popup_Link ?>
    <div id="r_Popup_Link" class="form-group row">
        <label id="elh_w_settings_Popup_Link" for="x_Popup_Link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Popup_Link->caption() ?><?= $Page->Popup_Link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Popup_Link->cellAttributes() ?>>
<span id="el_w_settings_Popup_Link">
<textarea data-table="w_settings" data-field="x_Popup_Link" data-page="2" name="x_Popup_Link" id="x_Popup_Link" cols="35" rows="2" placeholder="<?= HtmlEncode($Page->Popup_Link->getPlaceHolder()) ?>"<?= $Page->Popup_Link->editAttributes() ?> aria-describedby="x_Popup_Link_help"><?= $Page->Popup_Link->EditValue ?></textarea>
<?= $Page->Popup_Link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Popup_Link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<span id="el_w_settings_ID">
<input type="hidden" data-table="w_settings" data-field="x_ID" data-hidden="1" data-page="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
</span>
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
    ew.addEventHandlers("w_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#fd_x_Logo").after("<p class='alert alert-default small p-1 m-0'><i class='fa fa-info-circle'></i> Ukuran gambar 191x59px ekstensi .png</p>"),$("#fd_x_Login_Picture").after("<p class='alert alert-default small p-1 m-0'><i class='fa fa-info-circle'></i> Ukuran gambar 500x662px ekstensi .png</p>"),$("#fd_x_Register_Picture").after("<p class='alert alert-default small p-1 m-0'><i class='fa fa-info-circle'></i> Ukuran gambar 385x583px ekstensi .png</p>"),$("#fd_x_Popup_Picture").after("<p class='alert alert-default small p-1 m-0'><i class='fa fa-info-circle'></i> Gambar bisa lebih dari satu</p>"),$("#x_Popup_Link").after("<p class='alert alert-default small p-1 m-0'><i class='fa fa-info-circle'></i> Link pisahkan dengan tanda koma (,) sesuai urutan gambar dan jumlah gambar</p>"),$("#btn-cancel,.text-muted").hide();
});
</script>
