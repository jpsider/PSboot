<!DOCTYPE html>
<html lang="en">
<?php
	require_once 'components/header.php';
?>
<!-- Insert Head PHP -->
<?php
	if (!empty($_GET['NewSystem'])){
		$SystemName=$_GET['SystemName'];
		include 'components/database.php';
		$pdo = Database::connect();
		$sql = "INSERT INTO SYSTEMS (SYSTEM_NAME,STATUS_ID) VALUES ('$SystemName',1)";
		$pdo->query($sql);
		header("Refresh:0 url=systems.php");		
	}
	else {

?>
<!-- End Head PHP -->
<div class="content-area">
    <!-- Start content-area -->

    <h3>PSBoot: Systems</h3>
    <table id="example" class="table table-compact">
		<thead>
			<tr>
			<th>ID</th>
			<th>System Name</th>
			<th>Status</th>
			<th>Date Modified</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			    include 'components/database.php';
			    $pdo = Database::connect();
                $sql = "select ss.ID, "
                            . "ss.SYSTEM_NAME, "
                            . "ss.STATUS_ID, "
                            . "ss.date_modified, "
                            . "s.STATUS_NAME, "
                            . "s.HTMLCOLOR, "
                            . "s.HTML_Description "
                        . "from SYSTEMS ss "
                        . "join STATUS s on ss.STATUS_ID=s.ID ";
                foreach ($pdo->query($sql) as $row) {
			    	echo '<tr>';
			    	echo '<td>'. $row['ID'] . '</td>';
			    	echo '<td>'. $row['SYSTEM_NAME'] . '</td>';
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
				<td><b>Add a New System</b></td>
				<td>
					<input type="text" name="SystemName" value="Enter System Name">
				</td>
				<td>
					<input type="hidden" name="NewSystem" value="TRUE"><input type="Submit" class="btn btn-success-outline btn-sm" value="Add System"></td>
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