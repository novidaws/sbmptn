<?
	$serverName = "localhost";
	$userName = "root";
	$password = "";
	$dbName = "sbmptn_normalized";

	$conn = mysql_connect($serverName, $userName, $password);
	mysql_select_db($dbName, $conn);

	// Check connection
	if (!$conn) {
	    die("Connection failed: ");
	}else{
		$nomorPeserta = $_GET["nomor"];
		$sql = "select a.nomor, case when b.nomor is NULL then 0 else 1 end isLulus, a.nama, ";
		$sql .= "a.tgl_lahir, b.kode_prodi, b.kode_univ, c.nama_prodi, d.nama_univ, d.url_univ ";
		$sql .= "from peserta a ";
		$sql .= "left join result b on a.nomor = b.nomor ";
		$sql .= "inner join prodi c on b.kode_prodi = c.kode_prodi ";
		$sql .= "inner join univ d on b.kode_univ = d.kode_univ where a.nomor = '".$nomorPeserta."'";
	
//echo $sql;
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysql_fetch_array($result)) {
			echo "Nomor: ".$row["nomor"]."<br>";
			echo "Nama: ".$row["nama"]."<br>";
			echo "Tanggal Lahir: ".$row["tgl_lahir"]."<br>";
			if($row["isLulus"] == 0){
				echo "Maaf, anda tidak lulus SBMPTN.<br>";
			}else{
				echo "Selamat! Anda lulus SBMPTN<br>";
				echo "Pada Program Studi ".$row["nama_prodi"]." <a href='".$row["url_univ"]."'>".$row["nama_univ"]."</a><br>";
			}
		    }
		} else {
		    echo "<i>Nomor peserta tidak terdaftar.</i>";
		}
		

	}
	
	
?>
