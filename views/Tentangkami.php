<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Tentangkami = &$Page;
?>
<?php echo myheader(); ?>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<style>
	h1 h4 p ul li {
        font-family: 'Poppins', sans-serif;
		letter-spacing: 0.5px;
    }

	p, div, ul, li {
		font-size : 16px;
	}
	
	h1{
		font-size: 25px;
	}

	h2{
		font-size: 20px;
	}

	h3{
		font-size: 18px;
	}
	h4{
		font-size: 16px;
	}
	
	p class="mt-2" {
		margin-top : 2px;
	}

	.col-md-12{
		font-size : 16px;
		line-height: 1.3;
		margin-top : 2px;
		margin-bottom: 2px; 
	}

	.equal-height {
    display: flex;
    flex-direction: column;
    height: 100%;
	}

	.card-body {
		flex-grow: 1;
	}

	.fasilitas-container {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 20px;
	}

	.fasilitas-row {
		display: flex;
		gap: 20px;
		justify-content: center;
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
	}

	.fasilitas-item img {
		width: 100%;
		height: 200px;
		object-fit: cover;
		border-radius: 8px;
		margin-bottom: 15px;
	}

	.fasilitas-item strong {
		display: block;
		margin-top: 10px;
		font-size: 18px;
	}

	.fasilitas-item p {
		font-size: 16px;
		margin-top: 10px;
	}
	.fasilitas-item-full {
    background-color: #f9f9f9;
	object-fit: cover;
	padding: 15px;
	border-radius: 8px;
	text-align: center; 
	width: 1300px;
	height: 320px;
	}
	.fasilitas-item:hover,
	.col-md-4:hover {
		transform: translateY(-10px);
		box-shadow: 0 12px 16px rgba(0, 0, 0, 0.2);
	}

	@media (max-width: 992px) {
		.fasilitas-item-full {
			width: 100%; 
		}
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

<div class="container-fluid" style="background-color: #031A31; padding:20px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white; font-weight:bold">TENTANG KAMI</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="padding-left:0;padding-right:0;">
	<iframe  style="width: 100%; height: 509px; border-radius: 0px;" src="https://www.youtube.com/embed/m4Bxe4osZVo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</div>
<br>
<div class="container" style="text-align:justify;">
	<div class="row ">
		<center><h2 class="text-bold">SAMBUTAN  KEPALA PPEJP</h2></center>
		<div class="col-md-12">
			<div style="position:absolute;left:10px;top:210px;width:210px;background:#031A31;margin-left:2px;color:#fff;padding:10px;">
				<h3 style="font-size: 12px;" >SUGIH RAHMANSYAH, S.E., M.M.</h3>
				<p style="line-height:1;font-size:10px;margin-bottom:0;">KEPALA PUSAT PELATIHAN SUMBER DAYA MANUSIA EKSPOR DAN JASA PERDAGANGAN</p>
			</div>
			<img src="images/pages/kepala-ppejp.png" style="width: 210px;height:auto;float: left !important;margin: 10px 35px 20px 0;"></img>
			<p class="mt-2" >Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan (PPEJP) adalah lembaga terkemuka yang beroperasi di bawah naungan Sekretariat Jenderal, Kementerian Perdagangan. Dengan fokus yang tajam, PPEJP bertugas melaksanakan pengembangan sumber daya manusia di bidang ekspor, mutu, personil metrologi legal, dan jasa perdagangan. Dalam upaya kami memajukan dunia usaha dan masyarakat, kami mempersiapkan individu untuk meraih kesuksesan di panggung internasional.</p>
			<p>Di PPEJP, kami mempersembahkan program pelatihan yang dirancang khusus untuk mengasah keterampilan dan pengetahuan dalam ekspor, mutu, metrologi legal, dan jasa perdagangan. Kami memadukan keahlian praktis dengan pendekatan terkini untuk memastikan peserta kami siap menghadapi tantangan dalam dunia bisnis yang dinamis.</p>
			<p>PPEJP adalah jembatan Anda menuju kesuksesan. Mari bergabung dengan kami dan tembuslah batas-batas kesuksesan dalam ekspor, mutu, metrologi, dan jasa perdagangan.</p>
		</div>
	</div>
	<br>

	<div class="row ">
		<center><h2 class="text-bold">SEJARAH SINGKAT</h2></center>
		<div class="col-md-12">
			<p>Semenjak berdirinya pada tahun 1990, PPEI telah mengalami transformasi struktur organisasi, yang semula Eselon 2 di bawah Sekretariat Jenderal pada tahun 1990 hingga 1995 dengan nama Pusat Pelatihan Ekspor Indonesia (PPEI), kemudian pada tahun 1995 yakni saat Departemen Perdagangan digabung dengan Departemen Perindustrian, PPEI mengalami perubahan status menjadi Eselon 3 dibawah Pusat Pembinaan dan Pelatihan (PUSBINLAT) Deperindag dengan nama Balai Pendidikan dan Pelatihan Ekspor (PPEI) hingga tahun 2005.</p>
			<p>Akhirnya pada tahun 2006 PPEI kembali mengalami perubahan status menjadi Eselon 2 dengan nama Balai Besar Pendidikan dan Pelatihan Ekspor Indonesia (BBPPEI) di bawah Badan Pengembangan Ekspor Nasional Departemen Perdagangan. </p>
			<p>Pada tahun 2022 Balai Besar Pendidikan dan Pelatihan Ekspor Indonesia (BBPPEI) berubah nama menjadi Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan (PPEJP)  yang berada dibawah naungan Sekretariat Jenderal, Kementerian Perdagangan. PPEJP menyelenggarakan fungsi penyelenggaraan pelatihan SDM Ekspor, Pelatihan SDM Jasa Perdagangan, dan Export Coaching Program.  Transformasi status tersebut membawa pengaruh terhadap pelaksanaan tugasnya sebagai Unit Pelaksana Teknis yang melakukan pembinaan terhadap dunia usaha eksportir.</p>
		</div>
	</div>
	<br>

	<div class="row ">
		<center><h2 class="text-bold">FUNGSI PPEJP</h2></center>
		<div class="col-md-12">
			Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan (PPEJP) menyelenggarakan fungsi:
			<br>
			<ul>
				<li>Penyusunan rencana & program pengembangan sumber daya manusia ekspor, mutu, personil metrologi legal, dan jasa perdagangan</li>
				<li>Penyiapan koordinasi dan pelaksanaan pengembangan sumber daya manusia ekspor, mutu, personil metrologi legal, dan jasa perdagangan</li>
				<li>Penyiapan koordinasi dan pelaksanaan promosi dan kerja sama pengembangan sumber daya manusia ekspor, mutu, personil metrologi legal, dan jasa perdagangan</li>
				<li>Penyiapan koordinasi dan pelaksanaan pembinaan lembaga pengembangan sumber daya manusia ekspor, mutu, personil metrologi legal, dan jasa perdagangan</li>
				<li>Pelaksanaan urusan tata usaha dan rumah tangga Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan</li>
			</ul>
		</div>
	</div>
	<br>

	<div class="row ">
		<center><h2 class="text-bold">KEBIJAKAN MUTU PPEJP</h2></center>
		<div class="col-md-12">
			PPEJP menyediakan produk ekspor - impor dan jasa perdagangan yang bermutu dan senantiasa mengutamakan kepuasan pelanggan. Kebijakan mutu ini dikomunikasikan kepada seluruh pegawai untuk dipahami dan dilaksanakan.
		</div>
	</div>
	<br><br>

	<center><h2><strong>FASILITAS</strong></h2></center>
	<div class="fasilitas-container">
    <div class="fasilitas-row">
        <div class="fasilitas-item">
            <img src="images/fasilitas/fasilitas-perpustakaan.png" alt="Perpustakaan">
           <h4><strong>Perpustakaan</strong></h4>
            <p>Perpustakaan menyediakan berbagai informasi bagi dunia usaha, peserta pelatihan serta masyarakat umum.</p>
        </div>
        <div class="fasilitas-item">
            <img src="images/fasilitas/fasilitas-auditorium.png" alt="Auditorium">
            <h4><strong>Auditorium</strong></h4>
            <p>Auditorium dengan kapasitas untuk 200 orang.</p>
        </div>
        <div class="fasilitas-item">
            <img src="images/fasilitas/fasilitas-simulation-center.png" alt="Simulation Center">
            <h4><strong>Simulation Center</strong></h4>
            <p>Simulation Center adalah sarana praktek untuk mempermudah penyerapan sistem belajar dan memberikan pengalaman pertama untuk penerapan keterampilan.</p>
        </div>
        <div class="fasilitas-item">
            <img src="images/fasilitas/fasilitas-ruang-kelas.png" alt="Ruang Kelas">
            <h4><strong>Ruang Kelas</strong></h4>
            <p>Ruang Kelas dilengkapi dengan peralatan audio video dengan kapasitas 15, 30, dan 50 orang.</p>
        </div>
    </div>
    <div class="fasilitas-row fasilitas-row-center">
        <div class="fasilitas-item fasilitas-item-full">
            <img src="images/fasilitas/fasilitas-asrama.png" alt="Asrama" style="heigh:00px;">
            <h4><strong>ASRAMA</strong></h4>
            <p>Asrama adalah salah satu fasilitas yang disediakan oleh PPEJP untuk memberikan alternatif tempat penginapan.</p>
        </div>
    </div>
	</div>
	<br><br>

	<center><h3><strong>TIPE KAMAR</strong></h3></center>
	<div class="row justify-content-center text-center">
		<div class="col-md-4 col-12 mb-4">
			<img src="images/fasilitas/fasilitas-kamar-standar.png" alt="Kamar Standard" class="img-fluid rounded">
			<h3><br><strong>Kamar Standard</strong></h3>
			<p>Rp. 75.000 / malam / bed / pintu<br>(1 Ruangan ada 4 pintu/bed)</p>
		</div>
		<div class="col-md-4 col-12 mb-4">
			<img src="images/fasilitas/fasilitas-kamar-super.png" alt="Kamar Super" class="img-fluid rounded">
			<h3><br><strong>Kamar Super</strong></h3>
			<p>Rp. 100.000 / malam / bed<br>(1 ruangan ada 3 bed)</p>
		</div>
		<div class="col-md-4 col-12 mb-4">
			<img src="images/fasilitas/fasilitas-kamar-vip.png" alt="Kamar VIP" class="img-fluid rounded">
			<h3><br><strong>Kamar VIP</strong></h3>
			<p>Rp. 300.000 / malam<br>(1 ruangan ada 2 bed)</p>
		</div>
	</div>
</div>

<div class="container-fluid" style="background-color:#fff;">
	<div class="container">
		<div class="row mt-2">
			<center><h2 class="text-bold">KERJASAMA</h2></center>
			<div class="col-md-12 text-justify">
				<p>Untuk menyelenggarakan pelatihan ekspor, PPEI membuka peluang kerja sama dengan berbagai instansi terkait dan stake holder lainnya dengan menggunakan pola subsidi dan kontraktual. Informasi lebih lanjut dapat menghubungi Tim Kerja Sama dan Promosi.</p>
			</div>
		</div>

		<div class="row mt-0">
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-header" style="background-color:#031A31;color:#fff">
						<h2 class="text-bold text-center">KONTRAKTUAL</h2>
					</div>
					<div class="card-body d-flex flex-column justify-content-between">
						<div>
							<h3 class="text-bold text-center">KERJASAMA SECARA KONTRAKTUAL</h3>
							<p class="card-text text-justify">Kerja sama pelatihan yang kami tawarkan kepada instansi-instansi dengan pola kontraktual adalah Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan melaksanakan penyelenggaraan pelatihan bagi binaannya maupun SDM internal dengan pembiayaan penyelenggaraan dimaksud ditanggung oleh pihak yang akan bekerjasama dan membayarkan biaya kontraktual sebagai Penerimaan Negara Bukan Pajak (PNBP) kepada PPEJP. Pelaksanaan pelatihan menggunakan seluruhnya dari anggaran PNBP.</p>
						</div>
						<div>
							<h3 class="text-bold text-center">KEPESERTAAN</h3>
							<p class="card-text text-justify">Peserta berasal dari para pelaku usaha khususnya UKM binaannya maupun SDM Internal, minimal peserta 20 (dua puluh) orang dan maksimal 30 (tiga puluh) orang</p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-header" style="background-color:#031A31;color:#fff">
						<h2 class="text-bold text-center"><i>COST SHARING</i></h2>
					</div>
					<div class="card-body d-flex flex-column justify-content-between">
						<div>
							<h3 class="text-bold text-center">KERJASAMA SECARA <i>COST SHARING</i></h3>
							<p class="card-text text-justify">Kerja sama pelatihan yang pembiayaan sebagian besar dari anggaran Rupiah Murni APBN PPEJP (bukan PNBP), sedangkan mitra yang kerja sama membayar biaya pelatihan sesuai tariff Penerimaan Negara Bukan Pajak (PNBP) yang berlaku di Kementerian Perdagangan.</p>
							<br><br><br>
						</div>
						<div>
							<h3 class="text-bold text-center">KEPESERTAAN</h3>
							<p class="card-text text-justify">Peserta berasal dari para pelaku usaha khususnya UKM binaannya maupun SDM Internal, peserta harus 30 (tiga puluh) orang</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-md-12 text-center">
			<p>Klik tombol di bawah untuk mengisi form untuk kami hubungi kembali</p>
			<a class="btn btn-success" href="kontak">Kerjasama pelatihan</a>
		</div>
	</div>
</div>
<br>
<br>

<script>
    document.title = "Tentang Kami";
</script>
</html>
<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>