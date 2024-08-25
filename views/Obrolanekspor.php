<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Obrolanekspor = &$Page;
?>
<?php echo myheader(); ?>
<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #031A31;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold">OBROLAN EKSPOR</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="xmargin-top:90px;">
    <div class="row">
        <div class="col-md-12 p-0" style=" height: 500px">
            <div style="background-image: url(images/pages/obrolan-ekspor.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-4">
        <div class="col-md-12">
            <div class="text-center" style="font-size: 16px">
                Obrolan ekspor merupakan dialog antara PPEJP, pelaku usaha, dan praktisi ekspor untuk mencapai kesepahaman dan peningkatan kolaborasi
                pelaksanaan ekspor. Selain itu, Obrolan Ekspor memberikan informasi tentang ekspor serta peningkatan motivasi dan pengetahuan ekspor
                bagi dunia usaha terutama pelaku usaha berorientasi ekspor.
            </div>
        </div>
    </div>
</div>

<style>
    .grid-topik-obrol .col-4 {
        margin-bottom: 25px;
    }

    .grid-topik-obrol .col-8{
        text-transform: capitalize;
        padding-top: 5px;
    }
</style>

<!--<div class="container-fluid grid-topik-obrol" style="background-color: #e9e9e9;">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 p-0 text-center text-black">
                <!--<div class="xb1 text-center">-->
                    <!--<h2 class="mt-3 text-bold" style="font-size: 20px;">TOPIK OBROLAN</h2>-->
                <!--</div>-->
           <!-- </div>
        </div>
        <div class="row">
            <div class="col-md-4 py-3">
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon_newspaper_.svg" class="img-fluid">
                    </div>
                    <div class="col-8">Pengetahuan tentang ekspor</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon_archive_.svg" class="img-fluid">
                    </div>
                    <div class="col-8">Pendekatan produk ekspor</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon_zoomin_.png" class="img-fluid">
                    </div>
                    <div class="col-8">Pemecahan masalah ekspor</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon _bag_.png" class="img-fluid">
                    </div>
                    <div class="col-8">Pendekatan akses pasar</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon _user male_.png" class="img-fluid">
                    </div>
                    <div class="col-8">Success story</div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="container">
        <div class="row py-3">
            <div class="col-md-12 p-0 text-center text-black">
                <div class="xb1 text-center">
                    <h2 class="mt-3 text-bold" style="font-size: 20px; margin-bottom: -60px;">TOPIK OBROLAN</h2>
                </div>
           </div>
        </div>
<div class="container container-topik">
    <div class="topic-card">
        <img src="images\icons\technique.png" alt="Pengetahuan Ekspor">
        <h3>Pengetahuan Tentang Ekspor</h3>
        <p>Informasi dasar yang penting dalam dunia ekspor.</p>
    </div>
    <div class="topic-card">
        <img src="images\icons\in-stock.png" alt="Pendekatan Produk Ekspor">
        <h3>Pendekatan Produk Ekspor</h3>
        <p>Strategi terbaik untuk mengembangkan produk ekspor.</p>
    </div>
    <div class="topic-card">
        <img src="images\icons\solved.png" alt="Pemecahan Masalah Ekspor">
        <h3>Pemecahan Masalah Ekspor</h3>
        <p>Cara mengatasi tantangan yang dihadapi dalam ekspor.</p>
    </div>
    <div class="topic-card">
        <img src="images\icons\growth.png" alt="Pendekatan Akses Pasar">
        <h3>Pendekatan Akses Pasar</h3>
        <p>Membuka akses ke pasar internasional yang lebih luas.</p>
    </div>
    <div class="topic-card">
        <img src="images\icons\success-story.png" alt="Success Story">
        <h3>Success Story</h3>
        <p>Inspirasi dari kisah sukses para pelaku ekspor.</p>
    </div>
