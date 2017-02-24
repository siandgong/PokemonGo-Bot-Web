<?php
/**
 * Created by PhpStorm.
 * User: KIM
 * Date: 2017-02-19
 * Time: 오전 2:15
 */
session_start();
require_once('../db.php');

if(empty ($_POST['email']) || empty ($_POST['pw'])){
    die("<script>alert('실패');history.go(-1)</script>");
}

if(!endsWith($_POST['email'], "@gmail.com" )){
    die("<script>alert('이메일이 올바르지 않습니다.');history.go(-1)</script>");
}

$id = $_POST['email'];
$pw = $_POST['pw'];
$hash_key = $_POST['hash_key'];

if(!ctype_alnum(str_replace("@", "", str_replace(".", "", $id))) || !ctype_alnum($hash_key))
    die("<script>alert('특수문자는 사용이 금지됩니다.');history.go(-1)</script>");

$p_bot = new PokemonGo_Bot();
$idx = $p_bot->get_idx($_SESSION['ID']);
$result = $p_bot->bot_account_register($idx, $id, $pw, $hash_key);

if($result)
    die_with_alert_box("성공", './#bot_setting');
else
    die_with_alert_box("설정하고자 하는 계정이 이미 존재합니다.", './#bot_setting');

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
?>
