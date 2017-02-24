<?php
session_start();
if(empty($_SESSION['ID']))
        die('error');

$id = $_SESSION['ID'];
$output = shell_exec("pgrep -f -x 'bash.*{$id}.*_run.sh'");
$pids = explode("\n", $output);
foreach($pids as $pid){
    exec("kill -9 $pid");
}

$output = shell_exec("pgrep -f -x 'python.*pokecli.py.*{$id}.*{$id}.*'");
$pids = explode("\n", $output);
foreach($pids as $pid){
    exec("kill -9 $pid");
}

die_with_alert_box("종료 완료", "./#log");
function die_with_alert_box($msg, $href){
    die("<script>alert('$msg');location.href = '$href';</script>");
}

?>
