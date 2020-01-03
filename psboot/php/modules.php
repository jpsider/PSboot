<!DOCTYPE html>
<html lang="en">
<?php
	require_once 'components/header.php';
?>
<!-- Insert Head PHP -->
<?php
	if (!empty($_GET['NewModule'])){
		$MODULE_NAME=$_GET['MODULE_NAME'];
		include 'components/database.php';
		$pdo = Database::connect();
		$sql = "INSERT INTO MODULES (MODULE_NAME,STATUS_ID) VALUES ('$MODULE_NAME',1)";
		$pdo->query($sql);
		header("Refresh:0 url=modules.php");		
	}
	else {

?>
<!-- End Head PHP -->
<div class="content-area">
    <!-- Start content-area -->

    <h3>PSBoot: Modules</h3>
    <table id="example" class="table table-compact">
		<thead>
			<tr>
			<th>ID</th>
			<th>Module Name</th>
			<th>Status</th>
			<th>Date Modified</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			    include 'components/database.php';
			    $pdo = Database::connect();
                $sql = "select mo.ID, "
                            . "mo.MODULE_NAME, "
                            . "mo.STATUS_ID, "
                            . "mo.date_modified, "
                            . "s.STATUS_NAME, "
                            . "s.HTMLCOLOR, "
                            . "s.HTML_Description "
                        . "from MODULES mo "
                        . "join STATUS s on mo.STATUS_ID=s.ID ";
                foreach ($pdo->query($sql) as $row) {
			    	echo '<tr>';
			    	echo '<td>'. $row['ID'] . '</td>';
			    	echo '<td>'. $row['MODULE_NAME'] . '</td>';
                    echo '<td style=background-color:'. $row['HTMLCOLOR'] . '><b>'. $row['STATUS_NAME'] . '</b></td>';
                    echo '<td>'. $row['date_modified'] . '</td>';
                    echo '</tr>';
                }
                Database::disconnect();
            ?>
        </tbody>
	</table>
    <table  class="table table-compact">
		<tr>
			<form>
				<td><b>Add a New Module</b></td>
				<td>
					<input type="text" name="MODULE_NAME" value="Enter Module Name">
				</td>
				<td>
					<input type="hidden" name="NewModule" value="TRUE"><input type="Submit" class="btn btn-success-outline btn-sm" value="Add Module"></td>
				</td>
			</form>
		</tr>
	</table>
</div><!-- End content-area -->
<nav class="sidenav">
    <?php
			require_once 'components/Side_Bar.html';
		?>
</nav>
</div><!-- End content-container (From Header) -->
</body>
<?php
  	}
?>
</html>