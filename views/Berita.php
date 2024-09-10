<?php

namespace PHPMaker2021\ppejp_web;

// Page object
$Berita = &$Page;
?>
<?php echo myheader(); ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    /* Mengatur font default dan ukuran teks */
    body, p, table, div {
        font-family: 'Poppins', sans-serif !important;
        /* Menggunakan font Poppins */
        font-size: 16px !important;
        /* Ukuran teks 16px */
    }

    /* Mengatur ukuran heading */
    h1 {
        font-size: 25px !important;
        font-family: 'Poppins', sans-serif !important;
    }

    h2 {
        font-size: 20px !important;
        font-family: 'Poppins', sans-serif !important;
    }

    h3 {
        font-size: 18px !important;
        font-family: 'Poppins', sans-serif !important;
    }

    /* Mengatur ukuran teks di dalam berita */
    .text-justify {
        font-size: 16px !important;
        /* Ukuran teks di dalam berita */
        font-family: 'Poppins', sans-serif !important;
    }

    * {
    font-family: 'Poppins', sans-serif !important;
    }

</style>
-->
<div class="container-fluid mb-3" style="background-color: #031A31; padding:20px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class='m-0' style="color: white;font-weight:bold">BERITA</h1>
            </div>
        </div>
    </div>
</div>

<?php if (empty(@$_GET["baca"])) { ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.show_more', function() {
                var ID = $(this).attr('id');
                $('.show_more').hide();
                $('.loding').show();
                $.ajax({
                    type: 'POST',
                    url: 'dirku/ambildata.php',
                    data: 'id=' + ID,
                    success: function(html) {
                        $('#show_more_main' + ID).remove();
                        $('.postList').append(html);
                    }
                });
            });
        });
    </script>

    <div class="container grid pb-5">
        <div class="row">
            <div class="col-md-12 p-0">
                <h3 style="margin-bottom:0;background: #031a31;border-radius: 0 90px 0 0;padding: 5px 20px ;color: #fff;width:300px;">Berita Terbaru</h3>
            </div>
        </div>

        <?php
        date_default_timezone_set('Asia/Jakarta');
        $last_berita = ExecuteRow("SELECT id,gambar,judul,DATE_FORMAT(tanggal_publikasi,'%Y-%m-%d') tanggal FROM `w_berita` WHERE publish='Y' ORDER BY tanggal_publikasi DESC LIMIT 1");
        ?>

        <div class="row mb-5"><?php $gambar_terbaru = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $last_berita["gambar"]); ?>
            <a href="berita?baca=<?php echo $last_berita["id"]; ?>" style="color:#fff;text-decoration:none;padding:0;">
                <div class="col-md-12 p-0">
                    <div style="background-image: url('images/news/<?php echo $gambar_terbaru[0]; ?>');background-repeat:no-repeat; background-position: center center; background-size: cover;height: 450px; display: flex; flex-direction: column; justify-content: flex-end; color: #fff;border-radius: 0px 10px 10px 10px;">
                        <div style="background:#031a31bf; padding:10px 30px 10px 30px ;border-radius: 0px 0px 10px 10px;">
                            <h4><?php echo $last_berita["judul"]; ?></h4>
                            <div><?php echo tanggal_indo($last_berita["tanggal"]); ?></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="row postList mb-5">
            <?php
            $sql = "SELECT id,gambar,judul,tanggal_publikasi,DATE_FORMAT(tanggal_publikasi,'%Y-%m-%d') tanggal FROM `w_berita` WHERE publish='Y' ORDER BY tanggal_publikasi DESC LIMIT 1,12"; // define your SQL
            $stmt = ExecuteQuery($sql); // execute the query
            $value = ""; // initial value

            if ($stmt->rowCount() > 0) { // check condition: if record count is greater than 0
                while ($row = $stmt->fetch()) { // loop
                    $gambar = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $row["gambar"]);
                    $postID = strtotime($row["tanggal_publikasi"]);
            ?>
                    <div class="col-md-3 mb-4">
                        <a href="berita?baca=<?php echo $row["id"]; ?>" style="color:#000;text-decoration:none;">
                            <div style="background-image: url('images/news/<?php echo $gambar[0]; ?>'); background-size: cover;height: 200px;border-radius: 10px;">
                            </div>
                            <div style="font-weight: 500;" class="mb-1text-left">
                                <?php echo $row["judul"]; ?>
                            </div>
                            <div style="color: gray;" class="mt-2">
                                <?php echo tanggal_indo($row["tanggal"]); ?>
                            </div>
                        </a>
                    </div>

                <?php
                } // end loop
                ?>
                <div class="show_more_main mb-3 mt-2" id="show_more_main<?php echo $postID; ?>" style="text-align:right;">
                    <a href="javascript:void(0)" id="<?php echo $postID; ?>" style="font-weight: 600;text-decoration:none;color: #fff;background: #031a31;padding:10px;" class="show_more" title="Load more posts">Berita Lainnya <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                </div>
            <?php
            } else { // if there are no result
                echo "No record found."; // display the message
            } // end of check condition
            ?>
        </div>
    </div>

    <script>
        document.title = "Berita Terbaru"
    </script>

