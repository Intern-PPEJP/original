<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Home = &$Page;
?>
<?php echo myheader(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">-->
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
</head>

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

		/*

CC 2.0 License Iatek LLC 2018
Attribution required

*/

		@media (min-width: 768px) {

			/* show 3 items */
			#carouselProducts .carousel-inner .active,
			#carouselProducts .carousel-inner .active+.carousel-item,
			#carouselProducts .carousel-inner .active+.carousel-item+.carousel-item {
				display: block;
			}

			.carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left),
			.carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left)+.carousel-item,
			.carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left)+.carousel-item+.carousel-item {
				transition: none;
				margin-right: initial;
			}

			.carousel-inner .carousel-item-next,
			.carousel-inner .carousel-item-prev {
				position: relative;
				transform: translate3d(0, 0, 0);
			}

			.carousel-inner .active.carousel-item+.carousel-item+.carousel-item+.carousel-item {
				position: absolute;
				top: 0;
				right: -33.3333%;
				z-index: -1;
				display: block;
				visibility: visible;
			}

			/* left or forward direction */
			.active.carousel-item-left+.carousel-item-next.carousel-item-left,
			.carousel-item-next.carousel-item-left+.carousel-item,
			.carousel-item-next.carousel-item-left+.carousel-item+.carousel-item,
			.carousel-item-next.carousel-item-left+.carousel-item+.carousel-item+.carousel-item {
				position: relative;
				transform: translate3d(-100%, 0, 0);
				visibility: visible;
			}

			/* farthest right hidden item must be abso position for animations */
			.carousel-inner .carousel-item-prev.carousel-item-right {
				position: absolute;
				top: 0;
				left: 0;
				z-index: -1;
				display: block;
				visibility: visible;
			}

			/* right or prev direction */
			.active.carousel-item-right+.carousel-item-prev.carousel-item-right,
			.carousel-item-prev.carousel-item-right+.carousel-item,
			.carousel-item-prev.carousel-item-right+.carousel-item+.carousel-item,
			.carousel-item-prev.carousel-item-right+.carousel-item+.carousel-item+.carousel-item {
				position: relative;
				transform: translate3d(100%, 0, 0);
				visibility: visible;
				display: block;
				visibility: visible;
			}

		}

		.nav-fill .nav-item .nav-link.active {
			background: #28a745 !important;
		}

		/* Tambahkan efek untuk bagian yang akan naik ke atas */
		.angka {
			opacity: 0;
			transform: translateY(50px);
			transition: opacity 1.2s ease-out, transform 1.2s ease-out;
		}

		.angka.show {
			opacity: 1;
			transform: translateY(0);
		}

		p,
		div {
			font-size: 16px;
		}

		h2 {
			font-size: 20px;
		}

		h3 {
			font-size: 22px;
		}


		.icon-text,
		.featured-block {
			transition: transform 0.3s ease;
			/* Efek transisi yang halus */
		}

		.icon-text:hover,
		.featured-block:hover {
			transform: translateY(-10px);
			/* Efek naik saat dihover */
		}

		.carousel-indicators {
			position: relative;
			margin-top: 6px;
			/* Atur jarak dari konten di atasnya */
			margin-bottom: -2px;
			/* Geser lebih ke bawah dari posisi default */
			text-align: center;
			/* Posisikan di tengah secara horizontal */
		}

		.carousel-indicators li {
			width: 8px;
			height: 8px;
			background-color: #6c757d;
			/* Warna tombol titik */
			border-radius: 60%;
		}

		.carousel-indicators .active {
			background-color: #031A31;
			/* Warna tombol titik aktif */
		}

		.testimonials {
			text-align: center;
			padding: 20px;
			white-space: normal;
		}

		.testimonial {
			display: inline-block;
			background: white;
			border-radius: 10px;
			padding: 20px;
			width: 23%;
			text-align: center;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			vertical-align: top;
			margin-right: 1%;
		}

		.testimonial img {
			border-radius: 50%;
			width: 80px;
			height: 80px;
			margin-bottom: 20px;
		}

		.testimonial:hover {
			background-color: #edf6f9;
		}

		.testimonial p {
			font-style: italic;
			color: #666;
		}

		.testimonial h3 {
			color: #031A31;
			margin-top: 20px;
			font-size: 18px;
		}

		/* Responsif untuk testimoni */
		@media (max-width: 992px) {
			.testimonial {
				width: 48%;
				margin-bottom: 20px;
			}
		}

		@media (max-width: 768px) {
			.testimonial {
				width: 100%;
				margin-bottom: 20px;
			}
		}

		.barcount-section {
			background: none;
			/* Menghilangkan latar belakang */
			padding: 20px 0;
		}

		.jumlah {
			font-size: 4.5rem;
			color: #031A31;
			/* Ubah warna font menjadi biru */
			background: none;
			/* Hilangkan background */
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
			/* Pastikan tidak ada background pada elemen angka */
		}

		.container {
			background: none;
			/* Menghilangkan background pada container jika ada */
		}
	</style>


	<script>
		$('#carouselProducts').on('slide.bs.carousel', function(e) {

			/*

			CC 2.0 License Iatek LLC 2018
			Attribution required
			
			*/

			var $e = $(e.relatedTarget);

			var idx = $e.index();
			console.log("IDX :  " + idx);

			var itemsPerSlide = 8;
			var totalItems = $('#carouselProducts .carousel-item').length;

			if (idx >= totalItems - (itemsPerSlide - 1)) {
				var it = itemsPerSlide - (totalItems - idx);
				for (var i = 0; i < it; i++) {
					// append slides to end
					if (e.direction == "left") {
						$('#carouselProducts .carousel-item').eq(i).appendTo('#carouselProducts .carousel-inner');
					} else {
						$('#carouselProducts .carousel-item').eq(0).appendTo('#carouselProducts .carousel-inner');
					}
				}
			}
		});
	</script>
	<main>

		<section class="ppejp-section ppejp-section-full-height">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-12 p-0">
						<div class="container">
							<h4 class="judul">PUSAT PELATIHAN<br>SUMBER DAYA MANUSIA EKSPOR<br>DAN JASA PERDAGANGAN</h4>

							<p class="subline" style="font-size: 30px;">Mengembangkan UMKM Indonesia Sejak 1990</p>

							<ul class="slider-button pl-0">
								<li class="b-item mb-2">
									<a class="nav-link custom-btn custom-border-btn btn inactive list-pelatihan" href="#" data-toggle="modal" data-target="#ListPelatihan">Jadwal Pelatihan</a>
								</li>
								<li class="b-item">
									<a class="nav-link custom-btn custom-border-btn btn inactive daftar" href="formpendaftaran">Daftar Pelatihan</a>
								</li>
							</ul>


							<div class="y-jadwal">
								<ul style="list-style-type:none">
									<?php
									$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_peserta`, `sisa`, `tanggal_pelaksanaan`, `jenis_pelatihan`, `Link` 
				FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE()
				ORDER BY CASE WHEN `sisa` > 0 THEN 1 ELSE 2 END, `tawal` ASC");
									$i = 1;
									while ($row = $rs->fetch()) {
										$ket = '<span class="badge text-success">Sisa ' . $row["sisa"] . ' orang</span>';
										$link = 'detail-pelatihan/view/' . $row["pelatihan_id"];
										if ($row["sisa"] < 1) {
											$ket = '<span class="badge text-danger">Fully Booked</span>';
										} else if ($row["sisa"] >= 1 && $row["sisa"] <= 10) {
											$ket = '<span class="badge text-warning">Sisa ' . $row["sisa"] . ' orang</span>';
										}

										$ikon = "icon-users.png";
										if ($row["jenis_pelatihan"] == "obrolan_ekspor") {
											$ikon = "brand-youtube.png";
											$link = $row["Link"];
										} else if ($row["jenis_pelatihan"] == "webinar") {
											$ikon = "icon-video.png";
										}
									?><li><span class="" style="border: 2px solid #fff;position:absolute;left:23px;height:40%;border-radius:15px;"></span>
											<div class="item_direction mb-4">

												<i class="fas fa-circle cikon"></i><a href="<?php echo $link; ?>" style="text-decoration:none;color:#fff;">
													<table>
														<tr>
															<td><img src="images/icons/<?php echo $ikon; ?>"></img></td>
															<td>
																<?php
																echo $row["judul_pelatihan"]; ?><br><span class="y-tgl"><?php echo $row["tanggal_pelaksanaan"]; ?> <?php echo $ket; ?> </span></td>
														</tr>
													</table>
												</a>
											</div>
										</li>
									<?php
									}
									?>
								</ul>
							</div>

							<style>
								@media (max-width: 768px) {
									.y-jadwal {
										margin-left: -35px;
										/* Sesuaikan margin untuk layar kecil */
										padding-right: 35px;
										/* Sesuaikan padding pada layar kecil */
									}
								}
							</style>

						</div>
						<div id="ppejp-slide" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000" data-pause="false">
							<div style="position:absolute;background: rgb(0 0 0 / 50%);width:100%;height:100%;z-index: 2;"></div>
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images/slide/1.png" class="carousel-image img-fluid" alt="Gedung Depan PPEJP">
								</div>
								<div class="carousel-item">
									<img src="images/slide/2.png" class="carousel-image img-fluid" alt="Gedung Samping PPEJP">
								</div>
								<div class="carousel-item">
									<img src="images/slide/3.png" class="carousel-image img-fluid" alt="Gedung Atas PPEJP">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!--BERITA DI BERANDA-->

		<?php
		// Query untuk mengambil 4 berita terbaru
		$berita_terbaru = ExecuteQuery("SELECT id, gambar, judul, DATE_FORMAT(tanggal_publikasi, '%Y-%m-%d') tanggal FROM w_berita WHERE publish = 'Y' ORDER BY tanggal_publikasi DESC LIMIT 4");
		?>

		<div class="container mt-5">
			<div class="row mb-3">
				<div class="col-12">
					<h3 style="font-weight: bold; position: relative; display: inline-block;">
						Berita Terbaru
						<span style="position: absolute; left: 0; bottom: -8px; width: 50px; height: 4px; background-color: #4CAF50;"></span>
					</h3>
					<div style="border-bottom: 1px solid #e9ecef; margin-top: 0;"></div>
				</div>
			</div>
			<div class="row">
				<?php
				if ($berita_terbaru->rowCount() > 0) {
					while ($berita = $berita_terbaru->fetch()) {
						$gambar = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $berita["gambar"]);
				?>
						<div class="col-md-3 mb-4">
							<a href="berita?baca=<?php echo $berita['id']; ?>" style="color:#000;text-decoration:none;">
								<div class="card h-100 shadow card-hover" style="border-radius: 10px; border: none;">
									<div class="card-img-top" style="background-image: url('images/news/<?php echo $gambar[0]; ?>'); background-size: cover; height: 200px; border-top-left-radius: 10px; border-top-right-radius: 10px;"></div>
									<div class="card-body">
										<h5 class="card-title" style="font-weight: 500; font-size: 16px;"><?php echo $berita['judul']; ?></h5>
										<p class="card-text" style="font-size: .8em; color: gray;"><?php echo tanggal_indo($berita['tanggal']); ?></p>
									</div>
								</div>
							</a>
						</div>
				<?php
					}
				} else {
					echo "Belum ada berita terbaru.";
				}
				?>
			</div>
		</div>
		<!-- Button Berita Lainnya -->
		<div class="d-flex justify-content-center mt-1">
			<a href="berita" class="btn btn-primary" style="border:none; border-radius: 10px; font-size: 14px">Berita Lainnya »</a>
		</div>
		</div>

		<style>
			.card-hover {
				transition: transform 0.3s ease, box-shadow 0.3s ease;
			}

			.card-hover:hover {
				transform: translateY(-10px);
				box-shadow: 0 12px 16px rgba(0, 0, 0, 0.2);
			}

			.btn-primary {
				background-color: #031A31;

			}

			.btn-primary:hover {
				background-color: #19497D;
			}
		</style>


		<section class="profile-section">
			<div class="container text-center">
				<div class="row justify-content-center">
					<h3 class="mb-3 text-bold">Profil</h3>
					<div class="col-lg-8 col-12 vid-profil mb-4">

						<iframe width="90%" height="320" src="https://www.youtube.com/embed/m4Bxe4osZVo" title="Video Profil PPEJP" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

					</div>
					<div class="col-lg-10 col-12 text-description">

						<p style="text-align:center;">
							Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan (PPEJP) merupakan lembaga yang berada di lingkungan Sekretariat Jenderal, Kementerian Perdagangan. PPEJP mempunyai tugas melaksanakan pengembangan sumber daya manusia ekspor, mutu, personil metrologi legal, dan jasa perdagangan untuk dunia usaha dan masyarakat.
						</p>
					</div>
				</div>
			</div>
		</section>

		<style>
			.profile-section {
				background-color: #ffffff;
				padding-bottom: 15px;
			}
		</style>

		<section>
			<div class="container container-act">
				<a href="pelatihan-ekspor">
					<div class="act-card">
						<img src="images/icons/ekspor.png" alt="Pelatihan Ekspor">
						<h3>Pelatihan Ekspor</h3>
					</div>
				</a>
				<a href="pelatihan-metrologi">
					<div class="act-card">
						<img src="images/icons/measurement.png" alt="Pelatihan Metrologi">
						<h3>Pelatihan Metrologi</h3>
					</div>
				</a>
				<a href="pelatihan-mutu">
					<div class="act-card">
						<img src="images/icons/mutu.png" alt="Pelatihan Mutu">
						<h3>Pelatihan Mutu</h3>
					</div>
				</a>
				<a href="pelatihan-jasa-perdagangan">
					<div class="act-card">
						<img src="images/icons/trade.png" alt="Pelatihan Jasa Perdagangan">
						<h3>Pelatihan Jasa Perdagangan</h3>
					</div>
				</a>
				<a href="export-coaching-program">
					<div class="act-card">
						<img src="images\icons\coaching.png" alt="Export Coaching Program">
						<h3>Export Coaching Program</h3>
					</div>
				</a>
				<a href="webinar">
					<div class="act-card">
						<img src="images/icons/webinar.png" alt="Webinar">
						<h3>Webinar</h3>
					</div>
				</a>
			</div>
		</section>

		<style>
			.container-act {
				display: flex;
				justify-content: center;
				align-items: stretch;
				flex-wrap: nowrap;
				padding: 30px 0px;
				margin: 0 auto;
				max-width: 1250px;
				flex-direction: row;
			}

			.container-act .act-card {
				background-color: #ffffff;
				border-radius: 8px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				width: 200px;
				padding: 20px;
				margin: 10px;
				text-align: center;
				height: 90%;
				transition: transform 0.3s ease;
			}

			.container-act .act-card img {
				width: 90px;
				margin-bottom: 15px;
			}

			.container-act .act-card h3 {
				font-size: 18px;
				color: #2c3e50;
				margin-bottom: 10px;
			}

			.container-act .act-card p {
				font-size: 14px;
				color: #7f8c8d;
			}

			.container-act .act-card:hover {
				background-color: #023e8a;
				color: #ffffff;
				transition: background-color 0.3s ease, color 0.3s ease;
				transform: scale(1.05);
			}

			.container-act .act-card:hover h3 {
				color: #ffffff;
			}

			.container-act .act-card:hover img {
				filter: brightness(0) invert(1);
				/* Mengubah icon menjadi putih */
				transition: filter 0.3s ease;
			}

			.container-act a {
				text-decoration: none;
				color: inherit;
				display: block;
			}

			.container-act a:hover .act-card {
				background-color: #023e8a;
				color: #ffffff;
			}

			.container-act a:hover .act-card img {
				filter: brightness(0) invert(1);
			}

			/* Media query untuk layar kecil */
			@media (max-width: 768px) {
				.container-act {
					flex-direction: column;
					align-items: center;
				}

				.container-act .act-card {
					max-width: 200px;
					margin: 10 px;
				}
			}
		</style>

		<section class="barcount-section">
			<div class="container">
				<div class="row row-bar-count pt-2">
					<div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
						<span class="col-12 jumlah" data-target="60000">0</span>
						<span class="col-12 jumlah_cap">Alumni pelatihan</span>
					</div>

					<div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
						<span class="col-12 jumlah" data-target="2000">0</span>
						<span class="col-12 jumlah_cap">Alumni Pendampingan</span>
					</div>
					<div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
						<span class="col-12 jumlah" data-target="110">0</span>
						<span class="col-12 jumlah_cap">Fasilitator</span>
					</div>
					<div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
						<span class="col-12 jumlah" data-target="80">0</span>
						<span class="col-12 jumlah_cap">Topik Pelatihan</span>
					</div>
				</div>
			</div>
		</section>


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




		<section class="pt-5 pb-2">
			<div class="container">
				<div class="row">
					<div class="col-12 text-center">
						<a class="btn btn-success mb-3 mr-1" href="#carouselProducts" role="button" data-slide="prev" style="position:absolute;left:12px;top:0;">
							<i class="fa fa-arrow-left"></i>
						</a>
						<h3 class="mb-3 text-bold">Pelatihan Mendatang </h3>
						<a class="btn btn-success mb-3 " href="#carouselProducts" role="button" data-slide="next" style="position:absolute;right:25px;top:0">
							<i class="fa fa-arrow-right"></i>
						</a><br>
					</div>


					<div id="carouselProducts" class="carousel slide" data-ride="carousel" data-interval="5000">

						<div class="carousel-inner" role="listbox">
							<div class="row" style="margin-right:0px !important">
								<?php
								$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`,`tawal`, `jumlah_hari`, `tempat`, `jumlah_peserta`, `sisa`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` 
								FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') 
								ORDER BY CASE WHEN `sisa` > 0 THEN 1 ELSE 2 END, `tawal` ASC");
								$i = 1;
								while ($row = $rs->fetch()) {

									$peserta_terdaftar = ExecuteScalar("SELECT COUNT(1) FROM `w_orders` WHERE `pelatihan_id` = " . $row["pelatihan_id"]);
									$sisa = $row["sisa"];
									$active = "";
									if ($i == 1) $active = "active";
								?>
									<div class="carousel-item col-md-4 <?php echo $active; ?>">
										<div class="card" style="padding:0;border:0;box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);">
											<img class="img-fluid" alt="100%x220" style="height:220px !important;border-radius:8px 8px 0 0 !important;" src="files/<?php echo $row["gambar"]; ?>">
											<div class="card-body m-0 p-1">
												<h3 class="card-titte" style="height:40px; font-size: 18px; font-weight: bold;"><?php echo $row["judul_pelatihan"]; ?></h3>
												<table class="table p-0 m-0" style="font-size:.8em">
													<tr>
														<td width="60%" height="" valign="middle"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $row["jumlah_hari"]; ?></td>
														<td width="40%" valign="middle"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $row["tempat"]; ?></td>
													</tr>
													<tr>
														<td height=""><i class="fa fa-users" aria-hidden="true"></i> <?php echo $row["jumlah_peserta"]; ?> Orang</td>
														<td><i class="fa fa-money" aria-hidden="true"></i> <?php echo rupiah($row["harga"]); ?></td>
													</tr>
													<tr>
														<td height=""><?php echo $row["tanggal_pelaksanaan"]; ?> </td>
														<td><i class="fa fa-user" aria-hidden="true"></i>
															<?php if ($row["sisa"] > 0 && strtotime($row["tawal"]) > strtotime(date("Y-m-d"))) { ?>
																<span class="text-danger">Sisa <?php echo $sisa; ?> Kursi
																<?php } else { ?>
																	<span class="badge badge-danger">Fully Booked</span>
																<?php } ?>

														</td>
													</tr>
												</table>
												<div class="card-footer"><a href="<?= GetUrl('detail-pelatihan/view/' . $row["pelatihan_id"]) ?>" class="btn btn-success stretched-link btn-lg btn-block">Lihat Detail</a></div>
											</div>
										</div>
									</div>
								<?php
									$i++;
								}
								?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>

		<section class="content-section">
			<div class="container">
				<div class="row">
					<h3 class="text-center text-bold mb-4">Fasilitas</h3>
					<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true" data-bs-interval="3000">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<div class="row justify-content-center">

									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/fasilitas/perpustakaan (2).JPG" style="width:95%; height:210px !important; border-radius: 10px" alt="Perpustakaan" data-bs-toggle="modal" data-bs-target="#modalPerpustakaan">
										<h6 class="text-bold mt-3 text-secondary">PERPUSTAKAAN</h6>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/fasilitas/simulation_center.JPG" style="width:95%; height:210px !important; border-radius: 10px" alt="Simulation Center" data-bs-toggle="modal" data-bs-target="#modalSimulationCenter">
										<h6 class="text-bold mt-3 text-secondary">SIMULATION CENTER</h6>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images\fasilitas\auditorium.JPG" style="width:95%; height:210px !important; border-radius: 10px" alt="Auditorium" data-bs-toggle="modal" data-bs-target="#modalAuditorium">
										<h6 class="text-bold mt-3 text-secondary">AUDITORIUM</h6>
									</div>
								</div>
							</div>
							<div class="carousel-item">
								<div class="row justify-content-center">

									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/fasilitas/asrama.jpg" style="width:95%; height:210px !important; border-radius: 10px" alt="Asrama" data-bs-toggle="modal" data-bs-target="#modalAsrama">
										<h6 class="text-bold mt-3 text-secondary">ASRAMA</h6>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/fasilitas/jicanet.JPG" style="width:95%; height:210px !important; border-radius: 10px" alt="Jicanet" data-bs-toggle="modal" data-bs-target="#modalJicanet">
										<h6 class="text-bold mt-3 text-secondary">JICANET</h6>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images/fasilitas/ruang_kelas.JPG" style="width:95%; height:210px !important; border-radius: 10px" alt="Ruang Kelas" data-bs-toggle="modal" data-bs-target="#modalRuangKelas">
										<h6 class="text-bold mt-3 text-secondary">RUANG KELAS</h6>
									</div>
								</div>
							</div>
							<div class="carousel-item">
								<div class="row justify-content-center">

									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images\fasilitas\bpmjp\3. Instalasi timbangan jembatan.jpg" style="width:95%; height:210px !important; border-radius: 10px" alt="Instalasi" data-bs-toggle="modal" data-bs-target="#modalInstalasi">
										<h6 class="text-bold mt-3 text-secondary">INSTALASI</h6>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images\fasilitas\bpmjp\Lab Massa Elektronik.3.jpeg" style="width:95%; height:210px !important; border-radius: 10px" alt="Laboratorium" data-bs-toggle="modal" data-bs-target="#modalLaboratorium">
										<h6 class="text-bold mt-3 text-secondary">LABORATORIUM</h6>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 text-center">
										<img src="images\fasilitas\bpmjp\Lapangan Badminton.jpg" style="width:95%; height:210px !important; border-radius: 10px" alt="Lainnya" data-bs-toggle="modal" data-bs-target="#modalFasilitasLainnya">
										<h6 class="text-bold mt-3 text-secondary">FASILITAS LAINNYA</h6>
									</div>
								</div>
							</div>

						</div>
						<!-- Tombol titik navigasi -->
						<ol class="carousel-indicators">
							<li data-bs-target="#carouselExampleSlidesOnly" data-bs-slide-to="0" class="active"></li>
							<li data-bs-target="#carouselExampleSlidesOnly" data-bs-slide-to="1"></li>
							<li data-bs-target="#carouselExampleSlidesOnly" data-bs-slide-to="2"></li>
						</ol>
					</div>
				</div>
			</div>
		</section>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var myCarousel = document.querySelector('#carouselExampleSlidesOnly');
				var carousel = new bootstrap.Carousel(myCarousel, {
					interval: 3000,
					wrap: true
				});
			});
		</script>

		<!-- Modals -->
		<!-- Modal Perpustakaan -->
		<div class="modal fade" id="modalPerpustakaan" tabindex="-1" aria-labelledby="modalPerpustakaanLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalPerpustakaanLabel">Perpustakaan</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselPerpustakaan" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images/fasilitas/perpustakaan (2).JPG" class="d-block w-100" alt="Perpustakaan">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/perpus 1.JPG" class="d-block w-100" alt="Perpustakaan 1">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/perpus 2.JPG" class="d-block w-100" alt="Perpustakaan 2">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/perpus 3.JPG" class="d-block w-100" alt="Perpustakaan 3">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/perpus 4.JPG" class="d-block w-100" alt="Perpustakaan 4">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselPerpustakaan" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselPerpustakaan" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Simulation Center -->
		<div class="modal fade" id="modalSimulationCenter" tabindex="-1" aria-labelledby="modalSimulationCenterLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalSimulationCenterLabel">Simulation Center</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselSimulationCenter" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images/fasilitas/simulation_center.JPG" class="d-block w-100" alt="SC">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/SC 1.JPG" class="d-block w-100" alt="SC 1">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/SC 2.JPG" class="d-block w-100" alt="SC 2">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/SC 3.JPG" class="d-block w-100" alt="SC 3">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/SC 4.JPG" class="d-block w-100" alt="SC 4">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/SC 5.JPG" class="d-block w-100" alt="SC 5">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/SC 6.JPG" class="d-block w-100" alt="SC 6">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselSimulationCenter" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselSimulationCenter" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Auditorium -->
		<div class="modal fade" id="modalAuditorium" tabindex="-1" aria-labelledby="modalAuditoriumLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalAuditoriumLabel">Auditorium</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselAuditorium" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images/fasilitas/auditorium.JPG" class="d-block w-100" alt="Auditorium">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/auditorium 1.JPG" class="d-block w-100" alt="Auditorium 1">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/auditorium 2.JPG" class="d-block w-100" alt="Auditorium 2">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/auditorium 3.JPG" class="d-block w-100" alt="Auditorium 3">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/auditorium 5.JPG" class="d-block w-100" alt="Auditorium 4">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselAuditorium" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselAuditorium" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Asrama -->
		<div class="modal fade" id="modalAsrama" tabindex="-1" aria-labelledby="modalAsramaLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalAsramaLabel">Asrama</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselAsrama" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images/fasilitas/asrama.jpg" class="d-block w-100" alt="Asrama">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/Super (10).jpg" class="d-block w-100" alt="Asrama 1">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/Super (20).jpg" class="d-block w-100" alt="Asrama 2">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/VIP (17).jpg" class="d-block w-100" alt="Asrama 3">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/km standar 1.jpg" class="d-block w-100" alt="Asrama 4">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/km standar 2.jpg" class="d-block w-100" alt="Asrama 5">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/km standar 3.jpg" class="d-block w-100" alt="Asrama 6">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselAsrama" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselAsrama" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Jicanet -->
		<div class="modal fade" id="modalJicanet" tabindex="-1" aria-labelledby="modalJicanetLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalJicanetLabel">Jicanet</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselJicanet" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images/fasilitas/jicanet.JPG" class="d-block w-100" alt="Jicanet">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/jicanet 1.JPG" class="d-block w-100" alt="Jicanet 1">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/jicanet 2.JPG" class="d-block w-100" alt="Jicanet 2">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselJicanet" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselJicanet" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Ruang Kelas -->
		<div class="modal fade" id="modalRuangKelas" tabindex="-1" aria-labelledby="modalRuangKelasLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalRuangKelasLabel">Ruang Kelas</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselRuangKelas" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images/fasilitas/ruang_kelas.JPG" class="d-block w-100" alt="Ruang Kelas">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/rk 2.JPG" class="d-block w-100" alt="rk 1">
								</div>
								<div class="carousel-item">
									<img src="images/fasilitas/rk 3.JPG" class="d-block w-100" alt="rk 2">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselRuangKelas" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselRuangKelas" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Instalasi -->
		<div class="modal fade" id="modalInstalasi" tabindex="-1" aria-labelledby="modalInstalasiLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalInstalasiLabel">Instalasi</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselInstalasi" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images\fasilitas\bpmjp\3. Instalasi timbangan jembatan.jpg" class="d-block w-100" alt="Instalasi">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\1.1. Instalasi Tangki Ukur Mobil.jpg" class="d-block w-100" alt="Instalasi 1">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\1.2.Instalasi Tangki Ukur Mobil.jpg" class="d-block w-100" alt="Instalasi 2">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\2. Instalasi PU BBM.jpeg" class="d-block w-100" alt="Instalasi 3">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\4.Instalasi TUTSIT.jpeg" class="d-block w-100" alt="Instalasi 4">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselInstalasi" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselInstalasi" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Lab -->
		<div class="modal fade" id="modalLaboratorium" tabindex="-1" aria-labelledby="modalLaboratoriumLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalLaboratoriumLabel">Laboratorium</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselLaboratorium" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images\fasilitas\bpmjp\Lab Massa Elektronik.3.jpeg" class="d-block w-100" alt="Laboratorium">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Bejana Ukur.jpeg" class="d-block w-100" alt="Laboratorium 1">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Listrik.jpeg" class="d-block w-100" alt="Laboratorium 2">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Massa Elektronik.jpeg" class="d-block w-100" alt="Laboratorium 3">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Massa Elektronik.3.jpeg" class="d-block w-100" alt="Laboratorium 4">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Massa Elektronik.2.jpeg" class="d-block w-100" alt="Laboratorium 5">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Meter Kadar Air.1.jpg" class="d-block w-100" alt="Laboratorium 6">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Suhu, Gaya, Tekanan.jpeg" class="d-block w-100" alt="Laboratorium 7">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Timbangan Mekanik.3.jpeg" class="d-block w-100" alt="Laboratorium 8">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lab Timbangan Mekanik.jpeg" class="d-block w-100" alt="Laboratorium 9">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselLaboratorium" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselLaboratorium" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Fasilitas Lainnya -->
		<div class="modal fade" id="modalFasilitasLainnya" tabindex="-1" aria-labelledby="modalFasilitasLainnyaLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalFasilitasLainnyaLabel">Lapangan & Teater</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- Bootstrap Carousel -->
						<div id="carouselFasilitasLainnya" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="images\fasilitas\bpmjp\Lapangan Badminton.jpg" class="d-block w-100" alt="Lapangan 1">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Lapangan Voli dan Jogging Track.jpg" class="d-block w-100" alt="Lapangan 2">
								</div>
								<div class="carousel-item">
									<img src="images\fasilitas\bpmjp\Theater.jpg" class="d-block w-100" alt="Teater">
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselFasilitasLainnya" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselFasilitasLainnya" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap JS Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


		<style>
			.carousel-control-prev,
			.carousel-control-next {
				width: auto;
				background: none;
				border: none;
			}

			.carousel-control-prev-icon,
			.carousel-control-next-icon {
				background-color: transparent;
				background-image: none;
				border: 2px solid white;
				border-radius: 50%;
				width: 30px;
				height: 30px;
				line-height: 30px;
			}

			.carousel-control-prev-icon::before {
				content: '<';
				color: white;
				font-size: 20px;
				display: block;
				text-align: center;
			}

			.carousel-control-next-icon::before {
				content: '>';
				color: white;
				font-size: 20px;
				display: block;
				text-align: center;
			}
		</style>

		<section class="content-section">
			<div class="container">
				<h3 class="text-center text-bold mt-5 mb-4">Testimoni Alumni</h3>
				<!--<center>

			<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
			  <div class="carousel-inner">
					<?php
					$rs = ExecuteQuery("SELECT * FROM `w_testimoni` WHERE `show` = 'Y'");
					$count = 0;
					$i = 1;
					while ($row_testimoni = $rs->fetch()) {
						$active = "";
						if ($count % 4 == 0) {
							if ($i == 1) $active = "active";
							echo "<div class='carousel-item " . $active . "'><div class='row justify-content-center'>";
						}
					?>
					
					<div class="col-md-3 testimoni mb-2">
						<a href="<?= $row_testimoni["link_testimoni"]; ?>">
						<div class="col-12 p-0 m-0">
							<img class="p-0 m-0" style="border-radius:15px;width:100%" src="images/testimoni/<?php echo $row_testimoni["gambar"]; ?>" height="300px"></img>
							<div class="col-12" style="border-radius:15px;position: absolute; bottom: 0; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.5); /* Black see-through */ color: #f1f1f1; transition: .5s ease; color: white; font-size: 20px; padding-top: 300px; text-align: center;m-right:10px;"></div>
						</div>
						
						<h5 class="judul ml-5 mr-5">"<?= $row_testimoni["testimoni"]; ?>"</h5>
						</a>
					</div>
					
					<?php

						if ($count % 4 == 3) {
							echo "</div></div>";
						}

						$count++;
						$i++;
					}
					?>
			  </div>
			</div>

			</center>-->
				<center>
					<div class="testimonials">
						<?php
						$rs = ExecuteQuery("SELECT * FROM `w_testimoni` WHERE `show` = 'Y'");
						while ($row_testimoni = $rs->fetch()) {
						?>
							<div class="testimonial">
								<img src="images/testimoni/<?php echo $row_testimoni["gambar"]; ?>" alt="<?php echo $row_testimoni["nama"]; ?>">
								<p>"<?php echo $row_testimoni["testimoni"]; ?>"</p>
								<h3><?php echo strtoupper($row_testimoni["nama"]); ?></h3>
							</div>
						<?php
						}
						?>
					</div>
				</center>

		</section>

		<section class="content-section">
			<div class="container">
				<h3 class="text-center text-bold mb-5 mt-5">Media Sosial</h3>
				<div class="container mb-5">

					<ul class="nav nav-pills nav-fill mb-3 text-center row" id="pills-tab" role="tablist">
						<li class="nav-item col-md-3 col-12">
							<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link active" id="pills-instagram-tab" data-toggle="pill" href="#pills-instagram" role="tab" aria-controls="pills-instagram" aria-selected="true"><i class="fab fa-instagram"></i> INSTAGRAM</a>
						</li>
						<li class="nav-item col-md-3 col-12">
							<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link" id="pills-tiktok-tab" data-toggle="pill" href="#pills-tiktok" role="tab" aria-controls="pills-tiktok" aria-selected="false"><i class="fab fa-tiktok"></i> TIKTOK</a>
						</li>
						<li class="nav-item col-md-3 col-12">
							<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link" id="pills-youtube-tab" data-toggle="pill" href="#pills-youtube" role="tab" aria-controls="pills-youtube" aria-selected="true"><i class="fab fa-youtube"></i> YOUTUBE</a>
						</li>
						<li class="nav-item col-md-3 col-12">
							<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link" id="pills-facebook-tab" href="https://www.facebook.com/PPEJP.Kemendag/" target="_blank" role="tab" aria-controls="pills-facebook" aria-selected="false"><i class="fab fa-facebook"></i> FACEBOOK</a>
						</li>
					</ul>

					<div class="tab-content mb-5" style="z-index:1;">

						<div class="tab-pane fade show active" id="pills-instagram" role="tabpanel" aria-labelledby="pills-instagram-tab">
							<!-- Instagram Embed Script -->
							<script src="https://cdn2.woxo.tech/a.js#66c5a0ac34674ed437f7b09e" async data-usrc></script>
							<div class="elfsight-app-c0ba69ff-8b36-40f8-8eb3-758a5d633c90"></div>
						</div>
						<div class="tab-pane fade" id="pills-tiktok" role="tabpanel" aria-labelledby="pills-tiktok-tab">
							<!-- TikTok Embed Script -->
							<script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
							<div class="elfsight-app-91337aaf-cefd-4752-80dc-88a335265f76"></div>
						</div>
						<div class="tab-pane fade" id="pills-youtube" role="tabpanel" aria-labelledby="pills-youtube-tab">
							<!-- YouTube Embed Script -->
							<div data-mc-src="3662baff-3223-406a-afac-c6af840677d1#youtube"></div>
							<script src="https://cdn2.woxo.tech/a.js#656f9f772d45de716bdbffc3" async data-usrc></script>
						</div>
					</div>
					</script>
				</div>
		</section>

	</main>

	<?php echo myfooter(); ?>


	<div class="modal fade" id="ListPelatihan" tabindex="-1" role="dialog" aria-labelledby="ListPelatihan" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ListPelatihan"><strong>JADWAL PELATIHAN</strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>


				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<?php
							// $rs = ExecuteQuery("SELECT `judul_pelatihan`,SUM(`sisa`) AS total_sisa 
							// FROM `w_pelatihan` WHERE `Activated` = 'Y' 
							// AND `tawal` >= CURRENT_DATE() 
							// AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') 
							// GROUP BY `judul_pelatihan`
							// ORDER BY CASE WHEN SUM(`sisa`) > 0 THEN 1 ELSE 2 END, `judul_pelatihan` ASC");
							$rs = ExecuteQuery("SELECT `judul_pelatihan` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') GROUP BY `judul_pelatihan`");
							$i = 1;
							while ($row1 = $rs->fetch()) {
							?>
								<div class="col-lg-4">
									<div class="mb-3 p-0 pb-2" style="border:0;box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);">
										<p class="p-2" style=" height: 55px;"><?php echo "<b>" . $row1["judul_pelatihan"] . "</b>"; ?></p>
										<?php
										$rs2 = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `tawal`, `jumlah_hari`, `tempat`, `jumlah_peserta`, `sisa`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` 
			FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `judul_pelatihan` = '" . $row1["judul_pelatihan"] . "' AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') 
			ORDER BY CASE 
			WHEN `sisa` > 0  AND `tawal` >= CURDATE() THEN 1
			WHEN `sisa` > 0  AND `tawal` >= CURDATE() THEN 2 
			ELSE 3 END, `tawal` ASC");
										$i = 1;
										while ($row2 = $rs2->fetch()) {
										?>
											<div class="row m-1">
												<?php
												if ($row2["tawal"] < date("Y-m-d") || $row2["sisa"] <= 0) {
												?>


													<div class="col-8 text-sm-left" style="border:2px solid #babababa;padding:2px;border-right:none;border-radius:0.25rem 0 0 0.25rem;font-size:14pt;color:#bababa"><del><?php echo $row2["tanggal_pelaksanaan"]; ?></del></div>
													<div class="col-4" style="border:2px solid #babababa;padding:2px;border-radius:0 0.25rem 0.25rem 0;">
														<table>
															<tr>
																<td><i class="fa fa-user" aria-hidden="true" style="font-size:25px;color:#bababa;"></i></td>
																<td style="font-size:8pt;margin:0;padding:0;padding-left:5px;color:#bababa"><del>penuh</del></td>
															</tr>
														</table>
													</div>

												<?php

												} else {
													$link = GetUrl('detail-pelatihan/view/' . $row2["pelatihan_id"]);
												?>

													<a href="<?php echo $link; ?>" class="row" style="text-decoration:none;color:#000;padding:0;margin:0;">
														<div class="col-8 text-sm-left" style="border:2px solid #babababa;padding:2px;border-right:none;border-radius:0.25rem 0 0 0.25rem;font-size:14pt"><?php echo $row2["tanggal_pelaksanaan"]; ?></div>
														<div class="col-4" style="border:2px solid #babababa;padding:2px;border-radius:0 0.25rem 0.25rem 0;">
															<table style="margin:0;padding:0;">
																<tr>
																	<td rowspan="2"><i class="fa fa-user" aria-hidden="true" style="font-size:25px;"></i></td>

																	<td style="font-size:8pt;margin:0;padding:0;padding-left:5px;vertical-align:bottom;"><?php echo $row2["jumlah_peserta"]; ?> orang</td>
																<tr>
																	<td class="<?php if ($row2["sisa"] > 5) {
																					echo "text-success";
																				} else {
																					echo "text-danger";
																				} ?>" style="font-size:8pt;margin:0;padding:0;padding-left:5px;vertical-align:top;">sisa <?php echo $row2["sisa"]; ?> orang</td>

																</tr>
															</table>
														</div>
													</a>

												<?php

												}
												?>
											</div>
										<?php
										}
										?>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>


	<?php
	$ambilpopup = ExecuteRow("SELECT `Popup_Show`,`Popup_Picture`, `Popup_Link` FROM `w_settings` WHERE `ID` = 1");
	$Popup_Picture = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $ambilpopup["Popup_Picture"]);
	$Popup_Link = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $ambilpopup["Popup_Link"]);

	if ($ambilpopup["Popup_Show"] == 1 && !empty($ambilpopup["Popup_Picture"])) {

	?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<script type="text/javascript">
			$(window).on('load', function() {
				$('#popup-ppejp').modal('show');
				/*$('#popup-ppejp').modal({backdrop: 'static', keyboard: false}, 'show');*/
			});
		</script>


		<div class="modal fade" id="popup-ppejp" tabindex="-1" role="dialog" aria-labelledby="popup-ppejp" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">

					<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php foreach ($Popup_Picture as $i => $gambaran): ?>
								<li data-target="#carouselIndicators" data-slide-to="<?= $i; ?>" class="<?= $i === 0 ? ' active' : ''; ?>"></li>
							<?php endforeach; ?>
						</ol>
						<div class="carousel-inner">
							<?php foreach ($Popup_Picture as $i => $gambaran): ?>
								<div class="carousel-item<?= $i === 0 ? ' active' : ''; ?>">
									<a href="<?= $Popup_Link[$i]; ?>"><img class="d-block w-100" src="images/popup/<?= $Popup_Picture[$i]; ?>" alt="First slide" style="border-radius: 10px;"></a>
								</div>
							<?php endforeach; ?>
						</div>
						<a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>

	<?= GetDebugMessage() ?>
</body>

</html>