<?php
session_start();
if(empty($_SESSION['ID']))
  die("error");

$file = file("./PokemonGo-Bot/output/{$_SESSION['ID']}.logs");
if($file){
	 $file = array_reverse($file);
	 $count = 0;
	 $imgs = '';
	 $logs = '';
	 foreach($file as $line){
			 if($count++ > 8)
					 break;
			 echo "<p style='color: rgb(255,255,255);margin:0 0 1em 0;font-size:12px'>{$line}</p>";
	 }
}
else {
  echo 'Not found';
}
?>
