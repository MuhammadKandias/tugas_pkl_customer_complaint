<?php
session_start();

$query = "SELECT * FROM project where id_customer = '" . $_SESSION['data']['id_customer'] . "'";
$all_project = mysqli_query($koneksi, $query);
?>

<table class="responsive-table" border="2" style="width: 100%;">
	<tr>
		<td>
			<h4 class="blue-text hide-on-med-and-down">Tulis Laporan</h4>
		</td>
	</tr>
	<tr>
		<td style="padding: 20px;">
			<form method="POST" enctype="multipart/form-data">
				<!-- <textarea class="materialize-textarea" name="project" placeholder="Tulis Project"></textarea><br><br> -->
				<label for="project">Pilih Project:</label>
				<select name="project">
					<?php
					while ($project = mysqli_fetch_array($all_project, MYSQLI_ASSOC)) :;
					?>
						<option value="<?php echo $project["project"]; ?>">
							<?php echo $project["project"];
							?>
						</option>
					<?php
					endwhile;
					?>
				</select>
				<textarea class="materialize-textarea" name="fitur" placeholder="Tulis Fitur, Contoh: Registrasi"></textarea><br><br>
				<textarea class="materialize-textarea" name="subfitur" placeholder="Tulis Sub Fitur, Contoh: Tambah Pegawai"></textarea><br><br>
				<textarea class="materialize-textarea" name="laporan" placeholder="Tulis Laporan"></textarea><br><br>
				<label>File</label>
				<input type="file" name="lampiran"><br><br>
				<input type="submit" name="kirim" value="Kirim" class="btn">
			</form>
		</td>
	</tr>
</table>
<?php

if (isset($_POST['kirim'])) {
	$id_customer = $_SESSION['data']['id_customer'];
	$tgl = date('Y-m-d');


	$file = $_FILES['lampiran']['name'];
	$source = $_FILES['lampiran']['tmp_name'];
	$folder = './../img/';
	$listeks = array('jpg', 'png', 'jpeg', 'pdf', 'xlsx');
	$pecah = explode('.', $file);
	$eks = $pecah['1'];
	$size = $_FILES['lampiran']['size'];
	$nama = date('dmYis') . $file;

	if ($file != "") {
		if (in_array($eks, $listeks)) {
			if ($size <= 10000000) {
				move_uploaded_file($source, $folder . $nama);
				$query = mysqli_query($koneksi, "INSERT INTO pengaduan VALUES (NULL,'$tgl','$id_customer', '" . $_POST['project'] . "', '" . $_POST['fitur'] . "', '" . $_POST['subfitur'] . "','" . $_POST['laporan'] . "','$nama','proses')");

				if ($query) {
					echo "<script>alert('Pengaduan Akan Segera di Proses')</script>";
					echo "<script>location='index.php';</script>";
				}
			} else {
				echo "<script>alert('Ukuran File Tidak Lebih Dari 10000KB')</script>";
			}
		} else {
			echo "<script>alert('Format File Tidak Di Dukung')</script>";
		}
	} else {
		$query = mysqli_query($koneksi, "INSERT INTO pengaduan VALUES (NULL,'$tgl','$id_customer','" . $_POST['laporan'] . "','noImage.png','proses')");
		if ($query) {
			echo "<script>alert('Pengaduan Akan Segera Ditanggapi')</script>";
			echo "<script>location='index.php';</script>";
		}
	}
}

?>

<td>
	<h4 class="blue-text hide-on-med-and-down">Daftar Laporan</h4>
</td>
<td>

	<table border="3" class="responsive-table striped highlight">
		<tr>
			<td>No</td>
			<td>ID Customer</td>
			<td>Nama</td>
			<td>Tanggal Masuk</td>
			<td>Status</td>
			<td>Opsi</td>
		</tr>
		<?php
		$no = 1;
		$pengaduan = mysqli_query($koneksi, "SELECT * FROM pengaduan INNER JOIN customer ON pengaduan.id_customer=customer.id_customer INNER JOIN tanggapan ON pengaduan.id_pengaduan=tanggapan.id_pengaduan WHERE pengaduan.id_customer='" . $_SESSION['data']['id_customer'] . "' ORDER BY pengaduan.id_pengaduan DESC");
		while ($r = mysqli_fetch_assoc($pengaduan)) { ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $r['id_customer']; ?></td>
				<td><?php echo $r['nama']; ?></td>
				<td><?php echo $r['tgl_pengaduan']; ?></td>
				<td><?php echo $r['status']; ?></td>
				<td>
					<a class="btn blue modal-trigger" href="#tanggapan&id_pengaduan=<?php echo $r['id_pengaduan'] ?>">More</a>
					<a class="btn red" onclick="return confirm('Anda Yakin Ingin Menghapus Y/N')" href="index.php?p=pengaduan_hapus&id_pengaduan=<?php echo $r['id_pengaduan'] ?>">Hapus</a>
				</td>

				<!-- ditanggapi -->
				<div id="tanggapan&id_pengaduan=<?php echo $r['id_pengaduan'] ?>" class="modal">
					<div class="modal-content">
						<h4 class="blue-text">Detail</h4>
						<div class="col s12">
							<p>ID Customer : <?php echo $r['id_customer']; ?></p>
							<p>Dari : <?php echo $r['nama']; ?></p>
							<p>Petugas : <?php echo $r['nama_petugas']; ?></p>
							<p>Tanggal Masuk : <?php echo $r['tgl_pengaduan']; ?></p>
							<p>Tanggal Ditanggapi : <?php echo $r['tgl_tanggapan']; ?></p>
							<?php
							if ($r['file'] == "kosong") { ?>
								<img src="../img/noImage.png" width="100">
							<?php	} else { ?>
								<img width="100" src="../img/<?php echo $r['foto']; ?>">
							<?php }
							?>
							<br><b>Pesan</b>
							<p><?php echo $r['isi_laporan']; ?></p>
							<br><b>Respon</b>
							<p><?php echo $r['tanggapan']; ?></p>
						</div>

					</div>
					<div class="modal-footer col s12">
						<a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
					</div>
				</div>
				<!-- ditanggapi -->

			</tr>
		<?php	}
		?>
	</table>

</td>