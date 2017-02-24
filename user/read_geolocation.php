<?php
session_start();
if(empty($_SESSION['ID']))
  die("error");

require_once('../db.php');

$p_bot = new PokemonGo_Bot();
$idx = $p_bot->get_idx($_SESSION['ID']);

#last-location-ksg970312@gmail.com.json
$jsonfile = "./PokemonGo-Bot/data/last-location-{$p_bot->get_bot_email($idx)}.json";
$fp = fopen($jsonfile, 'r');
if($fp)
{
  $data = fread($fp, filesize($jsonfile));
  $obj = json_decode($data);
  fclose($fp);
  if($obj->lat == '')
    echo "37.520034, 126.9155836";
  else
    echo "{$obj->lat}, {$obj->lng}";
}
else
  echo "37.520034, 126.9155836";

?>
