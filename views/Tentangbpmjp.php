<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Tentangbpmjp = &$Page;
?>
<?php echo myheader(); ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="container-fluid " style="background-color: #3A8F53; padding:20px 0px;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="m-0" style="color: white;font-weight:bold">BALAI PELATIHAN SDM METROLOGI, MUTU DAN JASA PERDAGANGAN</h2>
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
	p {
		font-family: Poppins;
		font-size: 16px;
		line-height: 1.5;
	}

	h3 {
		font-weight: 600px;
	}

	.fasilitas-container {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 20px;
		margin-bottom: 200px;

	}

	.fasilitas-row {
		display: flex;
		gap: 20px;
		justify-content: center;
		flex-wrap: wrap;
	}

	.fasilitas-row:first-child {
		width: 100%;
		justify-content: space-between;
	}

	.fasilitas-row-center {
		justify-content: center;
	}

	.fasilitas-item {
		background-color: #f9f9f9;
		padding: 15px;
		border-radius: 8px;
		text-align: center;
		width: 30%;
		box-sizing: border-box;
	}

	.fasilitas-item img {
		width: 100%;
		height: 200px;
		object-fit: cover;
		margin-bottom: 15px;
	}

	.fasilitas-item strong {
		display: block;
		margin-top: 10px;
		font-size: 18px;
	}

	.fasilitas-item p {
		font-size: 14px;
		margin-top: 10px;
	}

	@media (max-width: 992px) {
		.fasilitas-row {
			flex-direction: column;
			align-items: center;
		}

		.fasilitas-item {
			width: 80%;
		}
	}

	@media (max-width: 768px) {
		.fasilitas-item {
			width: 100%;
		}
	}
</style>

<div class="container-fluid" style="padding-left:0;padding-right:0;">
	<iframe style="width: 100%; height: 509px; border-radius: 0px;" src="https://www.youtube.com/embed/uwYw0NQ1WTA?si=zQOWDUuill_NEdhd" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>

