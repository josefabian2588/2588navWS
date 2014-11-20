<?php

ob_start('ob_gzhandler');

header('content-type: application/json; charset=utf-8');

include('includes/config.php');
include('includes/polyline.php');
include('includes/correctorortografico.php');
require_once 'stemm_es.php';


function normaliza($cadena)
{
    $originales  = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena      = utf8_decode($cadena);
    $cadena      = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena      = strtolower($cadena);
    return utf8_encode($cadena);
}




function obtenerNombreZona($cadena)
{
   /*
*************************
*   VERIFICA SI TIENE LA PALABRA "DE" O "EN"
*************************
*/

        
$trozos = explode(" ", $cadena);    

if(count($trozos)>=1) {

    $NombreZona="";
 //   $palabraZonaExtra="";
    $contadorBlackWord=0;
    $FraseInicial="";
            


for($i=0; $i<=count($trozos); $i++) { //Recorro todos los elementos


    if($trozos[$i] === 'de' or $trozos[$i] === 'en')
      {
          //  $ZonaActivada=true;
         //   if($LimiteNombreZona==0){  // 0 , primera vez que encuentra "de"  o "en" 
                
               if($contadorBlackWord===0){
                
                      $contadorBlackWord=1;

                     for($e=$i; $e<count($trozos); $e++)
                     {       
                          
                          if($contadorBlackWord===1){

                                //$NombreZona =$NombreZona. $trozos[$e+1]; 
                                $contadorBlackWord++;

                          }
                          else{ //if($contadorBlackWord>1)

                                if($trozos[$e] === 'de' or $trozos[$e] === 'en')
                                {   
                                        $NombreZona =$NombreZona.",";
                                       // $NombreZona =$NombreZona. $trozos[$e];     

                                }
                                else
                                {
                                    $NombreZona =$NombreZona." "; 
                                    $NombreZona =$NombreZona. $trozos[$e];
                                   // $NombreZona =$NombreZona." "; 

                                }

                          }

    

                     } //FIN for($e=$i; $e<count($trozos); $e++)

                 } //if($contadorBlackWord===0){     

             }  // FIN if($trozos[$i] === 'de' or $trozos[$i] === 'en')

             else{

                     if($contadorBlackWord===0){

                         $FraseInicial=$FraseInicial. $trozos[$i];
                         $FraseInicial =$FraseInicial." "; 
                     }
             }
             
     // }

   }

//$search_term = EliminarPalabrasComunesExtras($search_term);
$NombreZona = EliminarPalabrasComunesExtras($NombreZona);
$NombreZona=trim($NombreZona);
// $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $FraseInicial . "'";
//  mysql_query($sql_insertrecord);

    }

//return $NombreZona;

return array(    'FraseFinal' => $NombreZona,
                 'FraseInicial' => $FraseInicial);

}


function EliminarPalabrasComunes($cadena)
{
    
    $PalabrasComunes = array(
        'a',
        'el',
        ' los',
        'les',        
        'del',
        'y',
        'o',
        'u',
        'uno',
        'una',
        'varias',
        'todos',
        'todas',
        'un',
        'unos',
        'como',
        'algun',
        'varios',
        'tambien',
        'solo',
        'solamente',
        'sin',
        'que',
        'aqui',
        'alguno',
        'algunas',
        'es',
        'lo',
        'al',      
        'con',
        'las',
        'le',
        'la',
        ',',
        '.',
        ';',
        ':'

    );
    // return preg_replace('/\b('.implode('|',$PalabrasComunes).')\b/','',$cadena);
    // return preg_replace('/(?<!-)\b('.implode('|',$PalabrasComunes).')\b(?!-)/i','',$cadena);
    // return preg_replace('/\b('.implode('|',$PalabrasComunes).')\b/i','',$cadena);
    
    return implode(' ', array_filter(explode(' ', $cadena), function($word) use ($PalabrasComunes)
    {
        return !in_array($word, $PalabrasComunes);
    }));
    
}

function EliminarPalabrasComunesExtras($cadena)
{
    
    $PalabrasComunes = array(
        
        'de',
        'en'
        

    );
    // return preg_replace('/\b('.implode('|',$PalabrasComunes).')\b/','',$cadena);
    // return preg_replace('/(?<!-)\b('.implode('|',$PalabrasComunes).')\b(?!-)/i','',$cadena);
    // return preg_replace('/\b('.implode('|',$PalabrasComunes).')\b/i','',$cadena);
    
    return implode(' ', array_filter(explode(' ', $cadena), function($word) use ($PalabrasComunes)
    {
        return !in_array($word, $PalabrasComunes);
    }));
    
}

