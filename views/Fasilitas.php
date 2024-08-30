<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Fasilitas = &$Page;
?>
<?php echo myheader(); ?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="6"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="7"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="8"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="9"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="10"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/fasilitas/fasilitas-perpustakaan.png" class="d-block w-100" alt="First slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/fasilitas-auditorium.png" class="d-block w-100" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/fasilitas-simulation-center.png" class="d-block w-100" alt="Third slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/fasilitas-ruang-kelas.png" class="d-block w-100" alt="Fourth slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/fasilitas-asrama.png" class="d-block w-100" alt="Fifth slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/bpmjp-instalasi.png" class="d-block w-100" alt="Sixth slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/bpmjp-laboratorium.png" class="d-block w-100" alt="Seventh slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/bpmjp-asrama.png" class="d-block w-100" alt="Eighth slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/bpmjp-ruang-kelas.png" class="d-block w-100" alt="Ninth slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/bpmjp-teater.png" class="d-block w-100" alt="Tenth slide">
        </div>
        <div class="carousel-item">
            <img src="images/fasilitas/bpmjp-fasilitas-lainnya.png" class="d-block w-100" alt="Eleventh slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>



<script>
    document.title = "Fasilitas"
</script>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
