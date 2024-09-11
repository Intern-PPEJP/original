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
        <div class="col-md-12 p-0" style=" height: 450px">
            <div style="background-image: url(images/pages/obrolan-ekspor.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>

<body id="top">
    <a href="#top" class="back-to-top" id="backToTopBtn">
        <div class="button-circle">
            <img src="images\icons\top.png" alt="Back to Top">
        </div>
    </a>
    <script>
        // Ambil elemen button
        const backToTopBtn = document.getElementById('backToTopBtn');

        // Fungsi untuk menampilkan atau menyembunyikan button
        function toggleBackToTopBtn() {
            if (window.scrollY > 200) { // Jika scroll lebih dari 200px
                backToTopBtn.style.display = "block";
            } else {
                backToTopBtn.style.display = "none";
            }
        }

        // Pasang event listener untuk scroll
        window.addEventListener('scroll', toggleBackToTopBtn);
    </script>

    <style>
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            text-decoration: none;
            display: none;
            /* Button disembunyikan secara default */
        }

        .button-circle {
            width: 50px;
            height: 50px;
            background-color: #19497D;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .button-circle img {
            width: 20px;
            height: 20px;
        }
    </style>
</body>

<div class="container">
    <div class="row my-4">
        <div class="col-md-12">
            <div class="text-justify" style="font-size: 16px">
                Obrolan ekspor merupakan dialog antara PPEJP, pelaku usaha, dan praktisi ekspor untuk mencapai kesepahaman dan peningkatan kolaborasi
                pelaksanaan ekspor. Selain itu, Obrolan Ekspor memberikan informasi tentang ekspor serta peningkatan motivasi dan pengetahuan ekspor
                bagi dunia usaha terutama pelaku usaha berorientasi ekspor.
            </div>
        </div>
    </div>
</div>

<style>
    p,
    table,
    div {
        font-size: 16px;
    }

    .grid-topik-obrol .col-4 {
        margin-bottom: 25px;
    }

    .grid-topik-obrol .col-8 {
        text-transform: capitalize;
        padding-top: 5px;
    }

    h1 {
        font-size: 25px;
    }

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
        filter: brightness(0) invert(1);
        /* Mengubah icon menjadi putih */
        transition: filter 0.3s ease;
    }

    .narasumber-card {
        background-color: #ffffff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .narasumber-card:hover {
        transform: translateY(-10px);
    }

    .narasumber-name {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .narasumber-role {
        font-size: 14px;
        color: #7f8c8d;
    }

    .narasumber-img {
        width: 100%;
        height: 220px;
        border-radius: 15px;
        object-fit: cover;
        margin-bottom: 15px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .flex-nowrap .col-md-4 {
        min-width: 250px;
    }

    @media (max-width: 1024px) {
        .narasumber-card {
            margin-bottom: 20px;
            padding: 15px;
        }

        .narasumber-img {
            width: 100%;
            /* Atur agar gambar lebih kecil pada tablet */
            height: auto;
            /* Memastikan gambar tetap proporsional */
        }
    }

    /* Media query untuk layar kecil */
    @media (max-width: 768px) {
        .container-topik {
            flex-direction: column;
            align-items: center;
        }

        .container-topik .topic-card {
            width: 100%;
            max-width: 350px;
            margin: 10px;
        }
    }
</style>

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

<div class="container">
    <div class="row py-3">
        <div class="col-md-12 p-0 text-center text-black">
            <div class="xb1 text-center">
                <h2 class="mt-3 text-bold" style="font-size: 20px; margin-bottom: 5px;">NARASUMBER</h2>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3 py-3 text-center text-white">
            <div class="narasumber-card">
                <!--<img src="images/icons/icon_user1.png" class="img-fluid rounded-circle mb-3" alt="Narasumber 1" style="height: 150px; width: 150px;">-->
                <img src="images\narasumber\fasil.jpg" class="narasumber-img" alt="Profil Narasumber">
                <h3 class="narasumber-name" style="font-weight: bold;">Fasilitator <br>PPEJP</h3>
            </div>
        </div>
        <div class="col-md-3 py-3 text-center text-white">
            <div class="narasumber-card">
                <!--<img src="images/icons/icon_user2.png" class="img-fluid rounded-circle mb-3" alt="Narasumber 2" style="height: 150px; width: 150px;">-->
                <img src="images\narasumber\pejabat.jpg" class="narasumber-img" alt="Profil Narasumber">
                <h3 class="narasumber-name" style="font-weight: bold;">Pejabat Perwakilan Perdagangan</h3>
            </div>
        </div>
        <div class="col-md-3 py-3 text-center text-white">
            <div class="narasumber-card">
                <!--<img src="images/icons/icon_user3.png" class="img-fluid rounded-circle mb-3" alt="Narasumber 3" style="height: 150px; width: 150px;">-->
                <img src="images\narasumber\narsum_alumni.JPG" class="narasumber-img" alt="Profil Narasumber">
                <h3 class="narasumber-name" style="font-weight: bold;">Alumni Sukses <br>Pelatihan PPEJP</h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid grid-topik-obrol" style="xbackground-color: #CCCCCC;margin-bottom: 88px;">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-12 p-0">
                <div style="font-size: 20px;" class="xb1 text-center">
                    <h2 class="text-bold">OBROLAN EKSPOR</h2>
                </div>
            </div>
        </div>
        <!--<div class="container">
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
                if ($jumlahpelatihan == 0) {
                    echo '<div class="alert alert-warning text-center">Obrolan Ekspor belum tersedia</div>';
                }
                ?>
            </div>
        </div>
        <div class="row mt-2" style="font-weight: 600; font-size: 1.2em;">
            <!--<a href="https://www.youtube.com/playlist?list=PLnXXNWWTR6gbM0BabCRzXf4cZovf0wc8e" style="color:#212529;text-decoration:none"><div class="col-md-12 text-right">
                Selengkapnya <i class="fa fa-chevron-right"></i>
            </div>
			</a>
        </div>
    </div>-->
        <div class="container">
            <div class="row">
                <?php
                $playlists = [
                    "https://www.youtube.com/embed/2FTgzPOHIVs?si=6RZMlxt6tKwZMkNM",
                    "https://www.youtube.com/embed/FWVt1DW2bs0?si=7EQ2UIW-Tqh3gHp_",
                    "https://www.youtube.com/embed/ED3VtTqOm9M?si=g_M3vu-v8zMMjNvg",
                    "https://www.youtube.com/embed/XhOVRfQhU-c?si=FaNHJKXf2hWU4KuQ"
                ];

                foreach ($playlists as $playlist) {
                    echo '
                    <div class="col-md-3 mb-4">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="' . $playlist . '" allowfullscreen></iframe>
                        </div>
                    </div>';
                }
                ?>
            </div>
            <div class="row mt-2" style="font-weight: 600; font-size: 1.2em;">
                <a href="https://www.youtube.com/playlist?list=PLnXXNWWTR6gbM0BabCRzXf4cZovf0wc8e" style="color:#212529;text-decoration:none">
                    <div class="col-md-12 text-right">
                        Selengkapnya <i class="fa fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.title = "Obrolan Ekspor"
</script>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>