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


<div class="container-fluid" style="margin-top:0;">
    <div class="row">
        <div class="col-md-12 p-0">
            <div style="
                background-image: url(images/pages/webinar.png);
                background-size: cover;
                background-position: center;
                width: 100%;
                height: 500px; 
                ">
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row my-5 ">
        <div class="col-md-12">
            <div class="text-justify" style="font-size: 16px;">
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
			$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_hari`, `sisa`, `tempat`, `jumlah_peserta`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `jenis_pelatihan` LIKE 'webinar' ORDER BY `tawal` ASC Limit 20");
			$jumlahpelatihan = 0;
			while ($row = $rs->fetch()) {
				$sisa = $row["sisa"];
			?>
				<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
					<div class="card pelatihan-mendatang h-100 d-flex flex-column" style="border: 1px solid #ddd; box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);">
						<img src="files/<?php echo $row["gambar"]; ?>" class="card-img-top" alt="<?php echo $row["judul_pelatihan"]; ?>" style="height: 350px; object-fit: contain;">
						<div class="card-body d-flex flex-column">
							<h5 class="card-title" style="font-weight: bold; font-size: 18px;"><?php echo $row["judul_pelatihan"]; ?></h5>
							<table class="table mb-3" style="border-top: 1px solid #ddd;">
								<tr>
									<td style="font-size: 16px;"><i class="fa fa-calendar-o" aria-hidden="true" style="font-size:16px;"></i> <?php echo $row["tanggal_pelaksanaan"]; ?></td>
									<td><i class="fa fa-user" aria-hidden="true"></i> <span class="text-dark"><small> <?php echo $row["jumlah_peserta"]; ?> orang </small></span></td>
								</tr>
							</table>
							<!-- Menambahkan mt-auto untuk membuat tombol berada di bawah -->
							<a href="wpelatihanview/<?php echo $row["pelatihan_id"]; ?>" class="btn btn-success stretched-link btn-block mt-auto">Lihat Detail</a>
						</div>
					</div>
				</div>
			<?php
				$jumlahpelatihan++;
			}
			if ($jumlahpelatihan == 0) {
				echo '<span class="alert alert-warning text-center">Pelatihan belum tersedia</span>';
			}
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