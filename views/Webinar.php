<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Webinar = &$Page;
?>
<?php echo myheader(); ?>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container" style="xmargin-top:110px">
        <div class="row" style="xbackground-color: #031A31;">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">WEBINAR</h1>
            </div>
        </div>
    </div>
</div>

<style>
     p, table, div {
        font-size: 16px;
	}
	
    h1{
		font-size: 25px;
	}

	h2{
		font-size: 20px;
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

<div class="container-fluid" style="margin-top:0;">
    <div class="row">
        <div class="col-md-12 p-0">
            <div style="
                background-image: url(images/pages/bannerwebinar.jpg);
                background-size: cover;
                background-position: center;
                width: 100%;
                height: 450px; 
                ">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-5">
        <div class="col-md-12">
            <div class="text-justify">
              Webinar ekspor adalah acara yang sangat bermanfaat bagi para pelaku bisnis yang ingin memulai atau mengembangkan bisnis ekspor mereka. Dalam acara ini, peserta akan mendapatkan pemahaman yang lebih dalam tentang pasar global, hambatan-hambatan yang mungkin mereka hadapi, serta strategi-strategi yang efektif untuk memasarkan dan menjual produk mereka ke luar negeri. Dengan demikian, acara webinar ekspor dapat menjadi langkah awal yang baik bagi para pelaku bisnis dalam memasuki pasar global dan memperluas jangkauan bisnis mereka.
            </div>
        </div>
    </div>
</div>

<section class="content-section mt-5">
    <div class="container">
        <h2 class="text-center text-bold mb-4">WEBINAR MENDATANG</h2>
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
<div class="mb-2">&nbsp;</div>

<script>
    document.title = "Webinar"
</script>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>