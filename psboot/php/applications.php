<!DOCTYPE html>
<html lang="en">
<?php
	require_once 'components/header.php';
?>
<!-- Insert Head PHP -->
<?php
	if (!empty($_GET['NewApplication'])){
		$APPLICATION_NAME=$_GET['APPLICATION_NAME'];
		include 'components/database.php';
		$pdo = Database::connect();
		$sql = "INSERT INTO APPLICATIONS (APPLICATION_NAME,STATUS_ID) VALUES ('$APPLICATION_NAME',1)";
		$pdo->query($sql);
		header("Refresh:0 url=applications.php");		
	}
	else {

?>
<!-- End Head PHP -->
<div class="content-area">
    <!-- Start content-area -->

    <h3>PSBoot: Applications</h3>
    <table id="example" class="table table-compact">
		<thead>
			<tr>
			<th>ID</th>
			<th>Application Name</th>
			<th>Status</th>
			<th>Date Modified</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			    include 'components/database.php';
			    $pdo = Database::connect();
                $sql = "select ap.ID, "
                            . "ap.APPLICATION_NAME, "
                            . "ap.STATUS_ID, "
                            . "ap.date_modified, "
                            . "s.STATUS_NAME, "
                            . "s.HTMLCOLOR, "
                            . "s.HTML_Description "
                        . "from APPLICATIONS ap "
                        . "join STATUS s on ap.STATUS_ID=s.ID ";
                foreach ($pdo->query($sql) as $row) {
			    	echo '<tr>';
			    	echo '<td>'. $row['ID'] . '</td>';
			    	echo '<td>'. $row['APPLICATION_NAME'] . '</td>';
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
				<td><b>Add a New Application</b></td>
				<td>
					<input type="text" name="APPLICATION_NAME" value="Enter Application Name">
				</td>
				<td>
					<input type="hidden" name="NewApplication" value="TRUE"><input type="Submit" class="btn btn-success-outline btn-sm" value="Add Application"></td>
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