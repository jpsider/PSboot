<!DOCTYPE html>
<html lang="en">
<?php
	require_once 'components/header.php';
?>
<!-- Insert Head PHP -->
<?php
	if (!empty($_GET['NewSystemApplication'])){
		$SYSTEM_ID=$_GET['SYSTEM_ID'];
		$APP_VER_ID=$_GET['APP_VER_ID'];
		include 'components/database.php';
		$pdo = Database::connect();
		$sql = "INSERT INTO SYSTEM_APPLICATIONS (SYSTEM_ID,APP_VER_ID,STATUS_ID) VALUES ('$SYSTEM_ID','$APP_VER_ID',1)";
		$pdo->query($sql);
		header("Refresh:0 url=system_applications.php");		
	}
	else {

?>
<!-- End Head PHP -->
<div class="content-area">
    <!-- Start content-area -->

    <h3>PSBoot: System Applications</h3>
    <table id="example" class="table table-compact">
		<thead>
			<tr>
			<th>ID</th>
			<th>System Name</th>
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
                $sql = "select sa.ID, "
                            . "sa.APP_VER_ID, "
                            . "sa.SYSTEM_ID, "
                            . "sa.STATUS_ID, "
                            . "sa.date_modified, "
                            . "apv.APPLICATION_ID, "
                            . "apv.APPLICATION_VERSION, "
                            . "ap.APPLICATION_NAME, "
                            . "ss.SYSTEM_NAME, "
                            . "s.STATUS_NAME, "
                            . "s.HTMLCOLOR, "
                            . "s.HTML_Description "
                        . "from SYSTEM_APPLICATIONS sa "
                        . "join SYSTEMS ss on sa.SYSTEM_ID=ss.ID "
                        . "join APPLICATION_VERSIONS apv on sa.APP_VER_ID=apv.ID "
                        . "join APPLICATIONS ap on apv.APPLICATION_ID=ap.ID "
                        . "join STATUS s on sa.STATUS_ID=s.ID ";
                foreach ($pdo->query($sql) as $row) {
			    	echo '<tr>';
			    	echo '<td>'. $row['ID'] . '</td>';
			    	echo '<td>'. $row['SYSTEM_NAME'] . '</td>';
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
                <td><b>Add a New System Application</b></td>
                <td>
                    <?php
                        echo "<select name='SYSTEM_ID'>";
                        $sql = "SELECT * FROM SYSTEMS";
                        foreach ($pdo->query($sql) as $row) {
                            echo "<option value=". $row['ID'] .">". $row['SYSTEM_NAME'] ."</option>";
                        }
                        echo "</select>"
                    ?>
                </td>
                <td>
                    <?php
                        echo "<select name='APP_VER_ID'>";
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
                            echo "<option value=". $row['ID'] .">". $row['APPLICATION_NAME'] .",". $row['APPLICATION_VERSION'] ."</option>";
                        }
                        echo "</select>"
                    ?>
                </td>
				<td>
					<input type="hidden" name="NewSystemApplication" value="TRUE"><input type="Submit" class="btn btn-success-outline btn-sm" value="Add System Application"></td>
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