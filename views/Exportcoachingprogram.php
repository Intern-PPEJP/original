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
	<style>.container-fluid,
	.container,
	.row {
		margin: 0;
		padding: 0;
	}

	h1 {
		font-size: 25px !important;
	}

	p,
	table,
	div {
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

	.criteria-row {
		display: flex;
		flex-wrap: nowrap;
		justify-content: space-between;
		/* Untuk memberikan ruang antar card */
		gap: 20px;
		/* Tambahkan gap antar card */
	}

	.criteria-container {
		flex: 1 0 19%;
		/* Setiap card mengambil 19% dari lebar container */
		text-align: center;
		padding: 20px;
		box-sizing: border-box;
		background-color: #ffffff;
		border-radius: 15px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		transition: transform 0.3s ease;
		min-width: 150px;
		/* Supaya tidak terlalu kecil saat layar mengecil */
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

	/* Responsive untuk layar yang lebih kecil */
	@media (max-width: 992px) {
		.criteria-row {
			flex-wrap: wrap;
			/* Membungkus ke baris berikutnya di layar kecil */
		}

		.criteria-container {
			flex: 1 0 30%;
			/* Menyesuaikan agar 3 card per baris di layar sedang */
		}
	}

	@media (max-width: 768px) {
		.criteria-container {
			flex: 1 0 45%;
			/* Menyesuaikan agar 2 card per baris di layar kecil */
		}
	}

	@media (max-width: 576px) {
		.criteria-container {
			flex: 1 0 100%;
			/* Menyesuaikan agar 1 card per baris di layar sangat kecil */
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
		<div class="criteria-row">
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
		</div>
	</div>
</section>
<br>

<center>
	<div class="row container">
</center>
<h2 class="text-center"><b>EXPORT COACHING PROGRAM 2024</b></h2><br>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<div id="map"></div>
<script>
	var map = L.map('map').setView([-2.5489, 118.0149], 5);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	var locations = [{
			name: "Jabodebek",
			lat: -6.2088,
			lng: 106.8456
		},
		{
			name: "Banten",
			lat: -6.1783,
			lng: 106.6319
		},
		{
			name: "Kalimantan Barat",
			lat: -0.0263,
			lng: 109.3425
		},
		{
			name: "Sumatera Barat",
			lat: -0.9471,
			lng: 100.4172
		},
		{
			name: "Yogyakarta",
			lat: -7.7956,
			lng: 110.3695
		},
		{
			name: "Jawa Tengah I",
			lat: -6.9667,
			lng: 110.4167
		},
		{
			name: "Jawa Tengah II",
			lat: -7.4244,
			lng: 109.2396
		},
		{
			name: "Jawa Barat",
			lat: -6.9175,
			lng: 107.6191
		},
		{
			name: "Jawa Timur",
			lat: -7.4465,
			lng: 112.7171
		}
	];

	locations.forEach(function(location) {
		L.marker([location.lat, location.lng]).addTo(map)
			.bindPopup(location.name)
			.openPopup();
	});
</script>
<br>
</div>
</div>

<!--<section>
	<div class="container py-5">
		<h2 class="text-center"><b>DOKUMENTASI KEGIATAN</b></h2> <br>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/pages/ecp1.jpg" class="d-block w-100" alt="1st slide">
        </div>
        <div class="carousel-item">
          <img src="images/pages/ecp2.jpg" class="d-block w-100" alt="2nd slide">
        </div>
        <div class="carousel-item">
          <img src="images/pages/ecp3.jpg" class="d-block w-100" alt="3rd slide">
        </div>
        <div class="carousel-item">
          <img src="images/pages/ecp4.jpg" class="d-block w-100" alt="4th slide">
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
	</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
  .custom-carousel-img {
    max-height: 400px; /* Membatasi tinggi maksimum gambar */
    object-fit: cover;  /* Agar gambar tidak terdistorsi */
    border-radius: 15px; /* Menambahkan border-radius */
  }

  .carousel-item {
    text-align: center;
  }
</style>-->

<section>
	<div class="container py-5">
		<h2 class="text-center"><b>DOKUMENTASI KEGIATAN</b></h2> <br>
        	<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true" data-bs-interval="3000">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<div class="row justify-content-center">

									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/pages/ecp1.jpg" style="width:95%; height:250px !important; border-radius: 10px" alt="ECP 1" data-bs-toggle="modal" data-bs-target="#modalPerpustakaan">
					
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/pages/ecp2.jpg" style="width:95%; height:250px !important; border-radius: 10px" alt="ECP 2" data-bs-toggle="modal" data-bs-target="#modalSimulationCenter">
										
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/pages/ecp3.jpg" style="width:95%; height:250px !important; border-radius: 10px" alt="ECP 3" data-bs-toggle="modal" data-bs-target="#modalAuditorium">
										
									</div>
								</div>
							</div>
							<div class="carousel-item">
								<div class="row justify-content-center">

									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/pages/ecp5.jpg" style="width:95%; height:250px !important; border-radius: 10px" alt="ECP 4" data-bs-toggle="modal" data-bs-target="#modalAsrama">
										
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/pages/ecp6.jpg" style="width:95%; height:250px !important; border-radius: 10px" alt="ECP 5" data-bs-toggle="modal" data-bs-target="#modalJicanet">
										
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/pages/ecp7.jpeg" style="width:95%; height:250px !important; border-radius: 10px" alt="ECP 6" data-bs-toggle="modal" data-bs-target="#modalRuangKelas">
										
									</div>
								</div>
							</div>
						</div>
						<!-- Tombol titik navigasi -->
						<ol class="carousel-indicators">
							<li data-bs-target="#carouselExampleSlidesOnly" data-bs-slide-to="0" class="active"></li>
							<li data-bs-target="#carouselExampleSlidesOnly" data-bs-slide-to="1"></li>
						</ol>
					</div>
				</div>
	</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!--<a class="btn btn-success btn-lg daftar mb-5" href="https://forms.gle/NenFWx4d4ySo1UVP6"> <h2> Daftar Sekarang! </h2></a></center>-->

<div class="mb-2">&nbsp;</div>

<script>
	document.title = "Pendampingan Export Coaching Program";
</script>

<?php echo myfooter(); ?>



<?= GetDebugMessage() ?>