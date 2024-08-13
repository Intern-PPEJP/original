<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WOrdersEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_ordersedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fw_ordersedit = currentForm = new ew.Form("fw_ordersedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_orders")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_orders)
        ew.vars.tables.w_orders = currentTable;
    fw_ordersedit.addFields([
        ["order_id", [fields.order_id.visible && fields.order_id.required ? ew.Validators.required(fields.order_id.caption) : null], fields.order_id.isInvalid],
        ["nama_peserta", [fields.nama_peserta.visible && fields.nama_peserta.required ? ew.Validators.required(fields.nama_peserta.caption) : null], fields.nama_peserta.isInvalid],
        ["nama_perusahaan", [fields.nama_perusahaan.visible && fields.nama_perusahaan.required ? ew.Validators.required(fields.nama_perusahaan.caption) : null], fields.nama_perusahaan.isInvalid],
        ["pelatihan_id", [fields.pelatihan_id.visible && fields.pelatihan_id.required ? ew.Validators.required(fields.pelatihan_id.caption) : null], fields.pelatihan_id.isInvalid],
        ["Biaya", [fields.Biaya.visible && fields.Biaya.required ? ew.Validators.required(fields.Biaya.caption) : null], fields.Biaya.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_ordersedit,
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
    fw_ordersedit.validate = function () {
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
    fw_ordersedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_ordersedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fw_ordersedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fw_ordersedit");
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
<form name="fw_ordersedit" id="fw_ordersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="w_orders">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->order_id->Visible) { // order_id ?>
    <div id="r_order_id" class="form-group row">
        <label id="elh_w_orders_order_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->order_id->caption() ?><?= $Page->order_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->order_id->cellAttributes() ?>>
<span id="el_w_orders_order_id">
<span<?= $Page->order_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->order_id->getDisplayValue($Page->order_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_orders" data-field="x_order_id" data-hidden="1" name="x_order_id" id="x_order_id" value="<?= HtmlEncode($Page->order_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_peserta->Visible) { // nama_peserta ?>
    <div id="r_nama_peserta" class="form-group row">
        <label id="elh_w_orders_nama_peserta" for="x_nama_peserta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_peserta->caption() ?><?= $Page->nama_peserta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_peserta->cellAttributes() ?>>
<span id="el_w_orders_nama_peserta">
<span<?= $Page->nama_peserta->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nama_peserta->getDisplayValue($Page->nama_peserta->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_orders" data-field="x_nama_peserta" data-hidden="1" name="x_nama_peserta" id="x_nama_peserta" value="<?= HtmlEncode($Page->nama_peserta->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
    <div id="r_nama_perusahaan" class="form-group row">
        <label id="elh_w_orders_nama_perusahaan" for="x_nama_perusahaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_perusahaan->caption() ?><?= $Page->nama_perusahaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_perusahaan->cellAttributes() ?>>
<span id="el_w_orders_nama_perusahaan">
<span<?= $Page->nama_perusahaan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nama_perusahaan->getDisplayValue($Page->nama_perusahaan->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_orders" data-field="x_nama_perusahaan" data-hidden="1" name="x_nama_perusahaan" id="x_nama_perusahaan" value="<?= HtmlEncode($Page->nama_perusahaan->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pelatihan_id->Visible) { // pelatihan_id ?>
    <div id="r_pelatihan_id" class="form-group row">
        <label id="elh_w_orders_pelatihan_id" for="x_pelatihan_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pelatihan_id->caption() ?><?= $Page->pelatihan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pelatihan_id->cellAttributes() ?>>
<span id="el_w_orders_pelatihan_id">
<span<?= $Page->pelatihan_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pelatihan_id->getDisplayValue($Page->pelatihan_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_orders" data-field="x_pelatihan_id" data-hidden="1" name="x_pelatihan_id" id="x_pelatihan_id" value="<?= HtmlEncode($Page->pelatihan_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Biaya->Visible) { // Biaya ?>
    <div id="r_Biaya" class="form-group row">
        <label id="elh_w_orders_Biaya" for="x_Biaya" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Biaya->caption() ?><?= $Page->Biaya->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Biaya->cellAttributes() ?>>
<span id="el_w_orders_Biaya">
<span<?= $Page->Biaya->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Biaya->getDisplayValue($Page->Biaya->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="w_orders" data-field="x_Biaya" data-hidden="1" name="x_Biaya" id="x_Biaya" value="<?= HtmlEncode($Page->Biaya->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_w_orders_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_w_orders_status">
<template id="tp_x_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="w_orders" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="w_orders"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
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
    ew.addEventHandlers("w_orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
