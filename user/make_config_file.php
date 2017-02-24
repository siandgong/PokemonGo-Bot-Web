<?php
/**
 * Created by PhpStorm.
 * User: KIM
 * Date: 2017-02-19
 * Time: 오전 2:15
 */
session_start();
require_once('../db.php');

if(empty ($_POST['bot_geolocation'])){
    die("<script>alert('좌표 세팅은 필수입니다.');history.go(-1)</script>");
}
$geolocation = $_POST['bot_geolocation'];

if(strtolower($geolocation) == 'default')
  $geolocation = '37.497942,127.025427';
else if(!ctype_alnum(str_replace(" ", "", str_replace(".", "", str_replace(",", "", $geolocation)))))
    die("<script>alert('좌표에 기타 특수문자 사용이 금지됩니다.');history.go(-1)</script>");

$p_bot = new PokemonGo_Bot();
$idx = $p_bot->get_idx($_SESSION['ID']);

$config_dir = "PokemonGo-Bot/configs/";
$bot_dir = "PokemonGo-Bot/";
$sample_auth_file = $config_dir."auth.json.example";
$sample_config_file = $config_dir."config.json.example";
$sample_run_file = $bot_dir."run.sh";

$user_auth_file = $config_dir.$_SESSION['ID']."_"."auth.json";
$user_config_file = $config_dir.$_SESSION['ID']."_"."config.json";
$user_run_file = $bot_dir.$_SESSION['ID']."_"."run.sh";

$json = file_get_contents($sample_auth_file);
$obj = json_decode($json);
$obj->username = $p_bot->get_bot_email($idx);
$obj->password = $p_bot->get_bot_pw($idx);
$obj->hashkey = $p_bot->get_bot_hashkey($idx);
$obj->location = $p_bot->safe_string($geolocation);
$obj->gmapkey = '';
$fp = fopen($user_auth_file, 'w+'); 
fwrite($fp, json_encode($obj)); 
fclose($fp);

$port = search_open_port();
$json = file_get_contents($sample_config_file);
$obj = json_decode($json);
$obj->websocket->server_url = '127.0.0.1:'.$port;
$fp = fopen($user_config_file, 'w+'); 
fwrite($fp, json_encode($obj)); 
fclose($fp);

$fp = fopen($sample_run_file, 'r+');
$run_file_data = fread($fp, filesize($sample_run_file));
$run_file_data = str_replace("config.json", $_SESSION['ID']."_"."config.json", $run_file_data);
$run_file_data = str_replace("auth.json", $_SESSION['ID']."_"."auth.json", $run_file_data);
fclose($fp);

$fp = fopen($user_run_file, 'w+');
fwrite($fp, $run_file_data);
fclose($fp);
chmod($user_run_file, 0755);

$p_bot->set_bot_config_flag($idx);
die_with_alert_box("성공", './#log');
?>

<?php
//function list

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function die_with_alert_box($msg, $href){
    die("<script>alert('$msg');location.href = '$href';</script>");
}

function search_open_port(){
		$host = 'localhost';

		for ($port=8000; $port<13000; $port++)
		{
				$connection = @fsockopen($host, $port);

				if (is_resource($connection))
						fclose($connection);
				else
						return $port;
		}
}
?>
