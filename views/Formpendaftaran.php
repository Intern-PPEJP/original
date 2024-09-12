<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Formpendaftaran = &$Page;
?>
<?php echo myheader(); ?>

<style>
    h1{
        font-size: 25px;
    }
</style>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #031A31;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">PENDAFTARAN</h1>
            </div>
        </div>
    </div>
</div>

<iframe class="responsive-iframe" src="https://docs.google.com/forms/d/e/1FAIpQLSeBtH6CIU7wSIJveJOZvylr7darc8rAInIxwVpZMpMn4xOURg/viewform" width="100%" height="2400px"></iframe>

<script>
    document.title = "Halaman Pendaftaran";
</script>

<div class="mb-1">&nbsp;</div>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
