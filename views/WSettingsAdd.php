<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WSettingsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_settingsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fw_settingsadd = currentForm = new ew.Form("fw_settingsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_settings")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_settings)
        ew.vars.tables.w_settings = currentTable;
    fw_settingsadd.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Login_Picture", [fields.Login_Picture.visible && fields.Login_Picture.required ? ew.Validators.required(fields.Login_Picture.caption) : null], fields.Login_Picture.isInvalid],
        ["Daftar_Picture", [fields.Daftar_Picture.visible && fields.Daftar_Picture.required ? ew.Validators.required(fields.Daftar_Picture.caption) : null], fields.Daftar_Picture.isInvalid],
        ["Logo", [fields.Logo.visible && fields.Logo.required ? ew.Validators.required(fields.Logo.caption) : null], fields.Logo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_settingsadd,
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
    fw_settingsadd.validate = function () {
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
    fw_settingsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_settingsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_settingsadd.lists.ID = <?= $Page->ID->toClientList($Page) ?>;
    loadjs.done("fw_settingsadd");
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
<form name="fw_settingsadd" id="fw_settingsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_settings">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID" class="form-group row">
        <label id="elh_w_settings_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID->cellAttributes() ?>>
<span id="el_w_settings_ID">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->ID->isInvalidClass() ?>" data-table="w_settings" data-field="x_ID" name="x_ID[]" id="x_ID_394979" value="1"<?= ConvertToBool($Page->ID->CurrentValue) ? " checked" : "" ?><?= $Page->ID->editAttributes() ?> aria-describedby="x_ID_help">
    <label class="custom-control-label" for="x_ID_394979"></label>
</div>
<?= $Page->ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Login_Picture->Visible) { // Login_Picture ?>
    <div id="r_Login_Picture" class="form-group row">
        <label id="elh_w_settings_Login_Picture" for="x_Login_Picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Login_Picture->caption() ?><?= $Page->Login_Picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Login_Picture->cellAttributes() ?>>
<span id="el_w_settings_Login_Picture">
<input type="<?= $Page->Login_Picture->getInputTextType() ?>" data-table="w_settings" data-field="x_Login_Picture" name="x_Login_Picture" id="x_Login_Picture" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Login_Picture->getPlaceHolder()) ?>" value="<?= $Page->Login_Picture->EditValue ?>"<?= $Page->Login_Picture->editAttributes() ?> aria-describedby="x_Login_Picture_help">
<?= $Page->Login_Picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Login_Picture->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Daftar_Picture->Visible) { // Daftar_Picture ?>
    <div id="r_Daftar_Picture" class="form-group row">
        <label id="elh_w_settings_Daftar_Picture" for="x_Daftar_Picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Daftar_Picture->caption() ?><?= $Page->Daftar_Picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Daftar_Picture->cellAttributes() ?>>
<span id="el_w_settings_Daftar_Picture">
<input type="<?= $Page->Daftar_Picture->getInputTextType() ?>" data-table="w_settings" data-field="x_Daftar_Picture" name="x_Daftar_Picture" id="x_Daftar_Picture" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Daftar_Picture->getPlaceHolder()) ?>" value="<?= $Page->Daftar_Picture->EditValue ?>"<?= $Page->Daftar_Picture->editAttributes() ?> aria-describedby="x_Daftar_Picture_help">
<?= $Page->Daftar_Picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Daftar_Picture->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
    <div id="r_Logo" class="form-group row">
        <label id="elh_w_settings_Logo" for="x_Logo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Logo->caption() ?><?= $Page->Logo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Logo->cellAttributes() ?>>
<span id="el_w_settings_Logo">
<input type="<?= $Page->Logo->getInputTextType() ?>" data-table="w_settings" data-field="x_Logo" name="x_Logo" id="x_Logo" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Logo->getPlaceHolder()) ?>" value="<?= $Page->Logo->EditValue ?>"<?= $Page->Logo->editAttributes() ?> aria-describedby="x_Logo_help">
<?= $Page->Logo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Logo->getErrorMessage() ?></div>
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
    ew.addEventHandlers("w_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
