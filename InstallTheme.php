<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Europe/London");


//showing php information
if (isset($_GET['php']) and $_GET['php']=="info") {
	# code...
	phpinfo();
	exit();
}

  if(file_exists("config.inc.php") && file_exists("vtigerversion.php")){
    require_once("config.inc.php");
    require_once("vtigerversion.php");
    // echo "true path!";
  }else{
    die("<center><h2>for continue, please copy this file to your <strong>VTiger CRM root path</strong> and refresh again to install Theme.</h2></center>");
    exit();
  }

global $site_URL;
global $root_directory;
global $vtiger_current_version;
global $HELPDESK_SUPPORT_EMAIL_ID;

$config_root_directory = $root_directory;
$config_vtiger_current_version = $vtiger_current_version;


$login_template = '';
if(version_compare($config_vtiger_current_version, '7.0.0', '<')) {
  // $template_folder= "layouts/vlayout";
  die("<h2>this installation app just created for VTiger 7.x login theme. if you need for another versions please contact us.</h2>");
  exit();
}else{
  // echo $config_vtiger_current_version;
  $template_folder = "layouts/v7";
  // $login_template = $template_folder.'/modules/Users/';
  $login_template = 'layouts/v7/modules/Users/';
}

function dir_is_empty($dir) {
  $handle = opendir($dir);
  while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != "..") {
      closedir($handle);
      return FALSE;
    }
  }
  closedir($handle);
  return TRUE;
}
function copy_login_theme($from, $to)
{
	if(function_exists('copy'))
	{
		copy($from, $to);
		return true;
	}
	elseif(function_exists('rename')) 
	{
		rename($from, $to);
		return true;
	}
}


$login_theme_path = is_writable('test/VTT/LoginTheme/') ? 'test/VTT/LoginTheme/' : false ;
$login_tpl = '/Login.tpl';
$theme_list_config = array(
	'0' => $login_theme_path.'0'.$login_tpl,
	'1' => $login_theme_path.'1'.$login_tpl,
	'2' => $login_theme_path.'2'.$login_tpl,
	'3' => $login_theme_path.'3'.$login_tpl,
	);

$lt_backup_path = 'test/VTT/LoginTheme/BK/';

if (dir_is_empty($lt_backup_path)) {
  	// copy_login_theme($login_template.'Login.tpl', $lt_backup_path);
  	copy_login_theme($login_template.'Login.tpl', $lt_backup_path.'Login.tpl');
  	// echo $login_template.'Login.tpl' . $lt_backup_path;
  	/*if(copy($login_template.'Login.tpl', $lt_backup_path.'Login.tpl')){
	echo "true copy";
}else{
echo "false copy";
}*/
}

$theme_code = '';
$theme_list_config_path = '';
if (isset($_POST['ltm'])) {
	$theme_code = htmlspecialchars($_POST['ltm']);
	$theme_list_config_path = array_key_exists($theme_code,$theme_list_config) ? $theme_list_config[$theme_code] : false;

	if (file_exists($theme_list_config_path) && is_writable($login_template.'Login.tpl') ) {
  // echo "<b>".$_POST['ltm']."</b>";
  // copy($theme_list_config_path, $login_template.'Login.tpl');
  // copy_login_theme($theme_list_config_path, $login_template.'Login.tpl');
	if(copy_login_theme($theme_list_config_path, $login_template.'Login.tpl'))
  	{
  		echo "<center><h2>your VTiger CRM Login Page Theme changed successful</h2></center>";
  	}else{
  		echo '<center><h2 style="color:red;"># there is a problem for changing theme!</h2></center>';
  	}
  
}
else{
	echo '<center><h2 style="color:red;"># can not change theme! please check "vtigerROOT/'. $login_template.'" write permission</h2></center>';
}
	
}elseif (!isset($_POST['ltm'])) {
	// echo "please select true theme!";
}





?>
<script type="text/javascript">
function select_all()
{
var text_val=document.getElementById("license_code");
text_val.focus();
text_val.select();
document.execCommand('copy');
}
</script>


<style type="text/css">
/*body {
  -webkit-animation: color-fade 10s infinite;
  -moz-animation: color-fade 10s infinite;
  animation: color-fade 10s infinite;
}
*/
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0,0,0,0);
  border: 0;
}
label {
display: inline-block;
transition: 0.5s ease;
cursor: pointer;
filter: grayscale(100%);
}

label:hover {
  filter: grayscale(0);
}
input[type="radio"]:checked + label {
    outline: 5px solid yellow;
    filter: grayscale(0);
    border: 5px solid #000000;
    transform: scale(1.2);
}

img{
	display: inline-block;
}
</style>

<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet"/> -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<fieldset>
  <legend>
    Please select your login page theme and press 'change login theme' button to chage your VTiger login style.
  </legend>
  
  <input type="radio" name="ltm" class="sr-only" id="tm1" value="1">
  <label for="tm1">
    <img src="./test/VTT/LoginTheme/img/1.jpg" alt="">
  </label>
  
  <input type="radio" name="ltm" class="sr-only" id="tm2" value="2">
  <label for="tm2">
    <img src="./test/VTT/LoginTheme/img/2.jpg" alt="female">
  </label>
  
  <input type="radio" name="ltm" class="sr-only" id="tm3" value="3">
  <label for="tm3">
    <img src="./test/VTT/LoginTheme/img/3.jpg" alt="female">
  </label>
  
  <input type="radio" name="ltm" class="sr-only" id="tm4" value="0">
  <label for="tm4">
    <img src="./test/VTT/LoginTheme/img/0.jpg" alt="female">
  </label>
<hr>
<br><br>
  <center><input type="submit" value="change login theme" name="clt" onClick="return checkTheme();"></center>

</fieldset>
</form>

<script type="text/javascript">
    function checkTheme() {            
        var radio_check_val = "";
        for (i = 0; i < document.getElementsByName('ltm').length; i++) {
            if (document.getElementsByName('ltm')[i].checked) {
            	console.log('want to change your VTiger login page theme');
        return confirm('Do you really want to change your VTiger login page theme?');
                // alert("this radio button was clicked: " + document.getElementsByName('ltm')[i].value);
                // radio_check_val = document.getElementsByName('ltm')[i].value;
            }        
        }

        if (radio_check_val === "")
        {
        	console.log('select one of the login page');
            alert("please select one of the login page template then press this button");
            return false;
        }

return false;          
    }
</script>