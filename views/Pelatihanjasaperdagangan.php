<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Pelatihanjasaperdagangan = &$Page;
?>
<?php echo myheader(); ?>

<div class="container-fluid " style="background-color: #3A8F53; padding:20px 0px;">
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #031A31;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">PELATIHAN JASA PERDAGANGAN</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="xmargin-top:90px;">
    <div class="row">
        <div class="col-md-12 p-0" style=" height: 400px">
            <div style="background-image: url(images/pages/pelatihan-jasa-perdagangan.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-5">
        <div class="col-md-12">
            <div class="text-justify">
              Melalui program pelatihan kami yang komprehensif, kami memberikan pengetahuan yang mendalam tentang aspek-aspek penting dalam jasa perdagangan. Dengan menggunakan metode pembelajaran interaktif dan studi kasus nyata, kami membekali peserta pelatihan dengan keterampilan praktis yang diperlukan untuk sukses dalam perdagangan internasional.
            </div>
        </div>
    </div>
</div>

<style>
    .alur-daftar {
        margin-top:0 !important;
    }

    .alur-daftar .step {
        font-weight: bolder;
        font-size: 1.4em;
    }

    .alur-daftar .title {
        margin-bottom: 10px;
        height: 60px;
    }

    .alur-daftar .dot {
        border-bottom: 2px solid white;
        font-size: 3em;
        font-weight: bolder;
    }

    .alur-daftar .desc {
        font-size: .7em;
        padding: 5px 8px;
        padding-top: 50px;
        text-align: left;
        font-weight: 300;
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

    .pelatihan-mendatang {
        display: flex;
        flex-direction: column;
        min-height: 400px; 
        box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);
    }

    .pelatihan-mendatang .card-title {
        flex-grow: 1; 
        display: flex;
        flex-direction: column;
        justify-content: space-between; 
        margin-bottom: 5px; 
    }

    .pelatihan-mendatang .card-title table {
        width: 100%;
        margin-bottom: auto; 
    }

    .pelatihan-mendatang .card-img-top {
        object-fit: cover;
        height: 250px;
        width: 100%;
    }

    .pelatihan-mendatang .btn {
        margin-top: auto; 
        padding: 10px; 
        text-align: center; 
        display: block;
        width: 100%; 
    }

    @media (max-width: 768px) {
        .pelatihan-mendatang {
            min-height: auto; 
        }

        .pelatihan-mendatang .card-title {
            margin-bottom: 5px; 
        }

        .pelatihan-mendatang .card-title p {
            font-size: 16px; 
            margin-bottom: 5px; 
        }

        .pelatihan-mendatang .card-title table td {
            display: block;
            width: 100%;
            box-sizing: border-box; 
            margin-bottom: 5px; 
        }

        .pelatihan-mendatang .btn {
            padding: 8px; 
            margin-top: 5px; 
        
        }
    }
</style>

