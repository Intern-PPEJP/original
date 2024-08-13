<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "PPEIsip";
$dbPassword = "GoSIPP3I20";
$dbName     = "ppei_sip20";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
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

if(!empty($_POST["id"])){
	date_default_timezone_set('Asia/Jakarta');
	
    // Include the database configuration file
    $_POST["id"] = date("Y-m-d H:i:s", $_POST["id"]);
	//echo $_POST["id"]." vs ".date("Y-m-d H:i:s");
    // Count all records except already displayed
    $query = $db->query("SELECT COUNT(*) as num_rows FROM `w_berita` WHERE publish='Y' AND tanggal_publikasi < '".$_POST['id']."' ORDER BY tanggal_publikasi DESC");
    $row = $query->fetch_assoc();
    $totalRowCount = $row['num_rows'];
    
    $showLimit = 4;
    
    // Get records from the database
    $query = $db->query("SELECT id,gambar,judul,tanggal_publikasi,DATE_FORMAT(tanggal_publikasi,'%Y-%m-%d') tanggal FROM `w_berita` WHERE publish='Y' AND tanggal_publikasi < '".$_POST['id']."' ORDER BY  tanggal_publikasi DESC LIMIT ".$showLimit);
    if($query->num_rows > 0){ 
        while($row = $query->fetch_assoc()){
			$gambar = explode(",",$row["gambar"]);
            $postID = strtotime($row["tanggal_publikasi"]);
    ?>
		<div class="col-md-3 mb-4">
		<a href="berita?baca=<?php echo $row["id"]; ?>" style="color:#000;text-decoration:none;"> 
				<div style="background-image: url('images/news/<?php echo $gambar[0]; ?>'); background-size: cover;height: 200px;border-radius: 10px;">
				</div>
				<div style="font-size:.8em; color: #000;  font-weight: 900;" class="mb-1text-left">
				   
				<?php echo $row["judul"]; ?>
				</div>
				<div style="font-size:.8em; color: gray;" class="mt-2">
					<?php echo tanggal_indo($row["tanggal"]); ?>
				</div>
		</a>
		</div>
    <?php } ?>
    <?php if($totalRowCount > $showLimit){ ?>
      
           <div class="show_more_main" id="show_more_main<?php echo $postID; ?>" style="text-align:right;">
				<a href="javascript:void(0)"  id="<?php echo $postID; ?>" style="font-size: 1.2em; font-weight: 600;text-decoration:none;color: #fff;background: #031a31;padding:10px;" class="show_more" title="Load more posts">Berita Lainnya <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
				<span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
			</div>
        
  
    <?php } ?>
<?php
    }
}
?>