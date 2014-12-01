<?

//http://xspell.tk/?page=api

function CorrectorOrtografico($cadena){

// $xt = "e8c1f50f9d79999617db34720c1dcd59"; token viejo
$xt = "e8c1f50f9d79999617db34720c1dcd59"; //01 dic 2014
$xs = $cadena;
$xu = "http://xspell.tk";
$xp = "api=spell&token=$xt&check=$xs";
$x = curl_init();
curl_setopt($x,CURLOPT_POST,1);
curl_setopt($x,CURLOPT_POSTFIELDS,$xp);
curl_setopt($x,CURLOPT_URL,$xu);
curl_setopt($x,CURLOPT_RETURNTRANSFER,1);
//$output = curl_exec($x);

 return $output = curl_exec($x);

}



?>