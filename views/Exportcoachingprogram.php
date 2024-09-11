<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Exportcoachingprogram = &$Page;
?>
<?php echo myheader(); ?>


<div class="container-fluid " style="background-color: #031A31; padding:20px; margin-top:0;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold"><i>EXPORT COACHING PROGRAM</i></h1>
            </div>
        </div>
    </div>
</div>
<style>
	<style>
    .container-fluid, .container, .row {
        margin: 0;
        padding: 0;
    }

    h1 {
        font-size: 25px !important;
    }

    p, table, div {
        font-size: 16px !important;
    }

    h2 {
        font-size: 20px !important;
    }

    h3 {
        font-size: 18px !important;
    }

    .barcount-section {
        background: none;
        padding: 0;
        margin: 0 auto;
    }

    .jumlah {
        font-size: 72px;
        color: #031A31;
        background: none;
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

    /* Animasi kriteria peserta */
    .slideshow-container {
        display: flex;
        justify-content: center;
        overflow: hidden;
        width: 100%;
        height: auto;
        background-color: none;
        padding: 20px 0px;
        border-radius: 15px;
    }

    .slideshow-track {
        display: flex;
        width: calc(200%);
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
        box-shadow: 2px 1px 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .criteria-container:hover {
        transform: scale(1.05);
    }

    .criteria-icon {
        font-size: 48px;
        color: #031A31;
    }

    .criteria-title {
        font-size: 19px;
        font-weight: bold;
        margin-top: 0px;
    }

    .criteria-desc {
        font-size: 16px;
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
            flex: 1 0 30%;
        }
    }

    #map {
        height: 500px;
        width: 80%;
        margin: 0 auto;
        border-radius: 15px;
        overflow: hidden;
        display: block;
    }

    .text-justify {
        padding: 20px;
        text-align: justify;
    }
	
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-0" style="height: 450px">
            <div style="background-image: url(images/pages/bannerecpnew1.jpeg); background-size: cover ; background-position: bottom;width: 100%; height: 100%; position: absolute;top:0">
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
		<div class="container py-5">
			<h2 class="text-center"><b>KRITERIA PESERTA</b></h2> <br>
			<div class="slideshow-container">
				<div class="slideshow-track">
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

</section>

	<center><div class="row container"></center>
		<h2 class="text-center"><b>EXPORT COACHING PROGRAM 2024</b></h2><br>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
		<div id="map"></div>
		<script>
			var map = L.map('map').setView([-2.5489, 118.0149], 5);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			var locations = [
				{ name: "Jabodebek", lat: -6.2088, lng: 106.8456 },
				{ name: "Banten", lat: -6.1783, lng: 106.6319 },
				{ name: "Kalimantan Barat", lat: -0.0263, lng: 109.3425 },
				{ name: "Sumatera Barat", lat: -0.9471, lng: 100.4172 },
				{ name: "Yogyakarta", lat: -7.7956, lng: 110.3695 },
				{ name: "Jawa Tengah I", lat: -6.9667, lng: 110.4167 },
				{ name: "Jawa Tengah II", lat: -7.4244, lng: 109.2396 },
				{ name: "Jawa Barat", lat: -6.9175, lng: 107.6191 },
				{ name: "Jawa Timur", lat: -7.4465, lng: 112.7171 }
			];

			locations.forEach(function(location) {
				L.marker([location.lat, location.lng]).addTo(map)
				.bindPopup(location.name)
				.openPopup();
			});
		</script>
		<br><br>
	</div>
</div>
<!--<a class="btn btn-success btn-lg daftar mb-5" href="https://forms.gle/NenFWx4d4ySo1UVP6"> <h2> Daftar Sekarang! </h2></a></center>-->

<div class="mb-2">&nbsp;</div>

<script>
    document.title = "Pendampingan Export Coaching Program";
</script>

	<?php echo myfooter(); ?>



<?= GetDebugMessage() ?>