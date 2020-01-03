<!DOCTYPE html>
<html lang="en">
<?php
	require_once 'components/header.php';
?>
<!-- Insert Head PHP -->
<?php
	if (!empty($_GET['NewModuleVersion'])){
		$MODULE_ID=$_GET['MODULE_ID'];
		$MODULE_VERSION=$_GET['MODULE_VERSION'];
		include 'components/database.php';
		$pdo = Database::connect();
		$sql = "INSERT INTO MODULE_VERSIONS (MODULE_VERSION,MODULE_ID,STATUS_ID) VALUES ('$MODULE_VERSION','$MODULE_ID',1)";
		$pdo->query($sql);
		header("Refresh:0 url=module_versions.php");		
	}
	else {

?>
<!-- End Head PHP -->
<div class="content-area">
    <!-- Start content-area -->

    <h3>PSBoot: Module Versions</h3>
    <table id="example" class="table table-compact">
		<thead>
			<tr>
			<th>ID</th>
			<th>Module Name</th>
			<th>Module Version</th>
			<th>Status</th>
			<th>Date Modified</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			    include 'components/database.php';
			    $pdo = Database::connect();
                $sql = "select mov.ID, "
                            . "mov.MODULE_VERSION, "
                            . "mov.MODULE_ID, "
                            . "mov.STATUS_ID, "
                            . "mov.date_modified, "
                            . "mo.MODULE_NAME, "
                            . "s.STATUS_NAME, "
                            . "s.HTMLCOLOR, "
                            . "s.HTML_Description "
                        . "from MODULE_VERSIONS mov "
                        . "join MODULES mo on mov.MODULE_ID=mo.ID "
                        . "join STATUS s on mov.STATUS_ID=s.ID ";
                foreach ($pdo->query($sql) as $row) {
			    	echo '<tr>';
			    	echo '<td>'. $row['ID'] . '</td>';
			    	echo '<td>'. $row['MODULE_NAME'] . '</td>';
			    	echo '<td>'. $row['MODULE_VERSION'] . '</td>';
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
                <td><b>Add a New Module Version</b></td>
                <td>
                    <?php
                        echo "<select name='MODULE_ID'>";
                        $sql = "SELECT * FROM MODULES";
                        foreach ($pdo->query($sql) as $row) {
                            echo "<option value=". $row['ID'] .">". $row['MODULE_NAME'] ."</option>";
                        }
                        echo "</select>"
                    ?>
                </td>
				<td>
					<input type="text" name="MODULE_VERSION" value="Enter Module Version">
				</td>
				<td>
					<input type="hidden" name="NewModuleVersion" value="TRUE"><input type="Submit" class="btn btn-success-outline btn-sm" value="Add Module Version"></td>
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