<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Informasipelatihan = &$Page;
?>
<?php echo myheader(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
form:invalid [type="submit"] {
  pointer-events: none;
  border: 1px solid #999999;
  background-color: #CCCCCC;
  color: #666666;
}
</style>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold;">KONTAK</h1>
            </div>
        </div>
    </div>
</div>

<div class="container mb-4" style="margin-top:36px;">
    <div class="row"><h2 class="h1-responsive font-weight-bold text-center my-4">Hubungi Kami</h2>
		<div class="col-md-6 col-12">
			<section>
				<p class="text-justify w-responsive mx-auto mb-3">Untuk seputar pertanyaan dan informasi silahkan menghubungi kami dengan mengisi form dibawah ini</p>

				<div class="row">
					<div class="col-md-12 mb-md-0 mb-5">
						<form id="contact-form" name="contact-form" action="send.php" method="POST">

							<div class="row">

								<div class="col-md-12">
									<div class="md-form mb-0">
										<label for="name" class="mb-0">Kepada</label>
										 <select class="form-control w-100 mb-2" id="kepada" required >
										  <option>Silahkan pilih...</option>
										  <option value="PPEJP">PPEJP</option>
										  <option value="BPMJP">BPMJP</option>
										</select>
									</div>
								</div>
								<div class="col-md-12 inputan">
									<div class="md-form mb-0">
										<label for="name" class="mb-0">Perihal</label>
										 <select class="form-control w-100 mb-2" id="perihal" required>
										  <option>Silahkan pilih...</option>
										  <option value="1">Informasi Pelatihan</option>
										  <option value="2">Kerjasama Pelatihan</option>
										  <option value="3">Konsultasi</option>
										  <option value="4">Lain-lain</option>
										</select>
									</div>
								</div>
								<div class="col-md-12 inputan">
									<div class="md-form mb-0">
										<label for="nama" class=" mb-0">Nama</label>
										<input type="text" id="nama" name="nama" class="form-control w-100 mb-2" required>
									</div>
								</div>
								<div class="col-md-12 inputan">
									<div class="md-form mb-0">
										<label for="namap" class=" mb-0">Nama perusahaan</label>
										<input type="text" id="namap" name="namap" class="form-control w-100 mb-2" required>
									</div>
								</div>
								<div class="col-md-12 inputan">
									<div class="md-form mb-0">
										<label for="w_email" class=" mb-0">Alamat email</label>
										<input type="email" id="w_email" name="w_email" class="form-control w-100 mb-2" required>
									</div>
								</div>

								<div class="col-md-12 inputan">

									<div class="md-form">
										<label for="pesan" class=" mb-0">Pesan</label>
										<textarea type="text" id="pesan" name="pesan" rows="2" class="form-control md-textarea" required></textarea>
									</div>

								</div>
								<div class="col-md-12 inputan">
									<div class="text-center text-md-left">
										<a class="send_form btn btn-success mt-4 px-5" href="javascript:void" type="submit" title="Send to Whatsapp">Kirim</a>
										<div id="text-info" class="alert alert-info mt-5"></div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-6 col-12">
			<div id="map-ppejp">
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15866.740610310819!2d106.790633!3d-6.1728921!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f65e8a20c0ad%3A0x16686d34d44c12fb!2sPusat%20Pelatihan%20Sumber%20Daya%20Manusia%20Ekspor%20dan%20Jasa%20Perdagangan%20(PPEJP)!5e0!3m2!1sid!2sid!4v1682930206918!5m2!1sid!2sid" width="100%" height="580" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			
			</div>
			<div id="map-bpmjp">
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15845.190459814496!2d107.5694983!3d-6.8548862!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e5df4dc488b3%3A0xb14b834b4c7f78c0!2sBalai%20Pelatihan%20SDM%20Metrologi%2C%20Mutu%20dan%20Jasa%20Perdagangan!5e0!3m2!1sid!2sid!4v1691290146586!5m2!1sid!2sid" width="100%" height="580" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
		
		</div>
	</div>
</div>

<div style="margin-bottom:36px;">&nbsp;</div>


<script>
$("#text-info").hide();
$(document).on('click','.send_form', function(){
var input_wa = document.getElementById('kepada');

/* Whatsapp Settings */
var walink = 'https://web.whatsapp.com/send',
    phone = '6281388356060',
    wa_teks = 'Halo ',
    text_yes = 'Terkirim.',
    text_no = 'Isi semua Formulir lalu klik Send.';

/* Smartphone Support */
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
var walink = 'whatsapp://send';
}

if("" != input_wa.value){

 /* Call Input Form */
var input_kepada = $("#kepada :selected").text(),
    input_perihal = $("#perihal :selected").text(),
    input_nama = $("#nama").val(),
    input_namap = $("#namap").val(),
    input_email = $("#w_email").val(),
    input_pesan = $("#pesan").val();

/* Final Whatsapp URL */
var kirim_whatsapp = walink + '?phone=' + phone + '&text=' + wa_teks + '*' + input_kepada + '*, %0A%0A' +    
    '*Perihal* : ' + input_perihal + '%0A' +
	'*Nama* : ' + input_nama + '%0A' +
    '*Nama Perusahaan* : ' + input_namap + '%0A' +
    '*Alamat Email* : ' + input_email + '%0A' +
    '*Pesan* : ' + input_pesan + '%0A';

/* Whatsapp Window Open */
window.open(kirim_whatsapp,'_blank'); /* _blank  */
$("#text-info").show();
document.getElementById("text-info").innerHTML = '<span class="yes">'+text_yes+'</span>';
} else {
document.getElementById("text-info").innerHTML = '<span class="no">'+text_no+'</span>';
}
});



$("#map-bpmjp").hide();
$("#kepada").change(function(){
	if( $("#kepada").value() == "BPMJP" ) {
		$("#map-ppejp").hide();
		$("#map-bpmjp").show();
		$(".inputan").show();
	} else if( $("#kepada").value() == "PPEJP" ) {
		$("#map-ppejp").show();
		$("#map-bpmjp").hide();
		$(".inputan").show();
	} else {
		$(".inputan").hide();
		$("#map-bpmjp").hide();
		$("#map-ppejp").hide();
	}
	
});


document.title = "Kontak"
</script>
<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
