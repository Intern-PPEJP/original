<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Pelatihan = &$Page;
?>
<?php echo myheader(); ?>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #031A31;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">PELATIHAN</h1>
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

<style>
    p,
    table,
    div {
        font-size: 16px;
    }

    h1 {
        font-size: 25px;
    }

    h2 {
        font-size: 20px;
    }

    h3 {
        font-size: 18px;
    }
</style>

<div class="container-fluid">
    <div id="ppejp-slide" class="carousel slide row" data-ride="carousel" data-interval="3000" data-pause="false" style="margin-bottom: 0;">
        <div class="carousel-inner col-12 p-0">

            <div class="carousel-item active" style=" height: 450px;">
                <div style="background-image: url(images/pages/pelatihan2.JPG); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0;">
                </div>
            </div>
            <div class="carousel-item" style=" height: 450px;">
                <div style="background-image: url(images/pages/pelatihan1new.JPG); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
                </div>
            </div>
            <div class="carousel-item" style=" height: 450px;">
                <div style="background-image: url(images/pages/pelatihan3.JPG); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
                </div>
            </div>
            <div class="carousel-item" style=" height: 450px;">
                <div style="background-image: url(images/pages/pelatihan4.JPG); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
                </div>
            </div>
            <div class="carousel-item" style=" height: 450px;">
                <div style="background-image: url(images/pages/pelatihan5.JPG); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mb-5 mt-n5">
        <div class="col-md-12">
            <div class="text-justify">
                Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan adalah mitra terpercaya untuk mengembangkan pengetahuan dan keterampilan di bidang ekspor, metrologi, mutu, dan jasa perdagangan. Program pelatihan kami yang terkini dan instruktur berpengalaman akan mempersiapkan Anda untuk menghadapi tantangan global dalam dunia bisnis, serta meningkatkan keunggulan produk, efisiensi operasional, dan kemampuan dalam bertransaksi di pasar internasional.
                Bergabunglah dengan kami sekarang untuk mengambil langkah selanjutnya dalam karier dan keberhasilan bisnis Anda!
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-2 mt-6">
        <div class="col-md-12 p-0 text-center text-black">
            <div class="xb1 text-center">
                <h2 class="mt-3 text-bold" style="font-size: 20px; margin-bottom: -60px;">MENGAPA MEMILIH KAMI?</h2>
            </div>
        </div>
    </div>
    <div class="container container-why">
        <div class="why-card">
            <img src="images\icons\money (1).png" alt="Icon">
            <h3>Biaya Terjangkau</h3>
            <p>Pelatihan di PPEJP memiliki harga biaya kepesertaan yang relatif lebih rendah dibanding institusi pelatihan sejenis.</p>
        </div>
        <div class="why-card">
            <img src="images\icons\trust.png" alt="Icon">
            <h3>Terpercaya</h3>
            <p>Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan merupakan institusi pelatihan resmi yang berada di bawah Kementerian Perdagangan.</p>
        </div>
        <div class="why-card">
            <img src="images\icons\certificatenew.png" alt="Icon">
            <h3>Sertifikat</h3>
            <p>Peserta yang telah selesai melaksanakan rangkaian pelatihan akan mendapatkan sertifikat.</p>
        </div>
    </div>
</div>

