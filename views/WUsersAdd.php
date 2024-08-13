<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WUsersAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_usersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fw_usersadd = currentForm = new ew.Form("fw_usersadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_users)
        ew.vars.tables.w_users = currentTable;
    fw_usersadd.addFields([
        ["user_email", [fields.user_email.visible && fields.user_email.required ? ew.Validators.required(fields.user_email.caption) : null, ew.Validators.email], fields.user_email.isInvalid],
        ["no_hp", [fields.no_hp.visible && fields.no_hp.required ? ew.Validators.required(fields.no_hp.caption) : null], fields.no_hp.isInvalid],
        ["pass", [fields.pass.visible && fields.pass.required ? ew.Validators.required(fields.pass.caption) : null], fields.pass.isInvalid],
        ["_userlevel", [fields._userlevel.visible && fields._userlevel.required ? ew.Validators.required(fields._userlevel.caption) : null], fields._userlevel.isInvalid],
        ["aktif", [fields.aktif.visible && fields.aktif.required ? ew.Validators.required(fields.aktif.caption) : null], fields.aktif.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null], fields.created_at.isInvalid],
        ["user_created_by", [fields.user_created_by.visible && fields.user_created_by.required ? ew.Validators.required(fields.user_created_by.caption) : null], fields.user_created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_usersadd,
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
    fw_usersadd.validate = function () {
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
    fw_usersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_usersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_usersadd.lists.pass = <?= $Page->pass->toClientList($Page) ?>;
    fw_usersadd.lists._userlevel = <?= $Page->_userlevel->toClientList($Page) ?>;
    fw_usersadd.lists.aktif = <?= $Page->aktif->toClientList($Page) ?>;
    loadjs.done("fw_usersadd");
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
<form name="fw_usersadd" id="fw_usersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_users">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->user_email->Visible) { // user_email ?>
    <div id="r_user_email" class="form-group row">
        <label id="elh_w_users_user_email" for="x_user_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_email->caption() ?><?= $Page->user_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_email->cellAttributes() ?>>
<span id="el_w_users_user_email">
<input type="<?= $Page->user_email->getInputTextType() ?>" data-table="w_users" data-field="x_user_email" name="x_user_email" id="x_user_email" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_email->getPlaceHolder()) ?>" value="<?= $Page->user_email->EditValue ?>"<?= $Page->user_email->editAttributes() ?> aria-describedby="x_user_email_help">
<?= $Page->user_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <div id="r_no_hp" class="form-group row">
        <label id="elh_w_users_no_hp" for="x_no_hp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_hp->caption() ?><?= $Page->no_hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_hp->cellAttributes() ?>>
<span id="el_w_users_no_hp">
<input type="<?= $Page->no_hp->getInputTextType() ?>" data-table="w_users" data-field="x_no_hp" name="x_no_hp" id="x_no_hp" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->no_hp->getPlaceHolder()) ?>" value="<?= $Page->no_hp->EditValue ?>"<?= $Page->no_hp->editAttributes() ?> aria-describedby="x_no_hp_help">
<?= $Page->no_hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_hp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pass->Visible) { // pass ?>
    <div id="r_pass" class="form-group row">
        <label id="elh_w_users_pass" for="x_pass" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pass->caption() ?><?= $Page->pass->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pass->cellAttributes() ?>>
<span id="el_w_users_pass">
    <select
        id="x_pass"
        name="x_pass"
        class="form-control ew-select<?= $Page->pass->isInvalidClass() ?>"
        data-select2-id="w_users_x_pass"
        data-table="w_users"
        data-field="x_pass"
        data-value-separator="<?= $Page->pass->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pass->getPlaceHolder()) ?>"
        <?= $Page->pass->editAttributes() ?>>
        <?= $Page->pass->selectOptionListHtml("x_pass") ?>
    </select>
    <?= $Page->pass->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pass->getErrorMessage() ?></div>
<?= $Page->pass->Lookup->getParamTag($Page, "p_x_pass") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_users_x_pass']"),
        options = { name: "x_pass", selectId: "w_users_x_pass", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_users.fields.pass.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
    <div id="r__userlevel" class="form-group row">
        <label id="elh_w_users__userlevel" for="x__userlevel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_userlevel->caption() ?><?= $Page->_userlevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_userlevel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_w_users__userlevel">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_userlevel->getDisplayValue($Page->_userlevel->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el_w_users__userlevel">
    <select
        id="x__userlevel"
        name="x__userlevel"
        class="form-control ew-select<?= $Page->_userlevel->isInvalidClass() ?>"
        data-select2-id="w_users_x__userlevel"
        data-table="w_users"
        data-field="x__userlevel"
        data-value-separator="<?= $Page->_userlevel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_userlevel->getPlaceHolder()) ?>"
        <?= $Page->_userlevel->editAttributes() ?>>
        <?= $Page->_userlevel->selectOptionListHtml("x__userlevel") ?>
    </select>
    <?= $Page->_userlevel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_userlevel->getErrorMessage() ?></div>
<?= $Page->_userlevel->Lookup->getParamTag($Page, "p_x__userlevel") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='w_users_x__userlevel']"),
        options = { name: "x__userlevel", selectId: "w_users_x__userlevel", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.w_users.fields._userlevel.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif" class="form-group row">
        <label id="elh_w_users_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktif->caption() ?><?= $Page->aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktif->cellAttributes() ?>>
<span id="el_w_users_aktif">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->aktif->isInvalidClass() ?>" data-table="w_users" data-field="x_aktif" name="x_aktif[]" id="x_aktif_580249" value="1"<?= ConvertToBool($Page->aktif->CurrentValue) ? " checked" : "" ?><?= $Page->aktif->editAttributes() ?> aria-describedby="x_aktif_help">
    <label class="custom-control-label" for="x_aktif_580249"></label>
</div>
<?= $Page->aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aktif->getErrorMessage() ?></div>
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
    ew.addEventHandlers("w_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
