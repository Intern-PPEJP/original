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

<head> 
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>

    <style>
        .slider-container {
            width: 80%;
            margin: 0 auto;
        }

        .slider-item {
            background-color: #f7f9fc;
            border: 1px solid #d9e3ef;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .slider-item h3 {
            font-size: 18px;
            color: #1a2238;
            margin-top: 15px;
        }

        .slider-item p {
            font-size: 14px;
            color: #4a4a4a;
        }

        .slick-dots li button:before {
            color: #d1d1d1;
        }

        .slick-dots li.slick-active button:before {
            color: #d55ace;
        }
    </style>
</head>

<style>
    p, table, div {
    font-size: 16px;
	}
	
	h2{
		font-size: 20px;
	}

	h3{
		font-size: 18px;
	}
</style>

<div class="container-fluid">
	<div id="ppejp-slide" class="carousel slide row" data-ride="carousel" data-interval="3000" data-pause="false">
	  <div class="carousel-inner col-12 p-0">
		<div class="carousel-item active" style=" height: 600px;">
            <div style="background-image:linear-gradient(0deg, rgba(3, 26, 49, 0.61), rgba(3, 26, 49, 0.61)), url(images/pages/pelatihan2.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
		<div class="carousel-item" style=" height: 600px;">
            <div style="background-image:linear-gradient(0deg, rgba(3, 26, 49, 0.61), rgba(3, 26, 49, 0.61)), url(images/pages/altpelatihan1/p3131465_2.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
		<div class="carousel-item" style=" height: 600px;">
            <div style="background-image:linear-gradient(0deg, rgba(3, 26, 49, 0.61), rgba(3, 26, 49, 0.61)), url(images/pages/header-ecp.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
	  </div>
	</div>
</div>
<div class="container">
    <div class="row my-5 ">
        <div class="col-md-12">
            <div class="text-center">
                Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan adalah mitra terpercaya untuk mengembangkan pengetahuan dan keterampilan di bidang ekspor, metrologi, mutu, dan jasa perdagangan. Program pelatihan kami yang terkini dan instruktur berpengalaman akan mempersiapkan Anda untuk menghadapi tantangan global dalam dunia bisnis, serta meningkatkan keunggulan produk, efisiensi operasional, dan kemampuan dalam bertransaksi di pasar internasional. 
                Bergabunglah dengan kami sekarang untuk mengambil langkah selanjutnya dalam karier dan keberhasilan bisnis Anda! 
            </div>
        </div>
    </div>
</div>

<!--<div class="container-fluid p-0" style="background-image: linear-gradient(0deg, rgba(3, 26, 49, 0.8), rgba(3, 26, 49, 0.8)), url(images/pages/altpelatihan1/img_6147_1.png); background-size: cover;position: relative; background-position: center;">
    <div style="box-sizing: border-box; position: absolute; top:0; height: 100%; width: 100%;;"></div>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 p-0 text-center text-white">
                <h2 class="mt-3"><b> MENGAPA MEMILIH KAMI</b></h2>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-4 text-center text-white">
                <img src="images/icons/wallet.png" style="height: 150px;">
                <h3><b>Biaya Terjangkau</b></h3>
                <div>Pelatihan Di PPEJP memiliki harga biaya kepesertaan yang relatif lebih rendah dibanding institusi pelatihan sejenis. </div>
            </div>
            <div class="col-md-4 text-center text-white">
                <img src="images/icons/shield.png" style="height: 150px;">
                <h3>Terpercaya</h3>
                <div>Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan merupakan institusi pelatihan resmi yang berada di bawah Kementerian Perdagangan.</div>
            </div>
            <div class="col-md-4 text-center text-white">
                <img src="images/icons/certificate.png" style="height: 150px;">
                <h3>Sertifikat</h3>
                <div>Peserta yang telah selesai melaksanakan pelatihan akan mendapatkan sertifikat</div>
            </div>
        </div>
		
        <div class="row mt-5">
            <div class="col-md-12 p-0 text-center text-white">
                <h2 class="mt-3"><b>METODE PELATIHAN</b></h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-2 text-center text-white">
                <img src="images/icons/icon_speakerphone_.png" style="height: 100px;">
                <p>Presentasi</p>
            </div>
            <div class="col-md-2 text-center text-white">
                <img src="images/icons/icon_messages_.png" style="height: 100px;">
                <p>Diskusi</p>
            </div>
            <div class="col-md-2 text-center text-white">
                <img src="images/icons/icon_users group_.png" style="height: 100px;">
                <p>Studi Kasus</p>
            </div>
            <div class="col-md-2 text-center text-white">
                <img src="images/icons/icon_run_.png" style="height: 100px;">
                <p>Role Play</p>
            </div>
            <div class="col-md-2 text-center text-white">
                <img src="images/icons/icon_file text_.png" style="height: 100px;">
                <p>Latihan</p>
            </div>
        </div>
    </div>
</div>-->

