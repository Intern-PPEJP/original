<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Home = &$Page;
?>
<?php echo myheader(); ?>

<style>
/*

CC 2.0 License Iatek LLC 2018
Attribution required

*/

@media (min-width: 768px) {

    /* show 3 items */
    #carouselProducts .carousel-inner .active,
    #carouselProducts .carousel-inner .active + .carousel-item,
    #carouselProducts .carousel-inner .active + .carousel-item + .carousel-item {
        display: block;
    }
    
    .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left),
    .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item,
    .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item {
        transition: none;
        margin-right: initial;
    }
    
    .carousel-inner .carousel-item-next,
    .carousel-inner .carousel-item-prev {
      position: relative;
      transform: translate3d(0, 0, 0);
    }
    
    .carousel-inner .active.carousel-item + .carousel-item + .carousel-item + .carousel-item {
        position: absolute;
        top: 0;
        right: -33.3333%;
        z-index: -1;
        display: block;
        visibility: visible;
    }
    
    /* left or forward direction */
    .active.carousel-item-left + .carousel-item-next.carousel-item-left,
    .carousel-item-next.carousel-item-left + .carousel-item,
    .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item,
    .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(-100%, 0, 0);
        visibility: visible;
    }
    
    /* farthest right hidden item must be abso position for animations */
    .carousel-inner .carousel-item-prev.carousel-item-right {
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
        display: block;
        visibility: visible;
    }
    
    /* right or prev direction */
    .active.carousel-item-right + .carousel-item-prev.carousel-item-right,
    .carousel-item-prev.carousel-item-right + .carousel-item,
    .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item,
    .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item {
        position: relative;
        transform: translate3d(100%, 0, 0);
        visibility: visible;
        display: block;
        visibility: visible;
    }

}

.nav-fill .nav-item .nav-link.active {
  background: #28a745 !important;
}

/* Tambahkan efek untuk bagian yang akan naik ke atas */
.angka {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 1.2s ease-out, transform 1.2s ease-out;
}

.angka.show {
    opacity: 1;
    transform: translateY(0);
}

p, div {
    font-size: 18px;
}
	
	h2{
		font-size: 20px;
}

	h3{
		font-size: 22px;
}

.zoom-in {
    opacity: 0;
    transform: scale(0.9);
    transition: opacity 1.2s ease-out, transform 1.2s ease-out;
}

