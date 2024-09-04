<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Exportcoachingprogram = &$Page;
?>
<?php echo myheader(); ?>

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

	.barcount-section {
    background: none; /* Menghilangkan latar belakang */
    padding: 20px 0;
	}

	.jumlah {
		font-size: 4.5rem;
		color: #031A31; /* Ubah warna font menjadi biru */
		background: none; /* Hilangkan background */
		display: block;
		text-align: center;
		font-weight: bold;
	}

	.jumlah_cap {
		font-size: 20px;
		color: #000;
		display: block;
		text-align: center;
		margin-top: 5px;
	}

	.angka {
		background: none; 
	}

	.container {
		background: none; 
	}

</style>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold"><i>EXPORT COACHING PROGRAM</i></h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-0" style="height: 450px">
            <div style="background-image: url(images/pages/bannerecp3.jpeg); background-size: cover ; background-position: bottom;width: 100%; height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-justify">
                Export Coaching Program merupakan program pendampingan untuk pelaku usaha berorientasi ekspor yang dilaksanakan dengan 7 tahapan selama kurang lebih 8 bulan sampai dengan 1 tahun. Tujuan program pendampingan ini adalah agar para pelaku usaha mampu menjalankan bisnis ekspornya secara efektif sehingga dapat melakukan ekspor secara mandiri.
            </div>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<section class="barcount-section">
		<div class="container">
			<div class="row row-bar-count pt-5">

				<div class="col-lg col-md-4 col-sm-4 col-xs-4 angka">
					<span class="col-12 jumlah" data-target="74">0</span>
					<span class="col-12 jumlah_cap">Angkatan ECP</span>
				</div>
				
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 angka">
					<span class="col-12 jumlah" data-target="2160">0</span>
					<span class="col-12 jumlah_cap">Peserta ECP</span>		
				</div>
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 angka">
					<span class="col-12 jumlah" data-target="20">0</span>
					<span class="col-12 jumlah_cap">Jumlah Wilayah</span>		
				</div>
			</div>
		</div>

		<script>
			// Fungsi untuk melakukan animasi hitung angka
			function animateCountUp(element, start, end, duration) {
				let startTime = null;

				function animation(currentTime) {
					if (startTime === null) startTime = currentTime;
					const progress = Math.min((currentTime - startTime) / duration, 1);
					element.innerText = Math.floor(progress * (end - start) + start);
					if (progress < 1) {
						requestAnimationFrame(animation);
					} else {
						element.innerText = end; // Pastikan angka berakhir sesuai target
					}
				}
				requestAnimationFrame(animation);
			}

			// Memulai animasi pada semua elemen dengan class 'jumlah'
			document.querySelectorAll('.jumlah').forEach((element) => {
				const target = parseInt(element.getAttribute('data-target'));
				animateCountUp(element, 0, target, 4000); // 2000ms = 2 detik
			});

			document.addEventListener('DOMContentLoaded', function() {
			const angkaElements = document.querySelectorAll('.angka');

			function checkScroll() {
				angkaElements.forEach(element => {
					const rect = element.getBoundingClientRect();
					if (rect.top <= window.innerHeight - 100) { // Sesuaikan angka -100 untuk mengatur kapan animasi dimulai
						element.classList.add('show');
					}
				});
			}

			// Memeriksa elemen saat halaman pertama kali dimuat
			checkScroll();

			// Memeriksa elemen ketika pengguna melakukan scroll
			window.addEventListener('scroll', checkScroll);
		});

		</script>
	</section>

	<section>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .slideshow-container {
            display: flex;
            overflow: hidden;
            width: 100%;
            height: auto;
            background-color: none;
            padding: 20px 10px;
            border-radius: 15px;
        }

        .slideshow-track {
            display: flex;
            width: calc(200%); /* Menggandakan lebar untuk looping */
            animation: slide 30s linear infinite;
            gap: 20px;
        }

        .criteria-container {
            flex: 1 0 25%;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .criteria-container:hover {
            transform: scale(1.05);
        }

        .criteria-icon {
            font-size: 3rem;
            color: #031A31;
        }

        .criteria-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 10px;
        }

        .criteria-desc {
            font-size: 1rem;
            color: #555;
        }

        @keyframes slide {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        @media (max-width: 992px) {
            .criteria-container {
                flex: 1 0 25%;
            }
        }

        @media (max-width: 768px) {
            .criteria-container {
                flex: 1 0 25%;
            }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <center><h2><b>Kriteria Peserta</b></h2></center> <br>
    <div class="slideshow-container">
        <div class="slideshow-track">
            <!-- Duplikasi container untuk menciptakan efek looping -->
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-id-card"></i></div>
                <div class="criteria-title">NIB & Badan Usaha</div>
                <div class="criteria-desc">Memiliki NIB, Badan Usaha (UD, CV, PT, Koperasi) yang masih berlaku.</div>
            </div>
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-industry"></i></div>
                <div class="criteria-title">Kapasitas Produksi</div>
                <div class="criteria-desc">Memiliki kapasitas produksi yang mendukung kegiatan ekspor.</div>
            </div>
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="criteria-title">Komitmen Tahunan</div>
                <div class="criteria-desc">Memiliki komitmen untuk mengikuti tahapan pendampingan ekspor selama 1 tahun.</div>
            </div>
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-business-time"></i></div>
                <div class="criteria-title">Pengalaman Bisnis</div>
                <div class="criteria-desc">Diutamakan memiliki pengalaman bisnis minimal 1 tahun.</div>
            </div>
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-language"></i></div>
                <div class="criteria-title">Kemampuan Bahasa & IT</div>
                <div class="criteria-desc">Memiliki tim yang memahami bahasa Inggris & mampu menggunakan komputer.</div>
            </div>
            <!-- Mulai pengulangan konten -->
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-id-card"></i></div>
                <div class="criteria-title">NIB & Badan Usaha</div>
                <div class="criteria-desc">Memiliki NIB, Badan Usaha (UD, CV, PT, Koperasi) yang masih berlaku.</div>
            </div>
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-industry"></i></div>
                <div class="criteria-title">Kapasitas Produksi</div>
                <div class="criteria-desc">Memiliki kapasitas produksi yang mendukung kegiatan ekspor.</div>
            </div>
            <div class="criteria-container">
                <div class="criteria-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="criteria-title">Komitmen Tahunan</div>
                <div class="criteria-desc">Memiliki komitmen untuk mengikuti tahapan pendampingan ekspor selama 1 tahun.</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</section>

<br>

	<br>
	<center><div class="row container">
	<center><h2><b>EXPORT COACHING PROGRAM 2024</b></h2></center>
	<div class="col-md-12" style="text-align: left; margin-top:36px;margin-bottom:76px;">
		<h3><b> Pelaksanaan di 9 (sembilan) Daerah: </b></h3>
		<ul>
			<li>Wilayah Jabodebek (Penyelenggaraan kegiatan di Gedung PPEJP)</li>
			<li>Wilayah Banten (Penyelenggaraan kegiatan di Tangerang)</li>
			<li>Wilayah Kalimantan Barat (Penyelenggaraan kegiatan di Pontianak)</li>
			<li>Wilayah Sumatera Barat (Penyelenggaraan kegiatan di Padang)</li>
			<li>Wilayah Daerah Istimewa Yogyakarta (Penyelenggaraan kegiatan di Yogyakarta)</li>
			<li>Wilayah Jawa Tengah I (Penyelenggaraan kegiatan di Semarang)</li>
			<li>Wilayah Jawa Tengah II (Penyelenggaraan kegiatan di Purwokerto)</li>
			<li>Wilayah Jawa Barat (Penyelenggaraan kegiatan di Bandung)</li>
			<li>Wilayah Jawa Timur (Penyelenggaraan kegiatan di Sidoarjo)</li>
		</ul>
	</div>
</div>
<a class="btn btn-success btn-lg daftar mb-5" href="https://forms.gle/NenFWx4d4ySo1UVP6"> <h2> Daftar Sekarang! </h2></a></center>

<div class="mb-3">&nbsp;</div>

<script>
    document.title = "Pendampingan Export Coaching Program";
</script>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
