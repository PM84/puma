<?php
if(is_file ("../config.php")){
	header("LOCATION: ../index.php");
}
?>
<html>

<head>

    <head>
        <?php include("../includes/head_main_install.php"); ?>
    </head>

<body>
    <?php include("../includes/header_bar_install.php"); ?>

    <div class="container">
        <div class="navbar navbar-default navbar-fixed-top" style="width:100%; height:60px;">
            <div class='row'>
                <div class="col-xs-2  col-sm-3">
                    <div style='width:100%; display:block;text-align:center; padding-top:5px;'>
                        <a href="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/index.php" style='color: black;'><img src="../images/PumaLMU_LS_Logo.png" alt="" height="50"></a>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-9" style="text-align:center;">

                    <div id="menuTopRight">
                        <h2>Installation PUMA@LMU</h2>
                    </div>

                </div>

            </div>
        </div>
        <?php
        if (empty($_POST['submit'])) { ?>
            <div class='row' style="margin-top: 70px; width:80%; margin-left:auto;margin-right:auto;">
                <form method="POST" action="">

                    <h3>Basic</h3>
                    <div class="form-group row">
                        <label for="subdir" class="col-sm-3 col-form-label" style="text-align:right;">Subdirectory</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="subdir" name="subdir" value="/">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="workshopurl" class="col-sm-3 col-form-label" style="text-align:right;">Workshop URL</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="workshopurl" name="workshopurl" value="https://www.domain.de">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="support_email" class="col-sm-3 col-form-label" style="text-align:right;">Support E-Mail Adresse</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="support_email" name="support_email" value="support@domain.de">
                        </div>
                    </div>

                    <br><br>

                    <h3>Datenbank</h3>
                    <div class="form-group row">
                        <label for="db_host" class="col-sm-3 col-form-label" style="text-align:right;">Database-Host</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="db_host" name="db_host" value="localhost">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_user" class="col-sm-3 col-form-label" style="text-align:right;">Database-User</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="db_user" name="db_user" value="DB User">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_name" class="col-sm-3 col-form-label" style="text-align:right;">Database-Name</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="db_name" name="db_name" value="DB Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="db_pwd" class="col-sm-3 col-form-label" style="text-align:right;">Database-Passwort</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="db_pwd" name="db_pwd" value="DB Passwort">
                        </div>
                    </div>
                    <br>
                    <h3>E-Mail</h3>
                    <div class="form-group row">
                        <label for="imap_email" class="col-sm-3 col-form-label" style="text-align:right;">E-Mail Adresse</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="imap_email" name="imap_email" value="name@domain.de">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imap_host" class="col-sm-3 col-form-label" style="text-align:right;">IMAP Host</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="imap_host" name="imap_host" value="imap.domain.de">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imap_host_name" class="col-sm-3 col-form-label" style="text-align:right;">IMAP Host Name (Postfach)</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="imap_host_name" name="imap_host_name" value="{imap.domain.de:143}INBOX">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imap_username" class="col-sm-3 col-form-label" style="text-align:right;">IMAP Nutzername</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="imap_username" name="imap_username" value="IMAP Nutzername">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imap_clearname" class="col-sm-3 col-form-label" style="text-align:right;">IMAP Klarname</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="imap_clearname" name="imap_clearname" value="Max Mustermann">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imap_password" class="col-sm-3 col-form-label" style="text-align:right;">IMAP Passwprt</label>
                        <div class="col-sm-9">
                            <input type="password" required class="form-control-plaintext" id="imap_password" name="imap_password" value="Passwort">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imap_port" class="col-sm-3 col-form-label" style="text-align:right;">IMAP Port</label>
                        <div class="col-sm-9">
                            <input type="text" required class="form-control-plaintext" id="imap_port" name="imap_port" value="143">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imap_secure" class="col-sm-3 col-form-label" style="text-align:right;">IMAP Secure</label>
                        <div class="col-sm-9">
                            <select class="form-control-plaintext" id="imap_secure" name="imap_secure">
                                <option value='TLS' selected>TLS</option>
                                <option value='SSL'>SSL</option>
                            </select>
                        </div>
                    </div>

                    <br><br>

                    <div class="form-group row">
                        <label for="smtp_host" class="col-sm-3 col-form-label" style="text-align:right;">SMTP Host Name</label>
                        <div class="col-sm-9">
                            <input type="text" requiredclass="form-control-plaintext" id="smtp_host" name="smtp_host" value="smtp.domain.de:143">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="smtp_username" class="col-sm-3 col-form-label" style="text-align:right;">SMTP Nutzername</label>
                        <div class="col-sm-9">
                            <input type="text" requiredclass="form-control-plaintext" id="smtp_username" name="smtp_username" value="SMTP Nutzername">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="smtp_password" class="col-sm-3 col-form-label" style="text-align:right;">SMTP Passwprt</label>
                        <div class="col-sm-9">
                            <input type="password" requiredclass="form-control-plaintext" id="smtp_password" name="smtp_password" value="Passwort">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="smtp_port" class="col-sm-3 col-form-label" style="text-align:right;">SMTP Port</label>
                        <div class="col-sm-9">
                            <input type="text" requiredclass="form-control-plaintext" id="smtp_port" name="smtp_port" value="465">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="smtp_secure" class="col-sm-3 col-form-label" style="text-align:right;">SMTP Secure</label>
                        <div class="col-sm-9">
                            <select class="form-control-plaintext" id="smtp_secure" name="smtp_secure">
                                <option value='TLS'>TLS</option>
                                <option value='SSL' selected>SSL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="smtp_auth" class="col-sm-3 col-form-label" style="text-align:right;">SMTP Auth</label>
                        <div class="col-sm-9">
                            <select class="form-control-plaintext" id="smtp_auth" name="smtp_auth">
                                <option value='true' selected>true</option>
                                <option value='false'>false</option>
                            </select>
                        </div>
                    </div>

                    <br><br>

                    <button class="btn btn-success col-sm-10" value="true" name="submit">Installieren</button>

                </form>
            </div>
        <?php } else { ?>
            <div style="margin-top:80px">
                <table>
                    <?php
                    $exclude = ['submit'];

                    foreach ($_POST as $name => $value) {
                        if (in_array($name, $exclude)) {
                            continue;
                        }
                        echo "<tr><td style=\"width:200px\">$name</td><td>$value</td></tr>";
                    }
                    ?>
                </table>
            </div>
        <?php } ?>
    </div>
