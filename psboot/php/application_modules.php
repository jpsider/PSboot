<!DOCTYPE html>
<html lang="en">
<?php
	require_once 'components/header.php';
?>
<!-- Insert Head PHP -->
<?php
	if (!empty($_GET['NewApplicationModule'])){
		$MOD_VER_ID=$_GET['MOD_VER_ID'];
		$APP_VER_ID=$_GET['APP_VER_ID'];
		include 'components/database.php';
		$pdo = Database::connect();
		$sql = "INSERT INTO APPLICATION_MODULES (MOD_VER_ID,APP_VER_ID,STATUS_ID) VALUES ('$MOD_VER_ID','$APP_VER_ID',1)";
		$pdo->query($sql);
		header("Refresh:0 url=application_modules.php");		
	}
	else {

?>
<!-- End Head PHP -->
<div class="content-area">
    <!-- Start content-area -->

    <h3>PSBoot: Application Modules</h3>
    <table id="example" class="table table-compact">
		<thead>
			<tr>
			<th>ID</th>
			<th>Application Name</th>
			<th>Application Version</th>
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
                $sql = "select am.ID, "
                            . "am.APP_VER_ID, "
                            . "am.MOD_VER_ID, "
                            . "am.STATUS_ID, "
                            . "am.date_modified, "
                            . "apv.APPLICATION_ID, "
                            . "apv.APPLICATION_VERSION, "
                            . "ap.APPLICATION_NAME, "
                            . "mo.MODULE_NAME, "
                            . "mov.MODULE_VERSION, "
                            . "s.STATUS_NAME, "
                            . "s.HTMLCOLOR, "
                            . "s.HTML_Description "
                        . "from APPLICATION_MODULES am "
                        . "join APPLICATION_VERSIONS apv on am.APP_VER_ID=apv.ID "
                        . "join MODULE_VERSIONS mov on am.MOD_VER_ID=mov.ID "
                        . "join APPLICATIONS ap on apv.APPLICATION_ID=ap.ID "
                        . "join MODULES mo on mov.MODULE_ID=mo.ID "
                        . "join STATUS s on am.STATUS_ID=s.ID ";
                foreach ($pdo->query($sql) as $row) {
			    	echo '<tr>';
			    	echo '<td>'. $row['ID'] . '</td>';
			    	echo '<td>'. $row['APPLICATION_NAME'] . '</td>';
			    	echo '<td>'. $row['APPLICATION_VERSION'] . '</td>';
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
                <td><b>Add a New Application Module</b></td>
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
                    <?php
                        echo "<select name='MOD_VER_ID'>";
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
                            echo "<option value=". $row['ID'] .">". $row['MODULE_NAME'] .",". $row['MODULE_VERSION'] ."</option>";
                        }
                        echo "</select>"
                    ?>
                </td>
				<td>
					<input type="hidden" name="NewApplicationModule" value="TRUE"><input type="Submit" class="btn btn-success-outline btn-sm" value="Add Application Module"></td>
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