<style>
    .container-why {
        display: flex;
        justify-content: center;
        align-items: stretch;
        flex-wrap: nowrap;
        padding: 50px 0px;
    }

    .container-why .why-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 280px;
        padding: 20px;
        margin: 10px;
        text-align: center;
        transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
    }

    .container-why .why-card img {
        width: 90px;
        margin-bottom: 15px;
    }

    .container-why .why-card h3 {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .container-why .why-card p {
        font-size: 14px;
        color: #7f8c8d;
    }

    .container-why .why-card:hover {
        background-color: #023e8a;
        color: #ffffff;
        transition: background-color 0.3s ease, color 0.3s ease;
        transform: scale(1.05);
    }

    .container-why .why-card:hover h3,
    .container-why .why-card:hover p {
        color: #ffffff;
    }

    .container-why .why-card:hover img {
        filter: brightness(0) invert(1);
        /* Mengubah icon menjadi putih */
        transition: filter 0.3s ease;
    }

    /* Media query untuk layar kecil */
    @media (max-width: 768px) {
        .container-why {
            flex-direction: column;
            align-items: center;
        }

        .container-why .why-card {
            width: 100%;
            max-width: 350px;
            margin: 10px;
        }
    }
</style>


<div class="container">
    <div class="row my-2 mt-6">
        <div class="col-md-12 p-0 text-center text-black">
            <div class="xb1 text-center">
                <h2 class="mt-3 text-bold" style="font-size: 20px; margin-bottom: -60px;">METODE PELATIHAN</h2>
            </div>
        </div>
    </div>
    <div class="container container-method">
        <div class="method-card">
            <img src="images\icons\teaching.png" alt="Presentasi">
            <h3>Presentasi</h3>
        </div>
        <div class="method-card">
            <img src="images\icons\conversation.png" alt="Diskusi">
            <h3>Diskusi</h3>
        </div>
        <div class="method-card">
            <img src="images\icons\file-case.png" alt="Studi Kasus">
            <h3>Studi Kasus</h3>
        </div>
        <div class="method-card">
            <img src="images\icons\role-playing.png" alt="Role Play">
            <h3>Role Play</h3>
        </div>
        <div class="method-card">
            <img src="images\icons\composition.png" alt="Latihan">
            <h3>Latihan</h3>
        </div>
    </div>
</div>

<style>
    .container-method {
        display: flex;
        justify-content: center;
        align-items: stretch;
        flex-wrap: nowrap;
        padding: 50px 0px;
    }

    .container-method .method-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 250px;
        padding: 20px;
        margin: 10px;
        text-align: center;
    }

    .container-method .method-card img {
        width: 90px;
        margin-bottom: 15px;
    }

    .container-method .method-card h3 {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .container-method .method-card p {
        font-size: 14px;
        color: #7f8c8d;
    }

    .container-method .method-card:hover {
        background-color: #023e8a;
        color: #ffffff;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container-method .method-card:hover h3 {
        color: #ffffff;
    }

    .container-method .method-card:hover img {
        filter: brightness(0) invert(1);
        /* Mengubah icon menjadi putih */
        transition: filter 0.3s ease;
    }

    /* Media query untuk layar kecil */
    @media (max-width: 768px) {
        .container-method {
            flex-direction: column;
            align-items: center;
        }

        .container-method .method-card {
            width: 100%;
            max-width: 350px;
            margin: 10px;
        }
    }
</style>


<style>
    @media (min-width: 768px) {
        .d-right {
            position: relative;
            left: 50%;
        }

        .d-left {
            position: relative;
            right: 50%;
        }
    }
</style>



<div class="container">
    <div class="row my-2 mt-6">
        <div class="col-md-12 p-0">
            <div style="font-weight: 600;" class="text-center">
                <h2 class="text-bold">JENIS PELATIHAN</h2>
            </div>
        </div>
    </div>
    <div class="container-j my-4" style="max-width: 1260px; margin: 0 auto;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="images/pages/pel-ekspor.png" alt="Pelatihan Ekspor" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="font-weight-bold">PELATIHAN EKSPOR</h2>
                <p style="text-align: justify;">PPEJP menyelenggarakan beragam pelatihan yang dirancang khusus untuk memperluas wawasan dan meningkatkan keterampilan dalam berbisnis di pasar global.
                    Melalui program pelatihan kami, Anda akan mendapatkan pengetahuan yang diperlukan untuk memahami regulasi perdagangan internasional yang kompleks dan standar yang berlaku di berbagai negara. Kami akan membantu Anda memahami proses ekspor, strategi pemasaran global, serta praktik terbaik dalam menghadapi persaingan yang sengit.</p>
                <a href="pelatihan-ekspor" class="btn btn-outline-dark">Info Selengkapnya</a>
            </div>
        </div>
    </div>
    <div class="container-j my-4" style="max-width: 1260px; margin: 0 auto;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="images/pages/pel-metr.png" alt="Pelatihan Metrologi" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="font-weight-bold">PELATIHAN METROLOGI</h2>
                <p style="text-align: justify;">PPEJP melalui Badan Diklat Mutu Metrologi dan Jasa Perdagangan menawarkan program pelatihan yang dirancang secara khusus untuk memperluas pemahaman Anda tentang prinsip-prinsip metrologi, peraturan dan standar pengukuran, serta teknik dan alat yang digunakan dalam proses pengukuran. Melalui pelatihan ini, Anda akan belajar bagaimana merancang, melaksanakan, dan memvalidasi pengukuran dengan tingkat akurasi yang tinggi.</p>
                <a href="pelatihan-metrologi" class="btn btn-outline-dark">Info Selengkapnya</a>
            </div>
        </div>
    </div>

    <div class="container-j my-4" style="max-width: 1260px; margin: 0 auto;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="images/pages/pel-mutu.png" alt="Pelatihan Mutu" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="font-weight-bold">PELATIHAN MUTU</h2>
                <p style="text-align: justify;">PPEJP melalui Balai Pelatihan Metrologi, Mutu, dan Jasa Perdagangan menawarkan program pelatihan praktis tentang standar mutu, analisis data, pengendalian proses, perbaikan berkelanjutan, audit mutu, dan sertifikasi. Bergabunglah dengan kami untuk mencapai keunggulan mutu dan kepuasan pelanggan yang lebih baik.</p>
                <a href="pelatihan-mutu" class="btn btn-outline-dark">Info Selengkapnya</a>
            </div>
        </div>
    </div>

    <div class="container-j my-4" style="max-width: 1260px; margin: 0 auto;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="images/pages/pel-jasa-perd.png" alt="Pelatihan Jasa Perdagangan" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="font-weight-bold">PELATIHAN JASA PERDAGANGAN</h2>
                <p style="text-align: justify;">PPEJP melalui Badan Diklat Mutu Metrologi dan Jasa Perdagangan menyediakan program pelatihan untuk meningkatkan kompetensi dalam industri jasa perdagangan. Pelatihan kami mencakup strategi pemasaran, manajemen risiko, persyaratan peraturan internasional, dan keterampilan praktis seperti negosiasi dan layanan pelanggan. Bergabunglah dengan kami untuk mengembangkan keterampilan Anda dalam perdagangan jasa dan meraih kesuksesan di pasar global.</p>
                <a href="pelatihan-jasa-perdagangan" class="btn btn-outline-dark">Info Selengkapnya</a>
            </div>
        </div>
    </div>
</div>

<style>
    .container-j {
        padding: 15px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .container-j:hover {
        transform: translateY(-10px);
    }

    .img-fluid {
        border-radius: 0px;
    }

    h2 {
        font-size: 20px;
        margin-bottom: 20px;
    }

    p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .btn-outline-dark {
        padding: 10px 20px;
        border: 2px solid #3a8f53;
        color: #3a8f53;
        text-transform: uppercase;
        font-weight: bold;
        border-radius: 5px;
        font-size: small;
    }

    .btn-outline-dark:hover {
        background-color: #3a8f53;
        /* Warna hijau saat di-hover */
        border-color: #3a8f53;
        /* Ubah warna border juga */
        color: #ffffff;
        /* Ubah teks menjadi putih */
    }
</style>

<script>
    document.title = "Pelatihan"
</script>

<div class="mb-5">&nbsp;
</div>
<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>