</body>

</html>
<div style="height:100px; display:block;"></div>
<?php

if (!empty($_POST['submit'])) {

    $fp = fopen("../config.php", "w");
    $string = '<?php
$_SESSION["DOCUMENT_ROOT_DIR"] = "' . $_POST["subdir"] . '";
$dbname="' . $_POST["db_name"] . '";
$dbhost="' . $_POST["db_host"] . '";
$dbuser="' . $_POST["db_user"] . '";
$dbpass="' . $_POST["db_pwd"] . '";

$verbindung=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die("Die Seite wird gerade gewartet. Bitte kommen Sie später zurück!");
mysqli_set_charset($verbindung, "utf8mb4");

$email_adresse = "' . $_POST["imap_email"] . '"; 
$imap_host_name = "' . $_POST["imap_host_name"] . '"; 
$mail_Host = "' . $_POST["imap_host"] . '";
$imap_user_name = "' . $_POST["imap_username"] . '";
$imap_user_clearName="' . $_POST["imap_clearname"] . '";
$imap_password = "' . $_POST["imap_password"] . '";
$imap_port = "' . $_POST["imap_port"] . '";
$imap_secure="' . $_POST["imap_secure"] . '";

$smtp_host = "' . $_POST["smtp_host"] . '";
$smtp_username = "' . $_POST["smtp_username"] . '";
$smtp_password = "' . $_POST["smtp_password"] . '";
$smtp_port = "' . $_POST["smtp_port"] . '";
$smtp_secure="' . $_POST["smtp_secure"] . '";
$smtp_auth = ' . $_POST["smtp_auth"] . ';

$WorkshopUrl="' . $_POST["workshopurl"] . '";
$ResetLink="$WorkshopUrl/module/user/PasswortReset.php";

$support_email="' . $_POST["support_email"] . '";

$VideoURL="https://www.physik-workshop.de";
$index_video_path="$VideoURL/VideoVerwaltung/indexFile/index_video.txt";
$index_themen_path="$VideoURL/VideoVerwaltung/indexFile/index_themen.txt";
$index_Sim_path="$VideoURL/VideoVerwaltung/indexFile/index_sim.txt";';

    fwrite($fp, $string);
    fclose($fp);

    $filenames = ['db_dump_structure.sql', 'db_dump_data.sql'];
    $verbindung = mysqli_connect($_POST["db_host"], $_POST["db_user"], $_POST["db_pwd"], $_POST["db_name"]) or die("Die Seite wird gerade gewartet. Bitte kommen Sie später zurück!");
    mysqli_set_charset($verbindung, "utf8mb4");
    foreach ($filenames as $filename) {
        $dump = file_get_contents($filename);
        $sqls = explode(";
", $dump);

        foreach ($sqls as $sql) {
            mysqli_query($verbindung, $sql) or print('Error performing query \'<strong>:' . mysqli_error($verbindung) . '<br /><br />');
        }
        echo  $filename . " erfolgreich verarbeitet<br>";
    }

    echo "Tables imported successfully";
}
?>