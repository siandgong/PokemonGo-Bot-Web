<?php
session_start();
if(empty($_SESSION['ID']))
    die('error');

$id = $_SESSION['ID'];
$output = shell_exec("pgrep -f -x 'bash.*{$id}.*_run.sh'");
if($output != '')
    die_with_alert_box("이미 실행중입니다.", "./#log");

chdir('PokemonGo-Bot');
$log_path = "./output/{$id}.logs";
if (file_exists($log_path))
    unlink($log_path);

exec("nohup ./{$id}_run.sh > $log_path 2>&1 </dev/null &");

die_with_alert_box("실행 완료", "./#log");
function die_with_alert_box($msg, $href){
    die("<script>alert('$msg');location.href = '$href';</script>");
}
?>
