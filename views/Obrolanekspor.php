<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Obrolanekspor = &$Page;
?>
<?php echo myheader(); ?>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold">OBROLAN EKSPOR</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="xmargin-top:90px;">
    <div class="row">
        <div class="col-md-12 p-0" style=" height: 600px">
            <div style="background-image: url(images/pages/obrolan-ekspor.png); background-size: cover ; background-position: center;width: 100%;height: 100%; position: absolute;top:0">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-5 ">
        <div class="col-md-12">
            <div class="text-center" style="font-size: 1.2em;">
                Obrolan ekspor merupakan Dialog antara PPEJP, Pelaku Usaha, dan praktisi ekspor untuk mencapai kesepahaman dan peningkatan kolaborasi
                pelaksanaan ekspor. Selain itu, Obrolan Ekspor memberikan informasi tentang ekspor serta Peningkatan motivasi dan pengetahuan ekspor
                bagi dunia usaha terutama pelaku usaha berorientasi ekspor.
            </div>
        </div>
    </div>
</div>

<style>
    .grid-topik-obrol .col-4 {
        margin-bottom: 25px;
    }

    .grid-topik-obrol .col-8{
        text-transform: capitalize;
        padding-top: 5px;
    }
</style>

<div class="container-fluid grid-topik-obrol" style="background-color: #e9e9e9;">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-12 p-0">
                <div style="font-weight: 600;" class="xb1 text-center">
                    <h2 class="text-bold">TOPIK OBROLAN</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 py-3">
                <div class="row">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon_newspaper_.svg" style="height: 80px;">
                    </div>
                    <div class="col-8">pengetahuan tentang ekspor</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon_archive_.svg" style="height: 80px;">
                    </div>
                    <div class="col-8">pendekatan produk ekspor</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon_zoomin_.png" style="height: 80px;">
                    </div>
                    <div class="col-8">pemecahan masalah ekspor</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon _bag_.png" style="height: 80px;">
                    </div>
                    <div class="col-8">pendekatan akses pasar</div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="row">
                    <div class="col-4 text-center">
                        <img src="images/icons/icon _user male_.png" style="height: 80px;">
                    </div>
                    <div class="col-8">Success story</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0" style="background-image: url(images/pages/narasumber-obrolan-ekspor.png); background-size: cover;position: relative; background-position: center;">
    <div style="box-sizing: border-box; position: absolute; top:0; height: 100%; width: 100%; background-image: linear-gradient(#111111aa,#111111dd,#111111ff);"></div>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 p-0 text-center text-white">
                <img src="images/icons/icon _user male circle_.png" style="height: 200px;">
                <h1 class="mt-3 text-bold">NARASUMBER</h1>
            </div>
        </div>
        <div class="row mt-5 ">
            <div class="col-md-4 text-center text-white">
                <h1>Fasilitator <br>PPEJP</h1>
            </div>
            <div class="col-md-4 text-center text-white">
                <h1>Pejabat Perwakilan <br>Perdagangan</h1>
            </div>
            <div class="col-md-4 text-center text-white">
                <h1>Alumni Sukses <br>Pelatihan PPEJP</h1>
            </div>
        </div>
    </div>
</div>

<style>
    .flex-nowrap .col-md-4 {
        min-width: 250px;
    }
</style>
<div class="container-fluid grid-topik-obrol" style="xbackground-color: #CCCCCC;margin-bottom: 88px;">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-12 p-0">
                <div style="font-weight: 600;" class="xb1 text-center">
                    <h2 class="text-bold">OBROLAN EKSPOR</h2>
                </div>
            </div>
        </div>
        <div class="row xpy-5 flex-nowrap" style="overflow-x: scroll; height: 420px;">
		<?php
			$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_hari`,`sisa`, `tempat`, `jumlah_peserta`, `harga`, `tanggal_pelaksanaan`,`Link`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `jenis_pelatihan` LIKE 'obrolan_ekspor' ORDER BY `tawal` DESC Limit 20");
			$jumlahpelatihan = 0;
			while ($row = $rs->fetch()) {
		?>
            <div class="col-md-4 " style="">
			<a href="<?php echo $row["Link"]; ?>" target="_blank">
                <img src="files/<?php echo $row["gambar"]; ?>" style="width: 100%; height: 400px;">
			</a>
            </div>
		<?php	
			$jumlahpelatihan++;
				}
			if($jumlahpelatihan == 0){ echo '<span class="alert alert-warning text-center">Obrolan Ekspor belum tersedia</span>'; }
		?>
        </div><!--
        <div class="row mt-2" style="font-weight: 600; font-size: 1.2em;">
            <a href="https://www.youtube.com/playlist?list=PLnXXNWWTR6gbM0BabCRzXf4cZovf0wc8e" style="color:#212529;text-decoration:none"><div class="col-md-12 text-right">
                Selengkapnya <i class="fa fa-chevron-right"></i>
            </div>
			</a>
        </div>-->
    </div>
</div>


<script>
    document.title = "Obrolan Ekspor"
</script>


<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
