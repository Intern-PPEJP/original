<?php

namespace PHPMaker2021\ppejp_web;
$trace = @$Error["error"]["trace"];
if ($trace) {
    $card = preg_replace('/<button.+><\/button>/i', "", Config("DEBUG_MESSAGE_TEMPLATE"));
    $debug = $Language->phrase("Debug") ?: "Debug";
    $pre = "<pre>" . htmlentities($Error["error"]["trace"]) . "</pre>";
    $trace = str_replace(["%t", "%s"], [$debug, $pre], $card);
}
?>
<style>
.main-header,.content-header,.main-footer,.mb-2 .text-dark, .breadcrumb  { display:none !important; }
.content,.container-fluid { padding:0 !important;width:100% !important; }
</style>
<?php echo myheader(); ?>

<div class="error-page m-5" style="min-height:300px">
    <?php if (@$Error["statusCode"] > 200) { ?>
    <h2 class="headline <?= @$Error["error"]["class"] ?>"><?= $Error["statusCode"] ?></h2>
    <?php } ?>
    <div class="error-content">
        <?php if (@$Error["error"]["type"]) { ?>
        <h3><i class="fas fa-exclamation-triangle <?= @$Error["error"]["class"] ?>"></i> <?= @$Error["error"]["type"] ?></h3>
        <?php } ?>
        <p><?= @$Error["error"]["description"] ?></p>
        <?= $trace ?>
    </div>
    <!-- /.error-content -->
</div>
<!-- /.error-page -->
<script>
$(".content").attr('content', 'container-fluid');
</script>
<?php echo myfooter(); ?>
