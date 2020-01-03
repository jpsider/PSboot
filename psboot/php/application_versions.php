<!DOCTYPE html>
<html lang="en">
<?php
	require_once 'components/header.php';
?>
<!-- Insert Head PHP -->
<?php
	if (!empty($_GET['NewApplicationVersion'])){
		$APPLICATION_ID=$_GET['APPLICATION_ID'];
		$APPLICATION_VERSION=$_GET['APPLICATION_VERSION'];
		include 'components/database.php';
		$pdo = Database::connect();
		$sql = "INSERT INTO APPLICATION_VERSIONS (APPLICATION_VERSION,APPLICATION_ID,STATUS_ID) VALUES ('$APPLICATION_VERSION','$APPLICATION_ID',1)";
		$pdo->query($sql);
		header("Refresh:0 url=application_versions.php");		
	}
	else {

?>
<!-- End Head PHP -->
<div class="content-area">
    <!-- Start content-area -->

    <h3>PSBoot: Application Versions</h3>
    <table id="example" class="table table-compact">
		<thead>
			<tr>
			<th>ID</th>
			<th>Application Name</th>
			<th>Application Version</th>
			<th>Status</th>
			<th>Date Modified</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			    include 'components/database.php';
			    $pdo = Database::connect();
                $sql = "select apv.ID, "
                            . "apv.APPLICATION_VERSION, "
                            . "apv.APPLICATION_ID, "
                            . "apv.STATUS_ID, "
                            . "apv.date_modified, "
                            . "ap.APPLICATION_NAME, "
                            . "s.STATUS_NAME, "
                            . "s.HTMLCOLOR, "
                            . "s.HTML_Description "
                        . "from APPLICATION_VERSIONS apv "
                        . "join APPLICATIONS ap on apv.APPLICATION_ID=ap.ID "
                        . "join STATUS s on apv.STATUS_ID=s.ID ";
                foreach ($pdo->query($sql) as $row) {
			    	echo '<tr>';
			    	echo '<td>'. $row['ID'] . '</td>';
			    	echo '<td>'. $row['APPLICATION_NAME'] . '</td>';
			    	echo '<td>'. $row['APPLICATION_VERSION'] . '</td>';
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
                <td><b>Add a New Application Version</b></td>
                <td>
                    <?php
                        echo "<select name='APPLICATION_ID'>";
                        $sql = "SELECT * FROM APPLICATIONS";
                        foreach ($pdo->query($sql) as $row) {
                            echo "<option value=". $row['ID'] .">". $row['APPLICATION_NAME'] ."</option>";
                        }
                        echo "</select>"
                    ?>
                </td>
				<td>
					<input type="text" name="APPLICATION_VERSION" value="Enter Application Version">
				</td>
				<td>
					<input type="hidden" name="NewApplicationVersion" value="TRUE"><input type="Submit" class="btn btn-success-outline btn-sm" value="Add Application Version"></td>
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