<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Webinar = &$Page;
?>
<?php echo myheader(); ?>

<div class="container-fluid " style="background-color: #031A31; padding:10px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold">WEBINAR</h1>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="xmargin-top:90px;">
    <div class="row">
        <div class="col-md-12 p-0" style=" height: 400px">
            <div style="background-image: url(images/pages/webinar.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-5 ">
        <div class="col-md-12">
            <div class="text-center" style="font-size: 1.3em;">
              Webinar ekspor adalah acara yang sangat bermanfaat bagi para pelaku bisnis yang ingin memulai atau mengembangkan bisnis ekspor mereka. Dalam acara ini, peserta akan mendapatkan pemahaman yang lebih dalam tentang pasar global, hambatan-hambatan yang mungkin mereka hadapi, serta strategi-strategi yang efektif untuk memasarkan dan menjual produk mereka ke luar negeri. Dengan demikian, acara webinar ekspor dapat menjadi langkah awal yang baik bagi para pelaku bisnis dalam memasuki pasar global dan memperluas jangkauan bisnis mereka.
            </div>
        </div>
    </div>
</div>

<section class="content-section mt-5">
	<div class="container">
		<h3 class="text-center text-bold mb-4">WEBINAR MENDATANG</h3>
		<div class="row mb-5">
		
		<?php
			$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_hari`,`sisa`, `tempat`, `jumlah_peserta`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `jenis_pelatihan` LIKE 'webinar' ORDER BY `tawal` ASC Limit 20");
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
						<td><i class="fa fa-user" aria-hidden="true"></i> <span class="text-dark"><small> <?php echo $row["jumlah_peserta"]; ?> orang </small></td>
					</tr>
				</table>
				
							<a href="wpelatihanview/<?php echo $row["pelatihan_id"];?>" class="btn btn-success stretched-link btn-default btn-block">Lihat Detail</a>
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

<div class="mb-5">&nbsp;</div>



<script>
    document.title = "Webinar"
</script>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
