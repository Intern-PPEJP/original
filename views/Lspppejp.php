<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Lspppejp = &$Page;
?>
<?php echo myheader(); ?>


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
		display: none; /* Button disembunyikan secara default */
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

	p, table, div {
    font-size: 16px;
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

	table {
		width: 100%;
		border-collapse: collapse;
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
		border-radius: 10px;
		overflow: hidden;
	}

	thead {
		background-color: #19497D;
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

	.container-topik {
        display: flex;
        justify-content: center;
        align-items: stretch;
        flex-wrap: nowrap;
        padding: 50px 0px;
    }

    .container-topik .topic-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 250px;
        padding: 20px;
        margin: 10px;
        text-align: center;
    }

    .container-topik .topic-card img {
        width: 90px;
        margin-bottom: 15px;
    }

    .container-topik .topic-card h3 {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .container-topik .topic-card:hover {
		background-color: #023e8a;
		color: #ffffff;
		transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container-topik .topic-card:hover h3 {
        color: #ffffff;
    }

    .container-topik .topic-card:hover img {
		filter: brightness(0) invert(1); /* Mengubah icon menjadi putih */
		transition: filter 0.3s ease;
    }

	/* Media query untuk layar kecil */
    @media (max-width: 768px) {
    .container-topik {
			flex-direction: column; 
			align-items: center; 
		}

		.container-topik .topic-card {
			width: 100%; 
			max-width: 350px; 
			margin: 10px; 
		}
    }

	.custom-margin-bottom {
        margin-bottom: 40px; /* Sesuaikan dengan jarak yang diinginkan */
    }
</style>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #031A31;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">LSP PPEJP</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="xmargin-top:90px;">
    <div class="row">
        <div class="col-md-12 p-0" style=" height: 400px">
            <div style="background-image: url(images/pages/altpelatihan1/bg-lsp-ppejp.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-4">
        <div class="col-md-12">
            <div class="text-center">
				<p> LSP PPEJP ini merupakan LSP pihak ke 2 yang mempunyai tugas memastikan dan memelihara kompetensi alumni pelatihan PPEJP dan jejaringnya, khususnya eksportir dan calon eksportir di dalam ruang lingkup tugas mereka sebagai pengelola dan pelaku manajemen ekspor impor.</p>
			</div>
        </div>
    </div>
</div>

<section class="barcount-section" style="min-height:100px !important">
	<div class="container">
		<div class="row row-bar-count pt-3 text-white">
			<div class="col-12 text-center">
				<h2>Motto Kami: </h2>
				<h2>“MEMASTIKAN DAN MEMELIHARA KOMPETENSI ANDA DI BIDANG EKSPOR IMPOR”</h2>	
			</div>
		</div>
	</div>
</section>

<div class="container">
    <div class="row my-4">
        <div class="col-md-12">
            <h3 class="text-center custom-margin-bottom">
             Persyaratan Pendaftaran Peserta Sertifikasi:
            </h3>
			<p>
				<ol>
					<li>LSP PPEJP menginformasikan kepada pemohon persyaratan sertifikasi sesuai skema sertifikasi jenis bukti, aturan bukti, proses sertifikasi, hak pemohon dan kewajiban pemohon, biaya sertifikasi dan kewajiban pemegang sertifikat kompetensi</li>
					<li>Pemohon mengisi formulir pendaftaran (APL-01) dan dilengkapi dengan bukti-bukti pendukung berupa :
						<ol type="a">	
							<li>Foto copy KTP</li>
							<li>Pas Photo 3 x 4 cm sebanyak 2 (dua) lembar, dengan latar belakang warna merah, dan</li>
							<li>Foto copy Sertifikat Pelatihan Persiapan Ekspor dari PPEJP</li>
							<li>Foto copy Ijazah SMA/SMK Sederjat atau</li>
							<li>Surat Keterangan telah bekerja minimal 2 tahun pada pekerjaan Persiapan Ekspor, atau</li>
							<li>Foto copy Surat Ijin Berusaha, seperti NIB.</li>
						</ol>
					</li>
					<li>Pemohon mengisi formulir Asesmen Mandiri (APL 02) dan dilengkapi dengan bukti pendukung yang relevan (jika ada)</li>
					<li>Peserta menyatakan setuju untuk memenuhi persyaratan sertifikasi dan memberikan setiap informasi yang diperlukan untuk penilaian.</li>
					<li>LSP PPEJP menelaah berkas pendaftaran untuk konfirmasi bahwa peserta sertifikasi memenuhi persyaratan yang ditetapkan dalam skema sertifikasi.</li>
					<li>Pemohon yang memenuhi persyaratan dinyatakan sebagai peserta sertifikasi.</li>
				</ol>
			</p>
			<br>
            <h3 class="text-center mt-2 mb-2 custom-margin-bottom">Empat ruang lingkup skema sertifikasi klaster:</h3>
			<div class="container container-topik">
				<a href="#persiapan-ekspor" style="text-decoration: none;">
				<div class="topic-card">
					<img src="images\icons\clipboard.png" alt="Persiapan Ekspor">
					<h3>Persiapan Ekspor</h3>
				</div>
				</a>

				<a href="#pelaksanaan-ekspor" style="text-decoration: none;">
				<div class="topic-card">
					<img src="images\icons\implement.png" alt="Pelaksanaan Ekspor">
					<h3>Pelaksanaan Ekspor</h3>
				</div>
				</a>

				<a href="#persiapan-impor" style="text-decoration: none;">
				<div class="topic-card">
					<img src="images\icons\clipboard.png" alt="Persiapan Impor">
					<h3>Persiapan Impor</h3>
				</div>
				</a>

				<a href="#pelaksanaan-impor" style="text-decoration: none;">
				<div class="topic-card">
					<img src="images\icons\implement.png" alt="Pelaksanaan Impor">
					<h3>Pelaksanaan Impor</h3>
				</div>
				</a>
			</div>
			<p class="text-center">
			Kemasan yang digunakan mengacu pada Standar Kompetensi Kerja Nasional Indonesia berdasarkan Keputusan Menteri Ketenagakerjaan Republik Indonesia Nomor 95 Tahun 2018 Tentang Penetapan Standar Kompetensi Kerja Nasional Indonesia Kategori Perdagangan Besar Dan Eceran; Reparasi Dan Perawatan Mobil Dan Sepeda Motor Golongan Pokok Perdagangan Besar, Bukan Mobil Dan Sepeda Motor Bidang Ekspor Impor.
			</p>
        </div>
    </div>
</div>

<div id="persiapan-ekspor" class="container-fluid text-white mb-4" style="background-color:#031A31;">
	<div class="container py-3">
		<h3>1. Skema Sertifikasi Persiapan Ekspor</h3>
	</div>
</div>

<div class="container mb-5">
	<p>Rincian Unit Kompetensi :</p>
	<table>
        <thead>
            <tr>
                <th>NO</th>
                <th>KODE UNIT</th>
                <th>JUDUL UNIT KOMPETENSI</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>G.46PEI01.006.2</td>
                <td>Melakukan Riset pasar Ekspor</td>
            </tr>
            <tr>
                <td>2</td>
                <td>G.46PEI01.005.2</td>
                <td>Menentukan Harga Jual Ekspor</td>
            </tr>
            <tr>
                <td>3</td>
                <td>G.46PEI00.011.2</td>
                <td>Melakukan Negosiasi Ekspor Impor</td>
            </tr>
            <tr>
                <td>4</td>
                <td>G.46PEI00.030.1</td>
                <td>Menentukan Metode Pembayaran Perdagangan Luar Negeri</td>
            </tr>
            <tr>
                <td>5</td>
                <td>G.46PEI01.009.2</td>
                <td>Melaksanakan Promosi Ekspor</td>
            </tr>
            <tr>
                <td>6</td>
                <td>G.46PEI01.001.2</td>
                <td>Melakukan Identifikasi Komoditi/Produk Ekspor</td>
            </tr>
            <tr>
                <td>7</td>
                <td>G.46PEI01.007.1</td>
                <td>Menerapkan Persyaratan Akses Pasar di Negara Tujuan Ekspor</td>
            </tr>
            <tr>
                <td>8</td>
                <td>G.46PEI00.012.2</td>
                <td>Membuat Kontrak Dagang Ekspor Impor</td>
            </tr>
            <tr>
                <td>9</td>
                <td>G.46PEI01.008.2</td>
                <td>Memilih Saluran Distribusi Barang Ekspor</td>
            </tr>
            <tr>
                <td>10</td>
                <td>G.46PEI01.028.1</td>
                <td>Menentukan Sumber Pembiayaan Ekspor</td>
            </tr>
            <tr>
                <td>11</td>
                <td>G.46PEI01.031.2</td>
                <td>Menganalisa Syarat dan Kondisi Letter of Credit (L/C)</td>
            </tr>
            <tr>
                <td>12</td>
                <td>G.46PEI00.018.2</td>
                <td>Mengklasifikasikan Barang Ekspor Impor Sesuai HS Code</td>
            </tr>
            <tr>
                <td>13</td>
                <td>G.46PEI01.010.1</td>
                <td>Melakukan Korespondensi Ekspor</td>
            </tr>
        </tbody>
    </table>
	<br>

	<p> Persyaratan Dasar Pemohon Sertifikasi:
		<ol>
			<li>Memiliki sertifikat pelatihan ekspor yang diselenggarakan oleh PPEJP, dan</li>
			<li>Pendidikan minimal SMA/SMK atau tenaga kerja berpengalaman pada pekerjaan persiapan ekspor minimal 2 tahun atau memiliki Izin usaha.</li>
		</ol>
	</p>
	
	<div class="card p-3 text-center">
		<p>Biaya sertifikasi untuk skema Kompetensi Persiapan Ekspor sebesar Rp.500.000. dengan rincian biaya terlampir. (dalam proses pengajuan PP tarif)</p>
	</div>
</div>

<div id="pelaksanaan-ekspor" class="container-fluid text-white mb-4" style="background-color:#031A31;">
	<div class="container py-3">
		<h3>2. Skema Sertifikasi Pelaksanaan Ekspor</h3>
	</div>
</div>

<div class="container mb-5">
	<p>Rincian Unit Kompetensi :</p>
	<table>
		<thead>
			<tr>
				<th>NO</th>
				<th>KODE UNIT</th>
				<th>JUDUL UNIT KOMPETENSI</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>G.46PEI01.006.2</td>
				<td>Melakukan Riset pasar Ekspor</td>
			</tr>
			<tr>
				<td>2</td>
				<td>G.46PEI01.005.2</td>
				<td>Menentukan Harga Jual Ekspor</td>
			</tr>
			<tr>
				<td>3</td>
				<td>G.46PEI00.011.2</td>
				<td>Melakukan Negosiasi Ekspor Impor</td>
			</tr>
			<tr>
				<td>4</td>
				<td>G.46PEI00.030.1</td>
				<td>Menentukan Metode Pembayaran Perdagangan Luar Negeri</td>
			</tr>
			<tr>
				<td>5</td>
				<td>G.46PEI01.009.2</td>
				<td>Melaksanakan Promosi Ekspor</td>
			</tr>
			<tr>
				<td>6</td>
				<td>G.46PEI01.001.2</td>
				<td>Melakukan Identifikasi Komoditi/Produk Ekspor</td>
			</tr>
			<tr>
				<td>7</td>
				<td>G.46PEI01.007.1</td>
				<td>Menerapkan Persyaratan Akses Pasar di Negara Tujuan Ekspor</td>
			</tr>
			<tr>
				<td>8</td>
				<td>G.46PEI00.012.2</td>
				<td>Membuat Kontrak Dagang Ekspor Impor</td>
			</tr>
			<tr>
				<td>9</td>
				<td>G.46PEI01.008.2</td>
				<td>Memilih Saluran Distribusi Barang Ekspor</td>
			</tr>
			<tr>
				<td>10</td>
				<td>G.46PEI01.028.1</td>
				<td>Menentukan Sumber Pembiayaan Ekspor</td>
			</tr>
			<tr>
				<td>11</td>
				<td>G.46PEI01.031.2</td>
				<td>Menganalisa Syarat dan Kondisi Letter of Credit (L/C)</td>
			</tr>
			<tr>
				<td>12</td>
				<td>G.46PEI00.018.2</td>
				<td>Mengklasifikasikan Barang Ekspor Impor Sesuai HS Code</td>
			</tr>
			<tr>
				<td>13</td>
				<td>G.46PEI01.010.1</td>
				<td>Melakukan Korespondensi Ekspor</td>
			</tr>
		</tbody>
	</table>
	<br>

	<p> Persyaratan Dasar Pemohon Sertifikasi: </p>
	<ol>
		<li>Memiliki sertifikat pelatihan ekspor yang diselenggarakan oleh PPEJP, dan</li>
		<li>Pendidikan minimal SMA/SMK atau tenaga kerja berpengalaman pada pekerjaan pelaksanaan ekspor minimal 2 tahun atau memiliki Izin usaha.</li>
	</ol>
	
	<div class="card p-3 text-center">
		<p>Biaya sertifikasi untuk skema Kompetensi Pelaksanaan Ekspor sebesar Rp.500.000. dengan rincian biaya terlampir. (dalam proses pengajuan PP tarif)</p>
	</div>
</div>

<div id="persiapan-impor" class="container-fluid text-white mb-4" style="background-color:#031A31;">
	<div class="container py-3">
		<h3>3. Skema Sertifikasi Persiapan Impor</h3>
	</div>
</div>

<div class="container mb-5">
	<p>Rincian Unit Kompetensi :</p>
	<table>
		<thead>
			<tr>
				<th>NO</th>
				<th>KODE UNIT</th>
				<th>JUDUL UNIT KOMPETENSI</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>G.46PEI02.034.1</td>
				<td>Mengidentifikasi Pemasok Barang Impor</td>
			</tr>
			<tr>
				<td>2</td>
				<td>G.46PEI02.036.2</td>
				<td>Melakukan Korespondensi Impor</td>
			</tr>
			<tr>
				<td>3</td>
				<td>G.46PEI02.043.1</td>
				<td>Menentukan Sumber Pembiayaan Impor</td>
			</tr>
			<tr>
				<td>4</td>
				<td>G.46PEI00.018.2</td>
				<td>Mengklasifikasikan Barang Ekspor Impor Sesuai HS Code</td>
			</tr>
			<tr>
				<td>5</td>
				<td>G.46PEI02.035.2</td>
				<td>Menghitung Biaya Impor</td>
			</tr>
			<tr>
				<td>6</td>
				<td>G.46PEI02.037.1</td>
				<td>Mengurus Dokumen Impor</td>
			</tr>
			<tr>
				<td>7</td>
				<td>G.46PEI02.044.1</td>
				<td>Mengurus Pembiayaan Impor</td>
			</tr>
			<tr>
				<td>8</td>
				<td>G.46PEI02.045.2</td>
				<td>Mengaplikasikan Permohonan Penerbitan L/C Impor</td>
			</tr>
		</tbody>
	</table>
	<br>

	<p> Persyaratan Dasar Pemohon Sertifikasi:
		<ol>
			<li>Memiliki sertifikat pelatihan ekspor yang diselenggarakan oleh PPEJP, dan</li>
			<li>Pendidikan minimal SMA/SMK atau tenaga kerja berpengalaman pada pekerjaan persiapan impor minimal 2 tahun atau memiliki Izin usaha.</li>
		</ol>
	</p>
	
	<div class="card p-3 text-center">
		<p>Biaya sertifikasi untuk skema Kompetensi Persiapan Impor sebesar Rp.500.000. dengan rincian biaya terlampir. (dalam proses pengajuan PP tarif)</p>
	</div>
</div>

<div id="pelaksanaan-impor" class="container-fluid text-white mb-4" style="background-color:#031A31;">
	<div class="container py-3">
		<h3>4. Skema Sertifikasi Pelaksanaan Impor</h3>
	</div>
</div>

<div class="container mb-5">
	<p>Rincian Unit Kompetensi :</p>
	<table>
		<thead>
			<tr>
				<th>NO</th>
				<th>KODE UNIT</th>
				<th>JUDUL UNIT KOMPETENSI</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>G.46PEI02.038.2</td>
				<td>Mengurus Customs Clearance Impor</td>
			</tr>
			<tr>
				<td>2</td>
				<td>G.46PEI02.041.2</td>
				<td>Mengurus Pengeluaran Barang Impor</td>
			</tr>
			<tr>
				<td>3</td>
				<td>G.46PEI02.039.2</td>
				<td>Membayar Pungutan Pabean Impor</td>
			</tr>
			<tr>
				<td>4</td>
				<td>G.46PEI02.040.1</td>
				<td>Mengurus Dokumen Pengangkutan Barang Impor</td>
			</tr>
			<tr>
				<td>5</td>
				<td>G.46PEI02.042.2</td>
				<td>Mengurus Asuransi Pengangkutan Barang Ekspor Impor</td>
			</tr>
			<tr>
				<td>6</td>
				<td>G.46PEI02.046.2</td>
				<td>Mengelola Perubahan Syarat dan Kondisi L/C Impor</td>
			</tr>
			<tr>
				<td>7</td>
				<td>G.46PEI02.047.1</td>
				<td>Mengurus Penyelesaian Kewajiban L/C Impor</td>
			</tr>
			<tr>
				<td>8</td>
				<td>G.46PEI02.048.2</td>
				<td>Mengurus Penyelesaian Kewajiban Impor Non L/C</td>
			</tr>
		</tbody>
	</table>
	<br>

	<p> Persyaratan Dasar Pemohon Sertifikasi:
		<ol>
			<li>Memiliki sertifikat pelatihan ekspor yang diselenggarakan oleh PPEJP, dan</li>
			<li>Pendidikan minimal SMA/SMK atau tenaga kerja berpengalaman pada pekerjaan pelaksanaan impor minimal 2 tahun atau memiliki Izin usaha.</li>
		</ol>
	</p>
	
	<div class="card p-3 text-center">
		<p>Biaya sertifikasi untuk skema Kompetensi Pelaksanan Impor sebesar Rp.500.000. dengan rincian biaya terlampir. (dalam proses pengajuan PP tarif)</p>
	</div>
</div>
	
<div class="mb-1">&nbsp;
</div>
<?php echo myfooter(); ?>
<?= GetDebugMessage() ?>
</body>