</div>
</div>

    <style>
        .container-topik {
        display: flex;
        justify-content: center;
        align-items: stretch;
        flex-wrap: nowrap;
        padding: 50px 0px;
    }

    .container-topik .topic-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 250px;
        padding: 20px;
        margin: 10px;
        text-align: center;
    }

    .container-topik .topic-card img {
        width: 90px;
        margin-bottom: 15px;
    }

    .container-topik .topic-card h3 {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .container-topik .topic-card p {
        font-size: 14px;
        color: #7f8c8d;
    }

    .container-topik .topic-card:hover {
    background-color: #023e8a;
    color: #ffffff;
    transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container-topik .topic-card:hover h3,
    .container-topik .topic-card:hover p {
        color: #ffffff;
    }

    .container-topik .topic-card:hover img {
    filter: brightness(0) invert(1); /* Mengubah icon menjadi putih */
    transition: filter 0.3s ease;
    }
    </style>

<div class="container-fluid p-0" style="background-image: url(images/pages/narasumber-obrolan-ekspor.png); background-size: cover; position: relative; background-position: center;">
    <div style="box-sizing: border-box; position: absolute; top: 0; height: 100%; width: 100%; background-image: linear-gradient(#111111aa,#111111dd,#111111ff);"></div>
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 p-0 text-center text-white">
                <h2 class="mt-3 text-bold" style="font-size: 20px;">NARASUMBER</h2>
            </div>
        </div>
        <div class="row mt-0">
            <div class="col-md-4 py-3 text-center text-white">
                <img src="images/icons/icon _user male circle_.png" style="height: 100px; margin-bottom: 15px;">
                <h1 style="font-size: 20px;">Fasilitator <br>PPEJP</h1>
            </div>
            <div class="col-md-4 py-3 text-center text-white">
                <img src="images/icons/icon _user male circle_.png" style="height: 100px; margin-bottom: 15px;">
                <h1 style="font-size: 20px;">Pejabat Perwakilan <br>Perdagangan</h1>
            </div>
            <div class="col-md-4 py-3 text-center text-white">
                <img src="images/icons/icon _user male circle_.png" style="height: 100px; margin-bottom: 15px;">
                <h1 style="font-size: 20px;">Alumni Sukses <br>Pelatihan PPEJP</h1>
            </div>
        </div>
    </div>
</div>


<style>
    @media (max-width: 767px) {
        .container-fluid h1 {
            font-size: 20px;
        }
    }

    @media (min-width: 768px) {
        .container-fluid h1 {
            font-size: 20px;
        }
    }
</style>

<style>
    .flex-nowrap .col-md-4 {
        min-width: 250px;
    }
</style>
<div class="container-fluid grid-topik-obrol" style="xbackground-color: #CCCCCC;margin-bottom: 88px;">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-12 p-0">
                <div style="font-size: 20px;" class="xb1 text-center">
                    <h2 class="text-bold">OBROLAN EKSPOR</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row xpy-5 flex-nowrap" style="overflow-x: auto; height: 420px;">
                <?php
                    $rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_hari`,`sisa`, `tempat`, `jumlah_peserta`, `harga`, `tanggal_pelaksanaan`,`Link`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `jenis_pelatihan` LIKE 'obrolan_ekspor' ORDER BY `tawal` DESC Limit 20");
                    $jumlahpelatihan = 0;
                    while ($row = $rs->fetch()) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card border-2" style="width: 100%; height: 100%;">
                            <a href="<?php echo $row["Link"]; ?>" target="_blank">
                                <img src="files/<?php echo $row["gambar"]; ?>" class="card-img-top" style="height: 400px; object-fit: cover;">
                            </a>
                        </div>
                    </div>
                <?php	
                    $jumlahpelatihan++;
                        }
                    if($jumlahpelatihan == 0){ echo '<div class="alert alert-warning text-center">Obrolan Ekspor belum tersedia</div>'; }
                ?>
            </div>
        </div>
<!--
        <div class="row mt-2" style="font-weight: 600; font-size: 1.2em;">
            <a href="https://www.youtube.com/playlist?list=PLnXXNWWTR6gbM0BabCRzXf4cZovf0wc8e" style="color:#212529;text-decoration:none"><div class="col-md-12 text-right">
                Selengkapnya <i class="fa fa-chevron-right"></i>
            </div>
			</a>
        </div>-->
    </div>
</div>


<script>
    document.title = "Obrolan Ekspor"
</script>


<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>