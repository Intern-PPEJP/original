<?php

namespace PHPMaker2021\ppejp_web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // pages
    $app->group(
    '/pages',
    function (\Slim\Routing\RouteCollectorProxy $group) {
        $group->any('/' . Config("VIEW_ACTION") . '[/{custom_url}]', WPagesController::class . ':view')->add(PermissionMiddleware::class)->setName('pages/view-w_pages-view-3'); // view
    }
    );

    // detail pelatihan
	$app->group(
		'/detail-pelatihan',
		function (\Slim\Routing\RouteCollectorProxy $group) {
				$group->any('/' . Config("VIEW_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':view')->add(PermissionMiddleware::class)->setName('detail-pelatihan/view-w_pelatihan-view-3'); // view
		}
	);
	
	// detail webinar
	$app->group(
		'/detail-webinar',
		function (\Slim\Routing\RouteCollectorProxy $group) {
				$group->any('/' . Config("VIEW_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':view')->add(PermissionMiddleware::class)->setName('detail-webinar/view-w_pelatihan-view-4'); // view
		}
	);

	// detail ecp
	$app->group(
		'/detail-ecp',
		function (\Slim\Routing\RouteCollectorProxy $group) {
				$group->any('/' . Config("VIEW_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':view')->add(PermissionMiddleware::class)->setName('detail-ecp/view-w_pelatihan-view-5'); // view
		}
	);
	
  // exportcoachingprogram 
    $app->any('/export-coaching-program[/{params:.*}]', ExportcoachingprogramController::class)->add(PermissionMiddleware::class)->setName('exportcoachingprogram-exportcoachingprogram-custom'); // custom

    // obrolanekspor
    $app->any('/obrolan-ekspor[/{params:.*}]', ObrolaneksporController::class)->add(PermissionMiddleware::class)->setName('obrolan-ekspor-obrolanekspor-custom2'); // custom

    // pelatihanekspor
    $app->any('/pelatihan-ekspor[/{params:.*}]', PelatihaneksporController::class)->add(PermissionMiddleware::class)->setName('pelatihanekspor-pelatihanekspor-custom'); // custom

    // pelatihanmetrologi
    $app->any('/pelatihan-metrologi[/{params:.*}]', PelatihanmetrologiController::class)->add(PermissionMiddleware::class)->setName('pelatihanmetrologi-pelatihanmetrologi-custom'); // custom
    // pelatihanmutu
    $app->any('/pelatihan-mutu[/{params:.*}]', PelatihanmutuController::class)->add(PermissionMiddleware::class)->setName('pelatihanmutu-pelatihanmutu-custom'); // custom

    // pelatihanjasaperdagangan
    $app->any('/pelatihan-jasa-perdagangan[/{params:.*}]', PelatihanjasaperdaganganController::class)->add(PermissionMiddleware::class)->setName('pelatihanjasaperdagangan-pelatihanjasaperdagangan-custom'); // custom

    // tentangkami
    $app->any('/tentang-kami[/{params:.*}]', TentangkamiController::class)->add(PermissionMiddleware::class)->setName('tentangkami-tentangkami-custom'); // custom

    // SERTIFIKASI KOMPETENSI
    $app->any('/sertifikasi-kompetensi[/{params:.*}]', SertifikasikompetensiController::class)->add(PermissionMiddleware::class)->setName('sertifikasikompetensi-sertifikasikompetensi-custom'); // custom

    // tentangbpmjp
    $app->any('/tentang-bpmjp[/{params:.*}]', TentangbpmjpController::class)->add(PermissionMiddleware::class)->setName('tentangbpmjp-tentangbpmjp-custom'); // custom

    // LSP PPEJP
    $app->any('/lsp-ppejp[/{params:.*}]', LspppejpController::class)->add(PermissionMiddleware::class)->setName('lspppejp-lspppejp-custom'); // custom

    // LSP BPMJP
    $app->any('/lsp-bpmjp[/{params:.*}]', LspbpmjpController::class)->add(PermissionMiddleware::class)->setName('lspbpmjp-lspbpmjp-custom'); // custom

    // informasi-pelatihan
    $app->any('/kontak[/{params:.*}]', InformasipelatihanController::class)->add(PermissionMiddleware::class)->setName('informasi-pelatihan-custom'); // custom


    $app->group(
        '/pencarian',
        function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', CaridataController::class . ':list')->add(PermissionMiddleware::class)->setName('pencarian/list-caridata-list-3'); // list
        }
    );
	

}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function myheader(){
?>
<!-- font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<!-- format phone -->
<link href="<?= GetUrl('dirku/cssku/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= GetUrl('dirku/cssku/bootstrap-icons.css') ?>" rel="stylesheet">
<link href="<?= GetUrl('dirku/cssku/cscs.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	body,.h1,.h2,.h3,.h4,.h5,.h6,body,h1,h2,h3,h4,h5,h6,p { font-family: 'Poppins', sans-serif !important; }
	.main-header #ew-navbar .nav-item { padding: 10px; }
	.content-header { background: #031A31; margin-bottom: 15px; } .content-header h1 { color: #ffffff !important }
	button.close span { font-size: 25px; background: #ff1800; border-radius: 10px; padding-right: 10px; padding-left: 10px; }
	#fcari {
		position: absolute;
		z-index: 99;
		width: 200px !important;
		left: 194px;
		top: 10px;
		flex-grow: 1; /* Agar kotak pencarian mengambil ruang yang tersisa */
		margin-left: 20px; /* Jarak antara logo dan kotak pencarian */
		font-size: 16px;
	}

	@media screen and (max-width: 768px) { /* mobile view */
		#fcari {
			position: static;
			width:100% !important;
			margin-left: 0; /* Reset margin pada tampilan mobile */
		}
		
		.header {
			flex-direction: column;
			align-items: flex-start; /* Agar logo dan kotak pencarian berada di atas-bawah */
    }
	}
	
	.header {
		display: flex;
		align-items: center;
		justify-content: space-between; /* Agar logo dan kotak pencarian berada di ujung yang berlawanan */
		padding: 10px;
	}

    p, table, div, ul, li {
    font-size: 16px;
	}
	
	h2{
		font-size: 20px;
	}

	h3{
		font-size: 18px;
	}

	.logo {
    	margin-left: 20px; /* Ganti angka ini dengan jumlah jarak yang diinginkan */
		height: auto;
	}
</style>

<script>
// Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
  $('.dropdown-menu a').click(function(e){
    e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
     $(this).find('.submenu').hide();
  })
  });
}
</script>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding:0;">
	<a class="navbar-brand" href="<?= GetUrl('home')?>">
		<img src="<?= GetUrl('images/logo-kemendag.png') ?>" class="logo" alt="PPEJP | Pusat Pelatihan Sumber Daya Manusia Ekspor dan Jasa Perdagangan (PPEJP) merupakan lembaga yang berada di lingkungan Sekretariat Jenderal, Kementerian Perdagangan. PPEJP mempunyai tugas melaksanakan pengembangan sumber daya manusia ekspor, mutu, personil metrologi legal, dan jasa perdagangan untuk dunia usaha dan masyarakat.">
	</a>
		 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
			<ul class="navbar-nav ms-auto mr-3">
				<li class="nav-item">
					<a class="nav-link click-scroll" href="<?= GetUrl('home') ?>">Beranda</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tentang Kami</a>
					<ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
						<li><a class="dropdown-item" href="<?= GetUrl('tentang-kami') ?>">Pusat Pelatihan SDM Ekspor dan <br>Jasa Perdagangan (PPEJP)</a></li>
						<li><a class="dropdown-item" href="<?= GetUrl('tentang-bpmjp') ?>">Balai Pelatihan SDM Metrologi, Mutu <br>dan Jasa Perdagangan (BPMJP)</a></li>
						<li><a class="dropdown-item dropdown-toggle" href="#">Lembaga Sertifikasi Profesi (LSP)</a>
							<ul class="submenu dropdown-menu">
								<li><a class="dropdown-item" href="<?= GetUrl('lsp-ppejp') ?>">LSP PPEJP</a></li>
								<li><a class="dropdown-item" href="<?= GetUrl('lsp-bpmjp') ?>">LSP BPMJP</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kegiatan</a>
					<ul class="dropdown-menu" aria-labelledby="navbarLightDropdownMenuLink" id="sub-pelatihan">
						<li><a class="dropdown-item dropdown-toggle" href="<?= GetUrl('pelatihan') ?>">Pelatihan</a>
							<ul class="submenu dropdown-menu">
								<li><a class="dropdown-item" href="<?= GetUrl('pelatihan-ekspor') ?>">Pelatihan Ekspor</a></li>
								<li><a class="dropdown-item" href="<?= GetUrl('pelatihan-metrologi') ?>">Pelatihan Metrologi</a></li>
								<li><a class="dropdown-item" href="<?= GetUrl('pelatihan-mutu') ?>">Pelatihan Mutu</a></li>
								<li><a class="dropdown-item" href="<?= GetUrl('pelatihan-jasa-perdagangan') ?>">Pelatihan Jasa Perdagangan</a></li>
							</ul>
						</li>
						<li><a class="dropdown-item font-italic" href="<?= GetUrl('export-coaching-program') ?>">Export Coaching Program</a></li>
						<li><a class="dropdown-item" href="<?= GetUrl('webinar') ?>">Webinar</a></li>
						<li><a class="dropdown-item" href="https://kudagang.kemendag.go.id/" target="_blank">KUDAGANG</a></li>
						<li><a class="dropdown-item" href="<?= GetUrl('obrolan-ekspor') ?>">Obrolan Ekspor</a></li>
						<li><a class="dropdown-item" href="<?= GetUrl('sertifikasikompetensi') ?>">Sertifikasi Kompetensi</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="<?= GetUrl('kontak') ?>">Kontak</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= GetUrl('berita') ?>">Berita</a>
				</li>
				<?php if (IsLoggedIn()) { 
				?>
				<!--<li class="nav-item dropdown">
					<a class="nav-link" href="akun" style="font-size:35px;padding-top:5px;"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
					<ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
						<li><a class="dropdown-item" href="logout"><i class="fa fa-logout" aria-hidden="true"></i> Logout</a></li>
					</ul>
				</li>-->
				<?php
				} else { ?>
				<!--<li class="nav-item">
					<a class="nav-link" href="login" style=""><i class="fa fa-user" aria-hidden="true"></i> Masuk</a>
				</li>-->
				<?php } ?>
				<li class="nav-item ms-3">
					<a class="nav-link custom-btn custom-border-btn btn" href="<?= GetUrl('formpendaftaran') ?>"><p>Daftar Pelatihan</p></a>
				</li>
			</ul>
		</div>
</nav>
<form name="fcari" id="fcari" class="ew-form ew-login-form" action="<?= GetUrl('caridatalist') ?>" method="get">
<div class="input-group p-2">
  <input type="hidden" name="cmd" value="search">
  <input type="hidden" name="t" value="caridata">
  <input type="text" class="form-control" id="psearch" name="psearch" placeholder="Pencarian..." aria-label="Pencarian..." aria-describedby="basic-addon2" value="<?php echo @$_GET["psearch"]; ?>" style="min-width:80px">
  <div class="input-group-append">
    <button class="btn btn-default" id="cari" type="submit" value="cari" style=" border: 1px solid #bbb; "><i class="fas fa-search" aria-hidden="true"></i> </button>
  </div>
</div>
</form>
<script>
$(document).ready(function(){
    $('#cari').attr('disabled',true);
    $('#psearch').keyup(function(){
        if($(this).val().length !=0)
            $('#cari').attr('disabled', false);            
        else
            $('#cari').attr('disabled',true);
    })
});
</script>
<?php
}

function myfooter (){
?>
<footer class="site-footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-12 mb-4">
				<h5 class="site-footer-title mb-3">INFORMASI KEGIATAN PPEJP</h5>
				<p class="text-white d-flex mb-4">
					Pusat Pelatihan SDM  Ekspor dan Jasa Perdagangan<br>
					Jl. Letjen S. Parman No. 112 Grogol, Jakarta Barat<br>
					Tel: 021-5674229 ext 106<br>
					Whatsapp: 0813 8835 6060<br>
					e-mail : promosi.ppejp@kemendag.go.id
				</p>
				<p class="text-white d-flex mb-2">
					Balai Pelatihan SDM Metrologi Mutu dan Jasa Perdagangan<br>
					Jl. Daeng Muhammad Ardiwinata KM 3,4 Kel. Cihanjuang, Kec. Parongpong, Kabupaten Bandung Barat, Jawa Barat 40559<br>
					Whatsapp: 0811 200 6666 4<br>
					e-mail : bpmjp@kemendag.go.id<br>
				</p>
			</div>
			<div class="col-lg-2 col-12 mb-4">
				<h5 class="site-footer-title mb-3">Navigation</h5>
				<ul class="footer-menu">
					<li class="footer-menu-item"><a href="<?= GetUrl('home') ?>" class="footer-menu-link"><i class="fa fa-chevron-right"></i> Beranda</a></li>
					<li class="footer-menu-item"><a href="<?= GetUrl('faq') ?>" class="footer-menu-link"><i class="fa fa-chevron-right"></i></i> FAQ</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-12 mb-4">
				<h5 class="site-footer-title mb-3">Quick Links</h5>
				<ul class="footer-menu">
					<li class="footer-menu-item"><a href="<?= GetUrl('pelatihan') ?>" class="footer-menu-link"><i class="fa fa-chevron-right"></i> Pelatihan</a></li>
					<li class="footer-menu-item"><a href="<?= GetUrl('export-coaching-program') ?>" class="footer-menu-link"><i class="fa fa-chevron-right"></i> Pendampingan</a></li>
					<li class="footer-menu-item"><a href="<?= GetUrl('obrolan-ekspor') ?>" class="footer-menu-link"><i class="fa fa-chevron-right"></i> Obrolan Ekspor</a></li>
					<li class="footer-menu-item"><a href="<?= GetUrl('webinar') ?>" class="footer-menu-link"><i class="fa fa-chevron-right"></i> Webinar</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-md-6 col-12 mx-auto">
				<h5 class="site-footer-title mb-3">Social Media</h5>
				<p class="text-white d-flex mb-2">
					<a href="https://www.facebook.com/PPEJP.Kemendag" class="footer-menu-link" target="_blank"><image src="<?= GetUrl('images/icons/facebook.png') ?>"></img> </a>
					<a href="https://www.instagram.com/ppejp.kemendag/" class="footer-menu-link" target="_blank"><image src="<?= GetUrl('images/icons/instagram.png') ?>"></img> </a>
					<a href="https://www.youtube.com/@PPEJPKemendag" class="footer-menu-link" target="_blank"><image src="<?= GetUrl('images/icons/youtube.png') ?>"></img> </a>
					<a href="https://www.tiktok.com/@ppejp.kemendag/" class="footer-menu-link" target="_blank"><image src="<?= GetUrl('images/icons/tiktok.png') ?>"></img> </a>
				</p>
			</div>
		</div>
	</div>
</footer>
<?php
}

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
}

function tanggal_indo($tanggal)
{
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
