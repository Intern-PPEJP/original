<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Register = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregister;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "register";
    fregister = currentForm = new ew.Form("fregister", "register");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "w_users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.w_users)
        ew.vars.tables.w_users = currentTable;
    fregister.addFields([
        ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
        ["user_email", [fields.user_email.visible && fields.user_email.required ? ew.Validators.required(fields.user_email.caption) : null, ew.Validators.username(fields.user_email.raw), ew.Validators.email], fields.user_email.isInvalid],
        ["no_hp", [fields.no_hp.visible && fields.no_hp.required ? ew.Validators.required(fields.no_hp.caption) : null], fields.no_hp.isInvalid],
        ["c_pass", [ew.Validators.required(ew.language.phrase("ConfirmPassword")), ew.Validators.mismatchPassword], fields.pass.isInvalid],
        ["pass", [fields.pass.visible && fields.pass.required ? ew.Validators.required(fields.pass.caption) : null, ew.Validators.password(fields.pass.raw)], fields.pass.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fregister,
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
    fregister.validate = function () {
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
    fregister.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregister.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fregister");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="w_users">
<input type="hidden" name="action" id="action" value="insert">
<div class="ew-register-div d-none"><!-- page* -->
<?php if ($Page->user_email->Visible) { // user_email ?>
    <div id="r_user_email" class="form-group row">
        <label id="elh_w_users_user_email" for="x_user_email" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_users_user_email"><?= $Page->user_email->caption() ?><?= $Page->user_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_email->cellAttributes() ?>>
<template id="tpx_w_users_user_email"><span id="el_w_users_user_email">
<input type="<?= $Page->user_email->getInputTextType() ?>" data-table="w_users" data-field="x_user_email" name="x_user_email" id="x_user_email" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_email->getPlaceHolder()) ?>" value="<?= $Page->user_email->EditValue ?>"<?= $Page->user_email->editAttributes() ?> aria-describedby="x_user_email_help">
<?= $Page->user_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_email->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <div id="r_no_hp" class="form-group row">
        <label id="elh_w_users_no_hp" for="x_no_hp" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_users_no_hp"><?= $Page->no_hp->caption() ?><?= $Page->no_hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_hp->cellAttributes() ?>>
<template id="tpx_w_users_no_hp"><span id="el_w_users_no_hp">
<input type="<?= $Page->no_hp->getInputTextType() ?>" data-table="w_users" data-field="x_no_hp" name="x_no_hp" id="x_no_hp" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->no_hp->getPlaceHolder()) ?>" value="<?= $Page->no_hp->EditValue ?>"<?= $Page->no_hp->editAttributes() ?> aria-describedby="x_no_hp_help">
<?= $Page->no_hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_hp->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pass->Visible) { // pass ?>
    <div id="r_pass" class="form-group row">
        <label id="elh_w_users_pass" for="x_pass" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_users_pass"><?= $Page->pass->caption() ?><?= $Page->pass->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pass->cellAttributes() ?>>
<template id="tpx_w_users_pass"><span id="el_w_users_pass">
<div class="input-group">
    <input type="password" name="x_pass" id="x_pass" autocomplete="new-password" data-field="x_pass" size="20" placeholder="<?= HtmlEncode($Page->pass->getPlaceHolder()) ?>"<?= $Page->pass->editAttributes() ?> aria-describedby="x_pass_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<?= $Page->pass->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pass->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pass->Visible) { // pass ?>
    <div id="r_c_pass" class="form-group row">
        <label id="elh_c_w_users_pass" for="c_pass" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_w_users_c_pass"><?= $Language->phrase("Confirm") ?> <?= $Page->pass->caption() ?><?= $Page->pass->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pass->cellAttributes() ?>>
<template id="tpx_w_users_c_pass"><span id="el_c_w_users_pass">
<div class="input-group">
    <input type="password" name="c_pass" id="c_pass" autocomplete="new-password" data-field="x_pass" size="20" placeholder="<?= HtmlEncode($Page->pass->getPlaceHolder()) ?>"<?= $Page->pass->editAttributes() ?> aria-describedby="x_pass_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<?= $Page->pass->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pass->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_w_usersregister" class="ew-custom-template m-0"></div>
<template id="tpm_w_usersregister">
<div id="ct_Register">
<style>
.main-header,.content-header,.main-footer,.mb-2 .text-dark, .breadcrumb  { display:none !important; }
</style>

<link href="dirku/cssku/bootstrap.min.css" rel="stylesheet">
<link href="dirku/cssku/bootstrap-icons.css" rel="stylesheet">
<link href="dirku/cssku/cscs.css" rel="stylesheet">

<script> $("#fregister,#x_user_email, #x_no_hp").addClass("w-100");$("#x_no_hp").attr("placeholder", "+62___-__-__");$("input").addClass("form-control-lg");</script>
<style>.offset-sm-2 .btn {display:none;} .ew-toggle-password { border:1px solid #ced4da;border-radius: 0 .5rem .5rem .0;"}</style>
<section class="xvh-100">
  <div class="container pt-3 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="images/register-image.png"
                alt="register form" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 text-black">
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <img src="images/Logo-Kemendag.png" alt="" class="brand-image ew-brand-image">
                  </div>
                  <h5 class="fw-normal mt-2 pb-3" style="letter-spacing: 1px;">BUAT AKUN</h5>
                  <div class="form-outline mt-2">
                    <label class="form-label m-0" for="">Email</label>
                    <slot class="ew-slot" name="tpx_w_users_user_email"></slot>
                  </div>
                  <div class="form-outline mt-2">
                    <label class="form-label m-0" for="">Phone</label>
                    <slot class="ew-slot" name="tpx_w_users_no_hp"></slot>
                  </div>
                  <div class="form-outline mt-2">
                    <label class="form-label m-0" for="">Password</label>
                     <slot class="ew-slot" name="tpx_w_users_pass"></slot>
                  </div>
                   <div class="form-outline mt-2">
                    <label class="form-label m-0" for="">Konfirmasi password</label>
                     <slot class="ew-slot" name="tpx_w_users_c_pass"></slot>
                  </div>
                  <div class="pt-1 mb-2"><?php if (!$Page->IsModal) { ?>
                   <button class="btn btn-primary ew-btn btn-lg btn-block mt-2" name="btn-action" id="btn-action" type="submit">BUAT AKUN</button>
    <?php } ?>
                  </div>
<center><a class="small text-muted" href="./" style="float:left;"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali ke beranda</a><a class="small text-muted" href="login" style="float:right;">Login <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("RegisterBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_w_usersregister", "tpm_w_usersregister", "w_usersregister", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
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
    // Write your startup script here, no need to add script tags.
	
});

$('#x_no_hp').mask('+62 000-0000-00000'); 

</script>
