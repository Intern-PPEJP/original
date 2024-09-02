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
            <div class="text-center">
                Export Coaching Program merupakan program pendampingan untuk pelaku usaha berorientasi ekspor yang dilaksanakan dengan 7 tahapan selama kurang lebih 8 bulan sampai dengan 1 tahun. Tujuan program pendampingan ini adalah agar para pelaku usaha mampu menjalankan bisnis ekspornya secara efektif sehingga dapat melakukan ekspor secara mandiri.
            </div>
        </div>
    </div>
</div>
<br>

	<section class="barcount-section">
		<div class="container">
			<div class="row row-bar-count pt-5">

				<div class="col-lg col-md-4 col-sm-4 col-xs-4 angka">
					<span class="col-12 jumlah" data-target="65">0</span>
					<span class="col-12 jumlah_cap">Angkatan ECP</span>
				</div>
				
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 angka">
					<span class="col-12 jumlah" data-target="1860">0</span>
					<span class="col-12 jumlah_cap">Peserta ECP</span>		
				</div>
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 angka">
					<span class="col-12 jumlah" data-target="338">0</span>
					<span class="col-12 jumlah_cap">Peserta ECP Sukses Ekspor</span>		
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
	<br>
	<center><div class="row container">
	<center><h2><b>EXPORT COACHING PROGRAM 2024</b></h2></center>
	<div class="col-md-12" style="text-align: left; margin-top:36px;margin-bottom:76px;">
		<h3><b> Kriteria Peserta: </b></h3>
		<ul>
			<li>Memiliki NIB, Badan Usaha (UD, CV, PT dan Koperasi) yang masih berlaku</li>
			<li>Memiliki kapasitas produksi yang mendukung kegiatan ekspor</li>
			<li>Memiliki komitmen untuk mengikuti tahapan pendampingan ekspor selama 1 (satu) tahun berjalan</li>
			<li>Diutamakan memiliki pengalaman bisnis minimal 1 (satu) tahun</li>
			<li>Memiliki tim yang memahami bahasa inggris & mampu menggunakan komputer</li>
		</ul>
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