<div class="slider-container">
        <div class="slider">
            <div class="slider-item">
                <img src="images\icons\money (1).png" alt="Icon">
                <h3>Biaya Terjangkau</h3>
                <p>Pelatihan di PPEJP memiliki harga biaya kepesertaan yang relatif lebih rendah dibanding institusi pelatihan sejenis.</p>
            </div>
            <div class="slider-item">
                <img src="images\icons\trust.png" alt="Icon">
                <h3>Terpercaya</h3>
                <p>Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan merupakan institusi pelatihan resmi yang berada di bawah Kementerian Perdagangan.</p>
            </div>
            <div class="slider-item">
                <img src="images\icons\certificate.png" alt="Icon">
                <h3>Sertifikat</h3>
                <p>Peserta yang telah selesai melaksanakan rangkaian pelatihan akan mendapatkan sertifikat.</p>
            </div>
        </div>
    </div>

    <!-- Slick JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.slider').slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
        });
    </script>

<div class="container">
        <div class="row py-3">
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
    filter: brightness(0) invert(1); /* Mengubah icon menjadi putih */
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
		left:50%;
	}
	.d-left {
		position: relative;
		right:50%;
	}
}
</style>



<div class="container">
    <div class="row my-2 mt-7">
        <div class="col-md-12 p-0">
            <div style="font-weight: 600;" class="text-center">
                <h2 class="text-bold">JENIS PELATIHAN</h2>
            </div>
        </div>
    </div>
    <div class="row text-justify py-5 mb-5">

        <div class="col-md-6" style="background-image: url(images/pages/pel-ekspor.png); height: 350px; background-size: cover; background-position: center;">
            
        </div>
        <div class="col-md-6 " style="display: flex; flex-direction: column; justify-content: center;">
            <h3 style="font-weight: bold;">PELATIHAN EKSPOR</h3>
            <div class="mb-3">PPEJP menyelenggarakan beragam pelatihan yang dirancang khusus untuk memperluas wawasan dan meningkatkan keterampilan dalam berbisnis di pasar global.
            Melalui program pelatihan kami, Anda akan mendapatkan pengetahuan yang diperlukan untuk memahami regulasi perdagangan internasional yang kompleks dan standar yang berlaku di berbagai negara. Kami akan membantu Anda memahami proses ekspor, strategi pemasaran global, serta praktik terbaik dalam menghadapi persaingan yang sengit.
            </div>
            <div class='mb-4' style="display: flex; justify-content: space-between; ">
                <a class="btn btn-success" href="pelatihan-ekspor">Info selengkapnya</a>
            </div>
        </div>

        <div class="col-md-6 d-right" style="z-index: 2; background-image: url(images/pages/pel-metr.png); height: 350px; background-size: cover; background-position: center;">
        </div>
        <div class="col-md-6 d-left" style="display: flex; flex-direction: column; justify-content: center;z-index: 3;">
            <h3 style="font-weight: bold;">PELATIHAN METROLOGI</h3>
            <div class="mb-3">PPEJP melalui Badan Diklat Mutu Metrologi dan Jasa Perdagangan menawarkan program pelatihan yang dirancang secara khusus untuk memperluas pemahaman Anda tentang prinsip-prinsip metrologi, peraturan dan standar pengukuran, serta teknik dan alat yang digunakan dalam proses pengukuran. Melalui pelatihan ini, Anda akan belajar bagaimana merancang, melaksanakan, dan memvalidasi pengukuran dengan tingkat akurasi yang tinggi.
            </div> <div class='mb-4' style="display: flex; justify-content: space-between; ">
                <a class="btn btn-success" href="pelatihan-metrologi">Info selengkapnya</a>
            </div>
        </div>

        <div class="col-md-6" style="background-image: url(images/pages/pel-mutu.png); height: 350px; background-size: cover; background-position: center;">
        </div>
        <div class="col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
            <h3 style="font-weight: bold;">PELATIHAN MUTU</h3>
            <div class="mb-3">PPEJP melalui Balai Pelatihan Metrologi, Mutu, dan Jasa Perdagangan menawarkan program pelatihan praktis tentang standar mutu, analisis data, pengendalian proses, perbaikan berkelanjutan, audit mutu, dan sertifikasi. Bergabunglah dengan kami untuk mencapai keunggulan mutu dan kepuasan pelanggan yang lebih baik.
            </div>
            <div class='mb-4' style="display: flex; justify-content: space-between; ">
                <a class="btn btn-success" href="pelatihan-mutu">Info selengkapnya</a>
            </div>
        </div>
		
        <div class="col-md-6 d-right" style="z-index: 2; background-image: url(images/pages/pel-jasa-perd.png); height: 350px; background-size: cover; background-position: center;">
        </div>
        <div class="col-md-6 d-left" style="display: flex; flex-direction: column; justify-content: center;z-index: 3;">
            <h3 style="font-weight: bold;">PELATIHAN JASA PERDAGANGAN</h3>
            <div class="mb-3">PPEJP melalui Badan Diklat Mutu Metrologi dan Jasa Perdagangan menyediakan program pelatihan untuk meningkatkan kompetensi dalam industri jasa perdagangan. Pelatihan kami mencakup strategi pemasaran, manajemen risiko, persyaratan peraturan internasional, dan keterampilan praktis seperti negosiasi dan layanan pelanggan. Bergabunglah dengan kami untuk mengembangkan keterampilan Anda dalam perdagangan jasa dan meraih kesuksesan di pasar global.

            </div> <div class='mb-4' style="display: flex; justify-content: space-between; ">
                <a class="btn btn-success" href="pelatihan-jasa-perdagangan">Info selengkapnya</a>
            </div>
        </div>
    </div>
</div>


<script>
    document.title = "Pelatihan"
</script>
	
</div>
<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
