<?php namespace PHPMaker2021\ppejp_web; ?>
<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Login = &$Page;
?>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<script>
var flogin;
loadjs.ready("head", function() {
    var $ = jQuery;
    flogin = new ew.Form("flogin");

    // Add fields
    flogin.addFields([
        ["username", ew.Validators.required(ew.language.phrase("UserName")), <?= $Page->Username->IsInvalid ? "true" : "false" ?>],
        ["password", ew.Validators.required(ew.language.phrase("Password")), <?= $Page->Password->IsInvalid ? "true" : "false" ?>]
    ]);

    // Captcha
    <?= Captcha()->getScript("flogin") ?>

    // Set invalid fields
    $(function() {
        flogin.setInvalid();
    });

    // Validate
    flogin.validate = function() {
        if (!this.validateRequired)
            return true; // Ignore validation
        var $ = jQuery,
            fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    flogin.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation
    flogin.validateRequired = <?= JsonEncode(Config("CLIENT_VALIDATE")) ?>;
    loadjs.done("flogin");
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>


<link href="dirku/cssku/bootstrap.min.css" rel="stylesheet">
<link href="dirku/cssku/bootstrap-icons.css" rel="stylesheet">
<link href="dirku/cssku/cscs.css" rel="stylesheet">
<style>
.main-header,.content-header,.main-footer,.mb-2 .text-dark, .breadcrumb  { display:none !important; }
</style>

<form name="flogin" id="flogin" class="ew-form ew-login-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">


<section class="vh-100">
  <div class="container py-2 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="images/login-image.png"
                alt="login form" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 text-black">

                <form>

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <img src="images/Logo-Kemendag.png" alt="" class="brand-image ew-brand-image">
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">AKUN</h5>

                  
				<div class="form-group row p-2">
					<label class="form-label p-0" for="">Email</label>    
					<input type="email" name="<?= $Page->Username->FieldVar ?>" id="<?= $Page->Username->FieldVar ?>" autocomplete="username" value="<?= HtmlEncode($Page->Username->CurrentValue) ?>" class="form-control form-control-lg w-100" />
					<div class="invalid-feedback p-0"><?= $Page->Username->getErrorMessage() ?></div>
                </div>

				<div class="form-group row">
                    <label class="form-label" for="">Password</label>
					<div class="input-group"><input type="password" name="<?= $Page->Password->FieldVar ?>" id="<?= $Page->Password->FieldVar ?>" autocomplete="current-password" class="form-control form-control-lg" /><div class="input-group-append" style="border:1px solid #ced4da;border-radius: 0 .5rem .5rem .0;"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div></div>
					<div class="invalid-feedback"><?= $Page->Password->getErrorMessage() ?></div>
				</div>
               

                  <div class="pt-1 mb-4"><?php if (!$Page->IsModal) { ?>
                    <button class="btn btn-dark btn-lg btn-block" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("Login") ?></button>
    <?php } ?>
                  </div>

                  <a class="small text-muted" href="#!">Lupa password?</a>
                  <!--<p class="mb-5 pb-lg-2" style="color: #393f81;">Belum mempunyai akun? <a href="register"
                      style="color: #393f81;">Daftar disini</a></p>-->
					  
					  <center><a class="small text-muted" href="./"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali ke beranda</a></center>
                </form>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>


</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
