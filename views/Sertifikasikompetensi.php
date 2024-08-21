<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Sertifikasikompetensi = &$Page;
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
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #031A31;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">SERTIFIKASI KOMPETENSI</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="xmargin-top:90px;">
    <div class="row">
        <div class="col-md-12 p-0" style=" height: 400px">
            <div style="background-image: url(images/pages/altpelatihan1/p3131465_2.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-5 ">
        <div class="col-md-12">
            <div class="text-center">
              ...
            </div>
        </div>
    </div>
</div>



<section class="content-section mt-5">
	<div class="container">
		<h2 class="text-center text-bold mb-4">SEFTIFIKASI KOMPETENSI TAHUN <?php echo date("Y"); ?></h2>
		<div class="row mb-5">
		
		<?php
			$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_hari`, `tempat`, `jumlah_peserta`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan`  WHERE `Activated` = 'Y' AND `jenis_pelatihan` LIKE 'sert_kompetensi' ORDER BY `tawal` ASC");
			$jumlahpelatihan = 0;
			while ($row = $rs->fetch()) {
			
			$peserta_terdaftar = ExecuteScalar("SELECT COUNT(1) FROM `w_orders` WHERE `pelatihan_id` = ".$row["pelatihan_id"]);
			$sisa = $row["jumlah_peserta"] - $peserta_terdaftar;
		?>
			<div class=" col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
			<div class="card pelatihan-mendatang mb-4" style="margin:0;border:0;box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);">
			  <img src="files/<?php echo $row["gambar"]; ?>" class="card-img-top" height="250px">
			  <div class="card-title m-2" style="height:2.5em">
			  <?php echo $row["judul_pelatihan"]; ?><!--
				<table class="table">
					<tr>
						<td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $row["tanggal_pelaksanaan"]; ?></td>
						<td><i class="fa fa-user" aria-hidden="true"></i> <span class="text-danger"><small>Sisa <?php echo $sisa; ?> Kursi</small></td>
					</tr>
				</table>
				
							<a href="wpelatihanview/<?php echo $row["pelatihan_id"];?>" class="btn btn-success stretched-link btn-default btn-block">Lihat Detail</a>-->
			  </div>
			</div>
			</div>
		
		<?php	
			$jumlahpelatihan++;
				}
			if($jumlahpelatihan == 0){ echo '<span class="alert alert-warning text-center">Sertifikasi kompetensi belum tersedia</span>'; }
		?>
		</div>
		</div>
	</div>
</section>


<script>
    document.title = "SERTIFIKASI KOMPETENSI";
</script>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
