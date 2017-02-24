<?php
require_once('db.php');

session_start();
if(empty ($_POST['id']) || empty ($_POST['pw'])){
    die("<script>alert('실패');history.go(-1)</script>");
}

$id = $_POST['id'];
$pw = $_POST['pw'];

if(!ctype_alnum($id))
    die_with_alert_box("아이디 형식이 올바르지 않습니다.", './#regist');
else if(strlen($id) < 4|| strlen($pw) < 4)
    die_with_alert_box("아이디 혹은 비밀번호의 길이가 유효하지 않습니다.", './#regist');


$pbot = new PokemonGo_Bot();
$result = $pbot->account_register($id, $pw, get_client_ip());
if($result)
    die_with_alert_box("성공", './#login');
else
    die_with_alert_box("가입하고자 하는 계정이 이미 존재합니다.", './#regist');
?>

<?php
// function list
function die_with_alert_box($msg, $href){
    die("<script>alert('$msg');location.href = '$href';</script>");
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