function PalabraDistritosPoblados($cadena)
{


    $PalabraDisPobla = array(
'abangares',
'acosta',
'aguirre',
'alajuela',
'alajuelita',
'alfaro ruiz',
'alvarado',
'aserri',
'atenas',
'bagaces',
'barva',
'belen',
'buenos aires',
'canas',
'carrillo',
'cartago',
'corredores',
'coto brus',
'curridabat',
'desamparados',
'dota',
'el guarco',
'escazu',
'esparza',
'flores',
'garabito',
'goicoechea',
'golfito',
'grecia',
'guacimo',
'guatuso',
'heredia',
'hojancha',
'jimenez',
'la cruz',
'la union',
'leon cortes',
'liberia',
'limon',
'los chiles',
'matina',
'montes de oro',
'mora',
'moravia',
'nandayure',
'naranjo',
'nicoya',
'oreamuno',
'orotina',
'osa',
'palmares',
'paraiso',
'parrita',
'perez zeledon',
'poas',
'pococi',
'puntarenas',
'puriscal',
'san carlos',
'san jose',
'san mateo',
'san rafael',
'san ramon',
'santa ana',
'santa barbara',
'santa cruz',
'santo domingo',
'sarapiqui',
'siquirres',
'talamanca',
'tarrazu',
'tibas',
'tilaran',
'turrialba',
'turrubares',
'upala',
'valverde vega',
'vazquez de coronado',
'acapulco',
'aguabuena',
'aguacaliente',
'aguas claras',
'aguas zarcas',
'alajuela',
'alajuelita',
'alegria',
'alfaro',
'angeles',
'anselmo llorente',
'arancibia',
'arenal',
'aserri',
'asuncion',
'atenas',
'bagaces',
'bahia ballena',
'barbacoas',
'barranca',
'barrantes',
'baru',
'barva',
'batan',
'bebedero',
'bejuco',
'belen',
'belen de nosarita',
'bijagua',
'bolivar',
'bolson',
'boruca',
'brasil',
'bratsi',
'briolley',
'brisas',
'brunka',
'buenavista',
'buenos aires',
'cabo velas',
'cachi',
'cahuita',
'cajon',
'calle blancos',
'canas',
'canas dulces',
'candelaria',
'candelarita',
'cangrejal',
'cano negro',
'canoas',
'capellades',
'carara',
'cariari',
'carmen',
'carmona',
'carrandi',
'carrillos',
'carrizal',
'cartagena',
'cascajal',
'catedral',
'ceiba',
'cervantes',
'chacarita',
'changena',
'chira',
'chires',
'chirripo',
'chomes',
'cinco esquinas',
'cipreses',
'cirri sur',
'cobano',
'colima',
'colinas',
'colon',
'colorado',
'concepcion',
'copey',
'corralillo',
'corredor',
'cot',
'cote',
'coyolar',
'cuajiniquil',
'curena',
'curridabat',
'curubande',
'cutris',
'damas',
'daniel flores',
'delicias',
'desamparaditos',
'desamparados',
'desmonte',
'diria',
'dos rios',
'duacari',
'dulce nombre',
'dulce nombre de jesus',
'el amparo',
'el roble',
'escazu',
'escobal',
'espiritu santo',
'esquipulas',
'filadelfia',
'florencia',
'florida',
'fortuna',
'frailes',
'garita',
'general',
'germania',
'golfito',
'granadilla',
'granja',
'gravilias',
'grecia',
'grifo alto',
'guacima',
'guacimal',
'guacimo',
'guadalupe',
'guadalupe (arenilla)',
'guaitil',
'guapiles',
'guayabo',
'guaycara',
'hacienda vieja',
'hatillo',
'heredia',
'hojancha',
'horquetas',
'hospital',
'huacas',
'ipis',
'isla del coco',
'jaco',
'jardin',
'jesus',
'jesus maria',
'jimenez',
'juan vinas',
'juntas',
'la cruz',
'la cuesta',
'la isabel',
'la suiza',
'la virgen',
'laguna',
'laurel',
'legua',
'leon xiii',
'lepanto',
'libano',
'liberia',
'limon',
'limoncito',
'llano bonito',
'llano grande',
'llanos de santa lucia',
'llanuras del gaspar',
'llorente',
'los chiles',
'los guido',
'macacona',
'mansion',
'manzanillo',
'mastate',
'mata de platano',
'mata redonda',
'matama',
'matina',
'mayorga',
'merced',
'mercedes',
'mercedes sur',
'miramar',
'mogote',
'monte romo',
'monte verde',
'monterrey',
'nacascolo',
'naranjito',
'naranjo',
'nicoya',
'nosara',
'occidental',
'oriental',
'orosi',
'orotina',
'pacayas',
'pacuarito',
'palmar',
'palmares',
'palmera',
'palmichal',
'palmira',
'paquera',
'para',
'paracito',
'paraiso',
'paramo',
'parrita',
'patalillo',
'patarra',
'pavas',
'pavon',
'pavones',
'pejibaye',
'penas blancas',
'picagres',
'piedades',
'piedades norte',
'piedades sur',
'piedras blancas',
'piedras negras',
'pilas',
'pitahaya',
'pital',
'pittier',
'platanares',
'pocora',
'pocosol',
'porozal',
'porvenir',
'potrero cerrado',
'potrero grande',
'pozos',
'puente de piedra',
'puerto carrillo',
'puerto cortes',
'puerto jimenez',
'puerto viejo',
'puntarenas',
'puraba',
'purral',
'quebrada grande',
'quebrada honda',
'quebradilla',
'quepos',
'quesada',
'rancho redondo',
'ribera',
'rio azul',
'rio blanco',
'rio cuarto',
'rio jimenez',
'rio naranjo',
'rio nuevo',
'rio segundo',
'rita',
'rivas',
'rodriguez',
'rosario',
'roxana',
'sabalito',
'sabana redonda',
'sabanilla',
'sabanillas',
'salitral',
'salitrillos',
'samara',
'san andres',
'san antonio',
'san cristobal',
'san diego',
'san felipe',
'san francisco',
'san francisco dos rios',
'san gabriel',
'san ignacio de acosta',
'san isidro',
'san isidro del general',
'san jeronimo',
'san joaquin de flores',
'san jorge',
'san jose',
'san jose de la montana',
'san josecito',
'san juan',
'san juan de dios',
'san juan de mata',
'san juan grande',
'san lorenzo',
'san luis',
'san marcos',
'san mateo',
'san miguel',
'san nicolas',
'san pablo',
'san pedro',
'san rafael',
'san rafael abajo',
'san rafael arriba',
'san ramon',
'san roque',
'san sebastian',
'san vicente',
'san vito',
'sanchez',
'santa ana',
'santa barbara',
'santa cecilia',
'santa cruz',
'santa elena',
'santa eulalia',
'santa lucia',
'santa maria',
'santa rita',
'santa rosa',
'santa teresita',
'santiago',
'santo domingo',
'santo tomas',
'sarapiqui',
'sarchi norte',
'sarchi sur',
'sardinal',
'savegre',
'sierpe',
'sierra',
'siquirres',
'sixaola',
'tabarcia',
'tacares',
'tamarindo',
'tambor',
'tapezco',
'tarbaca',
'tarcoles',
'tayutic',
'tejar',
'telire',
'tempate',
'tierra blanca',
'tierras morenas',
'tigra',
'tilaran',
'tirrases',
'tobosi',
'toro amarillo',
'tres equis',
'tres rios',
'trinidad',
'tronadora',
'tucurrique',
'tuis',
'tures',
'turrialba',
'turrucares',
'ulloa',
'union',
'upala',
'uruca',
'valle la estrella',
'varablanca',
'veintisiete de abril',
'venado',
'venecia',
'volcan',
'volio',
'vuelta de jorco',
'yolillal',
'zapotal',
'zapote',
'zaragoza',
'zarcero'


    );



 
/*
  
    if (in_array($cadena, $PalabraDisPobla) )
    {

        return true;
    }
    else
    {
        return false;
    }
*/
    return in_array($cadena, $PalabraDisPobla);

    
}


function ObtenerTerminosDirectorio()
{
    $sqlFilaTerminos = "SELECT id_search_term,term FROM  tb_search_term";
    $resFilaTerminos = mysql_query($sqlFilaTerminos);
    
    if (mysql_num_rows($resFilaTerminos) > 0) // verifica que exista algun termino  
        {
        //  $ArregloTermino =array(); //creo el arreglo que almacenara todas las palabras
        $contador = 0;
        while ($fila = mysql_fetch_assoc($resFilaTerminos)) {
            $var_id   = $fila['id_search_term'];
            $var_term = $fila['term'];
            $array    = explode(";", $var_term);
            
            foreach ($array as $values) {
                if ($contador == 0) {
                    $ArregloTermino = array();
                    //  $ArregloTermino =array($values,$var_id);
                    array_push($ArregloTermino, array(
                        $values,
                        $var_id
                    ));
                    $contador = 1;
                    
                } else
                    array_push($ArregloTermino, array(
                        $values,
                        $var_id
                    ));
                
                
            }
        }
    }
    return $ArregloTermino;
}


/*  SEGUNDO METODO PARA BUSCAR UN POBLADO */
function comprobarUltimaPalabra($palabrafinal)
{
    trim($palabrafinal);
    $result          = false;
    $sqlpalabrafinal = "SELECT distinct street, Match(street) AGAINST ('" . $palabrafinal . "')  as Score FROM  navigar_fetch_xmldata where Match(street) AGAINST ('" . $palabrafinal . "') ORDER BY Score DESC  limit 0,2";
    $resulFilaStreet     = mysql_query($sqlpalabrafinal);
    
    if (mysql_num_rows($resulFilaStreet) > 0) // verifica que existe algun city que concuerde 
        {
        
        $result = true;
        
    }
    
    return $result;
}





error_reporting(0);

if (!defined('ROOT_PATH')) {
    
    define('ROOT_PATH', realpath(dirname(dirname(__FILE__))));
    
}

if (!defined('DS')) {
    
    define("DS", DIRECTORY_SEPARATOR);
    
}

define("APPSTRING", "aHR0cDovL21hcHMuZ29vZ2xlYXBpcy5jb20vbWFwcy9hcGkvZGlyZWN0aW9ucy8=");

define("APPPLACE", "aHR0cHM6Ly9tYXBzLmdvb2dsZWFwaXMuY29tL21hcHMvYXBpL3BsYWNlLw==");

function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
{
    
    $pi80 = M_PI / 180;
    
    $lat1 *= $pi80;
    
    $lng1 *= $pi80;
    
    $lat2 *= $pi80;
    
    $lng2 *= $pi80;
    
    
    
    $r = 6372.797; // mean radius of Earth in km
    
    $dlat = $lat2 - $lat1;
    
    $dlng = $lng2 - $lng1;
    
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
    $km = $r * $c;
    
    
    
    return $km;
    
    return ($miles ? ($km * 0.621371192) : $km);
    
}



