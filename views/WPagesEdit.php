<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WPagesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_pagesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fw_pagesedit = currentForm = new ew.Form("fw_pagesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_pages")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_pages)
        ew.vars.tables.w_pages = currentTable;
    fw_pagesedit.addFields([
        ["page_id", [fields.page_id.visible && fields.page_id.required ? ew.Validators.required(fields.page_id.caption) : null], fields.page_id.isInvalid],
        ["page_name", [fields.page_name.visible && fields.page_name.required ? ew.Validators.required(fields.page_name.caption) : null], fields.page_name.isInvalid],
        ["page_content", [fields.page_content.visible && fields.page_content.required ? ew.Validators.required(fields.page_content.caption) : null], fields.page_content.isInvalid],
        ["custom_url", [fields.custom_url.visible && fields.custom_url.required ? ew.Validators.required(fields.custom_url.caption) : null], fields.custom_url.isInvalid],
        ["external_link", [fields.external_link.visible && fields.external_link.required ? ew.Validators.required(fields.external_link.caption) : null], fields.external_link.isInvalid],
        ["updated_date", [fields.updated_date.visible && fields.updated_date.required ? ew.Validators.required(fields.updated_date.caption) : null], fields.updated_date.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_pagesedit,
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
    fw_pagesedit.validate = function () {
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
    fw_pagesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_pagesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fw_pagesedit");
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
<form name="fw_pagesedit" id="fw_pagesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_pages">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->page_id->Visible) { // page_id ?>
    <div id="r_page_id" class="form-group row">
        <label id="elh_w_pages_page_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->page_id->caption() ?><?= $Page->page_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->page_id->cellAttributes() ?>>
<span id="el_w_pages_page_id">
<input type="<?= $Page->page_id->getInputTextType() ?>" data-table="w_pages" data-field="x_page_id" name="x_page_id" id="x_page_id" maxlength="9" placeholder="<?= HtmlEncode($Page->page_id->getPlaceHolder()) ?>" value="<?= $Page->page_id->EditValue ?>"<?= $Page->page_id->editAttributes() ?> aria-describedby="x_page_id_help">
<?= $Page->page_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->page_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->page_name->Visible) { // page_name ?>
    <div id="r_page_name" class="form-group row">
        <label id="elh_w_pages_page_name" for="x_page_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->page_name->caption() ?><?= $Page->page_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->page_name->cellAttributes() ?>>
<span id="el_w_pages_page_name">
<input type="<?= $Page->page_name->getInputTextType() ?>" data-table="w_pages" data-field="x_page_name" name="x_page_name" id="x_page_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->page_name->getPlaceHolder()) ?>" value="<?= $Page->page_name->EditValue ?>"<?= $Page->page_name->editAttributes() ?> aria-describedby="x_page_name_help">
<?= $Page->page_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->page_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->page_content->Visible) { // page_content ?>
    <div id="r_page_content" class="form-group row">
        <label id="elh_w_pages_page_content" for="x_page_content" class="<?= $Page->LeftColumnClass ?>"><?= $Page->page_content->caption() ?><?= $Page->page_content->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->page_content->cellAttributes() ?>>
<span id="el_w_pages_page_content">
<textarea data-table="w_pages" data-field="x_page_content" name="x_page_content" id="x_page_content" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->page_content->getPlaceHolder()) ?>"<?= $Page->page_content->editAttributes() ?> aria-describedby="x_page_content_help"><?= $Page->page_content->EditValue ?></textarea>
<?= $Page->page_content->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->page_content->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->custom_url->Visible) { // custom_url ?>
    <div id="r_custom_url" class="form-group row">
        <label id="elh_w_pages_custom_url" for="x_custom_url" class="<?= $Page->LeftColumnClass ?>"><?= $Page->custom_url->caption() ?><?= $Page->custom_url->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->custom_url->cellAttributes() ?>>
<input type="<?= $Page->custom_url->getInputTextType() ?>" data-table="w_pages" data-field="x_custom_url" name="x_custom_url" id="x_custom_url" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->custom_url->getPlaceHolder()) ?>" value="<?= $Page->custom_url->EditValue ?>"<?= $Page->custom_url->editAttributes() ?> aria-describedby="x_custom_url_help">
<?= $Page->custom_url->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->custom_url->getErrorMessage() ?></div>
<input type="hidden" data-table="w_pages" data-field="x_custom_url" data-hidden="1" name="o_custom_url" id="o_custom_url" value="<?= HtmlEncode($Page->custom_url->OldValue ?? $Page->custom_url->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->external_link->Visible) { // external_link ?>
    <div id="r_external_link" class="form-group row">
        <label id="elh_w_pages_external_link" for="x_external_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->external_link->caption() ?><?= $Page->external_link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->external_link->cellAttributes() ?>>
<span id="el_w_pages_external_link">
<input type="<?= $Page->external_link->getInputTextType() ?>" data-table="w_pages" data-field="x_external_link" name="x_external_link" id="x_external_link" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->external_link->getPlaceHolder()) ?>" value="<?= $Page->external_link->EditValue ?>"<?= $Page->external_link->editAttributes() ?> aria-describedby="x_external_link_help">
<?= $Page->external_link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->external_link->getErrorMessage() ?></div>
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
    ew.addEventHandlers("w_pages");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