.zoom-in.show {
    opacity: 1;
    transform: scale(1);
}
</style>	
<script>
$('#carouselProducts').on('slide.bs.carousel', function (e) {

    /*

    CC 2.0 License Iatek LLC 2018
    Attribution required
    
    */

    var $e = $(e.relatedTarget);
    
    var idx = $e.index();
    console.log("IDX :  " + idx);
    
    var itemsPerSlide = 8;
    var totalItems = $('#carouselProducts .carousel-item').length;
    
    if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            // append slides to end
            if (e.direction=="left") {
                $('#carouselProducts .carousel-item').eq(i).appendTo('#carouselProducts .carousel-inner');
            }
            else {
                $('#carouselProducts .carousel-item').eq(0).appendTo('#carouselProducts .carousel-inner');
            }
        }
    }
});
</script>	
<main>

	<section class="ppejp-section ppejp-section-full-height">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-12 p-0">
				<div class="container">
				<h4 class="judul">PUSAT PELATIHAN<br>SUMBER DAYA MANUSIA EKSPOR<br>DAN JASA PERDAGANGAN</h4>
				<p class="subline" style="font-size: 30px;">Mengembangkan UMKM Indonesia Sejak 1990</p>
				<ul class="slider-button pl-0">
				<li class="b-item mb-2">
					<a class="nav-link custom-btn custom-border-btn btn inactive list-pelatihan" href="#" data-toggle="modal" data-target="#ListPelatihan">Jadwal Pelatihan</a>
				</li>
				<li class="b-item">
					<a class="nav-link custom-btn custom-border-btn btn inactive daftar" href="formpendaftaran">Daftar Pelatihan</a>
				</li>
				</ul>
				
				
				<div class="y-jadwal">
				<ul style="list-style-type:none">
				<?php 
				$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `jumlah_peserta`, `sisa`, `tanggal_pelaksanaan`, `jenis_pelatihan`, `Link` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() ORDER BY `tawal` ASC");
				$i=1;
				while ($row = $rs->fetch()) {
					$ket = '<span class="badge text-success">Sisa '.$row["sisa"].' orang</span>';
					$link = 'detail-pelatihan/view/'. $row["pelatihan_id"];
					if($row["sisa"]<1){
						$ket = '<span class="badge text-danger">Fully Booked</span>';
					} else if($row["sisa"]>=1 && $row["sisa"]<=10) {
						$ket = '<span class="badge text-warning">Sisa '.$row["sisa"].' orang</span>';
					}
					
					$ikon = "icon-users.png";
					if($row["jenis_pelatihan"] == "obrolan_ekspor"){
						$ikon = "brand-youtube.png";
						$link = $row["Link"];
					} else if ($row["jenis_pelatihan"] == "webinar" ){
						$ikon = "icon-video.png";
					}
				?><li><span class="" style="border: 2px solid #fff;position:absolute;left:22px;height:100%;"></span>
					<div class="item_direction mb-4">
						
						<i class="fas fa-circle cikon"></i><a href="<?php echo $link; ?>" style="text-decoration:none;color:#fff;">
						<table><tr><td><img src="images/icons/<?php echo $ikon; ?>"></img></td><td>
				<?php echo $row["judul_pelatihan"]; ?><br><span class="y-tgl"><?php echo $row["tanggal_pelaksanaan"]; ?> <?php echo $ket; ?> </span></td></tr></table>
					</a>
					</div></li>
				<?php
				}
				?>
				</ul>
				</div>
			
				</div>
					<div id="ppejp-slide"  class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000" data-pause="false">
					  <div style="position:absolute;background: rgb(0 0 0 / 20%);width:100%;height:100%;z-index: 2;"></div>
					  <div class="carousel-inner">
						<div class="carousel-item active">
						  <img src="images/slide/1.png" class="carousel-image img-fluid" alt="Gedung Depan PPEJP">
						</div>
						<div class="carousel-item">
						  <img src="images/slide/2.png" class="carousel-image img-fluid" alt="Gedung Samping PPEJP">
						</div>
						<div class="carousel-item">
						  <img src="images/slide/3.png" class="carousel-image img-fluid" alt="Gedung Atas PPEJP">
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="profile-section">
		<div class="container text-center">
			<div class="row justify-content-center">
			<h3 class="mb-3 text-bold">Profil</h3>
				<div class="col-lg-8 col-12 vid-profil mb-4">
					<iframe width="90%" height="300" src="https://www.youtube.com/embed/m4Bxe4osZVo" title="Video Profil PPEJP" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
				</div>
				<div class="col-lg-10 col-12 text-description">
	
					<p style="text-align:center;">
						Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan (PPEJP) merupakan lembaga yang berada di lingkungan Sekretariat Jenderal, Kementerian Perdagangan. PPEJP mempunyai tugas melaksanakan pengembangan sumber daya manusia ekspor, mutu, personil metrologi legal, dan jasa perdagangan untuk dunia usaha dan masyarakat.
					</p>
				</div>
			</div>
		</div>
	</section>
	
	<section>
		<div class="container-fluid">	
				<div class="row cs-icons-menu">
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 icons-menu"><a href="pelatihan-ekspor" class="d-block">
							<p class="icon-text text-center zoom-in">PELATIHAN EKSPOR</p>
					<div class="featured-block d-flex justify-content-center align-items-center">
						<p class="zoom-in">
							<img src="images/icons/icon-world.png" class="featured-block-image img-fluid " alt="">
						</p>
					</div>
					<div class="cs-bg-icons" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('images/icons/bg/bg-pelatihan-ekspor.png');">
					</div>
					</a>
				</div>
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 icons-menu"><a href="pelatihan-metrologi" class="d-block">
							<p class="icon-text text-center zoom-in">PELATIHAN METROLOGI</p>
					<div class="featured-block d-flex justify-content-center align-items-center">
						<p class="zoom-in">
							<img src="images/icons/pelatihan-metrologi.png" class="featured-block-image img-fluid" alt="">
						</p>
					</div>
					<div class="cs-bg-icons" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('images/icons/bg/bg-pelatihan-metrologi.png');">
					</div>
					</a>
				</div>
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 icons-menu"><a href="pelatihan-mutu" class="d-block">
							<p class="icon-text text-center zoom-in">PELATIHAN MUTU</p>
					<div class="featured-block d-flex justify-content-center align-items-center">
						<p class="zoom-in">
							<img src="images/icons/icon-checkup.png" class="featured-block-image img-fluid " alt="">
						</p>
					</div>
					<div class="cs-bg-icons" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('images/icons/bg/bg-pel-mutu.jpg');">
					</div>
					</a>
				</div>
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 icons-menu"><a href="pelatihan-jasa-perdagangan" class="d-block">
							<p class="icon-text text-center zoom-in">PELATIHAN JASA PERDAGANGAN</p>
					<div class="featured-block d-flex justify-content-center align-items-center">
						<p class="zoom-in">
							<img src="images/icons/pelatihan-ekspor.png" class="featured-block-image img-fluid " alt="">
						</p>
					</div>
					<div class="cs-bg-icons" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/icons/bg/bg-pel-jasa.jpg');">
					</div>
					</a>
				</div>
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 icons-menu"><a href="export-coaching-program" class="d-block">
							<p class="icon-text text-center zoom-in">EXPORT COACHING PROGRAM</p>
					<div class="featured-block d-flex justify-content-center align-items-center">
						<p class="zoom-in">
							<img src="images/icons/ecp.png" class="featured-block-image img-fluid" alt="">
						</p>
					</div>
					<div class="cs-bg-icons" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 0.83), rgba(0, 0, 0, 0.83)), url('images/icons/bg/bg-ecp.png');">
					</div>
					</a>
				</div>
				<div class="col-lg col-md-4 col-sm-4 col-xs-4 icons-menu"><a href="webinar" class="d-block">
							<p class="icon-text text-center zoom-in">WEBINAR</p>
					<div class="featured-block d-flex justify-content-center align-items-center">
						<p class="zoom-in">
							<img src="images/icons/webinar.png" class="featured-block-image img-fluid" alt="">
						</p>
					</div>
					<div class="cs-bg-icons" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('images/icons/bg/bg-webinar.png');">
					</div>
					</a>
				</div>
			</div>
		</div>
	</section>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
    	const elements = document.querySelectorAll('.zoom-in');

    	function checkElements() {
        elements.forEach(element => {
            const rect = element.getBoundingClientRect();
            if (rect.top <= window.innerHeight && rect.bottom >= 0) {
                element.classList.add('show');
            }
        });
    }

		window.addEventListener('scroll', checkElements);
		checkElements(); // Check initially in case the elements are already in view
	});
	</script>

	<section class="barcount-section">
    <div class="container">
        <div class="row row-bar-count pt-3">
            <div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
                <span class="col-12 jumlah" data-target="60000">0</span>
                <span class="col-12 jumlah_cap">Alumni pelatihan</span>
            </div>
            
            <div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
                <span class="col-12 jumlah" data-target="2000">0</span>
                <span class="col-12 jumlah_cap">Alumni Pendampingan</span>        
            </div>
            <div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
                <span class="col-12 jumlah" data-target="110">0</span>
                <span class="col-12 jumlah_cap">Fasilitator</span>        
            </div>
            <div class="col-lg col-md-3 col-sm-6 col-xs-6 angka">
                <span class="col-12 jumlah" data-target="80">0</span>
                <span class="col-12 jumlah_cap">Topik Pelatihan</span>        
            </div>
        </div>
    </div>
