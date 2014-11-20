<?php

ob_start('ob_gzhandler');

header('content-type: application/json; charset=utf-8');

require('includes/config.php');
include('includes/polyline.php');
include('includes/correctorortografico.php');
require_once 'stemm_es.php';
require  'helpers.php';



error_reporting(0);

if (!defined('ROOT_PATH')) {
    
    define('ROOT_PATH', realpath(dirname(dirname(__FILE__))));
    
}

if (!defined('DS')) {
    
    define("DS", DIRECTORY_SEPARATOR);
    
}


define("APPSTRING", "aHR0cDovL21hcHMuZ29vZ2xlYXBpcy5jb20vbWFwcy9hcGkvZGlyZWN0aW9ucy8=");

define("APPPLACE", "aHR0cHM6Ly9tYXBzLmdvb2dsZWFwaXMuY29tL21hcHMvYXBpL3BsYWNlLw==");






$action = $_REQUEST['action'];


try {


	 switch ($action) {

	 			
	 	case 'addPOINEW':

			$latitude = ((isset($_REQUEST['latitude'])) ? $_REQUEST['latitude'] : '');
            
            $longitude = ((isset($_REQUEST['longitude'])) ? $_REQUEST['longitude'] : '');
            
            $title = ((isset($_REQUEST['title'])) ? $_REQUEST['title'] : '');
            
            $street = ((isset($_REQUEST['street'])) ? $_REQUEST['street'] : '');
            
            $description = ((isset($_REQUEST['description'])) ? $_REQUEST['description'] : '');
            
            $typeHex = ((isset($_REQUEST['typeHex'])) ? $_REQUEST['typeHex'] : '');
            
            $phone = ((isset($_REQUEST['phone'])) ? $_REQUEST['phone'] : '');
            
            
            
            
            
            $main_category_id = ((isset($_REQUEST['main_category_id'])) ? $_REQUEST['main_category_id'] : '');
            
            
            
            $business_type = $_REQUEST["business_type"];
            
            
            
            
            
            if ($latitude != '' && $longitude != '' && $title != '') {
                
                
                
                $description_new = mysql_escape_string($description);
                
                //$day=date('Y-m-d h:i:s');
                
                
                
                if ($typeHex == "") {
                    
                    $typeHex = rand(1000, 99999);
                    
                    
                    
                    ## CHECK IF MAIN CATEGORY EXIST. IF NNOT ADD IT
                    
                    $SQL = " SELECT * FROM navigar_categorias WHERE category_name = '" . $business_type . "'   ";
                    
                    $_res = mysql_query($SQL);
                    
                    if (mysql_num_rows($_res) == 0) {
                        
                        $SQL = "INSERT INTO navigar_categorias SET category_name='" . $business_type . "', category_image='http://www.your242.com/newdts/Code/Code016/bluejay/trackIt/webservices/category_images/11.png'  ";
                        
                        mysql_query($SQL);
                        
                        $main_category_id = mysql_insert_id();
                        
                        $update = true;
                        
                    } else {
                        
                        $_fetch = mysql_fetch_array($_res);
                        
                        $main_category_id = $_fetch["id"];
                        
                        $update = true;
                        
                    }
                    
                    
                    
                    
                    
                    $fetchMaincat = mysql_fetch_array(mysql_query("SELECT hexcode_range FROM navigar_categorias WHERE id='" . $main_category_id . "'"));
                    
                    
                    
                    
                    
                    
                    
                    if ($fetchMaincat["hexcode_range"] != "") {
                        
                        $hexcode_range = $fetchMaincat["hexcode_range"] . "," . $typeHex;
                        
                    } else {
                        
                        $hexcode_range = $typeHex;
                        
                    }
                    
                    if ($update) {
                        
                        $SQL = "UPDATE navigar_categorias  SET hexcode_range='" . $hexcode_range . "' WHERE id='" . $main_category_id . "' ";
                        
                        mysql_query($SQL);
                        
                    }
                    
                    
                    
                }
                
                
                
                
                
                $sql = "insert into navigar_fetch_xmldata set 

                `label` = '" . $title . "',
                
                `phone` = '" . $phone . "',

                `comment` = '" . $description_new . "',

                `street` = '" . $street . "',

                `latitude` = '" . $latitude . "',

                `typeHex` = '" . $typeHex . "',

                `longitude` = '" . $longitude . "'";
                
                
                
                $res = mysql_query($sql);
                
                
                
                $last_insert_id = mysql_insert_id();
                
                
                
                
                
                if ($last_insert_id) {
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'msg' => 'inserted successully'
                        
                    );
                    
                } else {
                    
                    $return = array(
                        
                        'error' => 1,
                        
                        'msg' => 'error in insert'
                        
                    );
                    
                }
                
                
                
                
                
                
                
            } else {
                
                throw new Exception("fields can not be null");
                
            }
            
            

            break;








        case 'addReview':

            $poi_id = ((isset($_REQUEST['poi_id'])) ? $_REQUEST['poi_id'] : '');
            
            $review_desc = ((isset($_REQUEST['review_desc'])) ? $_REQUEST['review_desc'] : '');
            
            $rate = ((isset($_REQUEST['rate'])) ? $_REQUEST['rate'] : '');
            
            
            
            $imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');


            $review_desc=trim($review_desc);
            
            /* Quitar Acentos  */ 
            
            $review_desc=normaliza($review_desc);
       
            if ($poi_id != '' && $review_desc != '' && $rate != '') {
                
                
                
                $review_desc_new = mysql_escape_string($review_desc);
                
                $day = date('Y-m-d h:i:s');
                
                
                
                $sql = "insert into navigar_reviews (`poi_id`,`review_desc`,`submit_date`,`rate`,`imei`) values('" . $poi_id . "','" . $review_desc_new . "','" . $day . "','" . $rate . "','" . $imei . "')";
                
                
                
                $res = mysql_query($sql);
                
                
                
                $last_insert_id = mysql_insert_id();
                
                if ($last_insert_id) {
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'msg' => 'inserted successully'
                        
                    );
                    
                } else {
                    
                    $return = array(
                        
                        'error' => 1,
                        
                        'msg' => 'error in insert'
                        
                    );
                    
                }
                
                
                
                
                
                
                
            } else {
                
                throw new Exception("fields can not be null");
                
            }
            
            
            
            
            
            
            
            break;



     case 'getReview':       

     		$poi_id = ((isset($_REQUEST['poi_id'])) ? $_REQUEST['poi_id'] : '');
            
            $sql = "select * from navigar_reviews where poi_id='" . $poi_id . "'";
            
            $res = mysql_query($sql);
            
            $x = 0;
            
            while ($row = mysql_fetch_assoc($res)) {
                
                $data[$x] = $row;
                
                $x++;
                
            }
            
            $return = array(
                
                'error' => 0,
                
                'posts' => $data
                
                
                
            );
            
            
            
            break;



     case 'spellSearch':        


    		$search_term = ((isset($_REQUEST['search_term'])) ? $_REQUEST['search_term'] : '');
            $search_term = normaliza($search_term);
            $search_term=trim($search_term);
            $search_termIntacto=$search_term; /* valor ingresado por el usuario para uso  auxiliar */
            $search_term = EliminarPalabrasComunes($search_term);


            $trozos = explode(" ", $search_term);



