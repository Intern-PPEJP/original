<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Akun = &$Page;
?>

<?php echo myheader(); ?>


<?php CurrentPage()->ShowMessage(); ?>

<style>.container li{padding:5px;a{color:#222222 !important;text-decoration:none;}</style>
<div class="container-fluid " style="background-color: #031A31; padding:10px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">AKUN</h1>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="padding:10px 0px;margin-top:36px;margin-bottom:76px;">
    <div class="container" style="border:1px solid #222222;">
        <div class="row" style="border-bottom:1px solid #222222;">
            <div class="col-md-10">
                <b>Profil</b>
            </div>
            <div class="col-md-2">
                <a class="ew-row-link ew-edit" title="" data-table="akunku" data-caption="Edit" href="akunkuedit/<?= CurrentUserInfo("user_id"); ?>" data-original-title="Edit"><i class="fa fa-cog"></i> Edit Profile</a></a>
                <!--<a class="ew-row-link ew-edit" title="" data-table="akunku" data-caption="Edit" href="#" onclick="return ew.modalDialogShow({lnk:this,btn:'SaveBtn',url:'/ppejp/akunkuedit/<?= CurrentUserInfo("user_id"); ?>'});" data-original-title="Edit"><i class="fa fa-cog"></i> Edit Profile</a></a>-->
            </div>
            
        </div>
        <div class="row" style="padding:10px;">
            <div class="col-md-3" style="border-right:1px solid #222222;">
            	<ul style="list-style-type:none;padding:5px;">
            	<li>
                <i class="fa fa-user-circle-o" aria-hidden="true" style="font-size:75px"></i>
                </li>
                <li><?php echo CurrentUserName(); ?></li>
                <li><?php echo CurrentUserInfo("nama_peserta"); ?><br><br></li>
                
                <li><a href="#" id="link_profil">Profil</a></li>
                <li><a href="#" id="link_pelatihan">Pelatihan</a></li>
                <li><a href="#" id="link_webinar">Webinar</a></li>
                <li><br><br><a href="logout">Logout</a></li>
                
                
            </div>
            <div class="col-md-9">
			
			<div id="profil">
			
			<?php 
				$kota = "-";
				if(CurrentUserInfo("kota") > 0) { $kota = ExecuteScalar("SELECT `kota` FROM `t_kota` WHERE `kdkota` = ".CurrentUserInfo("kota")); }
				$provinsi = "-";
				if(CurrentUserInfo("provinsi") > 0) { $provinsi = ExecuteScalar("SELECT `prop` FROM `t_prop` WHERE `kdprop` = ".CurrentUserInfo("provinsi")); } 
			?>
                
            	<ul style="list-style-type:none;">
            	<li style="font-weight:bold">Nama</li>
            	<li><?= CurrentUserInfo("nama_peserta") ?></li>
            	<li style="font-weight:bold">Perusahaan</li>
            	<li><?= CurrentUserInfo("perusahaan") ?></li>
            	<li style="font-weight:bold">Nomor HP</li>
            	<li><?= CurrentUserInfo("no_hp") ?></li>
            	<li style="font-weight:bold">Email</li>
            	<li><?= CurrentUserName() ?></li>
            	<li style="font-weight:bold">Jabatan</li>
            	<li><?= CurrentUserInfo("jabatan") ?></li>
            	<li style="font-weight:bold">Provinsi</li>
            	<li><?= $provinsi ?></li>
            	<li style="font-weight:bold">Kota</li>
            	<li><?= $kota ?></li>
            	<li style="font-weight:bold">Sektor Usaha</li>
            	<li><?= CurrentUserInfo("usaha") ?></li>
            	<li style="font-weight:bold">Produk</li>
            	<li><?= CurrentUserInfo("produk") ?></li>
            </div>
			
			<div id="pelatihan">
				
				<?php
					$sqlku = "SELECT  a.`pelatihan_id`, a.`order_id`, a.`status`, b.judul_pelatihan, b.tanggal_pelaksanaan, b.tempat  FROM `w_orders` a INNER JOIN `w_pelatihan` b ON a.`pelatihan_id` = b.`pelatihan_id` WHERE a.`username` LIKE '".CurrentUserName()."' ORDER BY a.`order_id` ASC";
					$rs = ExecuteQuery($sqlku);
					if($rs->rowCount() < 1){ echo "<p>Data tidak ditemukan.</p>"; }
					while ($row = $rs->fetch()) {	
					if( $row["status"] == 1 ) { $warna = "text-danger"; $status = "<a href='konfimasipembayaranedit?order_id=".$row["order_id"]."' class='btn btn-danger text-default' style='text-decoration: none;'>Selesaikan Pembayaran</a>"; }
					else if( $row["status"] == 2 ) { $warna = "text-warning"; $status = "Menunggu Verifikasi"; }
					else if( $row["status"] == 3 ) { $warna = "text-success"; $status = "Terdaftar"; }
					else if( $row["status"] == 4 ) { $warna = "text-success"; $status = "Selesai"; }
					else { $warna = "text-default"; $status = "Batal"; }
					
				?>
					<div class="row">
						<div class="col-7 ml-4">
							<span class="fw-bold"><?php echo $row["judul_pelatihan"]; ?></span><br>
							<span><?php echo $row["tanggal_pelaksanaan"]; ?></span><br>
							<span><?php echo $row["tempat"]; ?></span>
						</div>
						<div class="col-4">
							<span class="fw-bold">Status:</span><br>
							<span class="<?= $warna; ?>"><?= $status; ?></span>
						</div>
					</div><hr>
				
				<?php			
						}
				?>
				
			
			</div>
			
			<div id="webinar">
				<p>Data tidak ditemukan.</p>
			</div>
            
        </div>
		
		</div>
    </div>
</div>

<script>
<?php if(@$_GET["r"] == "pel") { ?>

$("#profil").hide();
$("#webinar").hide();

<?php } else { ?>
$("#pelatihan").hide();
$("#webinar").hide();

<?php } ?>
$("#link_profil").click(function(){
    $("#profil").show(500);
    $("#pelatihan").hide(500);
    $("#webinar").hide(500);
});
$("#link_pelatihan").click(function(){
    $("#profil").hide(500);
    $("#webinar").hide(500);
    $("#pelatihan").show(500);
});
$("#link_webinar").click(function(){
    $("#profil").hide(500);
    $("#pelatihan").hide(500);
    $("#webinar").show(500);
});

</script>

<?php echo myfooter(); ?>


<?= GetDebugMessage() ?>
