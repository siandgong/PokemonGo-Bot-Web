<?php
require_once('db.php');

session_start();
if(empty ($_POST['id']) || empty ($_POST['pw'])){
    die("<script>alert('실패');history.go(-1)</script>");
}

$id = $_POST['id'];
$pw = $_POST['pw'];

if(!ctype_alnum($id))
    die_with_alert_box("아이디 형식이 올바르지 않습니다.", './#login');
else if(strlen($id) < 4|| strlen($pw) < 4)
    die_with_alert_box("아이디 혹은 비밀번호의 길이가 유효하지 않습니다.", './#login');


$pbot = new PokemonGo_Bot();
$result = $pbot->login($id, $pw);
if($result) {
    $_SESSION['ID'] = $pbot->safe_string($id);
    die("<script>location.href='./user';</script>");
    //die_with_alert_box("성공", '/user/');
}
else
    die_with_alert_box("아이디 혹은 비밀번호의 길이가 유효하지 않습니다.", './#login');
?>

<?php
// function list
function die_with_alert_box($msg, $href){
    die("<script>alert('$msg');location.href = '$href';</script>");
}

?>