if(1<count($trozos)){

    $NombreZona="";
    $palabraZonaExtra="";
    $contadorZonaAUX=0;

for($i=1;$i<=count($trozos);$i++) {


    if($trozos[$i] =='de' or $trozos[$i] =='en')
      {
          
            if($LimiteNombreZona==0){  /* 0 , primera vez que encuentra "de"  o "en" */
                
               if($contadorZonaAUX==0){
                     for($e=$i; $e<count($trozos); $e++)
                     {                   
                        $NombreZona =$NombreZona. $trozos[$e+1];
                        $NombreZona =$NombreZona." ";  
                        $contadorZonaAUX++;
                     }
                  }      

                }  /* 1 , segunda o + vez que encuentra "de"  o "en" */
                
      }

   }

$search_term = EliminarPalabrasComunesExtras($search_term);


   $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $NombreZona . "'";
   mysql_query($sql_insertrecord);

} // fin if(1<count($trozos))


 $main_category_id = ((isset($_REQUEST['main_category_id'])) ? $_REQUEST['main_category_id'] : '');
            
            $WC = "";
            
            
            if ($main_category_id != "") {
                
                // CHECK IF RANGE IS THERE
                
                $SQL = "SELECT * FROM navigar_categorias WHERE id='" . $main_category_id . "' ";
                
                $fetchCat = mysql_fetch_array(mysql_query($SQL));
                
                if ($fetchCat["hexcode_range"] == "") {
                    
                    $SQL = "SELECT id, duplicate_hexcode FROM navigar_subcategorias WHERE parent_id='" . $main_category_id . "'";
                    
                    $Res = mysql_query($SQL);
                    
                    //  echo $SQL;
                    
                    while ($Fetch = mysql_fetch_array($Res)) {
                        
                        if ($allType != "")
                            $allType .= "," . $Fetch['id'];
                        
                        else
                            $allType = $Fetch['id'];
                        
                        if ($Fetch['duplicate_hexcode'] != "") {
                            
                            $allType .= "," . $Fetch['duplicate_hexcode'];
                            
                        }
                        
                    }
                    
                    $typeval = explode(',', $allType);
                    
                    $typevalAll = '';
                    
                    foreach ($typeval as $key) {
                        
                        $typevalAll .= "'" . $key . "',";
                        
                    }
                    
                    $last_all_Type = rtrim($typevalAll, ',');
                    
                    $WC = " AND typeHex IN  (" . $last_all_Type . ") ";
                    
                    
                    
                    //$WC = " AND typeHex IN ( )";
                    
                } else {
                    
                    $allType = $fetchCat['hexcode_range'];
                    
                    $typeval = explode(',', $allType);
                    
                    $typevalAll = '';
                    
                    foreach ($typeval as $key) {
                        
                        $typevalAll .= "'" . $key . "',";
                        
                    }
                    
                    $last_all_Type = rtrim($typevalAll, ',');
                    
                    $WC = " AND typeHex IN  (" . $last_all_Type . ") ";
                    
                }
                
            }
            
            
            
            
            
            
            //modificado  Curita para el iphone 
            
            
            if (isset($_REQUEST['latitude'])) // verifica si viene una request desde una iphone
                {
                // si es verdadero asigna las variables que vienen del iphone latitude y longitude (no tiene el c_ al inicio)
                
                $latitude = ((isset($_REQUEST['latitude'])) ? $_REQUEST['latitude'] : '9.954376');
                
                $longitude = ((isset($_REQUEST['longitude'])) ? $_REQUEST['longitude'] : '-84.127636');
                
                
            } else {
                //si entra al falso es porq viene de un android 
                $latitude = ((isset($_REQUEST['c_latitude'])) ? $_REQUEST['c_latitude'] : '9.954376');
                
                $longitude = ((isset($_REQUEST['c_longitude'])) ? $_REQUEST['c_longitude'] : '-84.127636');
                
            }
            
            
            $imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');
            
            
            
            $location = $latitude . ',' . $longitude;
            
            
            
            $radius = ((isset($_REQUEST['radius'])) ? $_REQUEST['radius'] : '');
            
            
            //  curita para problema con el radios , 300000 es el que envia la aplicacion pero desde otros paises no funciona las busquedas 
            $radius = 20000000; // METROS
            
            
            if ($search_term != '') {
                
                
                
                $url1 = base64_decode(APPPLACE) . 'textsearch/json?query=' . urlencode($search_term) . '&sensor=true&key=AIzaSyCUNEgXFYxE3IzHKveGclIlCgDe6esSeWU&location=' . $location . '&radius=' . $radius;
                
                
                
                //echo $url1;
                
                $data_all = json_decode(file_get_contents($url1));
                
                //echo $data_all = file_get_contents($url1);
                
                //echo '<pre>';
                
                //          print_r($data_all->results);
                
                //          echo '</pre>';
                
                $x = 0;
                
                $data = array();
                
                $address = array();
                
                $addexplode = array();
                
                //print_r($data_all->results);
                
                //exit();
                
                foreach ($data_all->results as $mydata) {
                    
                    //echo 'arka';
                    
                    
                    
                    $address = $mydata->formatted_address;
                    
                    //print_r($address);
                    
                    $addexplode = explode(',', $address);
                    
                    $country = end($addexplode);
                    
                    
                    
                    $cno = count($addexplode);
                    
                    $street = '';
                    
                    foreach ($addexplode as $key => $val) {
                        
                        if ($key != $cno - 1) {
                            
                            
                            
                            $street .= $val . ',';
                            
                        }
                        
                        
                        
                    }
                    
                    //echo '**'.$street.'**';
                    
                    $streetNew = rtrim($street, ',');
                    
                    //echo $country;
                    
                    //exit();
                    
                    $sql = "select id,google_id from  navigar_fetch_xmldata where google_id='" . $mydata->id . "'";
                    
                    $res = mysql_query($sql);
                    
                    $numRes = mysql_num_rows($res);
                    
                    
                    
                    if ($numRes > 0) {
                        
                        
                        
                    } else {
                        
                        
                        
                        $sql_insert = "insert into navigar_fetch_xmldata set `label`='" . $mydata->name . "',`latitude`='" . $mydata->geometry->location->lat . "',`longitude`='" . $mydata->geometry->location->lng . "',`country`='" . $country . "',`street`='" . $streetNew . "', `google_id`='" . $mydata->id . "'";
                        $cr         = "Costa Rica";
                        if (strcasecmp($cr, $country) == 0) {
                            mysql_query($sql_insert);
                        }
                        
                    }
                }





                // ******************************************  
                // Busquedas por terminos , Directorio     
                //  *******************************************  


                $TerminoEncontrado = 0;
                $coincidencia      = 0;
                $search_term=trim($search_term);
                
                
                
              //  $trozos         = explode(" ", $search_term);
              //  $numero         = count($trozos);
                $palabraInicial = $trozos[0];





	 		

	 }//switch









}//try
















?>