</section>

<script>
    // Fungsi untuk melakukan animasi hitung angka
    function animateCountUp(element, start, end, duration) {
        let startTime = null;

        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            element.innerText = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                requestAnimationFrame(animation);
            } else {
                element.innerText = end; // Pastikan angka berakhir sesuai target
            }
        }
        requestAnimationFrame(animation);
    }

    // Memulai animasi pada semua elemen dengan class 'jumlah'
    document.querySelectorAll('.jumlah').forEach((element) => {
        const target = parseInt(element.getAttribute('data-target'));
        animateCountUp(element, 0, target, 4000); // 2000ms = 2 detik
    });

	document.addEventListener('DOMContentLoaded', function() {
    const angkaElements = document.querySelectorAll('.angka');

    function checkScroll() {
        angkaElements.forEach(element => {
            const rect = element.getBoundingClientRect();
            if (rect.top <= window.innerHeight - 100) { // Sesuaikan angka -100 untuk mengatur kapan animasi dimulai
                element.classList.add('show');
            }
        });
    }

    // Memeriksa elemen saat halaman pertama kali dimuat
    checkScroll();

    // Memeriksa elemen ketika pengguna melakukan scroll
    window.addEventListener('scroll', checkScroll);
});

</script>

	<section class="pt-5 pb-2">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<a class="btn btn-success mb-3 mr-1" href="#carouselProducts" role="button" data-slide="prev" style="position:absolute;left:12px;top:0;">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h3 class="mb-3 text-bold">Pelatihan Mendatang </h3>
					<a class="btn btn-success mb-3 " href="#carouselProducts" role="button" data-slide="next" style="position:absolute;right:25px;top:0">
						<i class="fa fa-arrow-right"></i>
					</a>
				</div>

				<div id="carouselProducts" class="carousel slide" data-ride="carousel" data-interval="9000">
					<div class="carousel-inner" role="listbox">
						<div class="row" style="margin-right:0px !important">
							<?php
								$rs = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`,`tawal`, `jumlah_hari`, `tempat`, `jumlah_peserta`, `sisa`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') ORDER BY `tawal` ASC");
								$i=1;
								while ($row = $rs->fetch()) {
								
								$peserta_terdaftar = ExecuteScalar("SELECT COUNT(1) FROM `w_orders` WHERE `pelatihan_id` = ".$row["pelatihan_id"]);
								$sisa = $row["sisa"];
								$active = "";
								if($i==1) $active = "active";
							?>
							 <div class="carousel-item col-md-4 <?php echo $active; ?>">
								<div class="card" style="padding:0;border:0;box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.25);">
									<img class="img-fluid" alt="100%x220" style="height:220px !important;border-radius:8px 8px 0 0 !important;" src="files/<?php echo $row["gambar"]; ?>">
									<div class="card-body m-0 p-1">
										<h3 class="card-titte" style="height:40px; font-size: 18px; font-weight: bold;"><?php echo $row["judul_pelatihan"]; ?></h3>
										<table class="table p-0 m-0" style="font-size:.8em">
											<tr>
												<td width="50%" height="" valign="middle"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $row["jumlah_hari"]; ?></td>
												<td width="50%" valign="middle"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $row["tempat"]; ?></td>
											</tr>
											<tr>
												<td height=""><i class="fa fa-users" aria-hidden="true"></i> <?php echo $row["jumlah_peserta"]; ?> Orang</td>
												<td><i class="fa fa-money" aria-hidden="true"></i> <?php echo rupiah($row["harga"]); ?></td>
											</tr>
											<tr>
												<td height="80px"><?php echo $row["tanggal_pelaksanaan"]; ?> </td><td><i class="fa fa-user" aria-hidden="true"></i> 
												<?php if($row["sisa"] >0 && strtotime($row["tawal"]) > strtotime(date("Y-m-d"))){ ?>
												<span class="text-danger">Sisa <?php echo $sisa; ?> Kursi
												<?php } else { ?>
												<span class="badge badge-danger">Fully Booked</span>
												<?php }?>
												
												</td>
											</tr>
										</table>
										<div class="card-footer"><a href="<?= GetUrl('detail-pelatihan/view/'.$row["pelatihan_id"]) ?>" class="btn btn-success stretched-link btn-lg btn-block">Lihat Detail</a></div>
									</div>
								</div>
							</div>
							<?php
								$i++;
									}
							?>

						</div>
					</div>
				</div>
	
			</div>
		</div>
	</section>	

	<section class="content-section">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-bold mb-4">Fasilitas</h3>
				<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						
						<!-- Slide 1 -->
						<div class="carousel-item active">
						<div class="row justify-content-center">
							<div class="col-12 text-center">
							<img src="images/fasilitas/perpustakaan.png" style="width:70%; height:300px !important;" alt="Perpustakaan">
							<h6 class="text-bold mt-3 text-secondary">PERPUSTAKAAN</h6>
							</div>
						</div>
						</div>

						<!-- Slide 2 -->
						<div class="carousel-item">
						<div class="row justify-content-center">
							<div class="col-12 text-center">
							<img src="images/fasilitas/simulation_center.png" style="width:70%; height:300px !important;" alt="Simulation Center">
							<h6 class="text-bold mt-3 text-secondary">SIMULATION CENTER</h6>
							</div>
						</div>
						</div>

						<!-- Slide 3 -->
						<div class="carousel-item">
						<div class="row justify-content-center">
							<div class="col-12 text-center">
							<img src="images/fasilitas/auditorium.png" style="width:70%; height:300px !important;" alt="Auditorium">
							<h6 class="text-bold mt-3 text-secondary">AUDITORIUM</h6>
							</div>
						</div>
						</div>

						<!-- Slide 4 -->
						<div class="carousel-item">
						<div class="row justify-content-center">
							<div class="col-12 text-center">
							<img src="images/fasilitas/fasilitas-asrama.png" style="width:70%; height:300px !important;" alt="Asrama">
							<h6 class="text-bold mt-3 text-secondary">ASRAMA</h6>
							</div>
						</div>
						</div>

						<!-- Slide 5 -->
						<div class="carousel-item">
						<div class="row justify-content-center">
							<div class="col-12 text-center">
							<img src="images/fasilitas/ruang_kelas.png" style="width:70%; height:300px !important;" alt="Ruang Kelas">
							<h6 class="text-bold mt-3 text-secondary">RUANG KELAS</h6>
							</div>
						</div>
						</div>

						<!-- Slide 6 -->
						<div class="carousel-item">
						<div class="row justify-content-center">
							<div class="col-12 text-center">
							<img src="images/fasilitas/laboratorium.png" style="width:70%; height:300px !important;" alt="Laboratorium">
							<h6 class="text-bold mt-3 text-secondary">LABORATORIUM</h6>
							</div>
						</div>
					</div>	
				</div>
			</div>

			<!-- Controls (Previous and Next) -->
			<a class="carousel-control-prev" href="#carouselExampleSlidesOnly" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleSlidesOnly" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
			</div>
	</section>

	<section class="content-section">
	<div class="container">
		<h3 class="text-center text-bold mt-5 mb-4">Testimoni alumni</h3>
			<center>
			<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
			  <div class="carousel-inner">
					<?php
						$rs = ExecuteQuery("SELECT * FROM `w_testimoni` WHERE `show` = 'Y'");
						$count = 0;
						$i = 1;
						while ($row_testimoni = $rs->fetch()) {
						$active = "";
						if ($count % 4 == 0) {
							if($i == 1) $active = "active";
							echo "<div class='carousel-item ".$active."'><div class='row justify-content-center'>";
						}
					?>
					
					<div class="col-md-3 testimoni mb-2">
						<a href="<?= $row_testimoni["link_testimoni"]; ?>">
						<div class="col-12 p-0 m-0">
							<img class="p-0 m-0" style="border-radius:15px;width:100%" src="images/testimoni/<?php echo $row_testimoni["gambar"]; ?>" height="300px"></img>
							<div class="col-12" style="border-radius:15px;position: absolute; bottom: 0; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.5); /* Black see-through */ color: #f1f1f1; transition: .5s ease; color: white; font-size: 20px; padding-top: 300px; text-align: center;m-right:10px;"></div>
						</div>
						
						<h5 class="judul ml-5 mr-5">"<?= $row_testimoni["testimoni"]; ?>"</h5>
						</a>
					</div>
					
					<?php
					
						if ($count % 4 == 3) {
							echo "</div></div>";
						}

						$count++;
						$i++;
						}
					?>
			  </div>
			</div>
			</center>
	</section>

	<section class="content-section">
		<div class="container">		
			<h3 class="text-center text-bold mb-5 mt-5">Media Sosial</h3>
			<div class="container mb-5">
			
			<ul class="nav nav-pills nav-fill mb-3 text-center row" id="pills-tab" role="tablist">
						<li class="nav-item col-md-3 col-12">
						<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link active" id="pills-instagram-tab" data-toggle="pill" href="#pills-instagram" role="tab" aria-controls="pills-instagram" aria-selected="true"><i class="fab fa-instagram"></i> INSTAGRAM</a>
						</li>
						<li class="nav-item col-md-3 col-12">
						<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link" id="pills-tiktok-tab" data-toggle="pill" href="#pills-tiktok" role="tab" aria-controls="pills-tiktok" aria-selected="false"><i class="fab fa-tiktok"></i> TIKTOK</a>
						</li>
						<li class="nav-item col-md-3 col-12">
						<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link" id="pills-youtube-tab" data-toggle="pill" href="#pills-youtube" role="tab" aria-controls="pills-youtube" aria-selected="true"><i class="fab fa-youtube"></i> YOUTUBE</a>
						</li>
						<li class="nav-item col-md-3 col-12">
						<a style="padding: 6px;padding-right: 1px;padding-left: 1px;" class="nav-link" id="pills-facebook-tab" data-toggle="pill" href="#pills-facebook" role="tab" aria-controls="pills-facebook" aria-selected="true"><i class="fab fa-facebook"></i> FACEBOOK</a>
						</li>
                    </ul>
					
					<div class="tab-content mb-5" style="z-index:1;">
					
						<div class="tab-pane fade show active" id="pills-instagram" role="tabpanel" aria-labelledby="pills-instagram-tab">
							<!-- Instagram Embed Script -->
							<script src="https://cdn2.woxo.tech/a.js#66c5a0ac34674ed437f7b09e" async data-usrc></script>
							<div class="elfsight-app-c0ba69ff-8b36-40f8-8eb3-758a5d633c90"></div>
						</div>
						<div class="tab-pane fade" id="pills-tiktok" role="tabpanel" aria-labelledby="pills-tiktok-tab">
							<!-- TikTok Embed Script -->
							<script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
							<div class="elfsight-app-91337aaf-cefd-4752-80dc-88a335265f76"></div>
						</div>
						<div class="tab-pane fade" id="pills-youtube" role="tabpanel" aria-labelledby="pills-youtube-tab">
							<!-- YouTube Embed Script -->
							<div data-mc-src="3662baff-3223-406a-afac-c6af840677d1#youtube"></div>
							<script src="https://cdn2.woxo.tech/a.js#656f9f772d45de716bdbffc3" async data-usrc></script>
						</div>
						<div class="tab-pane fade" id="pills-facebook" role="tabpanel" aria-labelledby="pills-facebook-tab">
							<!-- Facebook Embed Script -->
							<script src="https://cdn2.woxo.tech/a.js#66c5a0ac34674ed437f7b09e" async data-usrc></script>
							<div data-mc-src="c02aab12-d0ef-4899-8393-dc7b26758007#null"></div>
						</div>
					</div>
			</script>
		</div>
	</section>



	

</main>



<?php echo myfooter(); ?>


<div class="modal fade" id="ListPelatihan" tabindex="-1" role="dialog" aria-labelledby="ListPelatihan" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ListPelatihan">JADWAL PELATIHAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

	  
<div class="modal-body">
  <div class="container-fluid">
    <div class="row">
    <?php
		$rs = ExecuteQuery("SELECT `judul_pelatihan` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `tawal` >= CURRENT_DATE() AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') GROUP BY `judul_pelatihan`");
		$i=1;
		while ($row1 = $rs->fetch()) {
	?>
		<div class="col-lg-4">
		<div class="mb-3 p-0 pb-2" style="border:0;box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);">
		<p class="p-2" style=" height: 87px;"><?php echo $row1["judul_pelatihan"]; ?></p>
		<?php
			$rs2 = ExecuteQuery("SELECT `pelatihan_id`, `judul_pelatihan`, `tawal`, `jumlah_hari`, `tempat`, `jumlah_peserta`, `sisa`, `harga`, `tanggal_pelaksanaan`, `gambar`, `Last_Updated`, `Created_Date` FROM `w_pelatihan` WHERE `Activated` = 'Y' AND `judul_pelatihan` = '".$row1["judul_pelatihan"]."' AND `jenis_pelatihan` IN ('ekspor','metrologi','mutu','jasa_perdagangan','webinar') ORDER BY `tawal` ASC");
			$i=1;
			while ($row2 = $rs2->fetch()) {
		?>
		<div class="row m-1">
			<?php 
				if ($row2["tawal"] < date("Y-m-d") || $row2["sisa"] <=0){
			?>

			
			<div class="col-8 text-sm-left" style="border:2px solid #babababa;padding:2px;border-right:none;border-radius:0.25rem 0 0 0.25rem;font-size:14pt;color:#bababa"><del><?php echo $row2["tanggal_pelaksanaan"]; ?></del></div>
			<div class="col-4" style="border:2px solid #babababa;padding:2px;border-radius:0 0.25rem 0.25rem 0;">
								<table><tr><td><i class="fa fa-user" aria-hidden="true" style="font-size:25px;color:#bababa;"></i></td>
								
								<td style="font-size:8pt;margin:0;padding:0;padding-left:5px;color:#bababa"><del>penuh</del></td>
								
								
								</tr></table>
			</div>
			
			<?php
					
				} else {
					$link = GetUrl('detail-pelatihan/view/'.$row2["pelatihan_id"]);
			?>
			
			<a href="<?php echo $link; ?>" class="row" style="text-decoration:none;color:#000;padding:0;margin:0;">
			<div class="col-8 text-sm-left" style="border:2px solid #babababa;padding:2px;border-right:none;border-radius:0.25rem 0 0 0.25rem;font-size:14pt"><?php echo $row2["tanggal_pelaksanaan"]; ?></div>
			<div class="col-4" style="border:2px solid #babababa;padding:2px;border-radius:0 0.25rem 0.25rem 0;">
								<table style="margin:0;padding:0;"><tr><td rowspan="2"><i class="fa fa-user" aria-hidden="true" style="font-size:25px;"></i></td>
								
								<td style="font-size:8pt;margin:0;padding:0;padding-left:5px;vertical-align:bottom;"><?php echo $row2["jumlah_peserta"]; ?> orang</td><tr><td class="<?php if($row2["sisa"]>5){ echo "text-success"; } else { echo "text-danger"; } ?>" style="font-size:8pt;margin:0;padding:0;padding-left:5px;vertical-align:top;">sisa <?php echo $row2["sisa"]; ?> orang</td>
								
								
								</tr></table>
			</div>
			</a>
			
			<?php
				
				}
			?>
		</div>
		<?php
			}
		?>
		</div>
	</div>
	<?php
		}
	?>
	</div>
  </div>
</div>

    </div>
  </div>
</div>


<?php 
	$ambilpopup = ExecuteRow("SELECT `Popup_Show`,`Popup_Picture`, `Popup_Link` FROM `w_settings` WHERE `ID` = 1");
	$Popup_Picture = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"),$ambilpopup["Popup_Picture"]);
	$Popup_Link = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"),$ambilpopup["Popup_Link"]);
	
	if($ambilpopup["Popup_Show"] == 1 && !empty($ambilpopup["Popup_Picture"]) ){
		
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
	$(window).on('load', function() {
		$('#popup-ppejp').modal('show');
		/*$('#popup-ppejp').modal({backdrop: 'static', keyboard: false}, 'show');*/
	});
</script>


		<div class="modal fade" id="popup-ppejp" tabindex="-1" role="dialog" aria-labelledby="popup-ppejp" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
				  <?php foreach ($Popup_Picture as $i => $gambaran): ?>
					<li data-target="#carouselIndicators" data-slide-to="<?= $i; ?>" class="<?= $i === 0 ? ' active' : ''; ?>"></li>
					 <?php endforeach; ?>
				  </ol>
				   <div class="carousel-inner">
					<?php foreach ($Popup_Picture as $i => $gambaran): ?>
					<div class="carousel-item<?= $i === 0 ? ' active' : ''; ?>">
					  <a href="<?= $Popup_Link[$i]; ?>"><img class="d-block w-100" src="images/popup/<?= $Popup_Picture[$i]; ?>" alt="First slide" style="border-radius: 10px;"></a>
					</div>
					 <?php endforeach; ?>
				  </div>
				  <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
			  </div>
			</div>
		  </div>
		</div>

	<?php } ?>

<?= GetDebugMessage() ?>