function decodePolylineToArray($encoded)
{
    
    $length = strlen($encoded);
    
    $index = 0;
    
    $points = array();
    
    $lat = 0;
    
    $lng = 0;
    
    
    
    while ($index < $length) {
        
        // Temporary variable to hold each ASCII byte.
        
        $b = 0;
        
        
        
        // The encoded polyline consists of a latitude value followed by a
        
        // longitude value.  They should always come in pairs.  Read the
        
        // latitude value first.
        
        $shift = 0;
        
        $result = 0;
        
        do {
            
            // The `ord(substr($encoded, $index++))` statement returns the ASCII
            
            //  code for the character at $index.  Subtract 63 to get the original
            
            // value. (63 was added to ensure proper ASCII characters are displayed
            
            // in the encoded polyline string, which is `human` readable)
            
            $b = ord(substr($encoded, $index++)) - 63;
            
            
            
            // AND the bits of the byte with 0x1f to get the original 5-bit `chunk.
            
            // Then left shift the bits by the required amount, which increases
            
            // by 5 bits each time.
            
            // OR the value into $results, which sums up the individual 5-bit chunks
            
            // into the original value.  Since the 5-bit chunks were reversed in
            
            // order during encoding, reading them in this way ensures proper
            
            // summation.
            
            $result |= ($b & 0x1f) << $shift;
            
            $shift += 5;
            
        } 
        // Continue while the read byte is >= 0x20 since the last `chunk`
            
        // was not OR'd with 0x20 during the conversion process. (Signals the end)
            while ($b >= 0x20);
        
        
        
        // Check if negative, and convert. (All negative values have the last bit
        
        // set)
        
        $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        
        
        
        // Compute actual latitude since value is offset from previous value.
        
        $lat += $dlat;
        
        
        
        // The next values will correspond to the longitude for this point.
        
        $shift = 0;
        
        $result = 0;
        
        do {
            
            $b = ord(substr($encoded, $index++)) - 63;
            
            $result |= ($b & 0x1f) << $shift;
            
            $shift += 5;
            
        } while ($b >= 0x20);
        
        
        
        $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        
        $lng += $dlng;
        
        
        
        // The actual latitude and longitude values were multiplied by
        
        // 1e5 before encoding so that they could be converted to a 32-bit
        
        // integer representation. (With a decimal accuracy of 5 places)
        
        // Convert back to original values.
        
        $points[] = array(
            $lat * 1e-5,
            $lng * 1e-5
        );
        
    }
    
    
    
    return $points;
    
}





$action = $_REQUEST['action'];

