<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Lspbpmjp = &$Page;
?>
<?php echo myheader(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<style>
    .text-center {
    text-align: center;
}

p, table, div {
    font-size: 16px;
	}
	
	h2{
		font-size: 20px;
	}

	h3{
		font-size: 18px;
	}

	table {
		width: 100%;
		border-collapse: collapse;
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
		border-radius: 10px;
		overflow: hidden;
	}

	thead {
		background-color: #3a5a40;
		color: #ffffff;
		text-align: center; /* Rata tengah untuk header */
	}

	thead th {
		padding: 6px 7px;
		border: 1px solid #dddddd;
	}

	tbody td {
		padding: 6px 12px;
		border: 1px solid #dddddd;
		text-align: left; /* Rata kiri untuk isi kolom */
	}

	tbody td:nth-child(1) {
		text-align: center; /* Rata tengah isi untuk kolom NO */
	}

	tbody td:nth-child(2) {
		text-align: left; /* Rata kiri untuk isi kolom KODE UNIT */
	}

	tbody td:nth-child(3) {
		text-align: left; /* Rata kiri untuk isi kolom JUDUL UNIT KOMPETENSI */
	}

	tbody tr:nth-child(even) {
		background-color: #f3f3f3; /* memberi warna yang berbeda tiap baris*/
	}

    .custom-card {
    display: inline-block;
    padding: 25px 20px 10px 20px; /* Padding atas 25px, bawah 10px, kiri/kanan 20px */
    background-color: #fcf6bd;  /*Warna latar card */
}


</style>

<div class="container-fluid " style="background-color: #3A8F53; padding:20px 0px;">
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #3A8F53;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">LSP P1 BPMJP</h1>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="xmargin-top:90px;">
    <div class="row">
        <div class="col-md-12 p-0" style=" height: 400px">
            <div style="background-image: url(images/pages/altpelatihan1/bg-lsp-ppejp.png); background-size: cover; background-position: center; width: 100%; height: 100%; position: absolute; top:0">
            </div>
        </div>
    </div>
</div>
<div class="container" style="padding-bottom: 0px;">
    <div class="row my-4">
        <div class="col-md-12">
            <div class="text-center">
				<p class="responsive-text" style="padding-bottom: 0px;"> 
                Lembaga Sertifikasi Profesi (LSP) adalah organisasi yang berperan dalam sertifikasi kompetensi kerja di Indonesia. LSP berfungsi untuk menguji dan menilai kompetensi seseorang berdasarkan standar kompetensi yang telah ditetapkan oleh Badan Nasional Sertifikasi Profesi (BNSP) atau lembaga terkait lainnya. LSP bertujuan untuk memastikan bahwa tenaga kerja memiliki kompetensi sesuai dengan kebutuhan industri dan pasar kerja. 
                </p>
			</div>
        </div>
    </div>
</div>

<style>
/* Untuk layar dengan lebar lebih besar dari 768px */
.responsive-text {
    margin-left: 115px;
    margin-right: 115px;
    padding-bottom: 0px;
}

/* Untuk layar dengan lebar lebih kecil dari 768px */
@media (max-width: 768px) {
    .responsive-text {
        margin-left: 30px;
        margin-right: 30px;
    }
}
</style>

<div class="d-flex justify-content-center">
<div class="col-md-7 col-12">
    <div style="color:#000;padding-top:10px;padding-bottom:3px;">
        <h2 class="text-bold text-center">VISI</h2>
    </div>
    <div>
        <p class="text-center" >
            LSP P1 BPMJP mempunyai visi menjadi LSP bidang metrologi, mutu, dan jasa perdagangan serta penunjangnya untuk menciptakan sumber daya manusia yang kompeten dan profesional serta diakui secara Nasional, Regional, dan Internasional.
        </p>
    </div>

    <div style="color:#000;padding-top:10px;padding-bottom:3px;margin-top:20px;">
        <h2 class="text-bold text-center">MISI</h2>
    </div>
    <div>
        <ol style="padding-bottom: 30px;">
            <li class="text-justify">Menyelenggarakan sertifikasi kompetensi SDM bidang metrologi, mutu, dan jasa perdagangan serta penunjangnya/pemasok yang independen dan profesional.</li>
            <li class="text-justify">Memastikan dan memelihara kompetensi SDM bidang metrologi, mutu, dan jasa perdagangan untuk dapat bersaing secara nasional regional dan Internasional.</li>
            <li class="text-justify">Menjamin mutu dengan menjaga proses sertifikasi sesuai dengan standar yang berlaku.</li>
            <li class="text-justify">Menyediakan tempat uji kompetensi sesuai dengan ruang lingkup Lembaga Sertifikasi Profesi bidang metrologi, mutu dan jasa perdagangan.</li>
        </ol>
    </div>
</div>
</div>

<style>
@media (max-width: 768px) {
    p, ol {
        margin-left: 40px;
        margin-right: 40px;
        padding-left: 0;
        padding-right: 0;
    }
}
</style>

<!--<section class="barcount-section" style="min-height:50px !important">
	<div class="container">
		<div class="row row-bar-count py-1 text-white">
			<div class="col-12 text-center" style="padding-top: 8px;">
				<h2>VISI</h2>
			</div>
		</div>
	</div>
</section>
<div class="container">
    <div class="row my-4">
        <div class="col-md-12">
			<p class="text-center">
			LSP P1 BPMJP mempunyai visi menjadi LSP bidang metrologi, mutu, dan jasa perdagangan serta penunjangnya untuk menciptakan sumber daya manusia yang kompeten dan profesional serta diakui secara nasional, regional, dan internasional.
			</p>
        </div>
    </div>
</div>
<section class="barcount-section" style="min-height:50px !important">
	<div class="container">
		<div class="row row-bar-count py-1 text-white">
			<div class="col-12 text-center" style="padding-top: 8px;">
				<h2>MISI</h2>
			</div>
		</div>
	</div>
</section>
<div class="container">
    <div class="row my-4">
        <div class="col-md-12">
			<p>
				<ol>
					<li class="text-justify">Menyelenggarakan sertifikasi kompetensi SDM bidang metrologi, mutu, dan jasa perdagangan serta penunjangnya/pemasok yang independen dan profesional.</li>
					<li class="text-justify">Memastikan dan memelihara kompetensi SDM bidang metrologi, mutu, dan jasa perdagangan untuk dapat bersaing secara nasional regional dan Internasional.</li>
					<li class="text-justify">Menjamin mutu dengan menjaga proses sertifikasi sesuai dengan standar yang berlaku.</li>
					<li class="text-justify">Menyediakan tempat uji kompetensi sesuai dengan ruang lingkup Lembaga Sertifikasi Profesi bidang metrologi, mutu dan jasa perdagangan.</li>
				</ol>
			</p>
        </div>
    </div>
</div>-->
<!--<div class="container-fluid text-white mb-4" style="background-color: #3A8F53;">
	<div class="container py-3">
		<h3>Skema Sertifikasi Pengujian Meter Air</h3>
	</div>
</div>-->
<div class="container-fluid text-white mb-4">
    <div class="responsive-container" style="background-color: #3A8F53; border-radius: 10px; padding: 3px;">
        <div class="container py-3" >
            <h3 style="padding-top:5px;padding-bottom:0px;margin-left:24px;">Skema Sertifikasi Pengujian Meter Air</h3>
        </div>
    </div>
</div>
<div class="container">
    <div class="row my-4 responsive-content">
        <div class="col-md-12">
			<p class="text-justify">
			Skema sertifikasi Pengujian Meter Air adalah skema sertifikasi klaster yang dikembangkan oleh Komite Skema LSP P1 BPMJP untuk memenuhi kebutuhan sertifikasi kompetensi kerja di LSP P1 BPMJP.
			</p>
            <p class="text-justify">
			Skema sertifikasi yang telah dikembangkan oleh Komite Skema LSP P1 BPMJP adalah skema klaster pengujian meter air dengan unit kompetensi:
			</p>
            <table>
            <thead>
            <tr>
                <th>NO</th>
                <th>UNIT KOMPETENSI</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Menerapkan Keselamatan dan Kesehatan Kerja (K3)</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Mengalibrasi Meter Air </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Mengoperasikan Tangki Hidrofor </td>
            </tr>
            <tr>
                <td>4</td>
                <td>Mengoperasikan Alat Ukur Portabel </td>
            </tr>
            <tr>
                <td>5</td>
                <td>Melakukan Pengukuran Debit dan Tekanan </td>
            </tr>
            <tr>
                <td>6</td>
                <td>Merawat Alat Ukur Portabel </td>
            </tr>
            <tr>
                <td>7</td>
                <td>Berkomunikasi dengan orang lain</td>
            </tr>
            </tbody>
            </table>
            <br>
	        <p> Persyaratan Dasar Pemohon Sertifikasi:
		    <ol>
                <li>Memiliki sertifikat pelatihan pengujian meter air yang diselenggarakan oleh BPMJP.</li>
                <li>Pendidikan minimal SMA/SMK atau sederajat.</li>
		    </ol>
	        </p>
            <div class="card p-3 text-center">
            <p>Sesuai dengan PMK Nomor 140 Tahun 2023 Biaya sertifikasi untuk skema Kompetensi Pengujian Meter Air sebesar Rp. 1.250.000,- per orang per hari</p>
            </div>
            <div class="d-flex justify-content-center">
            <div class="alert alert-warning text-center" style="display: inline-block;">
            Informasi lebih lanjut hubungi: <strong>0811-2006-6664</strong>
            </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Untuk layar lebih besar dari 768px */
.responsive-container {
    margin-left: 185px;
    margin-right: 185px;
}

.responsive-content {
    margin-left: 110px;
    margin-right: 110px;
}

/* Untuk layar lebih kecil dari 768px */
@media (max-width: 768px) {
    .responsive-container {
        margin-left: 10px;
        margin-right: 10px;
    }

    .responsive-content {
        margin-left: 10px;
        margin-right: 10px;
    }
}
</style>

<div class="mb-1">&nbsp;</div>

<!--<div class="mb-5" style="min-height:500px">&nbsp;</div>-->

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
</body>
</html>