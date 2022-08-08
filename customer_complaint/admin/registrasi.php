        <div class="row">
        	<div class="col s12 m9">
        		<h3 class="blue-text">Customer</h3>
        	</div>
        	<div class="col s12 m3">
        		<div class="section"></div>
        		<a class="waves-effect waves-light btn modal-trigger blue" href="#modal1"><i class="material-icons">add</i></a>
        	</div>
        </div>

        <table id="example" class="display responsive-table" style="width:100%">
        	<thead>
        		<tr>
        			<th>No</th>
        			<th>ID Customer</th>
        			<th>Nama</th>
        			<th>Username</th>
        			<th>No Telepon</th>
        			<th>Opsi</th>
        		</tr>
        	</thead>
        	<tbody>

        		<?php
				$no = 1;
				$query = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id_customer ASC");
				while ($r = mysqli_fetch_assoc($query)) { ?>
        			<tr>
        				<td><?php echo $no++; ?></td>
        				<td><?php echo $r['id_customer']; ?></td>
        				<td><?php echo $r['nama']; ?></td>
        				<td><?php echo $r['username']; ?></td>
        				<td><?php echo $r['no_telepon']; ?></td>
        				<td><a class="btn teal modal-trigger" href="#regis_edit?id_customer=<?php echo $r['id_customer'] ?>">Edit</a> <a onclick="return confirm('Anda Yakin Ingin Menghapus Y/N')" class="btn red" href="index.php?p=regis_hapus&id_customer=<?php echo $r['id_customer'] ?>">Hapus</a></td>

        				<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->
        				<!-- Modal Structure -->
        				<div id="regis_edit?id_customer=<?php echo $r['id_customer'] ?>" class="modal">
        					<div class="modal-content">
        						<h4>Edit</h4>
        						<form method="POST">
        							<div class="col s12 input-field">
        								<label for="id_customer">ID Customer</label>
        								<input id="id_customer" type="number" name="id_customer" value="<?php echo $r['id_customer']; ?>">
        							</div>
        							<div class="col s12 input-field">
        								<label for="nama">Nama</label>
        								<input id="nama" type="text" name="nama" value="<?php echo $r['nama']; ?>">
        							</div>
        							<div class="col s12 input-field">
        								<label for="username">Username</label>
        								<input id="username" type="text" name="username" value="<?php echo $r['username']; ?>"><br><br>
        							</div>
        							<div class="col s12 input-field">
        								<label for="no_telepon">No Telepon</label>
        								<input id="no_telepon" type="number" name="no_telepon" value="<?php echo $r['no_telepon']; ?>"><br><br>
        							</div>
        							<div class="col s12 input-field">
        								<input type="submit" name="Update" value="Simpan" class="btn right">
        							</div>
        						</form>

        						<?php
								if (isset($_POST['Update'])) {
									$update = mysqli_query($koneksi, "UPDATE customer SET id_customer='" . $_POST['id_customer'] . "',nama='" . $_POST['nama'] . "',username='" . $_POST['username'] . "',no_telepon='" . $_POST['no_telepon'] . "' WHERE id_customer='" . $r['id_customer'] . "' ");
									if ($update) {
										echo "<script>alert('Data Tersimpan')</script>";
										echo "<script>location='location:index.php?p=registrasi';</script>";
									}
								}
								?>
        					</div>
        					<div class="modal-footer">
        						<a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        					</div>
        				</div>
        				<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->

        			</tr>
        		<?php  }
				?>

        	</tbody>
        </table>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
        	<div class="modal-content">
        		<h4>Add</h4>
        		<form method="POST">
        			<div class="col s12 input-field">
        				<label for="id_customer">ID Customer</label>
        				<input id="id_customer" type="number" name="id_customer">
        			</div>
        			<div class="col s12 input-field">
        				<label for="nama">Nama</label>
        				<input id="nama" type="text" name="nama">
        			</div>
        			<div class="col s12 input-field">
        				<label for="username">Username</label>
        				<input id="username" type="text" name="username"><br><br>
        			</div>
        			<div class="col s12 input-field">
        				<label for="password">Password</label>
        				<input id="password" type="password" name="password"><br><br>
        			</div>
        			<div class="col s12 input-field">
        				<label for="no_telepon">No Telepon</label>
        				<input id="no_telepon" type="number" name="no_telepon"><br><br>
        			</div>
        			<div class="col s12 input-field">
        				<label for="project1">Project 1</label>
        				<input id="project1" type="text" name="project1"><br><br>
        			</div>
        			<div class="col s12 input-field">
        				<label for="project2">Project 2</label>
        				<input id="project2" type="text" name="project2"><br><br>
        			</div>
        			<div class="col s12 input-field">
        				<label for="project3">Project 3</label>
        				<input id="project3" type="text" name="project3"><br><br>
        			</div>
        			<div class="col s12 input-field">
        				<label for="project4">Project 4</label>
        				<input id="project4" type="text" name="project4"><br><br>
        			</div>
        			<div class="col s12 input-field">
        				<input type="submit" name="simpan" value="Simpan" class="btn right">
        			</div>
        		</form>

        		<?php
				if (isset($_POST['simpan'])) {
					$password = md5($_POST['password']);

					$query = mysqli_query($koneksi, "INSERT INTO customer VALUES ('" . $_POST['id_customer'] . "','" . $_POST['nama'] . "','" . $_POST['username'] . "','" . $password . "','" . $_POST['no_telepon'] . "')");
					// if ($koneksi->query($query) === TRUE) {
					// 	$last_id = $koneksi->insert_id;
					// }
					// if (mysqli_query($koneksi, $query)) {
					// 	// Obtain last inserted id
					// 	$last_id = mysqli_insert_id($koneksi);
					// }
					if ($query) {
						echo "<script>alert('Data Tesimpan')</script>";
						echo "<script>location='location:index.php?p=registrasi';</script>";
					}
					if ($_POST['project1'] != null) {
						$query = mysqli_query($koneksi, "INSERT INTO project VALUES ('', '" . $_POST['id_customer'] . "','" . $_POST['project1'] . "')");
					}
					if ($_POST['project2'] != null) {
						$query = mysqli_query($koneksi, "INSERT INTO project VALUES ('', '" . $_POST['id_customer'] . "','" . $_POST['project2'] . "')");
					}
					if ($_POST['project3'] != null) {
						$query = mysqli_query($koneksi, "INSERT INTO project VALUES ('', '" . $_POST['id_customer'] . "','" . $_POST['project3'] . "')");
					}
					if ($_POST['project4'] != null) {
						$query = mysqli_query($koneksi, "INSERT INTO project VALUES ('', '" . $_POST['id_customer'] . "','" . $_POST['project4'] . "')");
					}
				}
				?>
        	</div>
        	<div class="modal-footer">
        		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        	</div>
        </div>