try {
    
    switch ($action) {
        
       
        
        
   
        
        case 'listpoiType':
            
            
            
            $sql = "select * from navigar_poitype";
            
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
            $search_termIntacto=$search_term; /* valor ingresado por el usuario como auxiliar */
            $search_term = EliminarPalabrasComunes($search_term); /*NO elimina "de" o "en"  */ 
           
            
       
            


/*
*************************
*   VERIFICA SI TIENE LA PALABRA "DE" O "EN"
*************************
*/


//$trozos = explode(" ", $search_term);    

//if(count($trozos)>1) {

   // $palabrafinal =obtenerNombreZona($search_term);
      $array = obtenerNombreZona($search_term); 
        $FraseFinal = trim($array['FraseFinal']);
        $FraseInicial = trim($array['FraseInicial']);

 //   $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $FraseFinal . "'";
//    mysql_query($sql_insertrecord);

//}


/*
        
$trozos = explode(" ", $search_term);    

if(count($trozos)>1) {

    $NombreZona="";
    $palabraZonaExtra="";
    $contadorZonaAUX=0;
            



//Recorro todos los elementos
for($i=1;$i<=count($trozos);$i++) {


    if($trozos[$i] === 'de' or $trozos[$i] === 'en')
      {
          //  $ZonaActivada=true;
            if($LimiteNombreZona==0){  // 0 , primera vez que encuentra "de"  o "en" 
                
               if($contadorZonaAUX==0){
                     for($e=$i; $e<count($trozos); $e++)
                     {                   
                        $NombreZona =$NombreZona. $trozos[$e+1];
                        $NombreZona =$NombreZona." ";  
                        $contadorZonaAUX++;

                     }
                  }      

                }  // 1 , segunda o + vez que encuentra "de"  o "en" 

      }

   }

$search_term = EliminarPalabrasComunesExtras($search_term);
$NombreZona = EliminarPalabrasComunesExtras($NombreZona);
$palabrafinal=trim($NombreZona);
  $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $NombreZona . "'";
  mysql_query($sql_insertrecord);

}
*/





            
            
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
                trim($search_term);
                
                
                
                $trozos         = explode(" ", $search_term);
                $numeroTrozos   = count($trozos);
                $numero         = count($trozos); //pendiente por eliminar numero
            //    $palabraInicial = $trozos[0];
                $palabraInicial = $FraseInicial; //pendiente por eliminar palabraInicial
                $palabrafinal = $FraseFinal;  //pendiente por eliminar palabraFinal

                 /*****************
                 /* BUSQUEDA DE TERMINOS PARA TERMINOS COMPUESTOS , USANDO  search_termIntacto  
                 /*****************/
                
                    
                     $ArregloTermino = ObtenerTerminosDirectorio();

                     

                   //    $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $FraseInicial . "'";
                    //   mysql_query($sql_insertrecord);



                foreach ($ArregloTermino as $obj_key => $termino) {
                    
                    foreach ($termino as $key => $value) {
                        
                        if ($coincidencia == 1) {
                            $var_id            = $value;
                            $TerminoEncontrado = 1;
                            break;
                        }
                        
                        if ($value === $search_termIntacto) //encuentra una similitud
                            $coincidencia = 1;
                    }
                    
                    //if para evitar delay
                    if ($coincidencia == 1) {
                        break;
                    } else {
                        $coincidencia = 0;
                    }
                    
                }





                
                 /*****************
                 /* BUSQUEDA DE TERMINOS  BASADO EN UNA PALABRA (PALABRA INICIAL)
                 /*****************/
                

                if ($TerminoEncontrado == 0) {

               // $ArregloTermino = ObtenerTerminosDirectorio();
                
                
                foreach ($ArregloTermino as $obj_key => $termino) {
                    
                    foreach ($termino as $key => $value) {
                        
                        if ($coincidencia == 1) {
                            $var_id            = $value;
                            $TerminoEncontrado = 1;
                            break;
                        }
                        
                        if ($value == $FraseInicial) //encuentra una similitud
                            $coincidencia = 1;
                    }
                    
                    //if para evitar delay
                    if ($coincidencia == 1) {
                        break;
                    } else {
                        $coincidencia = 0;
                    }
                    
                }


           }

/*

     $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $TerminoEncontrado . "'";
                        mysql_query($sql_insertrecord);

  $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $FraseInicial . "'";
                        mysql_query($sql_insertrecord);

   $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $FraseFinal . "'";
                        mysql_query($sql_insertrecord);

*/

               

                 /*****************       
                /*  PROCESO PARA OBTENER LOS POIS DEL TERMINO 
                /*****************/
                
                
                if ($TerminoEncontrado == 1) {
                   //    $sql_insertrecord = "insert into tb_SearchRecords set searchterm='entro!!'";
                  //     mysql_query($sql_insertrecord);

                    
                    
                    $sql = "SELECT Subhexcode FROM tb_search_term  where id_search_term = " . $var_id . "";
                    $res = mysql_query($sql);
                    $sql ="";
                    
                      
              
                    
                   //    $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $search_termIntacto . "'";
                   //    mysql_query($sql_insertrecord);
                    
                    /* OBTIENE LA PALABRA FINAL*/
                 
                   // $palabrafinal = $NombreZona;
                   // $palabrafinal=trim($NombreZona);
                    /*  OBTIENE SI CONCUERTA CON ALGUN STREET  */
                    /*
                    if ($numero > 1)
                        $resultPalabrafinal = comprobarUltimaPalabra($palabrafinal);
                    else

                        $resultPalabrafinal = false;
                        */
                    // $num  = mysql_num_rows($res);
                    
                       
                    if ($numeroTrozos > 1)
                    {
                    
                       $resultPalabrafinal=PalabraDistritosPoblados($FraseFinal);  //comprueba si la ultima plabra concuerda con algun poblado 

                      //  $sql_insertrecord = "insert into tb_SearchRecords set searchterm='entro!!'";
                     //  mysql_query($sql_insertrecord);


                       if ($resultPalabrafinal===false)
                             $resultPalabrafinal = comprobarUltimaPalabra($FraseFinal);  
                        
                    }
                      else

                        $resultPalabrafinal = false;


                     /* OBTIENE LA PALABRA FINAL*/
                 //   $palabrafinal = $trozos[$numero - 1];
                     //$palabrafinal = $NombreZona;
                    /*  OBTIENE SI CONCUERTA CON ALGUN STREET  */
                    /*
                    if ($numero > 1)
                        $resultPalabrafinal = true;
                    else
                        $resultPalabrafinal = false;
                    // $num  = mysql_num_rows($res);
                    */
                    
                    


                    /*********************
                    /*  INGRESA SI LA ULTIMA PALABRA CORRESPONDE A ALGUN POBLADO   
                    /***********************/



                    if ($resultPalabrafinal === true) {
                        
                    //    $search_termCortado = str_ireplace($palabrafinal, "", $search_term); // Crea una variable eliminando el nombre del poblado 

                 //       $sql_insertrecord = "insert into tb_SearchRecords set searchterm='hola!!!!'";
                  //     mysql_query($sql_insertrecord);

                        
                        
                        while ($fila = mysql_fetch_assoc($res)) {
                            
                            $var             = $fila['Subhexcode'];
                            $arraySubHexcode = explode(";", $var);


                            /*

                             $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_term . "') as Score,
                           (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating
                        FROM navigar_fetch_xmldata 
                        WHERE  Match(label) AGAINST ('" . $search_term . "')  
                       
                        ORDER BY Score DESC  limit 0,30";

                            */
                            
                        /*
                                $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $FraseInicial . "') as Score,
                                (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata 
                             where  Match(label) AGAINST ('" . $FraseInicial . "' )  and  Match(street) AGAINST ('" . $FraseFinal . "') ";
                            
*/


                              $sql = "SELECT id,label,street,latitude,longitude,phone,Match(street) AGAINST ('" . $FraseFinal . "') as Score,
                                (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata 
                             where  Match(label) AGAINST ('" . $FraseInicial . "' )  and  Match(street) AGAINST ('" . $FraseFinal . "') ";



                            $sql = $sql . " UNION";



                            
                            $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,Match(street) AGAINST ('" . $FraseFinal . "') as Score,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                    FROM navigar_fetch_xmldata  
                                    where Match(street) AGAINST ('" . $FraseFinal . "')  AND ( description = ";
                            
                            foreach ($arraySubHexcode as $values) {
                                
                                if ($arraySubHexcode[0] == $values) {
                                    
                                    $sql = $sql . "'" . $values . "'";
                                    
                                } else {
                                    $sql = $sql . " or description = '" . $values . "' ";
                                    
                                }
                                
                            }
                            
                            $sql = $sql . " ) ";
                        }
                        
                     //   $sql = $sql . "  ORDER BY Score DESC limit 0,40";

                         $sql = $sql . " HAVING distance < '" . $radius . "'  ORDER BY Score desc limit 0,15";


                         


/*
                          $sql = "SELECT id,label,street,latitude,longitude,phone,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata  
                            where Match(label) AGAINST ('" . $search_termCortado . "' )  and  Match(street) AGAINST ('" . $palabrafinal . "') ";
                                
                                
                                
                                
                                $sql = $sql . " UNION";
                                
                                $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                    FROM navigar_fetch_xmldata 
                                     where Match(street) AGAINST ('" . $palabrafinal . "') and description = ";
                                
                                foreach ($arraySubHexcode as $values) {
                                    
                                    if ($arraySubHexcode[0] == $values) {
                                        
                                        $sql = $sql . "'" . $values . "'";
                                        
                                    } else {
                                        $sql = $sql . " or description = '" . $values . "'   ";
                                        
                                    }
                                    
                                    
                                    
                                    
                                }
                                
                                $sql = $sql . " HAVING distance < '" . $radius . "'  ORDER BY distance limit 0,40";

*/


                         $res = mysql_query($sql);
                    
                         while($row[] = mysql_fetch_assoc($res));
                         mysql_free_result($res)
                         

                        $num = mysql_num_rows($res);

                         if ($num <= 0) {

                             $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_term . "') as Score,
                           (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating
                        FROM navigar_fetch_xmldata 
                        WHERE  Match(label) AGAINST ('" . $search_term . "')  
                       
                        ORDER BY Score DESC  limit 0,30";


                         }


                    
                    }
                    

                    
                    
                    
                    /*  INGRESA SI LA ULTIMA PALABRA *NO* CORRESPONDE A ALGUN STREET   */
                    else {
                        
                        if ($numeroTrozos == 1) {
                            
                     
           //        $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $search_term . "'";
           //        mysql_query($sql_insertrecord);

                            
                            // obtener el subhexcode                
                            while ($fila = mysql_fetch_assoc($res)) {
                                
                                
                                
                                $var             = $fila['Subhexcode'];
                                $arraySubHexcode = explode(";", $var);
                                
                                
                                $sql = "SELECT id,label,street,latitude,longitude,phone,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata  
                            where  Match(label) AGAINST ('" . $FraseInicial . "')  ";
                                
                                
                                
                                
                                $sql = $sql . " UNION";
                                
                                $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                    FROM navigar_fetch_xmldata 
                                     where description = ";
                                
                                foreach ($arraySubHexcode as $values) {
                                    
                                    if ($arraySubHexcode[0] == $values) {
                                        
                                        $sql = $sql . "'" . $values . "'";
                                        
                                    } else {
                                        $sql = $sql . " or description = '" . $values . "'   ";
                                        
                                    }
                                    
                                    
                                    
                                    
                                }
                                
                                $sql = $sql . " HAVING distance < '" . $radius . "'  ORDER BY distance limit 0,40";
                            }
                            
                        } //FIN 
                        
                        else {
                            
                            
                            /*
                            
                            $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_term . "') as Score,
                           (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating
                        FROM navigar_fetch_xmldata 
                        WHERE  Match(label) AGAINST ('" . $search_term . "')  
                       
                        ORDER BY Score DESC  limit 0,30";

                        */
                                
                                
             //  $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $search_term . "'";
        //         mysql_query($sql_insertrecord);
       
                                
                                
                             // obtener el subhexcode                
                            while ($fila = mysql_fetch_assoc($res)) {
                                
                                
                                
                                $var             = $fila['Subhexcode'];
                                $arraySubHexcode = explode(";", $var);
                                $sql="";
                                
                                /*
                                $sql = "SELECT id,label,street,latitude,longitude,phone,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata  
                            where  Match(label) AGAINST ('" . $search_termIntacto . "')  ";
                                
                                
                                
                                
                                $sql = $sql . " UNION";
                             

                         


                                $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                    FROM navigar_fetch_xmldata 
                                     where description = ";
                               
                             */  


                                      $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_termIntacto . "') as Score,
                                (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata 
                             where  Match(label) AGAINST ('" . $search_termIntacto . "' ) ";
                            
                      




                            
                            $sql = $sql . " UNION";

                            
                            $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,Match(street) AGAINST ('" . $palabrafinal . "') as Score,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                    FROM navigar_fetch_xmldata  
                                    where  description = ";


                                foreach ($arraySubHexcode as $values) {
                                    
                                    if ($arraySubHexcode[0] == $values) {
                                        
                                        $sql = $sql . "'" . $values . "'";
                                        
                                    } else {
                                        $sql = $sql . " or description = '" . $values . "'   ";
                                        
                                    }
                                    
                                    
                                    
                                    
                                }
                                
                              //  $sql = $sql . " HAVING distance < '" . $radius . "'  ORDER BY distance limit 0,40";
                                   $sql = $sql . "ORDER BY Score DESC  limit 0,30";
                            }


                            
                        } //FIN ELSE
                        
                         
                        
                        
                        
                    }
                    
                    
                    
             
                    
                    $res = mysql_query($sql);
                    
                    $num = mysql_num_rows($res);
                    
                    
                    if ($num > 0) {
                        
                        
                        
                        while ($row = mysql_fetch_object($res)) {
                            
                            $data[$x]['id'] = $row->id;
                            $_SQL           = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                            $_alreadyRev    = mysql_query($_SQL);
                            
                            $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                            
                            $res_rateC = mysql_query($sqlrateC);
                            
                            $row_rateC = mysql_fetch_object($res_rateC);
                            
                            $data[$x]['review_count'] = $row_rateC->rating;
                            
                            
                            
                            if (mysql_num_rows($_alreadyRev) > 0)
                                $data[$x]['already_reviewd'] = "true";
                            
                            else
                                $data[$x]['already_reviewd'] = "false";
                            
                            
                            
                            $data[$x]['label'] = $row->label;
                            
                            $data[$x]['street']   = $row->street;
                            $data[$x]['location'] = $row->location;
                            
                            $data[$x]['city'] = $row->city;
                            
                            $data[$x]['region'] = $row->region;
                            
                            $data[$x]['country'] = $row->country;
                            
                            $data[$x]['pincode'] = $row->pincode;
                            
                            $data[$x]['type'] = $row->type;
                            
                            $data[$x]['typeHex'] = $row->typeHex;
                            
                            $data[$x]['latitude'] = $row->latitude;
                            
                            $data[$x]['longitude'] = $row->longitude;
                            
                            $data[$x]['phone'] = $row->phone;
                            
                            $data[$x]['rating'] = $row->rating;
                            
                            
                            
                            $data[$x]['distance'] = $row->distance;
                            
                            
                            
                            $x++;
                        }
                        
                        $return = array(
                            
                            'error' => 0,
                            
                            'posts' => $data
                        );
                        
                        
                    } //if($num>0)
                    else {
                        $return = array(
                            
                            'error' => 0,
                            
                            'posts' => 'No result'
                            
                            
                            
                        );
                        
                    }
                    

                    
                } //termina busquedas por terminos 
                




                else {
                    
                    
                    
                    /* TERMINOS DE PRUEBA , EN ALGUN MOMENTO DIERON PROBLEMAS DE Busquedas
                    
                    coopecoronado
                    bar malibu
                    cima
                    plaza de cacao
                    
                    */
                    
                    // ******************************************  
                    // PRIMERA opcion de busqueda 
                    // Match(label) AGAINST ('" . $search_term . "')    
                    //  *******************************************     
                    
                    
                    /*  contar palabras  */
                    
                    /*
                    $trozos       = explode(" ", $search_term);
                    $numero       = count($trozos);
                    $palabrafinal = $trozos[$numero - 1];
                    */
                    
                    
                    
                    
                    /*SI ES SOLO UNA PALABRA , ORDENA POR DISTANCIA */
                    if ($numero == 1) {
                        

                        
                        /*  OBTIENE SI CONCUERTA CON ALGUN STREET  */
                    //    $resultPalabrafinal = comprobarUltimaPalabra($palabrafinal);
                        //    $resultPalabrafinal=false;
                        
                        /*  INGRESA SI LA ULTIMA PALABRA CORRESPONDE A ALGUN STREET   */
                        /*
                        if ($resultPalabrafinal == true) {
                            
                            
                            $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_term . "') as Score,
                         (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating
                        FROM navigar_fetch_xmldata 
                        WHERE  Match(label) AGAINST ('" . $search_term . "') and  Match(street) AGAINST ('" . $palabrafinal . "') 
                       
                        ORDER BY Score DESC  limit 0,30";
                            
                            
                        }
                        
                        else {
                            */
                            
                            $sql = "SELECT id,label,street,latitude,longitude,phone,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,

                       ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                       * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 

                        * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                        FROM navigar_fetch_xmldata 
                        WHERE  Match(label) AGAINST ('" . $search_term . "') or alias1=('" . $search_term . "' ) or alias2=('" . $search_term . "' ) or alias3=('" . $search_term . "' ) 
                        HAVING distance < '" . $radius . "' 
                        ORDER BY distance limit 0,30";
                            
                     //   }
                        
                    }
                    
                    
                     
                    /*                               */    
                    /*  SI ES *MAS* DE UNA PALABRA   */
                    /*                               */
                    else {
                        
                        
                        //   $palabrafinal=$trozos[$numero-1];
                        $result=PalabraDistritosPoblados($palabrafinal); 

                        
                        
                            /* la ultima palabra es un street */ 
                        if ($result == true) {


                            // ACTIVAR NUEVAMENTE !!!!!!!!!!!!!!!!!

                //         $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $search_term . "'";
                //         mysql_query($sql_insertrecord);
                            
                            $search_termCortado = str_ireplace($palabrafinal, "", $search_term);
                            
                            
                            $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_termCortado . "') as Score,
                           (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating
                        FROM navigar_fetch_xmldata 
                        WHERE  Match(label) AGAINST ('" . $search_termCortado . "')  and   Match(street) AGAINST ('" . $palabrafinal . "')";

                        $sql = $sql . " UNION ";


                        $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_termCortado . "') as Score,
                           (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating
                        FROM navigar_fetch_xmldata 
                        WHERE  Match(label) AGAINST ('" . $search_termCortado . "')  ";

                     

                         $sql = $sql . " ORDER BY Score DESC  limit 0,30";
                       

                           
                            
                            
                            /*
                            $sql = "SELECT id,label,street,latitude,longitude,phone,
                            (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                            
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 
                            
                            FROM navigar_fetch_xmldata 
                            WHERE  Match(label) AGAINST ('" . $search_term . "')  and   Match(street) AGAINST ('" . $palabrafinal . "') 
                            HAVING distance < '" . $radius . "' 
                            ORDER BY distance limit 0,30"; 
                            */




                        }
                        
                            /* ultima palabra no es un street */
                        else {
                            
                            /*  CORRECTOR ORTOGRAFICO */
                            
                            $Sugerencias = array();
                            $palabras    = explode(" ", $search_term);
                            $contador    = 1;
                            foreach ($palabras as $palabra) {
                                
                                
                                $resul = CorrectorOrtografico($palabra);
                                array_push($Sugerencias, $resul);
                            }
                            
                            $search_term = implode(" ", $Sugerencias);
                            
                         

                            $sql = "SELECT *,Match(label) AGAINST ('" . $search_term . "') as Score,
                            (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating 
                                         FROM navigar_fetch_xmldata 
                                          WHERE  Match(label) AGAINST ('" . $search_term . "') 
                                           ORDER BY Score DESC limit 0,30";
                            
                            
                            
                        }
                        
                        
                        
                    }
                    
                    $res = mysql_query($sql);
                    
                    
                    
                    $x = 0;
                    
                    $data = array();
                    
                    $num = mysql_num_rows($res);
                    
                    
                    
                    if ($num > 0) {
                        
                        while ($row = mysql_fetch_object($res)) {
                            
                            
                            
                            $data[$x]['id'] = $row->id;
                            
                            
                            
                            $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                            
                            $_alreadyRev = mysql_query($_SQL);
                            
                            
                            
                            
                            $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                            
                            $res_rateC = mysql_query($sqlrateC);
                            
                            $row_rateC = mysql_fetch_object($res_rateC);
                            
                            $data[$x]['review_count'] = $row_rateC->rating;
                            
                            
                            
                            
                            
                            //print_r($row_rate);
                            
                            if (mysql_num_rows($_alreadyRev) > 0)
                                $data[$x]['already_reviewd'] = "true";
                            
                            else
                                $data[$x]['already_reviewd'] = "false";
                            
                            
                            
                            $data[$x]['label'] = $row->label;
                            
                            $data[$x]['street']   = $row->street;
                            $data[$x]['location'] = $row->location;
                            
                            $data[$x]['city'] = $row->city;
                            
                            $data[$x]['region'] = $row->region;
                            
                            $data[$x]['country'] = $row->country;
                            
                            $data[$x]['pincode'] = $row->pincode;
                            
                            $data[$x]['type'] = $row->type;
                            
                            $data[$x]['typeHex'] = $row->typeHex;
                            
                            $data[$x]['latitude'] = $row->latitude;
                            
                            $data[$x]['longitude'] = $row->longitude;
                            
                            $data[$x]['phone'] = $row->phone;
                            
                            $data[$x]['rating'] = $row->rating;
                            
                            
                            
                            $data[$x]['distance'] = $row->distance;
                            
                            
                            
                            $x++;
                            
                        }
                        
                        $return = array(
                            
                            'error' => 0,
                            
                            'posts' => $data
                            
                            
                            
                        );
                        
                    } else {
                        
                        
                        
                        
                        //  ****************************************  
                        //  SEGUNDA metodo de busqueda
                        //   where  `label` like '%" . $search_term . "%' 
                        //  *******************************************  
                        
                        
                        
                        $sql = "SELECT id,label,street,latitude,longitude,phone,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,

                                         ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                                         * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 

                                         * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                                         FROM navigar_fetch_xmldata 
                                          where   `label` like '%" . $search_term . "%' 

                                         HAVING distance < '" . $radius . "' 
                                         ORDER BY distance limit 0,30";
                        
                        
                        
                        
                        
                        $res = mysql_query($sql);
                        
                        $x = 0;
                        
                        $data = array();
                        
                        $num = mysql_num_rows($res);
                        
                        
                        
                        if ($num > 0) {
                            
                            while ($row = mysql_fetch_object($res)) {
                                
                                
                                
                                $data[$x]['id'] = $row->id;
                                
                                
                                
                                $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                                
                                $_alreadyRev = mysql_query($_SQL);
                                
                                
                                
                                
                                $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                                
                                $res_rateC = mysql_query($sqlrateC);
                                
                                $row_rateC = mysql_fetch_object($res_rateC);
                                
                                $data[$x]['review_count'] = $row_rateC->rating;
                                
                                
                                
                                
                                
                                //print_r($row_rate);
                                
                                if (mysql_num_rows($_alreadyRev) > 0)
                                    $data[$x]['already_reviewd'] = "true";
                                
                                else
                                    $data[$x]['already_reviewd'] = "false";
                                
                                
                                
                                $data[$x]['label'] = $row->label;
                                
                                $data[$x]['street']   = $row->street;
                                $data[$x]['location'] = $row->location;
                                
                                $data[$x]['city'] = $row->city;
                                
                                $data[$x]['region'] = $row->region;
                                
                                $data[$x]['country'] = $row->country;
                                
                                $data[$x]['pincode'] = $row->pincode;
                                
                                $data[$x]['type'] = $row->type;
                                
                                $data[$x]['typeHex'] = $row->typeHex;
                                
                                $data[$x]['latitude'] = $row->latitude;
                                
                                $data[$x]['longitude'] = $row->longitude;
                                
                                $data[$x]['phone'] = $row->phone;
                                
                                $data[$x]['rating'] = $row->rating;
                                
                                
                                
                                $data[$x]['distance'] = $row->distance;
                                
                                
                                
                                $x++;
                                
                            }
                            
                            $return = array(
                                
                                'error' => 0,
                                
                                'posts' => $data
                                
                                
                                
                            );
                            
                            
                        } else {
                            
                            
                            //  *******************************************  
                            // TERCER opcion de busqueda
                            // match(label) AGAINST ('" . $search_term . "*' IN BOOLEAN MODE) 
                            //
                            //  *******************************************  
                            
                            
                            
                            
                            
                            $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_term . "') as Score,
                            (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating 
                             FROM navigar_fetch_xmldata 
                             WHERE  Match(label) AGAINST ('" . $search_term . "*' IN BOOLEAN MODE)  ORDER BY Score DESC  limit 0,20";
                            
                            
                            
                            $res = mysql_query($sql);
                            
                            
                            
                            $x = 0;
                            
                            $data = array();
                            
                            $num = mysql_num_rows($res);
                            
                            
                            
                            if ($num > 0) {
                                
                                while ($row = mysql_fetch_object($res)) {
                                    
                                    
                                    
                                    $data[$x]['id'] = $row->id;
                                    
                                    
                                    
                                    $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                                    
                                    $_alreadyRev = mysql_query($_SQL);
                                    
                                    
                                    
                                    
                                    $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                                    
                                    $res_rateC = mysql_query($sqlrateC);
                                    
                                    $row_rateC = mysql_fetch_object($res_rateC);
                                    
                                    $data[$x]['review_count'] = $row_rateC->rating;
                                    
                                    
                                    
                                    
                                    
                                    //print_r($row_rate);
                                    
                                    if (mysql_num_rows($_alreadyRev) > 0)
                                        $data[$x]['already_reviewd'] = "true";
                                    
                                    else
                                        $data[$x]['already_reviewd'] = "false";
                                    
                                    
                                    
                                    $data[$x]['label'] = $row->label;
                                    
                                    $data[$x]['street']   = $row->street;
                                    $data[$x]['location'] = $row->location;
                                    
                                    $data[$x]['city'] = $row->city;
                                    
                                    $data[$x]['region'] = $row->region;
                                    
                                    $data[$x]['country'] = $row->country;
                                    
                                    $data[$x]['pincode'] = $row->pincode;
                                    
                                    $data[$x]['type'] = $row->type;
                                    
                                    $data[$x]['typeHex'] = $row->typeHex;
                                    
                                    $data[$x]['latitude'] = $row->latitude;
                                    
                                    $data[$x]['longitude'] = $row->longitude;
                                    
                                    $data[$x]['phone'] = $row->phone;
                                    
                                    $data[$x]['rating'] = $row->rating;
                                    
                                    
                                    
                                    $data[$x]['distance'] = $row->distance;
                                    
                                    
                                    
                                    $x++;
                                    
                                }
                                
                                $return = array(
                                    
                                    'error' => 0,
                                    
                                    'posts' => $data
                                    
                                    
                                    
                                );
                                
                            } else {
                                
                                
                                //  ****************************************  
                                //  CUARTO metodo de busqueda
                                //   where  Match(label) AGAINST ('" . $search_term . "' WITH QUERY EXPANSION)
                                //  *******************************************  
                                
                                
                                $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $search_term . "') as Score,
                            (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating 
                             FROM navigar_fetch_xmldata 
                             where  Match(label) AGAINST ('" . $search_term . "' WITH QUERY EXPANSION)   ORDER BY Score DESC  limit 0,15";
                                
                                
                                $res = mysql_query($sql);
                                
                                
                                
                                $x = 0;
                                
                                $data = array();
                                
                                $num = mysql_num_rows($res);
                                
                                
                                
                                if ($num > 0) {
                                    
                                    while ($row = mysql_fetch_object($res)) {
                                        
                                        
                                        
                                        $data[$x]['id'] = $row->id;
                                        
                                        
                                        
                                        $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                                        
                                        $_alreadyRev = mysql_query($_SQL);
                                        
                                        
                                        
                                        
                                        $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                                        
                                        $res_rateC = mysql_query($sqlrateC);
                                        
                                        $row_rateC = mysql_fetch_object($res_rateC);
                                        
                                        $data[$x]['review_count'] = $row_rateC->rating;
                                        
                                        
                                        
                                        
                                        
                                        //print_r($row_rate);
                                        
                                        if (mysql_num_rows($_alreadyRev) > 0)
                                            $data[$x]['already_reviewd'] = "true";
                                        
                                        else
                                            $data[$x]['already_reviewd'] = "false";
                                        
                                        
                                        
                                        $data[$x]['label'] = $row->label;
                                        
                                        $data[$x]['street']   = $row->street;
                                        $data[$x]['location'] = $row->location;
                                        
                                        $data[$x]['city'] = $row->city;
                                        
                                        $data[$x]['region'] = $row->region;
                                        
                                        $data[$x]['country'] = $row->country;
                                        
                                        $data[$x]['pincode'] = $row->pincode;
                                        
                                        $data[$x]['type'] = $row->type;
                                        
                                        $data[$x]['typeHex'] = $row->typeHex;
                                        
                                        $data[$x]['latitude'] = $row->latitude;
                                        
                                        $data[$x]['longitude'] = $row->longitude;
                                        
                                        $data[$x]['phone'] = $row->phone;
                                        
                                        $data[$x]['rating'] = $row->rating;
                                        
                                        
                                        
                                        $data[$x]['distance'] = $row->distance;
                                        
                                        
                                        
                                        $x++;
                                        
                                    }
                                    
                                    $return = array(
                                        
                                        'error' => 0,
                                        
                                        'posts' => $data
                                        
                                        
                                        
                                    );
                                    
                                } else {
                                    
                                    $return = array(
                                        
                                        'error' => 0,
                                        
                                        'posts' => 'No result'
                                        
                                        
                                        
                                    );
                                    
                                }
                                
                                
                                
                            } //CUARTO  metodo de busqueda 
                            
                        } //TERCER metodo de busqueda 
                        
                    } // SEGUNDO  metodo de busqueda 
                    
                } // PRIMER metodo de busqueda 
                
                
            } else {
                throw new Exception("fields can not be null");
            }
            
            
            
            break;
            
            
           
        
        case 'listMainCategory':
            
            
            
            $sql = "select * from  navigar_categorias";
            
            $res = mysql_query($sql);
            
            $x = 0;
            
            while ($row = mysql_fetch_assoc($res)) {
                
                $data[$x]['id'] = $row['id'];
                
                $data[$x]['category_name'] = $row['category_name'];
                
                $data[$x]['category_image'] = $row['category_image'];
                
                if ($row['hexcode_range'] == '') {
                    
                    $range = 0;
                    
                } else {
                    
                    $range = 1;
                    
                }
                
                $data[$x]['hexcode_range'] = $range;
                
                $x++;
                
            }
            
            
            
            $return = array(
                
                'error' => 0,
                
                'posts' => $data
                
                
                
            );
            
            break;
        
        
        
        case 'listSubCategoryByMain':
            
            
            
            $par_id = ((isset($_REQUEST['catId'])) ? $_REQUEST['catId'] : '');
            
            
            
            $sql = "select * from  navigar_subcategorias where parent_id=" . $par_id;
            
            $res = mysql_query($sql);
            
            $numRes = mysql_num_rows($res);
            
            if ($numRes > 0) {
                
                $x = 0;
                
                while ($row = mysql_fetch_assoc($res)) {
                    
                    $data[$x] = $row;
                    
                    $x++;
                    
                }
                
                
                
                $return = array(
                    
                    'error' => 0,
                    
                    'posts' => $data
                    
                    
                    
                );
                
            } else {
                
                $return = array(
                    
                    'error' => 1,
                    
                    'posts' => 'No data found'
                    
                    
                    
                );
                
            }
            
            break;


        
        case 'getPOIPlaces':
            
            
            
            $c_latitude = ((isset($_REQUEST['c_latitude'])) ? $_REQUEST['c_latitude'] : '');
            
            $c_longitude = ((isset($_REQUEST['c_longitude'])) ? $_REQUEST['c_longitude'] : '');
            
            $distance = ((isset($_REQUEST['distance'])) ? $_REQUEST['distance'] : '');
            
            $typehex = ((isset($_REQUEST['typehex'])) ? $_REQUEST['typehex'] : '');
            
            $parent_ID = ((isset($_REQUEST['parent_ID'])) ? $_REQUEST['parent_ID'] : '');
            
            $imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');
            
            
            
            if ($c_latitude != '' && $c_longitude != '' && $distance != '') {
                
                
                
                if ($parent_ID != '') {
                    
                    $sql_cat = "select * from  navigar_categorias where id=" . $parent_ID;
                    
                    $res = mysql_query($sql_cat);
                    
                    //$numRes = mysql_num_rows($res);
                    
                    
                    
                    $row = mysql_fetch_assoc($res);
                    
                    $allType = $row['hexcode_range'];
                    
                    //echo $allType;
                    
                    $typeval = explode(',', $allType);
                    
                    $typevalAll = '';
                    
                    foreach ($typeval as $key) {
                        
                        //echo $key;
                        
                        $typevalAll .= "'" . $key . "',";
                        
                        
                        
                    }
                    
                    
                    
                    $last_all_Type = rtrim($typevalAll, ',');
                    
                    
                    
                    $sql = "SELECT 

                    *, 

                    ( 6371000 * acos( cos( radians('" . $c_latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $c_longitude . "')) + sin(radians('" . $c_latitude . "')) 

                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                    FROM navigar_fetch_xmldata where  typeHex IN (" . $last_all_Type . ") 

                    HAVING distance < '" . $distance . "' 

                    ORDER BY distance";
                    
                    
                    
                    $sql = "SELECT 

                    *, 

                    ( 6371000 * acos( cos( radians('" . $c_latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $c_longitude . "')) + sin(radians('" . $c_latitude . "')) 

                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                    FROM navigar_fetch_xmldata where  typeHex IN (" . $last_all_Type . ") 

                

                    ORDER BY distance LIMIT 70 ";
                    
                    
                    
                    //      echo $sql;
                    
                    
                    
                } else {
                    
                    //  echo "kjdfksd";
                    
                    $SQL = "SELECT duplicate_hexcode FROM navigar_subcategorias WHERE id='" . $typehex . "'";
                    
                    $fetchTypeHext = mysql_fetch_array(mysql_query($SQL));
                    
                    //echo $fetchTypeHext["duplicate_hexcode"];
                    
                    if ($fetchTypeHext["duplicate_hexcode"] != "") {
                        
                        $expHex = explode(",", $fetchTypeHext["duplicate_hexcode"]);
                        
                        //  echo sizeof($expHex);
                        
                        $tempStr = "";
                        
                        for ($k = 0; $k < sizeof($expHex); $k++) {
                            
                            $tempStr .= "'" . $expHex[$k] . "',";
                            
                        }
                        
                    }
                    
                    $typehex = $tempStr . "'" . $typehex . "'";
                    
                    //echo $typehex;
                    
                    //  exit;
                    
                    
                    
                    $sql = "SELECT 

                    *, 

                    ( 6371000 * acos( cos( radians('" . $c_latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $c_longitude . "')) + sin(radians('" . $c_latitude . "')) 

                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                    FROM navigar_fetch_xmldata where  typeHex IN (" . $typehex . ") 

                    HAVING distance < '" . $distance . "' 

                    ORDER BY distance";
                    
                    
                    
                    $sql = "SELECT 

                    *, 

                    ( 6371000 * acos( cos( radians('" . $c_latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $c_longitude . "')) + sin(radians('" . $c_latitude . "')) 

                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                    FROM navigar_fetch_xmldata where  typeHex IN (" . $typehex . ") 

                    

                    ORDER BY distance LIMIT 120";
                    
                    
                    
                    //  echo $sql;
                    
                    
                    
                }
                
                
                
                $res = mysql_query($sql);
                
                
                
                $x = 0;
                
                $data = array();
                
                $num = mysql_num_rows($res);
                
                
                
                
                
                if ($num > 0) {
                    
                    while ($row = mysql_fetch_object($res)) {
                        
                        
                        
                        $data[$x]['id'] = $row->id;
                        
                        $sqlrate = "select IFNULL((sum(t3.rate)/count(t3.id)),0) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                        
                        $res_rate = mysql_query($sqlrate);
                        
                        $row_rate = mysql_fetch_object($res_rate);
                        
                        
                        
                        // check for already reviewed
                        
                        $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                        
                        $_alreadyRev = mysql_query($_SQL);
                        
                        
                        
                        $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                        
                        $res_rateC = mysql_query($sqlrateC);
                        
                        $row_rateC = mysql_fetch_object($res_rateC);
                        
                        $data[$x]['review_count'] = $row_rateC->rating;
                        
                        
                        
                        //print_r($row_rate);
                        
                        if (mysql_num_rows($_alreadyRev) > 0)
                            $data[$x]['already_reviewd'] = "true";
                        
                        else
                            $data[$x]['already_reviewd'] = "false";
                        
                        
                        
                        $data[$x]['rating'] = $row_rate->rating;
                        
                        //exit();
                        
                        
                        
                        $data[$x]['label'] = $row->label;
                        
                        $data[$x]['street']   = $row->street;
                        $data[$x]['location'] = $row->location;
                        
                        $data[$x]['city'] = $row->city;
                        
                        $data[$x]['region'] = $row->region;
                        
                        $data[$x]['country'] = $row->country;
                        
                        $data[$x]['pincode'] = $row->pincode;
                        
                        $data[$x]['type'] = $row->type;
                        
                        $data[$x]['typeHex'] = $row->typeHex;
                        
                        $data[$x]['phone'] = $row->phone;
                        
                        $data[$x]['latitude'] = $row->latitude;
                        
                        $data[$x]['longitude'] = $row->longitude;
                        
                        
                        
                        
                        
                        
                        
                        $data[$x]['distance'] = $row->distance;
                        
                        
                        
                        $x++;
                        
                    }
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'posts' => $data
                        
                        
                        
                    );
                    
                }
                
                else {
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'posts' => 'No result'
                        
                        
                        
                    );
                    
                }
                
                
                
                
                
                
                
            } else {
                
                throw new Exception("fields can not be null");
                
            }
            
            
            
            
            
            
            
            break;
        
        case 'getPOIMap':
            
            
            
            $c_latitude = ((isset($_REQUEST['c_latitude'])) ? $_REQUEST['c_latitude'] : '');
            
            $c_longitude = ((isset($_REQUEST['c_longitude'])) ? $_REQUEST['c_longitude'] : '');
            
            $distance = ((isset($_REQUEST['distance'])) ? $_REQUEST['distance'] : '');
            
            $imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');
            
            
            
            if ($c_latitude != '' && $c_longitude != '' && $distance != '') {
                
                
                $sql = "SELECT *, 

                    ( 6371000 * acos( cos( radians('" . $c_latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $c_longitude . "')) + sin(radians('" . $c_latitude . "')) 

                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                    FROM navigar_fetch_xmldata 

                    HAVING distance < '" . $distance . "' 

                    ORDER BY distance";
                
                
                $res = mysql_query($sql);
                
                
                
                $x = 0;
                
                $data = array();
                
                $num = mysql_num_rows($res);
                
                
                
                
                
                if ($num > 0) {
                    
                    while ($row = mysql_fetch_object($res)) {
                        
                        
                        
                        $data[$x]['id'] = $row->id;
                        
                        $sqlrate = "select IFNULL((sum(t3.rate)/count(t3.id)),0) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                        
                        $res_rate = mysql_query($sqlrate);
                        
                        $row_rate = mysql_fetch_object($res_rate);
                        
                        
                        
                        // check for already reviewed
                        
                        $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                        
                        $_alreadyRev = mysql_query($_SQL);
                        
                        
                        
                        
                        $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                        
                        $res_rateC = mysql_query($sqlrateC);
                        
                        $row_rateC = mysql_fetch_object($res_rateC);
                        
                        $data[$x]['review_count'] = $row_rateC->rating;
                        
                        
                        
                        
                        //print_r($row_rate);
                        
                        if (mysql_num_rows($_alreadyRev) > 0)
                            $data[$x]['already_reviewd'] = "true";
                        
                        else
                            $data[$x]['already_reviewd'] = "false";
                        
                        
                        
                        $data[$x]['rating'] = $row_rate->rating;
                        
                        //exit();
                        
                        
                        
                        $data[$x]['label'] = $row->label;
                        
                        $data[$x]['street']   = $row->street;
                        $data[$x]['location'] = $row->location;
                        
                        $data[$x]['city'] = $row->city;
                        
                        $data[$x]['region'] = $row->region;
                        
                        $data[$x]['country'] = $row->country;
                        
                        $data[$x]['pincode'] = $row->pincode;
                        
                        $data[$x]['type'] = $row->type;
                        
                        $data[$x]['typeHex'] = $row->typeHex;
                        
                        $data[$x]['phone'] = $row->phone;
                        
                        $data[$x]['latitude'] = $row->latitude;
                        
                        $data[$x]['longitude'] = $row->longitude;
                        
                        
                        
                        
                        
                        
                        
                        $data[$x]['distance'] = $row->distance;
                        
                        
                        
                        $x++;
                        
                    }
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'posts' => $data
                        
                        
                        
                    );
                    
                }
                
                else {
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'posts' => 'No result'
                        
                        
                        
                    );
                    
                }
                
                
                
                
                
                
                
            } else {
                
                throw new Exception("fields can not be null");
                
            }
            
            
            
            
            
            
            
            break;
        
        case 'getPOIDetail':
            
            $imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');
            $pid  = ((isset($_REQUEST['pid'])) ? $_REQUEST['pid'] : '');
            
            
            
            if ($pid != '') {
                
                
                $sql = "SELECT *

                    FROM navigar_fetch_xmldata 

                    WHERE id = '" . $pid . "' ";
                
                
                $res = mysql_query($sql);
                
                
                
                $x = 0;
                
                $data = array();
                
                $num = mysql_num_rows($res);
                
                
                
                
                
                if ($num > 0) {
                    
                    while ($row = mysql_fetch_object($res)) {
                        
                        
                        
                        $data[$x]['id'] = $row->id;
                        
                        $sqlrate = "select IFNULL((sum(t3.rate)/count(t3.id)),0) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                        
                        $res_rate = mysql_query($sqlrate);
                        
                        $row_rate = mysql_fetch_object($res_rate);
                        
                        
                        
                        // check for already reviewed
                        
                        $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='" . $row->id . "' AND  imei='" . $imei . "' ";
                        
                        $_alreadyRev = mysql_query($_SQL);
                        
                        
                        
                        
                        $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=" . $row->id;
                        
                        $res_rateC = mysql_query($sqlrateC);
                        
                        $row_rateC = mysql_fetch_object($res_rateC);
                        
                        $data[$x]['review_count'] = $row_rateC->rating;
                        
                        
                        
                        
                        //print_r($row_rate);
                        
                        if (mysql_num_rows($_alreadyRev) > 0)
                            $data[$x]['already_reviewd'] = "true";
                        
                        else
                            $data[$x]['already_reviewd'] = "false";
                        
                        
                        
                        $data[$x]['rating'] = $row_rate->rating;
                        
                        //exit();
                        
                        
                        
                        $data[$x]['label'] = $row->label;
                        
                        $data[$x]['street']   = $row->street;
                        $data[$x]['location'] = $row->location;
                        
                        $data[$x]['city'] = $row->city;
                        
                        $data[$x]['region'] = $row->region;
                        
                        $data[$x]['country'] = $row->country;
                        
                        $data[$x]['pincode'] = $row->pincode;
                        
                        $data[$x]['type'] = $row->type;
                        
                        $data[$x]['typeHex'] = $row->typeHex;
                        
                        $data[$x]['phone'] = $row->phone;
                        
                        $data[$x]['latitude'] = $row->latitude;
                        
                        $data[$x]['longitude'] = $row->longitude;
                        
                        
                        
                        
                        
                        
                        
                        $data[$x]['distance'] = $row->distance;
                        
                        
                        
                        $x++;
                        
                    }
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'posts' => $data
                        
                        
                        
                    );
                    
                }
                
                else {
                    
                    $return = array(
                        
                        'error' => 0,
                        
                        'posts' => 'No result'
                        
                        
                        
                    );
                    
                }
                
                
                
                
                
                
                
            } else {
                
                throw new Exception("fields can not be null");
                
            }
            
            
            
            
            
            
            
            break;

        
        

        
        
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


        
      
        
       
        
        default:
            
            throw new Exception("Sorry no Action defined");
            
            break;
    }
}




catch (Exception $exc) {
    
    $return = array(
        
        'error' => 1,
        
        'msg' => $exc->getMessage(),
        
        'posts' => ''
        
    );
    
}


echo json_encode($return);

exit();

?>