<?php } else { ?>

    <?php
    $lihat_berita = ExecuteRow("SELECT id,gambar,judul,isi,DATE_FORMAT(tanggal_publikasi,'%Y-%m-%d') tanggal FROM `w_berita` WHERE publish='Y' AND  id = " . @$_GET["baca"] . " ORDER BY tanggal_publikasi DESC LIMIT 1");
    $gambar_detail_berita = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $lihat_berita["gambar"]);
    if (empty($lihat_berita["id"])) {
        CurrentPage()->terminate("berita");
    } else {
    ?>

        <script>
            document.title = '<?php echo $lihat_berita["judul"]; ?>'
        </script>
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8">
                    <h2><?php echo $lihat_berita["judul"]; ?></h2>
                    <div style="color: gray;" class="mt-2 mb-3"><?php echo tanggal_indo($lihat_berita["tanggal"]); ?></div>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($gambar_detail_berita as $i => $gambaran): ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i; ?>" class="<?= $i === 0 ? ' active' : ''; ?>""></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class=" carousel-inner">
                                    <?php foreach ($gambar_detail_berita as $i => $gambaran): ?>
                                        <div class="carousel-item<?= $i === 0 ? ' active' : ''; ?>">
                                            <img class="d-block w-100" src="images/news/<?= $gambar_detail_berita[$i]; ?>" alt="First slide" style="border-radius: 10px;">
                                        </div>
                                    <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="text-justify" style=""><?php echo $lihat_berita["isi"]; ?></div>
            </div>
            <div class="col-md-4">
                <h3 style="margin-bottom:10px;background: #031a31;border-radius: 0 53.1rem 0 0;padding: 5px;color: #fff;">Berita Lainnya</h3>

                <?php
                $sql = "SELECT id,gambar,judul,DATE_FORMAT(tanggal_publikasi,'%Y-%m-%d') tanggal FROM `w_berita` WHERE publish='Y' AND id != " . @$_GET["baca"] . " ORDER BY tanggal_publikasi DESC LIMIT 3"; // define your SQL
                $stmt = ExecuteQuery($sql); // execute the query
                $value = ""; // initial value
                if ($stmt->rowCount() > 0) { // check condition: if record count is greater than 0
                    while ($data3 = $stmt->fetch()) { // loop
                        $gambar_berita_lain = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $data3["gambar"]);
                ?>
                    <a href="berita?baca=<?php echo $data3["id"]; ?>" style="color:#000;text-decoration:none;">
                        <div class="row" style="padding:5px;">
                            <div class="col-md-12 mb-3">
                                <div style="background-image: url('images/news/<?php echo $gambar_berita_lain[0]; ?>'); background-size: cover;height: 200px;border-radius: 10px;"></div>
                                <div style="color: #000;  font-weight: 500;" class="mb-1text-left">
                                    <?php echo $data3["judul"]; ?>
                                </div>
                                <div style="color: gray;" class="mt-2">
                                    <?php echo tanggal_indo($data3["tanggal"]); ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php

                    } // end loop

                } else { // if there are no result
                    echo "No record found."; // display the message
                } // end of check condition
                ?>
            </div>
        </div>
    </div>
<?php
    }
}
?>

<?php echo myfooter(); ?>

<?= GetDebugMessage() ?>