<div class="container text-justify mt-5">
	<div class="row slim">
		<center>
			<h4 class="text-bold mb-3">SAMBUTAN KEPALA BPMJP</h4>
		</center>
		<div class="col-md-12">
			<div style="position:absolute;left:10px;top:550px;width:450px;background:#031A31;font-size:20px; margin-left:2px;color:#fff;padding:10px" h3>SUCI INGGRID DANIATI, S.Si., M.Si.</h3>
				<p style="line-height:1;font-size:17px;margin-bottom:0;">KEPALA BALAI PELATIHAN SUMBER DAYA MANUSIA METROLOGI, MUTU, DAN JASA PERDAGANGAN</p>
			</div>
			<img src="images/pages/kepala-bpmjp.png" style="width: 450px;height:550px;float: left !important;margin: 10px 15px 80px 0;"></img>

			<p style="margin-top:5px;">Perdagangan merupakan salah satu sektor penggerak pertumbuhan dan daya saing ekonomi untuk kesejahteraan masyarakat. Metrologi, mutu dan jasa perdagangan merupakan bidang yang tidak dapat dipisahkan dari kegiatan perdagangan pada masyarakat dan dunia usaha.</p>

			<p>Sebagai gambaran di bidang metrologi, pada tahun 2021 terdapat 16.175 pasar tradisional yang di dalamnya terdapat banyak alat ukur, alat takar, alat timbang dan perlengkapannya (UTTP) yang harus dicek kesesuaian pengukurannya oleh Juru Timbang. Terdapat 6.729 stasiun pengisian bahan bakar umum (SPBU) yang takarannya harus dicek berkala oleh Juru Takar, serta pemastian akan pelabelan dan kuanta produk makanan/minuman oleh Pelaku Usaha dimana industri ini menjadi kontributor terbesar produk domestik bruto (PDB) yakni mencapai Rp302,28 triliun (34,44%). </p>

			<p>Di bidang mutu, Indonesia mempunyai 10 produk ekspor unggulan dan produk potensi ekspor lainnya serta produk yang dipasarkan di dalam negeri yang harus dijaga kualitasnya oleh pelaku usaha. Di bidang jasa perdagangan yang pergerakannya terus meningkat, undang-undang perdagangan mengamanatkan agar penyedia Jasa yang bergerak di bidang Perdagangan Jasa wajib didukung tenaga teknis yang kompeten.</p>

			<p>Kami yakin apabila ketiga bidang tersebut didukung oleh Sumber Daya Manusia (SDM) yang berkompeten maka pertumbuhan ekonomi dapat berjalan baik, karena sebagus apapun strategi, struktur dan sistem di desain, eksekutor utamanya adalah SDM. </p>

			<p>Dalam mewujudkan harapan besar tersebut, BPMJP hadir untuk memberikan kontribusi nyata dalam pengembangan kompetensi bagi masyarakat dan pelaku usaha di bidang Metrologi, Mutu dan Jasa Perdagangan. Kami sangat terbuka dengan semua elemen seperti swasta, BUMD, BUMN, perguruan tinggi dan lainnya untuk berkolaborasi dan bersinergi dalam peningkatan kapabilitas SDM Sektor Perdagangan.</p>

		</div>
	</div>
	<div class="row ">
		<center>
			<h4 class="text-bold mb-4 t-5">SEJARAH SINGKAT</h4>
		</center>
		<div class="col-md-12">
			<p>Peran SDM (Sumber Daya Manusia) dalam suatu perusahaan merupakan pilar utama yang mendukung pertumbuhan dan kesuksesan perusahaan kecil dan menengah. Sebagai tulang punggung operasional, SDM berkontribusi secara langsung pada efisiensi proses, pelayanan pelanggan, dan inovasi produk. </p>

			<p>Kementerian Perdagangan Republik Indonesia, memiliki satu badan yang mendukung pelatihan SDM agar tumbuh berkembang, yaitu Balai Pelatihan SDM Metrologi, Mutu dan Jasa Perdagangan (BPMJP). BPMJP adalah Unit Pelaksana Teknis (UPT) bidang pelatihan di bawah Pusat Pelatihan SDM Ekspor dan Jasa Perdagangan (PPEJP). Unit ini mempunyai tugas menyelenggarakan pelatihan bagi sumber daya manusia dalam bidang metrologi, mutu dan jasa perdagangan untuk dunia usaha dan masyarakat. </p>

			<p>Dengan mendapatkan pelatihan yang tepat, SDM perusahaan akan menjadi lebih inovatif dan mudah beradaptasi dengan perubahan pasar dan teknologi Pelatihan di BPMJP membantu UMKM tetap relevan dan berdaya saing di era yang terus berkembang. Tak hanya itu, pelatihan SDM merupakan investasi yang memperkuat ikatan emosional, meningkatkan loyalitas sesama SDM maupun dengan perusahaan. Sehingga perusahaan dapat mempertahankan tim kerja yang solid dan berdedikasi. Semua ini berkontribusi secara keseluruhan pada pertumbuhan dan kesuksesan jangka panjang perusahaan. </p>

			<p>BPMJP menyediakan program pelatihan di bidang metrologi, mutu dan jasa perdagangan. Pada bidang metrologi tersedia pelatihan Pengujian Alat Ukur, Alat Takar, Alat Timbang, dan Alat Perlengkapan, pelatihan Pengujian Barang Dalam Keadaan Terbungkus (BDKT) dan pelatihan lainnya yang mendukung kebijakan Kementerian Perdagangan Republik Indonesia. Semua pelatihan ini bertujuan terwujudnya satu nusa satu ukuran. Selanjutnya di bidang mutu tersedia berbagai macam pelatihan untuk mempersiapkan personil-personil untuk segala kegiatan teknis. Misalnya pelatihan kalibrasi, petugas pengambil contoh, pengujian mutu. Lalu pelatihan pelatihan kompetensi non teknis seperti sistem manajemen mutu, audit internal dan penyusunan sistem manajemen mutu. Pada bidang jasa perdagangan tersedia pelatihan reparasi alat UTTP tingkat dasar dan tingkat lanjutan seperti pelatihan reparasi timbangan bukan otomatis mekanik, elektronik dan jembatan. </p>

			<p>Pelatihan di BPMJP menggunakan pendekatan yang berfokus pada praktik langsung dan penerapan dalam situasi kerja nyata. Dengan menghadirkan latihan intensif dan materi yang relevan. Kami menjamin, SDM akan dapat menguasai keterampilan baru dan mengaplikasikannya secara percaya diri dalam lingkungan kerja sehari-hari. Kami juga menyediakan fasilitas modern seperti kelas interaktif, laboratorium simulasi, dan referensi yang komprehensif untuk mendukung proses pembelajaran mereka. Lingkungan belajar yang optimal, memberdayakan sdm perusahaan untuk tumbuh dan berkinerja unggul dalam dunia usaha. </p>

			<p>BPMJP dengan senang hati mengundang pelaku usaha dan masyarakat luas untuk ikut bergabung dalam program pelatihan kami untuk menjadi SDM yang berkualitas dan siap bersaing di dunia kerja.</p>
		</div>
	</div>

	<center>
		<h4 class="text-bold mb-4 mt-5">FASILITAS</h4>
	</center>
	<div class="fasilitas-container">
		<div class="fasilitas-row">
			<div class="fasilitas-item">
				<img src="images/fasilitas/bpmjp-instalasi.png" alt="Instalasi">
				<strong>INSTALASI</strong>
				<p>Instalasi Tangki Ukur Mobil, Instalasi Pompa Ukur BBM, Instalasi Timbangan Jembatan dan Instalasi TUTSIT adalah sarana praktik untuk mempermudah penyerapan sistem belajar.</p>
			</div>
			<div class="fasilitas-item">
				<img src="images/fasilitas/bpmjp-laboratorium.png" alt="Laboratorium">
				<strong>LABORATORIUM</strong>
				<p>Selain Instalasi yang beragam, BPMJP pun mempunyai laboratorium Bejana Ukur, Dimensi, Listrik, Massa Elektronik, Meter Kadar Air, Suhu, Gaya dan Tekanan dan Timbangan Mekanik. Pembelajaran dengan dibantu simulasi akan mendukung hasil yang optimal.</p>
			</div>
			<div class="fasilitas-item">
				<img src="images/fasilitas/bpmjp-asrama.png" alt="Asrama">
				<strong>ASRAMA</strong>
				<p>Asrama adalah salah satu fasilitas di BPMJP yang dapat memberikan alternatif bagi peserta yang memerlukan untuk menginap yang satu lokasi dengan tempat pembelajaran, aman, bersih, dan murah dengan tarif yang terjangkau.</p>
			</div>
			<div class="fasilitas-item">
				<img src="images/fasilitas/bpmjp-ruang-kelas.png" alt="Ruang Kelas">
				<strong>RUANG KELAS</strong>
				<p>Ruang kelas dilengkapi dengan peralatan audio, video dengan kapasitas 20 dan 40 orang.</p>
			</div>
			<div class="fasilitas-item">
				<img src="images/fasilitas/bpmjp-teater.png" alt="Teater">
				<strong>TEATER</strong>
				<p>Teater dengan kapasitas untuk 150 orang.</p>
			</div>
			<div class="fasilitas-item">
				<img src="images/fasilitas/bpmjp-fasilitas-lainnya.png" alt="Fasilitas Lainnya">
				<strong>FASILITAS LAINNYA</strong>
				<p>Sarana olahraga seperti lapangan badminton, lapangan voli, dan jogging track dapat dimanfaatkan peserta untuk refreshing dan menjaga kondisi.</p>
			</div>
		</div>
	</div>

</div>

<script>
	document.title = "Pelatihan Metrologi"
</script>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>