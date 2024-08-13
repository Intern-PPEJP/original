<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$WKatBeritaAddopt = &$Page;
?>
<script>
var currentForm, currentPageID;
var fw_kat_beritaaddopt;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "addopt";
    fw_kat_beritaaddopt = currentForm = new ew.Form("fw_kat_beritaaddopt", "addopt");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_kat_berita")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_kat_berita)
        ew.vars.tables.w_kat_berita = currentTable;
    fw_kat_beritaaddopt.addFields([
        ["nama_kategori", [fields.nama_kategori.visible && fields.nama_kategori.required ? ew.Validators.required(fields.nama_kategori.caption) : null], fields.nama_kategori.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fw_kat_beritaaddopt,
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
    fw_kat_beritaaddopt.validate = function () {
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
        return true;
    }

    // Form_CustomValidate
    fw_kat_beritaaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fw_kat_beritaaddopt.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fw_kat_beritaaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="fw_kat_beritaaddopt" id="fw_kat_beritaaddopt" class="ew-form ew-horizontal" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="w_kat_berita">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->nama_kategori->Visible) { // nama_kategori ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_nama_kategori"><?= $Page->nama_kategori->caption() ?><?= $Page->nama_kategori->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->nama_kategori->getInputTextType() ?>" data-table="w_kat_berita" data-field="x_nama_kategori" name="x_nama_kategori" id="x_nama_kategori" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama_kategori->getPlaceHolder()) ?>" value="<?= $Page->nama_kategori->EditValue ?>"<?= $Page->nama_kategori->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nama_kategori->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("w_kat_berita");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
