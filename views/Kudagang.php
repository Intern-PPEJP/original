<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Kudagang = &$Page;
?>
<?php echo myheader(); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-0" style="height: 450px">
            <div style="background-image: url(images/pages/kudagang.png); background-size: cover ; background-position: bottom;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>
<br>
<div class="container" style="margin-bottom:36px;">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center" style="font-size: 1.2em;">
                E-learning Center Kudagang adalah platform belajar terpadu berbasis elektronik di lingkungan Kementerian Perdagangan dengan pembelajaran yang menggunakan teknologi komunikasi dan informasi (TIK) untuk mentransformasikan proses pembelajaran antara pengajar dan peserta didik.
            </div>
        </div>
    </div>
</div>
<br>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
