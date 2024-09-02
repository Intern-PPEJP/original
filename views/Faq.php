<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Faq = &$Page;
?>
<?php echo myheader(); ?>

<div class="container-fluid " style="background-color: #031A31; padding:20px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-0" style="color: white;font-weight:bold">FREQUENTLY ASKED QUESTIONS</h1>
            </div>
        </div>
    </div>
</div>


<style>
#main {
  margin: 50px 0;
  min-height: 300px;
}

#main #faq .card {
  margin-bottom: 30px;
  border: 0;
}

#main #faq .card .card-header {
  border: 0;
  -webkit-box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
          box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
  border-radius: 2px;
  padding: 0;
}

#main #faq .card .card-header .btn-header-link {
  display: block;
  text-align: left;
  font-size: 25px;
  font-weight:bold;
}

#main #faq .card .card-header .btn-header-link:after {
  content: "\f107";
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  float: right;
}

#main #faq .card .card-header .btn-header-link.collapsed:after {
  content: "\f106";
}

.card-body {
	padding-left: 80px;
	padding-right: 100px;
}

</style>


<div id="main">
  <div class="container mb-5">
		<div class="accordion" id="faq">
			<div class="card">
				<div class="card-header" id="faqhead1">
					<a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1"
					aria-expanded="true" aria-controls="faq1">PUSAT PELATIHAN SDM EKSPOR DAN JASA PERDAGANGAN</a>
				</div>

				<div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
					<div class="card-body">
						<p class="text-bold" style="margin-bottom:0;">Dimana Lokasi Pusat Pendidikan SDM Ekspor dan Jasa Perdagangan?</p>
						<p>Pusat Pelatihan SDM Ekspor dan Jasa Perdagangan (PPEJP) berlokasi di Jl. Letjen S. Parman No. 112 Grogol,  Kota Jakarta Barat, Provinsi DKI Jakarta 11440.</p>
						<p class="text-bold" style="margin-bottom:0;">Apakah semua peserta pelatihan PPEJP  mendapatkan sertifikat?</p>
						<p>Semua peserta pelatihan yang memenuhi tingkat kehadiran minimal 80% berhak mendapatkan sertifikat pelatihan dari PPEJP.</p>
						<p class="text-bold" style="margin-bottom:0;">Berapa lama durasi pelatihan PPEJP ?</p>
						<p>Pelatihan PPEJP memiliki durasi pelatihan yang berbeda. Pada umumnya pelatihan di PPEJP memiliki durasi pelatihan selama 3 hari, 4 hari, dan 7 hari.</p>
						<p class="text-bold" style="margin-bottom:0;">Apa saja fasilitas yang didapatkan ketika mengikuti pelatihan di PPEJP?</p>
						<p>Peserta pelatihan di PPEJP mendapatkan tas, alat tulis, makalah, snack pagi dan sore, makan siang, serta sertifikat.</p>
						<p class="text-bold" style="margin-bottom:0;">Apakah disediakan penginapan bagi peserta pelatihan?</p>
						<p>Biaya pelatihan yang dibayarkan belum termasuk biaya penginapan. Akan tetapi PPEJP memiliki asrama dengan harga terjangkau bagi peserta pelatihan. </p>
						<p class="text-bold" style="margin-bottom:0;">Apakah kurikulum pelatihan dapat disesuaikan dengan kebutuhan instansi/perusahaan?</p>
						<p>Salah satu keunggulan PPEJPP adalah kami dapat merancang kurikulum pelatihan sesuai dengan kebutuhan instansi/perusahaan.</p>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header" id="faqhead2">
					<a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq2"
					aria-expanded="true" aria-controls="faq2">BALAI PELATIHAN SDM METROLOGI, MUTU,  DAN JASA PERDAGANGAN</a>
				</div>

				<div id="faq2" class="collapse show" aria-labelledby="faqhead2" data-parent="#faq">
					<div class="card-body">
						<p class="text-bold" style="margin-bottom:0;">Dimana Lokasi Balai Pelatihan SDM Metrologi, Mutu, dan Jasa Perdagangan ?</p>
						<p>Balai Pelatihan SDM Metrologi Mutu dan Jasa Perdagangan berlokasi di Jl. Daeng Muhammad Ardiwinata KM 3.4 Kel. Cihanjuang, Kec. Parongpong, Kabupaten Bandung Barat, Jawa Barat 40559.</p>
						<p class="text-bold" style="margin-bottom:0;">Apakah biaya pelatihan sudah termasuk biaya penginapan?</p>
						<p>Biaya pelatihan belum termasuk penginapan biaya pelatihan hanya termasuk training kit, sertifikat, makan siang dan rehat kopi.</p>
						<p class="text-bold" style="margin-bottom:0;">Berapa biaya menginap di BPMJP?</p>
						<p>Sesuai PP No. 31 Tahun 2017 biaya menginap per hari adalah Rp300.000 dan per minggu adalah Rp500.000</p>
							<ul><li>Satu kamar dapat diisi oleh dua peserta</li></ul></p>
						<p class="text-bold" style="margin-bottom:0;">Apakah dengan mengikuti pelatihan di BPMJP akan dijamin kelulusannya?</p>
						<p>Peserta dinyatakan lulus apabila telah memenuhi standar kelulusan yang telah ditetapkan dalam kurikulum. Penetapan standard ini dimaksudkan agar peserta pelatihan dapat memenuhi standar kompetensi yang dipersyaratkan untuk tugas jabatannya dalam kegiatan metrologi, mutum dan jasa perdagangan.</p>
						<p class="text-bold" style="margin-bottom:0;">Apakah kurikulum pelatihan dapat disesuaikan dengan kebutuhan instansi/perusahaan?</p>
						<p>Salah satu keunggulan BPMJP adalah kami dapat merancang kurikulum pelatihan sesuai dengan kebutuhan instansi/perusahaan.</p>
					</div>
				</div>
			</div>
		</div>
    </div>
  </div>



<script>
    document.title = "FREQUENTLY ASKED QUESTIONS"
</script>


<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>