<div class="container-fluid p-0 mt-0" style="background-image: url(images/pages/altpelatihan1/img_6147_1.png); background-size: cover;position: relative; background-position: center;display:none;">
    <div style="box-sizing: border-box; position: absolute; top:0; height: 100%; width: 100%; background-image: linear-gradient(0deg, rgba(3, 26, 49, 0.8), rgba(3, 26, 49, 0.8));"></div>
    <div class="container py-3">
		<div class="col p-0 mb-3 text-white text-center">
			<h3 class="mt-3">Cara Daftar Pelatihan</h3>
		</div>
        <div class="row mt-5 alur-daftar justify-content-center">
			
            <div class="col-md-2 p-0 m-0 text-center text-white mt-5">
                <div class="step" style="height:67px;">Sign in</div>
                <div class="step">1</div>
                <div class="dot" style="position: relative; height: 20px; display: flex; justify-content: center;">
                    <div style="position: absolute; bottom:-10px; width: 20px; height: 20px; border-radius: 50%; background-color: white;">
                    </div>
                </div>
                <div class="desc">
                    Silahkan masuk ke akun PPEJP yang telah ada. Jika belum punya, maka calon peserta diharuskan membuat akun terlebih dahulu
                </div>
            </div>
            <div class="col-md-2 p-0 m-0 text-center text-white mt-5">
                <div class="step" style="height:67px;">Pilih Pelatihan</div>
                <div class="step">2</div>
                <div class="dot" style="position: relative; height: 20px; display: flex; justify-content: center;">
                    <div style="position: absolute; bottom:-10px; width: 20px; height: 20px; border-radius: 50%; background-color: white;">
                    </div>
                </div>
                <div class="desc">
                   Pilih pelatihan yang ingin diikuti di Website. Pilih tanggal pelaksanaan yang sesuai dan jumlah peserta yang akan mengikutinya
                </div>
            </div>
            <div class="col-md-2 p-0 m-0 text-center text-white mt-5">
                <div class="step" style="height:67px;">Pembayaran</div>
                <div class="step">3</div>
                <div class="dot" style="position: relative; height: 20px;display: flex; justify-content: center;">
                    <div style="position: absolute; bottom:-10px; width: 20px; height: 20px; border-radius: 50%; background-color: white;">
                    </div>
                </div>
                <div class="desc">
                    Pembayaran biaya ikut pelatihan ke rekening PPEJP yang resmi. Pastikan jumlah, nomor dan nama rekening sudah sesuai
                </div>
            </div>
			
            <div class="col-md-2 p-0 m-0 text-center text-white mt-5">
                <div class="step" style="height:67px;">Upload bukti pembayaran</div>
                <div class="step">5</div>
                <div class="dot" style="position: relative; height: 20px;display: flex; justify-content: center;">
                    <div style="position: absolute; bottom:-10px; width: 20px; height: 20px; border-radius: 50%; background-color: white;">
                    </div>
                </div>
                <div class="desc">
                    Setelah pembayaran selesai, silahkan upload bukti melalui website PPEJP. Pastikan alamat email yang terdaftar di PPEJP sudah sesuai
                </div>
            </div>
			
            <div class="col-md-2 p-0 m-0 text-center text-white mt-5">
                <div class="step" style="height:67px;">Verifikasi Pembayaran</div>
                <div class="step">5</div>
                <div class="dot" style="position: relative; height: 20px;display: flex; justify-content: center;">
                    <div style="position: absolute; bottom:-10px; width: 20px; height: 20px; border-radius: 50%; background-color: white;">
                    </div>
                </div>
                <div class="desc">
                    Pembayaran anda akan diverifikasi oleh tim PPEJP. Tunggu notifikasi apakah pembayaran terverifikasi atau tidak di halaman profil PPEJP dan alamat email yang terdaftar. Maks waktu verifikasi 5 hari kerja
                </div>
            </div>
			
        </div>
    </div>
</div>

<!--
<section class="content-section mt-5">
	<div class="container">
		<h2 class="text-center text-bold mb-4">PELATIHAN JASA PERDAGANGAN TAHUN <?php echo date("Y"); ?></h2>
		<div class="row mb-5">
		
		<?php
			$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_hari`,`sisa`, `tempat`, `jumlah_peserta`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() AND `jenis_pelatihan` LIKE 'jasa_perdagangan'");
			$jumlahpelatihan = 0;
			while ($row = $rs->fetch()) {
			
			//$peserta_terdaftar = ExecuteScalar("SELECT COUNT(1) FROM `w_orders` WHERE `pelatihan_id` = ".$row["pelatihan_id"]);
			$sisa = $row["sisa"];
		?>
			<div class=" col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="card pelatihan-mendatang mb-4" style="margin:0;border:0;box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);">
			  <img src="files/<?php echo $row["gambar"]; ?>" class="card-img-top" height="250px">
			  <div class="card-title m-2">
			  <?php echo $row["judul_pelatihan"]; ?>
				<table class="table">
					<tr>
						<td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $row["tanggal_pelaksanaan"]; ?></td>
						<td><i class="fa fa-user" aria-hidden="true"></i> <span class="text-danger"><small>Sisa <?php echo $sisa; ?> Kursi</small></td>
					</tr>
				</table>
				
							<a href="<?= GetUrl('detail-pelatihan/view/'.$row["pelatihan_id"]) ?>" class="btn btn-success stretched-link btn-default btn-block">Lihat Detail</a>
			  </div>
			</div>
			</div>
		<?php	
			$jumlahpelatihan++;
				}
			if($jumlahpelatihan == 0){ echo '<span class="alert alert-warning text-center">Pelatihan belum tersedia</span>'; }
		?>
		</div>
	</div>
</section>
            -->
<div class="mb-2">&nbsp;</div>

<script>
    document.title = "Pelatihan Jasa Perdagangan"
</script>
	
</div>
<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>