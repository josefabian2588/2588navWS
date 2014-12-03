<?php

ob_start('ob_gzhandler');

header('content-type: application/json; charset=utf-8');

include('includes/config.php');
include('includes/polyline.php');
include('includes/correctorortografico.php');
//require_once 'stemm_es.php';


function ordenarArrayDistancia($a, $b) {
    return $a['distance'] - $b['distance'];
 }

/* agrega el signo "+" al inicio de las palabras IN BOOLEAN MODE" */
function palabraRequeridaBoolean($cadena)
{
    $result="";
    $trozos = explode(" ", trim($cadena));  

    for($i=0; $i<count($trozos); $i++) { //Recorro todos los elementos

        $result=$result. "+" .$trozos[$i];
        $result=$result." ";
    }

    return $result;

}




function obtenerNombreZonaRevision($cadena)
{
   /*
*************************
*   VERIFICA SI TIENE LA PALABRA "DE" O "EN"
*************************
*/

        
$trozos = explode(" ", $cadena);    

if(count($trozos)>=1) {

    $NombreZona="";
    $NombreZonaCompleto="";
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
                                        $NombreZonaCompleto =$NombreZonaCompleto." ";
                                        $NombreZonaCompleto =$NombreZonaCompleto. $trozos[$e];
                                       // $NombreZona =$NombreZona. $trozos[$e];     

                                }
                                else
                                {
                                    $NombreZona =$NombreZona." "; 
                                    $NombreZona =$NombreZona. $trozos[$e];
                                    $NombreZonaCompleto = $NombreZonaCompleto." ";
                                    $NombreZonaCompleto = $NombreZonaCompleto. $trozos[$e];
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

    }


//return array(    'FraseFinal' => $NombreZona,
 //                'FraseFinalCompleta' => $NombreZonaCompleto,   
//                 'FraseInicial' => $FraseInicial);

return $NombreZona;
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
    $NombreZonaCompleto="";
 //   $palabraZonaExtra="";
    $contadorBlackWord=0;
    $FraseInicial="";
    $testborrar="";  
   


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
                                $testborrar=$testborrar.$trozos[$e];
                                $testborrar =$testborrar." ";
                           
                                $contadorBlackWord++;

                          }
                          else{ //if($contadorBlackWord>1)

                                if($trozos[$e] === 'de' or $trozos[$e] === 'en')
                                {   
                                        $NombreZona =$NombreZona.",";
                                        $NombreZonaCompleto =$NombreZonaCompleto." ";
                                        $NombreZonaCompleto =$NombreZonaCompleto. $trozos[$e];
                                       // $NombreZona =$NombreZona. $trozos[$e];     
                                         $contadorBlackWord++;
                                }
                                else
                                {
                                    if ($contadorBlackWord<3) //3 siginifica q hay mas de 
                                    {
                                      $testborrar=$testborrar.$trozos[$e];
                                      $testborrar =$testborrar." ";

                                    }
                                  //   $testborrar=$testborrar.$trozos[$e];
                                   //   $testborrar =$testborrar." ";
                                    $NombreZona =$NombreZona." "; 
                                    $NombreZona =$NombreZona. $trozos[$e];
                                    $NombreZonaCompleto = $NombreZonaCompleto." ";
                                    $NombreZonaCompleto = $NombreZonaCompleto. $trozos[$e];
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
                         $testborrar=$testborrar.$trozos[$i];
                         $testborrar =$testborrar." ";

                     }
             }
             
     // }

   }

//$search_term = EliminarPalabrasComunesExtras($search_term);
$NombreZona = EliminarPalabrasComunesExtras($NombreZona);
$NombreZona=trim($NombreZona);

    }


return array(    'FraseFinal' => $NombreZona,
                 'FraseFinalCompleta' => $NombreZonaCompleto, 
                 'testborrartest' => $testborrar,   
                 'FraseInicial' => $FraseInicial);

}


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

function EliminarPalabrasComunes($cadena)
{
    
    $PalabrasComunes = array(
        'a',
        'el',
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
        'le',
        'la',
        'las',
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






function createRouteGeometry($mainArray) {
    $routes = array();
    foreach ($mainArray['route_geometry'] as $routeDirectory) {
        $routes[] = implode(",", $routeDirectory);
    }
    return $routes;
}

function generatePolyline($mainArray, $currentIndex) {
    $startindex = $mainArray['route_instructions'][$currentIndex]['2'];
    if (isset($mainArray['route_instructions'][($currentIndex + 1)])) {
        $endIndex = $mainArray['route_instructions'][$currentIndex + 1]['2'];
    } else {
        $total = count($mainArray['route_geometry']);
        $endIndex = ($total - 1);
    }
    for ($i = $startindex; $i <= $endIndex; $i++) {
        $routeGemetry[$i] = $mainArray['route_geometry'][$i];
    }
    return Polyline::Encode($routeGemetry);
}

error_reporting(0);

if (!defined('ROOT_PATH')) {

    define('ROOT_PATH', realpath(dirname(dirname(__FILE__))));

}

if (!defined('DS')) {

    define("DS", DIRECTORY_SEPARATOR);

}

define("APPSTRING","aHR0cDovL21hcHMuZ29vZ2xlYXBpcy5jb20vbWFwcy9hcGkvZGlyZWN0aW9ucy8=");

define("APPPLACE","aHR0cHM6Ly9tYXBzLmdvb2dsZWFwaXMuY29tL21hcHMvYXBpL3BsYWNlLw==");

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



  while ($index < $length)

  {

    // Temporary variable to hold each ASCII byte.

    $b = 0;



    // The encoded polyline consists of a latitude value followed by a

    // longitude value.  They should always come in pairs.  Read the

    // latitude value first.

    $shift = 0;

    $result = 0;

    do

    {

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

    do

    {

      $b = ord(substr($encoded, $index++)) - 63;

      $result |= ($b & 0x1f) << $shift;

      $shift += 5;

    }

    while ($b >= 0x20);



    $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));

    $lng += $dlng;



    // The actual latitude and longitude values were multiplied by

    // 1e5 before encoding so that they could be converted to a 32-bit

    // integer representation. (With a decimal accuracy of 5 places)

    // Convert back to original values.

    $points[] = array($lat * 1e-5, $lng * 1e-5);

  }



  return $points;

}

function xml2array($contents, $get_attributes=1, $priority = 'tag') {

    if(!$contents) return array();



    if(!function_exists('xml_parser_create')) {

        //print "'xml_parser_create()' function not found!";

        return array();

    }



    //Get the XML parser of PHP - PHP must have this module for the parser to work

    $parser = xml_parser_create('');

    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss

    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);

    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

    xml_parse_into_struct($parser, trim($contents), $xml_values);

    xml_parser_free($parser);



    if(!$xml_values) return;//Hmm...



    //Initializations

    $xml_array = array();

    $parents = array();

    $opened_tags = array();

    $arr = array();



    $current = &$xml_array; //Refference



    //Go through the tags.

    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array

    foreach($xml_values as $data) {

        unset($attributes,$value);//Remove existing values, or there will be trouble



        //This command will extract these variables into the foreach scope

        // tag(string), type(string), level(int), attributes(array).

        extract($data);//We could use the array by itself, but this cooler.



        $result = array();

        $attributes_data = array();

        

        if(isset($value)) {

            if($priority == 'tag') $result = $value;

            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode

        }



        //Set the attributes too.

        if(isset($attributes) and $get_attributes) {

            foreach($attributes as $attr => $val) {

                if($priority == 'tag') $attributes_data[$attr] = $val;

                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'

            }

        }



        //See tag status and do the needed.

        if($type == "open") {//The starting of the tag '<tag>'

            $parent[$level-1] = &$current;

            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag

                $current[$tag] = $result;

                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;

                $repeated_tag_index[$tag.'_'.$level] = 1;



                $current = &$current[$tag];



            } else { //There was another element with the same tag name



                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array

                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

                    $repeated_tag_index[$tag.'_'.$level]++;

                } else {//This section will make the value an array if multiple tags with the same name appear together

                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array

                    $repeated_tag_index[$tag.'_'.$level] = 2;

                    

                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well

                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];

                        unset($current[$tag.'_attr']);

                    }



                }

                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;

                $current = &$current[$tag][$last_item_index];

            }



        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'

            //See if the key is already taken.

            if(!isset($current[$tag])) { //New Key

                $current[$tag] = $result;

                $repeated_tag_index[$tag.'_'.$level] = 1;

                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;









            } else { //If taken, put all things inside a list(array)

                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...



                    // ...push the new element into that array.

                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

                    

                    if($priority == 'tag' and $get_attributes and $attributes_data) {

                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;

                    }

                    $repeated_tag_index[$tag.'_'.$level]++;



                } else { //If it is not an array...

                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value

                    $repeated_tag_index[$tag.'_'.$level] = 1;

                    if($priority == 'tag' and $get_attributes) {

                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well

                            

                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];

                            unset($current[$tag.'_attr']);

                        }

                        

                        if($attributes_data) {

                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;

                        }

                    }

                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken

                }

            }



        } elseif($type == 'close') { //End of tag '</tag>'

            $current = &$parent[$level-1];

        }

    }

    

    return($xml_array);

}  



/*require_once ROOT_PATH . DS . 'wp-load.php';

require_once ROOT_PATH . DS . 'webservices' . DS . 'libs' . DS . 'functions' . DS . 'function.php';

require_once ROOT_PATH . DS . 'webservices' . DS . 'libs' . DS . 'htmlpurify' . DS . 'library' . DS . 'HTMLPurifier.auto.php';*/



$action = $_REQUEST['action'];

try {

    switch ($action) {

        case 'getallData':

		foreach($_REQUEST as $key=>$val){

		$_REQUEST[$key] = strtolower($val);

	}

		

$latitude = ((isset($_REQUEST['latitude'])) ? $_REQUEST['latitude'] : '-33.8670522');

$longitude = ((isset($_REQUEST['longitude'])) ? $_REQUEST['longitude'] : '151.1957362');



$location=$latitude.','.$longitude;

            //$location = ((isset($_REQUEST['location'])) ? $_REQUEST['location'] : '-33.8670522,151.1957362');

			$distance = ((isset($_REQUEST['distance'])) ? $_REQUEST['distance'] : 500);

            $rankby = ((isset($_REQUEST['rankby'])) ? $_REQUEST['rankby'] : 'distance');

            $types = ((isset($_REQUEST['types'])) ? $_REQUEST['types'] : 'food');

            $sensor = ((isset($_REQUEST['sensor'])) ? $_REQUEST['sensor'] : 'false');

            $key = ((isset($_REQUEST['key'])) ? $_REQUEST['key'] : 'AIzaSyCUNEgXFYxE3IzHKveGclIlCgDe6esSeWU');

			$subtype = ((isset($_REQUEST['subtype'])) ? $_REQUEST['subtype'] : '');

			

			

			

	if( $latitude !='' && $longitude !='' && $rankby !='' && $types !='' && $sensor !='' && $key !=''){	

	

	if(is_numeric($types)){

				

				 $sqltype= "select * from navigar_poitype where id='".$types."'";

				 $restype=mysql_query($sqltype);

				 $rowtype=mysql_fetch_assoc($restype);

				 if(!empty($rowtype['name'])){

				

				 $nametypes= $rowtype['name'];

				 }else{

				throw new Exception("poitype is not correct");

							

							

				 }

				

				}else{

				$nametypes= $types;

				

				}

		

			

			$url= base64_decode(APPPLACE).'nearbysearch/json?location='.$location.'&radius='.$distance.'&types='.$nametypes.'&sensor='.$sensor.'&key='.$key;

			

			//echo $url;

			$data_all = json_decode(file_get_contents($url));

			//echo '<pre>';

			//print_r($data_all->results);

			//echo '</pre>';

			$x=0;

			$data = array();

			foreach($data_all->results as $mydata)

			{

				 //print_r($mydata) ;

				 //echo $mydata->geometry->location->lat.'<br>';

				 $data[$x]['latitude']= $mydata->geometry->location->lat;

				 $data[$x]['longitude']= $mydata->geometry->location->lng;

				 $data[$x]['name']= $mydata->name;

				 $data[$x]['types']= $mydata->types;

				 $data[$x]['vicinity']= $mydata->vicinity;

				 $data[$x]['icon']= $mydata->icon;

				 if(!empty($mydata->rating)){

				 	$data[$x]['rating']= $mydata->rating;

				 }else{

				 	$data[$x]['rating']= 0;

				 }

				 $valdistance=distance($latitude, $longitude, $mydata->geometry->location->lat, $mydata->geometry->location->lng, $miles = true);

				 

				 $valdistancetwo=$valdistance*1000;

				 $vnew= number_format($valdistancetwo,1);

				 $data[$x]['distance']=$vnew;

				 

			$x++;

			} 

				/*echo '<pre>';

							//print_r($data_all->results);

							

				print_r($data);echo '</pre>';

				exit();*/



				if(is_numeric($types)){

				$tabletypes=$types;

				}else{

				 $sqltype= "select * from navigar_poitype where name='".$types."'";

				 $restype=mysql_query($sqltype);

				 $numtype=mysql_num_rows($restype);

				 if($numtype>0){

				 $rowtype=mysql_fetch_array($restype);

				 $tabletypes= $rowtype['id'];

				 }else{

					

							throw new Exception("poitype is not correct");

				 }

				}



if($subtype==''){

$subtypequery='';

}else{

$subtypequery=" and subtype='".strtolower($subtype)."'";

}

$sql="SELECT t1.*,t2.name as `type`,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=t1.id )as rating,  ( 6371000 * acos( cos( radians('".$latitude."') ) * cos( radians( t1.latitude) ) * cos( radians(t1.longitude) - radians('".$longitude."')) + sin(radians('".$latitude."')) * sin( radians(t1.latitude)))) AS distance FROM navigar_poi as t1

inner join navigar_poitype as t2 on t2.id=t1.poi_type

 WHERE poi_type='".$tabletypes."' ".$subtypequery." HAVING distance < '".$distance."'";

				

		//echo $sql;

				$res= mysql_query($sql);

				$num= mysql_num_rows($res);

				if($num>0){

					while($row=mysql_fetch_object($res)){

					

					 $data[$x]['id']= $row->id;

					 	 $data[$x]['latitude']= $row->latitude;

						 $data[$x]['longitude']= $row->longitude;

						 $data[$x]['name']= $row->poi_name;

						 $data[$x]['types']= array($row->type);

						 $data[$x]['icon']= '';

						 $data[$x]['vicinity']='';

						 if($row->rating!=0){

						 	$data[$x]['rating']= number_format($row->rating,2);

						 }else{

						 	$data[$x]['rating']= 0;

						 }

						 $valdist=$row->distance;

						 $vnewsecond= number_format($valdist,1);

						 $data[$x]['distance']=$vnewsecond;

						 $data[$x]['subtype']= $row->subtype;

						 

					$x++;

					}

				}

/*echo '<pre>';

print_r($data);

echo '</pre>';

exit;*/

				$return = array(

								'error' => 0,

								'posts' => $data

								

							);

	}else{

				$return = array(

								'error' => 0,

								'msg' => 'fields can not be null',

								'posts' => ''

								

								

							);

		}

            break; 
			
			
		case 'getAddressByName':
		$_address = $_REQUEST["address"];
		$url1 = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($_address)."&sensor=false";
		$ch = curl_init($url1);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$_jsonData = curl_exec($ch);
		curl_close($ch);
		$return = json_decode($_jsonData,true);
		break;
		

		case 'addPOI':



            $latitude = ((isset($_REQUEST['latitude'])) ? $_REQUEST['latitude'] : '');

            $longitude = ((isset($_REQUEST['longitude'])) ? $_REQUEST['longitude'] : '');

            $name = ((isset($_REQUEST['name'])) ? $_REQUEST['name'] : '');

            $poitype = ((isset($_REQUEST['poitype'])) ? $_REQUEST['poitype'] : '');

			$subtype = ((isset($_REQUEST['subtype'])) ? $_REQUEST['subtype'] : '');

			/*$latitude = $_REQUEST['latitude'];

            $longitude = $_REQUEST['longitude'];

            $name = $_REQUEST['name'];

            $poitype = $_REQUEST['poitype'];*/

			if( $latitude !='' && $longitude !='' && $name !='' && $poitype !=''){

			

				if(is_numeric($poitype)){

			

					$intpoitype=$poitype;

					

				}else{

				$poiname=strtolower($poitype);

				$sqlselect = "select id from navigar_poitype where `name`='".$poiname."'";

				$resselect = mysql_query($sqlselect);

				$numselect = mysql_num_rows($resselect);

				if($numselect>0){

				$rowselect = mysql_fetch_array($resselect);

				

				//exit();

				

					//throw new Exception("this poi type is exists in database");

				$intpoitype	= $rowselect['id']; 

				}else{

				

					$sqlint="insert into navigar_poitype set `name` = '".$poiname."'";

		  

		 		 $resint=mysql_query($sqlint);

		  

		 		 $intpoitype=mysql_insert_id();

				 }

					

				}

			

				$sql="insert into navigar_poi (`latitude`,`longitude`,`poi_name`,`poi_type`,`subtype`) values('".$latitude."','".$longitude."','".$name."','".$intpoitype."','".$subtype."')";

		  

		  		$res=mysql_query($sql);

		  

		 		 $last_insert_id=mysql_insert_id();

		  if($last_insert_id){

			  $return = array(

        		'error' => 0,

        		'msg' => 'inserted successully'

    			);

			}else{

				$return = array(

        		'error' => 1,

        		'msg' => 'error in insert'

    			);

			}

		  

			

			}else{

				$return = array(

        'error' => 1,

        'msg' => 'fields can not be null'

    );

			

			}

			

           break; 

		   

		   case 'listpoiType':



            $sql = "select * from navigar_poitype";

			$res= mysql_query($sql);

			$x=0;

			while($row= mysql_fetch_assoc($res)){

				$data[$x]= $row;

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

           

			if( $poi_id !='' && $review_desc !='' && $rate !=''){

			

			$review_desc_new= mysql_escape_string($review_desc);

			$day=date('Y-m-d h:i:s');

				

				$sql="insert into navigar_reviews (`poi_id`,`review_desc`,`submit_date`,`rate`,`imei`) values('".$poi_id."','".$review_desc_new."','".$day."','".$rate."','".$imei."')";

		  

		  		$res=mysql_query($sql);

		  

		 		 $last_insert_id=mysql_insert_id();

		  if($last_insert_id){

			  $return = array(

        		'error' => 0,

        		'msg' => 'inserted successully'

    			);

			}else{

				$return = array(

        		'error' => 1,

        		'msg' => 'error in insert'

    			);

			}	

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break;

		case 'getReview':

		

		 $poi_id = ((isset($_REQUEST['poi_id'])) ? $_REQUEST['poi_id'] : '');

		 $sql = "select * from navigar_reviews where poi_id='".$poi_id."'";

			$res= mysql_query($sql);

			$x=0;

			while($row= mysql_fetch_assoc($res)){

				$data[$x]= $row;

				$x++;

			}

			$return = array(

								'error' => 0,

								'posts' => $data

								

							);

		 

		break;

		case 'addEvent':

		

		 $c_latitude = ((isset($_REQUEST['c_latitude'])) ? $_REQUEST['c_latitude'] : '');

            $c_longitude = ((isset($_REQUEST['c_longitude'])) ? $_REQUEST['c_longitude'] : '');

            $event_type = ((isset($_REQUEST['event_type'])) ? $_REQUEST['event_type'] : '');

			$description = ((isset($_REQUEST['description'])) ? $_REQUEST['description'] : '');

           

			if( $c_latitude !='' && $c_longitude !='' && $event_type !=''){

			

			$desc_new= mysql_escape_string($description);

			//$day=date('Y-m-d h:i:s');

				

				$sql="insert into navigar_events (`latitude`,`longitude`,`event_type`,`description`, `added_date`) values('".$c_latitude."','".$c_longitude."','".$event_type."','".$desc_new."', '".time()."')";

				

		  

		  		$res=mysql_query($sql);

		  

		 		 $last_insert_id=mysql_insert_id();

		  if($last_insert_id){

			  $return = array(

        		'error' => 0,

        		'msg' => 'inserted successully'

    			);

			}else{

				$return = array(

        		'error' => 1,

        		'msg' => 'error in insert'

    			);

			}	

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break;

		case 'viewRoadEvents':

		

		 $c_latitude = ((isset($_REQUEST['c_latitude'])) ? $_REQUEST['c_latitude'] : '');

            $c_longitude = ((isset($_REQUEST['c_longitude'])) ? $_REQUEST['c_longitude'] : '');

            $distance = ((isset($_REQUEST['distance'])) ? $_REQUEST['distance'] : '');

			

			

           

			if( $c_latitude !='' && $c_longitude !='' && $distance !=''){

			

			

				$sql="insert into navigar_events (`latitude`,`longitude`,`event_type`,`description`) values(,'".$c_longitude."','".$event_type."','".$description."')";

				

				$mktime_threehours = mktime(date("G")-3,date("i"),date("s"),date("n"),date("j"),date("Y"));

				

				

				$sql="SELECT 

  *, 

   ( 6371000 * acos( cos( radians('".$c_latitude."') ) * cos( radians( navigar_events.latitude ) ) 

   * cos( radians(navigar_events.longitude) - radians('".$c_longitude."')) + sin(radians('".$c_latitude."')) 

   * sin( radians(navigar_events.latitude)))) AS distance 

FROM navigar_events WHERE added_date BETWEEN ".$mktime_threehours." AND ".time()." 

HAVING distance < '".$distance."' 

ORDER BY distance";

				

		$res= mysql_query($sql);

				

				$x=0;

				$data=array();

				$num= mysql_num_rows($res);

				

				if($num>0){

					while($row=mysql_fetch_object($res)){

					

					 $data[$x]['id']= $row->id;

					 	 $data[$x]['latitude']= $row->latitude;

						 $data[$x]['longitude']= $row->longitude;

						 $data[$x]['event_type']= $row->event_type;

						 $data[$x]['description']= $row->description;

						

						 $data[$x]['distance']= $row->distance;

						 

					$x++;

					}

					$return = array(

								'error' => 0,

								'posts' => $data

								

							);

				}

				else{

					$return = array(

								'error' => 0,

								'posts' => 'No result'

								

							);

				}

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break;

		case 'spellSearch':

		
	
		
          
            $search_term = ((isset($_REQUEST['search_term'])) ? $_REQUEST['search_term'] : '');
            $search_term = normaliza($search_term);
            $search_term=trim($search_term);
            $search_termIntacto=$search_term; /* valor ingresado por el usuario como auxiliar */
            $search_term = EliminarPalabrasComunes($search_term); /*NO elimina "de" o "en"  */ 

            
            //*** 09-4-14 insertar el registro de la busqueda 
            
            $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $search_term . "'";
            mysql_query($sql_insertrecord);
            
           

/*
*************************
*   VERIFICA SI TIENE LA PALABRA "DE" O "EN"
*************************
*/
            /* FRASE EJ : SPOON DE SAN PEDRO DE LIMON */
            /* FRASE EJ : BANCO DE COSTA RICA DE SAN PEDRO */
            /* FRASE EJ : BANCO NACIONAL DE SAN PEDRO */
        $array = obtenerNombreZona($search_term); 
        $FraseFinal = trim($array['FraseFinal']);  /*  almacena : san pedro , limon  /  almacena : banco  / almacena :  san pedro*/ 
        $FraseFinalCompleta = trim($array['FraseFinalCompleta']); /*almacena :  san pedro  de limon  /  almacena :  costa rica de san pedro  /  almacena : san pedro*/ 
        $FraseInicial = trim($array['FraseInicial']); /*almacena :  spoon   /  almacena : banco  / almacena : BANCO NACIONAL*/
        $testborrar = trim($array['testborrartest']);/* frase con solo el primer DE y hasta el siquiente  
                                                        almacena : spoon de san pedro   / almacena : banco de costa rica /  almacena : banco nacional de san pedro  */


            

                 /* PERMITE OBTENER EL NOMBRE DEL POBLADO DESPUES DE LA COMA , EJ costa rica, san pedro , DA COMO RESULTADO  san pedro */
        if(str_word_count($FraseInicial,0)<=1)
        {
              $sql = "SELECT id,Match(label) AGAINST ('" . $testborrar . "') as Score FROM navigar_fetch_xmldata where  Match(label) AGAINST ('" . $testborrar . "' )";
              $sql = $sql . " HAVING Score > 10" ;
              $res = mysql_query($sql);
              $num = mysql_num_rows($res);

               

            if ($num>0){
                $FraseInicial=EliminarPalabrasComunesExtras($testborrar);

                $FraseFinalAUX=$FraseFinal;
                $arraytest1=explode(" ",EliminarPalabrasComunesExtras($testborrar));
                array_push($arraytest1, ","); /* AGREGA UNA COMA AL FINAL  */

                   for($i=0; $i<count($arraytest1); $i++) { //Recorro todos los elementos

                        $FraseFinalAUX = str_ireplace($arraytest1[$i], "", $FraseFinalAUX);

                     }

                            $FraseFinal= trim($FraseFinal);
                            $FraseFinalAUX= trim($FraseFinalAUX);

                            if(strlen($FraseFinalAUX)>0)
                            {
                                if(strlen($FraseFinalAUX) < strlen($FraseFinal))
                                {
                                     $FraseFinal=$FraseFinalAUX;
                                }   

                            }
                  
                    
            }

        }
		 
		 

		 $main_category_id = ((isset($_REQUEST['main_category_id'])) ? $_REQUEST['main_category_id'] : ''); 

		 $WC = "";

		 if ($main_category_id!=""){

		 	// CHECK IF RANGE IS THERE

			$SQL = "SELECT * FROM navigar_maincategories WHERE id='".$main_category_id."' ";

			$fetchCat = mysql_fetch_array(mysql_query($SQL));

			if ($fetchCat["hexcode_range"]==""){

				$SQL = "SELECT id, duplicate_hexcode FROM navigar_subcategories WHERE parent_id='".$main_category_id."'";

				$Res = mysql_query($SQL);

			//	echo $SQL;

				while ($Fetch = mysql_fetch_array($Res)){

					if ($allType!="")

					$allType .= ",".$Fetch['id'];

					else

					$allType = $Fetch['id'];

					if ($Fetch['duplicate_hexcode']!=""){

						$allType .= ",".$Fetch['duplicate_hexcode'];

					}

				}

				$typeval = explode(',',$allType);

				$typevalAll = '';

				foreach($typeval as $key) {

					$typevalAll .= "'".$key."',";

				}

				$last_all_Type = rtrim($typevalAll, ',');

				$WC = " AND typeHex IN  (".$last_all_Type.") ";

			

				//$WC = " AND typeHex IN ( )";

			}else{

				$allType = $fetchCat['hexcode_range'];

				$typeval = explode(',',$allType);

				$typevalAll = '';

				foreach($typeval as $key) {

					$typevalAll .= "'".$key."',";

				}

				$last_all_Type = rtrim($typevalAll, ',');

				$WC = " AND typeHex IN  (".$last_all_Type.") ";

			}

		 }

		 

		 

	//modificado fabian Curita para el iphone 


if(isset($_REQUEST['latitude']) )  // verifica si viene una request desde una iphone
{ 
	// si es verdadero asigna las variables que vienen del iphone latitude y longitude (no tiene el c_ al inicio)

		$latitude = ((isset($_REQUEST['latitude'])) ? $_REQUEST['latitude'] : '9.95448');

		$longitude = ((isset($_REQUEST['longitude'])) ? $_REQUEST['longitude'] : '-84.127692');
	
} 
else 
{ 
	//si entra al falso es porq viene de un android 
  $latitude = ((isset($_REQUEST['c_latitude'])) ? $_REQUEST['c_latitude'] : '9.95448');

  $longitude = ((isset($_REQUEST['c_longitude'])) ? $_REQUEST['c_longitude'] : '-84.127692');
} 	 

		 

$imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');



$location=$latitude.','.$longitude;



$radius = ((isset($_REQUEST['radius'])) ? $_REQUEST['radius'] : '');

          

			if( $search_term !=''){

			
			
			//  curita para problema con el radios , 300000 es el que envia la aplicacion pero desde otros paises no funciona las busquedas 
			$radius=20000000; // METROS
			//

			$url1=  base64_decode(APPPLACE).'textsearch/json?query='.urlencode($search_term).'&sensor=true&key=AIzaSyCUNEgXFYxE3IzHKveGclIlCgDe6esSeWU&location='.$location.'&radius='.$radius;

			

			//echo $url1;

			$data_all = json_decode(file_get_contents($url1));

			//echo $data_all = file_get_contents($url1);

			//echo '<pre>';

//			print_r($data_all->results);

//			echo '</pre>';

			$x=0;

			$data = array();

			$address = array();

			$addexplode = array();

			//print_r($data_all->results);

			//exit();

			foreach($data_all->results as $mydata)

			{

			//echo 'arka';

			

			$address = $mydata->formatted_address;

			//print_r($address);

			$addexplode = explode(',',$address);

			$country = end($addexplode);

			

			$cno = count($addexplode);

			$street = '';

			foreach($addexplode as $key=>$val){

			if($key!=$cno-1){

			

			$street .=$val.',';

			}

			

			}

			//echo '**'.$street.'**';

			$streetNew = rtrim($street, ',');

			//echo $country;

			//exit();

			$sql = "select id,google_id from  navigar_fetch_xmldata where google_id='".$mydata->id."'";

			$res = mysql_query($sql);

			$numRes = mysql_num_rows($res);

			

			if($numRes > 0){

			

			}else{

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
                trim($search_term); /* banco de costa rica de san pedro */
                 $TerminoEncontradoAuxiliar=false; 
     
                
                
                $trozos         = explode(" ", $search_term); //ya no tiene blackwords
                $numeroTrozos   = count($trozos);
                $numero         = count($trozos); //pendiente por eliminar numero
            //    $palabraInicial = $trozos[0];
                $palabraInicial = $FraseInicial; //pendiente por eliminar palabraInicial
                $palabrafinal = $FraseFinal;  //pendiente por eliminar palabraFinal


                  /*****************
                 /* BUSQUEDA DE TERMINOS PARA TERMINOS COMPUESTOS , USANDO  search_termIntacto  
                 /*****************/
                
                    
            $ArregloTermino = ObtenerTerminosDirectorio(); /* CARGA EL ARREGLO CON LOS TERMINOS  */
             
            foreach ($ArregloTermino as $obj_key => $termino) {
                    
                    foreach ($termino as $key => $value) {
                        
                        if ($coincidencia == 1) {
                            $var_id            = $value;
                            $TerminoEncontrado = 1;
                            break;
                        }
                        
                        if ($value === $search_termIntacto) //encuentra una similitud
                              {
                                $coincidencia = 1;
                                $TerminoEncontradoAuxiliar=true; 

                             }
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
                
 


                if ($TerminoEncontrado === 0) {

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


              if ($TerminoEncontrado === 0) {
               // $ArregloTermino = ObtenerTerminosDirectorio();
                   // $trozos       = explode(" ", $search_term);
                  //  $numero       = count($trozos);
                    $palabraInicial = $trozos[0];
                
                foreach ($ArregloTermino as $obj_key => $termino) {
                    
                    foreach ($termino as $key => $value) {
                        
                        if ($coincidencia == 1) {
                            $var_id            = $value;
                            $TerminoEncontrado = 1;
                            break;
                        }
                        
                        if ($value == $palabraInicial) //encuentra una similitud
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
           
                
                       /*****************       
                /*  PROCESO PARA OBTENER LOS POIS DEL TERMINO 
                /*****************/
            
            
             
                if ($TerminoEncontrado === 1) {

        

                     $sql = "SELECT Subhexcode FROM tb_search_term  where id_search_term = " . $var_id . "";
                     $resHexcode = mysql_query($sql);
                     $sql ="";


                      if ($numeroTrozos > 1)
                        {
                             
     // $array = obtenerNombreZona($search_term); 
     //   $FraseFinal = trim($array['FraseFinal']);  /*  almacena : san pedro , limon  /  almacena : banco  / almacena :  san pedro*/ 
    //    $FraseFinalCompleta = trim($array['FraseFinalCompleta']); /*almacena :  san pedro  de limon  /  almacena :  costa rica de san pedro  /  almacena : san pedro*/ 
    // $FraseInicial = trim($array['FraseInicial']); /*almacena :  spoon   /  almacena : banco  / almacena : BANCO NACIONAL*/
   //     $testborrar = trim($array['testborrartest']);/* frase con solo el primer DE y hasta el siquiente  
   //   almacena : spoon de san pedro   / almacena : banco de costa rica /  almacena : banco nacional de san pedro  */



                           
                    
                             //  $resultPalabrafinal=PalabraDistritosPoblados($FraseFinalCompleta);  //comprueba si la ultima plabra concuerda con algun poblado 
                                 $resultPalabrafinal=PalabraDistritosPoblados($FraseFinal);  //comprueba si la ultima plabra concuerda con algun poblado        
                              
                               if ($resultPalabrafinal===false)
                                     $resultPalabrafinal = comprobarUltimaPalabra($FraseFinalCompleta);
                                else
                                    $FraseFinal=$FraseFinalCompleta;


                        }
                           else
                             {
                                $resultPalabrafinal = false;
                             }


                  
 if ($resultPalabrafinal === true) 
 {


                    /*********************
                    /*  INGRESA SI LA ULTIMA PALABRA CORRESPONDE A ALGUN POBLADO   
                    /***********************/

           while ($fila = mysql_fetch_assoc($resHexcode)) {
                            
                            $var             = $fila['Subhexcode'];
                            $arraySubHexcode = explode(";", $var);

                              $FraseFinalRequerida= palabraRequeridaBoolean($FraseFinal);
                              $FraseInicialRequerida= palabraRequeridaBoolean($FraseInicial);

                              $sql = "SELECT id,label,street,latitude,longitude,phone,Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) as Score,
                                (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata 
                             where  Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE )  and  Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) ";
                              $sql = $sql . " HAVING Score > 5" ;


                            $sql = $sql . " UNION";



                            
                            $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) as Score,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                    FROM navigar_fetch_xmldata  
                                    where Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE)  AND ( description = ";
                            
                            foreach ($arraySubHexcode as $values) {
                                
                                if ($arraySubHexcode[0] == $values) {
                                    
                                    $sql = $sql . "'" . $values . "'";
                                    
                                } else {
                                    $sql = $sql . " or description = '" . $values . "' ";
                                    
                                }
                                
                            }
                            
                            $sql = $sql . " ) ";
                        } //fin  while ($fila = mysql_fetch_assoc($resHexcode))

                        $sql = $sql . " HAVING (distance < '" . $radius . "') and (Score > 4)  ORDER BY Score desc  limit 0,25";





                 /******************
                  *  METODO EN CASO DE QUE NINGUN SCORE SEA MAYOR A 5 
                 *******************/


                     $res = mysql_query($sql);
                     $num = mysql_num_rows($res);



                        if ($num <= 0) {

                                $sql = "SELECT Subhexcode FROM tb_search_term  where id_search_term = " . $var_id . "";
                        $resHexcode = mysql_query($sql);
                        $sql ="";

                        while ($fila = mysql_fetch_assoc($resHexcode)) {
                            
                            $var             = $fila['Subhexcode'];
                            $arraySubHexcode = explode(";", $var);

                             $FraseFinalRequerida= palabraRequeridaBoolean($FraseFinal);
                              $FraseInicialRequerida= palabraRequeridaBoolean($FraseInicial);

                             $sql = "SELECT id,label,street,latitude,longitude,phone,Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) as Score,
                                (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                            FROM navigar_fetch_xmldata 
                             where  Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE )  and  Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) ";
                              $sql = $sql . " HAVING Score > 3" ;


                            $sql = $sql . " UNION";



                            
                            $sql = $sql . " SELECT id,label,street,latitude,longitude,phone,Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) as Score,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                    FROM navigar_fetch_xmldata  
                                    where Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE)  AND ( description = ";


                             foreach ($arraySubHexcode as $values) {
                                
                                if ($arraySubHexcode[0] == $values) {
                                    
                                    $sql = $sql . "'" . $values . "'";
                                    
                                } else {
                                    $sql = $sql . " or description = '" . $values . "' ";
                                    
                                }
                                
                            }            

                             $sql = $sql . " ) ";

                        } //fin while ($fila = mysql_fetch_assoc($resHexcode))

                         $sql = $sql . " HAVING (distance < '" . $radius . "') and (Score > 0.2)  ORDER BY Score desc  limit 0,25";





                          $res = mysql_query($sql);
                          $num = mysql_num_rows($res);

                        if ($num <= 0) {

                                    $FraseInicialRequerida= palabraRequeridaBoolean($search_term);

                                    $sql_insertrecord = "insert into tb_SearchRecords set searchterm='" . $FraseInicialRequerida . "'";
                                    mysql_query($sql_insertrecord);

                                  $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) as Score,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                                    FROM navigar_fetch_xmldata 
                                     where  Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE )";
                              

                                 $sql = $sql . " HAVING (distance < '" . $radius . "')  ORDER BY distance   limit 0,15";

                        }
  







                        } //if ($num > 0) {




}    // fin if ($resultPalabrafinal === true) 

 else {


         $FraseCorregida=EliminarPalabrasComunesExtras($testborrar);
                            $FraseCorregida=EliminarPalabrasComunes($FraseCorregida);
                
                            $FraseInicialRequerida= palabraRequeridaBoolean($FraseCorregida);  




                            if ($TerminoEncontradoAuxiliar===true)
                            {

                                      $sql = "SELECT Subhexcode FROM tb_search_term  where id_search_term = " . $var_id . "";
                                      $resHexcode = mysql_query($sql);
                                                    
                                                
                                        while ($fila = mysql_fetch_assoc($resHexcode)) 
                                        {
                                
                                         $var             = $fila['Subhexcode'];
                                         $arraySubHexcode = explode(";", $var);

                                           $sql = "SELECT *,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                                            FROM navigar_fetch_xmldata  where  Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE)  ";
                                       
                                      $sql = $sql . " UNION"; 
                                        
                                        $sql =$sql . " SELECT *
                                                    ,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 
                                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance               
                                                    FROM navigar_fetch_xmldata  where description = ";


                                                foreach ($arraySubHexcode as $values) {
                                                    
                                                    if ($arraySubHexcode[0] == $values) {
                                                        
                                                        $sql = $sql . "'" . $values . "'";
                                                        
                                                    } else {
                                                        $sql = $sql . " or description = '" . $values . "'   ";
                                                        
                                                    }
                                                                                    
                                                }
                                              
                                    
                                                   $sql = $sql . " HAVING distance < '" . $radius . "'  ORDER BY distance limit 0,15";           


                                    } //FIN WHILE                  

                            } // if ($TerminoEncontradoAuxiliar===true)

                            else //if ($TerminoEncontradoAuxiliar===FALSE)
                            {


                                 $sql = "SELECT id,label,street,latitude,longitude,phone,Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) as Score,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                                    FROM navigar_fetch_xmldata 
                                     where  Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE )";
                              

                                 $sql = $sql . " HAVING (distance < '" . $radius . "')  ORDER BY distance   limit 0,15";
               


                            }


                            



   } // FIN ELSE INGRESA SI LA ULTIMA PALABRA *NO* CORRESPONDE A ALGUN POBLADO   */

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
                        
                         /* ORDENAR ARRAY  POR DISTANCIA*/
                        usort($data, 'ordenarArrayDistancia');


                        $return = array(
                            
                            'error' => 0,
                            
                            'posts' => $data
                        );
                        
                        
                    } //if($num>0)
                    else
                    {

                        $return = array(
                                    
                                    'error' => 0,
                                    
                                    'posts' => 'No result'
                                    
                                    
                                    
                                );
                    
                    }
                    
                    
                } //termina busquedas por terminos 
                    
                    
           
                
                else {
                    
                 
                     /******************
                    /* 
                    /* EMPIEZA BUSQUEDA SIN SER TERMINO
                    /*
                    /*****************/
                 
                     /* TERMINOS DE PRUEBA , EN ALGUN MOMENTO DIERON PROBLEMAS DE Busquedas
                    
                    coopecoronado
                    bar malibu
                    cima
                    plaza de cacao
                    
                    */
                    
                    // ******************************************  
                    // PRIMERA opcion de busqueda  
                    //  *******************************************     

        $array = obtenerNombreZona($search_term); 
        $FraseFinal = trim($array['FraseFinal']);
        $FraseFinalCompleta = trim($array['FraseFinalCompleta']);
        $FraseInicial = trim($array['FraseInicial']);


/*SI ES SOLO UNA PALABRA */
if ($numeroTrozos === 1) {
                
                    
                    $FraseInicialRequerida=palabraRequeridaBoolean($FraseInicial);  //asigna el operador ´+´ para mejor resultado

                     
                     $sql = "SELECT 

                    *, (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,

                       ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                       * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 

                        * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                        FROM navigar_fetch_xmldata 
                        where  typeHex!=''   " . $WC . "  AND   Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) 
                        or alias1=('" . $FraseInicial . "') 
                        or alias2=('" . $FraseInicial . "') 
                        or alias3=('" . $FraseInicial . "') 
                        HAVING distance < '" . $radius . "' 
                        ORDER BY distance limit 0,25";



                         $res = mysql_query($sql);
                         $num = mysql_num_rows($res);

                            if ($num <= 0) 
                            {
                            
                                /*  CORRECTOR ORTOGRAFICO */
                                /* PARA CUANDO SOLO ES UNA PALABRA */    
                            $Sugerencias = array();
                            $palabras    = explode(" ", $FraseInicial);
                            $contador    = 1;
                            foreach ($palabras as $palabra) {
                                $resul = CorrectorOrtografico($palabra);
                                array_push($Sugerencias, $resul);
                            }
                            
                            $palabraCorregida = implode(" ", $Sugerencias);    

                             $FraseInicialRequerida=palabraRequeridaBoolean($palabraCorregida);  //asigna el operador ´+´ para mejor resulta

                       $sql = "SELECT 

                    *, (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,

                       ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                       * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 

                        * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                        FROM navigar_fetch_xmldata 
                        where  typeHex!=''   " . $WC . "  AND   Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) 
                        or alias1=('" . $FraseInicial . "') 
                        or alias2=('" . $FraseInicial . "') 
                        or alias3=('" . $FraseInicial . "') 
                        HAVING distance < '" . $radius . "' 
                        ORDER BY distance limit 0,25";
                            
                            }  // FIN if ($num <= 0) 



} //if ($numeroTrozos === 1) {

else {

                              /***************************** */    
                               /*  SI ES *MAS* DE UNA PALABRA   */
                               /****************************** */

/* comprobar si la ultima palabra es un poblado  */

    $resultPalabrafinal = false;
    $resultPalabrafinal=PalabraDistritosPoblados($FraseFinalCompleta);  //comprueba si la ultima plabra concuerda con algun poblado 


if ($resultPalabrafinal===false)
{

    if(PalabraDistritosPoblados($search_term))
    {
        $resultPalabrafinal =true;
    }
    else
    {
            $TemporalTermino = EliminarPalabrasComunesExtras(EliminarPalabrasComunes($search_term) );

             $Temporaltrozos = explode(" ", trim($TemporalTermino));  

            $Temporalultimapalabra = $Temporaltrozos [count($Temporaltrozos)-1];
            $TemporalultimaDOSpalabras = $Temporaltrozos [count($Temporaltrozos)-2] ." ". $Temporalultimapalabra;

    }
    
}



  if ($resultPalabrafinal===false)
  {
                  $resultPalabrafinal = comprobarUltimaPalabra($FraseFinal);

                  if ($resultPalabrafinal===false)
                     {
                        $resultPalabrafinal=PalabraDistritosPoblados($Temporalultimapalabra);

                                    if ($resultPalabrafinal===false)
                                    {
                                        $resultPalabrafinal=PalabraDistritosPoblados($TemporalultimaDOSpalabras);

                                        if ($resultPalabrafinal===true)
                                        {  //quitar el poblado
                                                $FraseInicial = str_replace($TemporalultimaDOSpalabras, "", $TemporalTermino );
                                                $FraseFinalCompleta =$TemporalultimaDOSpalabras;
                                        }
                                    }
                                    else
                                    {   //quitar el poblado 
                                        $FraseInicial = str_replace($Temporalultimapalabra, "", $TemporalTermino );
                                        $FraseFinalCompleta =$Temporalultimapalabra;
                                    }
                     }

  }
   else
       $FraseFinal=$FraseFinalCompleta;



   



    /* la ultima palabra es un street */ 
    if ($resultPalabrafinal === true) 
    {

                            $FraseFinalCompletaTemp=EliminarPalabrasComunesExtras($FraseFinalCompleta);

                            $FraseInicialRequerida=palabraRequeridaBoolean($FraseInicial);  //asigna el operador ´+´ para mejor resultado
                           $FraseFinalRequerida=palabraRequeridaBoolean($FraseFinalCompletaTemp);  //asigna el operador ´+´ para mejor resultado


                           $sql = "SELECT *,Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) as Score,
                                (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           

                                FROM navigar_fetch_xmldata 
                                 where  typeHex!=''   " . $WC . "  AND Match(label) AGAINST ('" . $FraseInicialRequerida . " ' IN BOOLEAN MODE)  and   Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE)";
                                

                            $sql = $sql . " HAVING (distance < '" . $radius . "') and (Score > 2.2) ORDER BY distance   limit 0,10";



                            $res = mysql_query($sql);
                            $num = mysql_num_rows($res);

                            if ($num <= 0) 
                            {
                                
                               
                                 $sql = "SELECT *,Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE) as Score,
                                (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                            ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                            * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                            * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           

                                FROM navigar_fetch_xmldata 
                                 where  typeHex!=''   " . $WC . "  AND    Match(label) AGAINST ('" . $FraseInicialRequerida . " ' IN BOOLEAN MODE)  and   Match(street) AGAINST ('" . $FraseFinalRequerida . "' IN BOOLEAN MODE)";
                                

                            $sql = $sql . " HAVING (distance < '" . $radius . "') and (Score > 0.4) ORDER BY distance   limit 0,15";
                            
                            }  // FIN if ($num <= 0) 



    }//if ($resultPalabrafinal === true) 

    else {


                            /***************************** */    
                            /*  LA ULTIMA PALABRA -NO- ES UN POBLADO   */
                            /****************************** */
                  
                             /*
                            /*  CORRECTOR ORTOGRAFICO */
                        /*        
                          
                            $Sugerencias = array();
                            $palabras    = explode(" ", $FraseInicial);
                            $contador    = 1;
                            foreach ($palabras as $palabra) {
                                
                                
                                $resul = CorrectorOrtografico($palabra);
                                array_push($Sugerencias, $resul);
                            }
                            
                            $FraseCorregida = implode(" ", $Sugerencias);
                        
                            $FraseCorregida=EliminarPalabrasComunesExtras($FraseCorregida);

                            $FraseInicialRequerida=palabraRequeridaBoolean($FraseCorregida);  //asigna el operador ´+´ para mejor 
*/

                                   $FraseCorregida=EliminarPalabrasComunesExtras($testborrar);
                                   $FraseInicialRequerida=palabraRequeridaBoolean($FraseCorregida);  //asigna el operador ´+´ para mejor 
                      
                             $sql = "SELECT *,Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) as Score,
                                      (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                      ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                                        * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                        * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                            
                                         FROM navigar_fetch_xmldata 
                                          where  typeHex!=''   " . $WC . "  AND   Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) ";
                                         $sql = $sql . " HAVING (distance < '" . $radius . "') and (Score > 0.5) ORDER BY distance  limit 0,20";



                             $res = mysql_query($sql);
                            $num = mysql_num_rows($res);

                            if ($num <= 0) 
                            {
                               
                                 $FraseCorregida=EliminarPalabrasComunesExtras($searchterm);
                                 $FraseCorregida=EliminarPalabrasComunes($FraseCorregida);
                                 $FraseInicialRequerida=palabraRequeridaBoolean($FraseCorregida);  //asigna el operador ´+´ para mejor 
                               
                                 $$sql = "SELECT *,Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) as Score,
                                      (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                      ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                                        * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                        * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                            
                                         FROM navigar_fetch_xmldata 
                                          where  typeHex!=''   " . $WC . "  AND    Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) ";
                                         $sql = $sql . " HAVING (distance < '" . $radius . "') and (Score => 1) ORDER BY distance  limit 0,20";
                            
                            }  // FIN if ($num <= 0)                

 

            } // ELSE .........LA ULTIMA PALABRA -NO- ES UN POBLADO

        } //ELSE .........SI ES *MAS* DE UNA PALABRA



                    
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

                        /* ORDENAR ARRAY  */
                      usort($data, 'ordenarArrayDistancia');
                        
                        $return = array(
                            
                            'error' => 0,
                            
                            'posts' => $data
                            
                            
                            
                        );
                        
                    }// if ($num > 0) {
                    
                    

                     else {
                        
                        //  ****************************************  
                        //   SEGUNDO metodo de busqueda
                        //  
                        //  *******************************************  
                       

                            /*  CORRECTOR ORTOGRAFICO */     
                          
                            $Sugerencias = array();
                            $palabras    = explode(" ", $searchterm);
                            $contador    = 1;
                            foreach ($palabras as $palabra) {
                                
                                
                                $resul = CorrectorOrtografico($palabra);
                                array_push($Sugerencias, $resul);
                            }
                            
                            $FraseCorregida = implode(" ", $Sugerencias);
                        
                            $FraseCorregida=EliminarPalabrasComunesExtras($FraseCorregida);
                            $FraseCorregida=EliminarPalabrasComunes($FraseCorregida);

                

                                if (str_word_count($FraseCorregida,0)===1)
                                    /*      SOLO ES UNA PALABRA   */
                                    /* Se obtienen resultados si se encuentran palabras que comiencen con "note" como "notebook", "notepad", etc */
                                {

                                        $sql = "SELECT *,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,

                                       ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                                       * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 

                                        * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                                        FROM navigar_fetch_xmldata 
                                        where  typeHex!=''   " . $WC . "  AND  Match(label) AGAINST ('" . $FraseCorregida . "*' IN BOOLEAN MODE) 
                                        or alias1=('" . $FraseInicial . "') 
                                        or alias2=('" . $FraseInicial . "') 
                                        or alias3=('" . $FraseInicial . "') 
                                        HAVING distance < '" . $radius . "' 
                                        ORDER BY distance limit 0,25";

                                }

                                else

                                {  /* MAS DE UNA PALABRA */


                                 $FraseInicialRequerida=palabraRequeridaBoolean($FraseCorregida);  //asigna el operador ´+´ para mejor 

                        


                                    $sql = "SELECT *,Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) as Score,
                                    (select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,
                                    ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) )
                                    * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 
                                    * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance                           
                                    FROM navigar_fetch_xmldata 
                                    where  typeHex!=''   " . $WC . "  AND Match(label) AGAINST ('" . $FraseInicialRequerida . "' IN BOOLEAN MODE) ";
                                   // $sql = $sql . " HAVING Score > 0.5  ORDER BY Score  limit 0,15";      
                                      $sql = $sql . " HAVING (distance < '" . $radius . "') and (Score > 0.5)  ORDER BY distance  limit 0,15";  


                                }

                        




                      /* 

                        $Sugerencias = array();
                        $palabras    = explode(" ", $search_term);
                        
                                     
                                      

                        foreach ($palabras as $palabra) {
                            $resul = CorrectorOrtografico($palabra); 
                                
                             array_push($Sugerencias, $resul);
                        }

                        
            
                        $search_term = implode(" ", $Sugerencias);

                        
                        
                        $sql = "SELECT *,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,

                                         ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                                         * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 

                                         * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                                         FROM navigar_fetch_xmldata  where  Match(label) AGAINST ('" . $search_term . "')  

                                         HAVING distance < '" . $radius . "' 
                                         ORDER BY distance limit 0,40";


                            


                            */                  
                        
                        $res = mysql_query($sql);
                                   
                        $x = 0;
                        
                        $data = array();
                        
                        $num = mysql_num_rows($res);
                        
                        if ($num > 0) {
                            //
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
                            
                        }
                        
else {
                            
                            
                  
                     //  ****************************************  
                        //   TERCER metodo de busqueda
                        //  
                        //  *******************************************           
    

  $sql = "SELECT id,label,street,latitude,longitude,phone,(select IFNULL((sum(t3.rate)/count(t3.id)),0)  from navigar_reviews as t3 where t3.poi_id=navigar_fetch_xmldata.id )as rating,

                                         ( 6371000 * acos( cos( radians('" . $latitude . "') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

                                         * cos( radians(navigar_fetch_xmldata.longitude) - radians('" . $longitude . "')) + sin(radians('" . $latitude . "')) 

                                         * sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

                                         FROM navigar_fetch_xmldata 
                                          where   `label` like '" . $FraseInicial . "%' 

                                         HAVING distance < '" . $radius . "' 
                                         ORDER BY distance limit 0,10";


                            
                            $res = mysql_query($sql);
                            
                            
                            
                            $x = 0;
                            
                            $data = array();
                            
                            $num = mysql_num_rows($res);
                            
                            if ($num > 0) {
                                //
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
                            
                            
                            
                        } //tercer segundo metodo de busqueda normal
                        
                    } //fin segundo metodo de busqueda normal


                } // fin primer metodo de busqueda normal
                
                
            } else {
                throw new Exception("fields can not be null");
            }
            
           
            
            break;       


        
        /*
          case 'jsoninsert':
            
            
            
            $coordinates = serialize($_REQUEST['coordinates']);
            
            $c_longitude = ((isset($_REQUEST['current_logitude'])) ? $_REQUEST['current_logitude'] : '');
            
            $c_latitude = ((isset($_REQUEST['current_latitude'])) ? $_REQUEST['current_latitude'] : '');
            
            
            
            
            
            if ($c_latitude != '' && $c_longitude != '') {
                
                
                
                
                
                //$day=date('Y-m-d h:i:s');
                
                
                
                $sql = "insert into navigar_record_route (`latitude`,`longitude`,`all_coordinates`) values('" . $c_latitude . "','" . $c_longitude . "','" . $coordinates . "')";
                
                
                
                
                
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
            
            
            
            */
            
            
                    
                
 
	/*
		case 'jsoninsert':

		

		 $coordinates = serialize($_REQUEST['coordinates']);

            $c_longitude = ((isset($_REQUEST['current_logitude'])) ? $_REQUEST['current_logitude'] : '');

            $c_latitude = ((isset($_REQUEST['current_latitude'])) ? $_REQUEST['current_latitude'] : '');

			

           

			if( $c_latitude !='' && $c_longitude !=''){

			

			

			//$day=date('Y-m-d h:i:s');

				

				$sql="insert into navigar_record_route (`latitude`,`longitude`,`all_coordinates`) values('".$c_latitude."','".$c_longitude."','".$coordinates."')";

				

		  

		  		$res=mysql_query($sql);

		  

		 		 $last_insert_id=mysql_insert_id();

		  if($last_insert_id){

			  $return = array(

        		'error' => 0,

        		'msg' => 'inserted successully'

    			);

			}else{

				$return = array(

        		'error' => 1,

        		'msg' => 'error in insert'

    			);

			}	

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break;
*/
		case 'listMainCategory':



            $sql = "select * from  navigar_maincategories";

			$res= mysql_query($sql);

			$x=0;

			while($row= mysql_fetch_assoc($res)){

				$data[$x]['id']= $row['id'];

				$data[$x]['category_name']= $row['category_name'];

				$data[$x]['category_image']= $row['category_image'];

				if($row['hexcode_range']==''){

				$range= 0;

				}else{

				$range= 1;

				}

				$data[$x]['hexcode_range']= $range;

				$x++;

			}

			

			$return = array(

								'error' => 0,

								'posts' => $data

								

							);

			break;

			

			case 'listSubCategoryByMain':

			

			$par_id = ((isset($_REQUEST['catId'])) ? $_REQUEST['catId'] : '');



            $sql = "select * from  navigar_subcategories where parent_id=".$par_id;

			$res= mysql_query($sql);

			$numRes = mysql_num_rows($res);

			if($numRes>0){

			$x=0;

			while($row= mysql_fetch_assoc($res)){

				$data[$x]= $row;

				$x++;

			}

			

			$return = array(

								'error' => 0,

								'posts' => $data

								

							);

			}else{

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

           

			if( $c_latitude !='' && $c_longitude !='' && $distance !=''){

			

				if($parent_ID != ''){

					 $sql_cat = "select * from  navigar_maincategories where id=".$parent_ID;

			$res= mysql_query($sql_cat);

			//$numRes = mysql_num_rows($res);

			

			$row= mysql_fetch_assoc($res);

			$allType = $row['hexcode_range'];

			//echo $allType;

			$typeval = explode(',',$allType);

			$typevalAll = '';

			foreach($typeval as $key) {

				//echo $key;

				$typevalAll .= "'".$key."',";

			

			}

			

			$last_all_Type = rtrim($typevalAll, ',');

					

				$sql="SELECT 

					*, 

					( 6371000 * acos( cos( radians('".$c_latitude."') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

					* cos( radians(navigar_fetch_xmldata.longitude) - radians('".$c_longitude."')) + sin(radians('".$c_latitude."')) 

					* sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

					FROM navigar_fetch_xmldata where  typeHex IN (".$last_all_Type.") 

					HAVING distance < '".$distance."' 

					ORDER BY distance";

					

					$sql="SELECT 

					*, 

					( 6371000 * acos( cos( radians('".$c_latitude."') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

					* cos( radians(navigar_fetch_xmldata.longitude) - radians('".$c_longitude."')) + sin(radians('".$c_latitude."')) 

					* sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

					FROM navigar_fetch_xmldata where  typeHex IN (".$last_all_Type.") 

				

					ORDER BY distance LIMIT 70";

					

			//		echo $sql;

					

				}else{

				//	echo "kjdfksd";

					$SQL = "SELECT duplicate_hexcode FROM navigar_subcategories WHERE id='".$typehex."'";

					$fetchTypeHext = mysql_fetch_array(mysql_query($SQL));

					//echo $fetchTypeHext["duplicate_hexcode"];

					if ($fetchTypeHext["duplicate_hexcode"]!=""){

						$expHex = explode(",",$fetchTypeHext["duplicate_hexcode"]);

					//	echo sizeof($expHex);

						$tempStr = "";

						for($k=0;$k< sizeof($expHex);$k++){

							$tempStr .= "'".$expHex[$k]."',";

						}

					}

					$typehex = $tempStr."'".$typehex."'";

					//echo $typehex;

				//	exit;

				

					$sql="SELECT 

					*, 

					( 6371000 * acos( cos( radians('".$c_latitude."') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

					* cos( radians(navigar_fetch_xmldata.longitude) - radians('".$c_longitude."')) + sin(radians('".$c_latitude."')) 

					* sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

					FROM navigar_fetch_xmldata where  typeHex IN (".$typehex.") 

					HAVING distance < '".$distance."' 

					ORDER BY distance";

					

					$sql="SELECT 

					*, 

					( 6371000 * acos( cos( radians('".$c_latitude."') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

					* cos( radians(navigar_fetch_xmldata.longitude) - radians('".$c_longitude."')) + sin(radians('".$c_latitude."')) 

					* sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

					FROM navigar_fetch_xmldata where  typeHex IN (".$typehex.") 

					

					ORDER BY distance LIMIT 70";

					

				//	echo $sql;

					

				}

				

		$res= mysql_query($sql);

				

				$x=0;

				$data=array();

				$num= mysql_num_rows($res);

				

				

				if($num>0){

					while($row=mysql_fetch_object($res)){

					

					 $data[$x]['id']= $row->id;

					$sqlrate = "select IFNULL((sum(t3.rate)/count(t3.id)),0) as rating  from navigar_reviews as t3 where t3.poi_id=".$row->id;

					 $res_rate = mysql_query($sqlrate);

					 $row_rate = mysql_fetch_object($res_rate);

					 

					 // check for already reviewed

					 $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='".$row->id."' AND  imei='".$imei."' ";

					 $_alreadyRev = mysql_query($_SQL);

					 
					 
					 
					 $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=".$row->id;

					 $res_rateC = mysql_query($sqlrateC);

					 $row_rateC = mysql_fetch_object($res_rateC);
					 
					 $data[$x]['review_count']= $row_rateC->rating;
					 
					 
					 

					 //print_r($row_rate);

					 if (mysql_num_rows($_alreadyRev)>0)

					  $data[$x]['already_reviewd']= "true";

					  else

					  $data[$x]['already_reviewd']= "false";

					 

					  $data[$x]['rating']= $row_rate->rating;

					  //exit();

					  

					 	 $data[$x]['label']= $row->label;

						 $data[$x]['street']= $row->street;
						 $data[$x]['location']= $row->location;

						 $data[$x]['city']= $row->city;

						 $data[$x]['region']= $row->region;

						 $data[$x]['country']= $row->country;

						 $data[$x]['pincode']= $row->pincode;

						 $data[$x]['type']= $row->type;

						 $data[$x]['typeHex']= $row->typeHex;

						 $data[$x]['phone']= $row->phone;

						 $data[$x]['latitude']= $row->latitude;

						 $data[$x]['longitude']= $row->longitude;

						 

						 

						

						 $data[$x]['distance']= $row->distance;

						 

					$x++;

					}

					$return = array(

								'error' => 0,

								'posts' => $data

								

							);

				}

				else{

					$return = array(

								'error' => 0,

								'posts' => 'No result'

								

							);

				}

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break;
		
		case 'getPOIMap':

		

		 $c_latitude = ((isset($_REQUEST['c_latitude'])) ? $_REQUEST['c_latitude'] : '');

            $c_longitude = ((isset($_REQUEST['c_longitude'])) ? $_REQUEST['c_longitude'] : '');

            $distance = ((isset($_REQUEST['distance'])) ? $_REQUEST['distance'] : '');

			$imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');

           

			if( $c_latitude !='' && $c_longitude !='' && $distance !=''){

			
			$sql="SELECT *, 

					( 6371000 * acos( cos( radians('".$c_latitude."') ) * cos( radians( navigar_fetch_xmldata.latitude ) ) 

					* cos( radians(navigar_fetch_xmldata.longitude) - radians('".$c_longitude."')) + sin(radians('".$c_latitude."')) 

					* sin( radians(navigar_fetch_xmldata.latitude)))) AS distance 

					FROM navigar_fetch_xmldata 

					HAVING distance < '".$distance."' 

					ORDER BY distance";
				

		$res= mysql_query($sql);

				

				$x=0;

				$data=array();

				$num= mysql_num_rows($res);

				

				

				if($num>0){

					while($row=mysql_fetch_object($res)){

					

					 $data[$x]['id']= $row->id;

					$sqlrate = "select IFNULL((sum(t3.rate)/count(t3.id)),0) as rating  from navigar_reviews as t3 where t3.poi_id=".$row->id;

					 $res_rate = mysql_query($sqlrate);

					 $row_rate = mysql_fetch_object($res_rate);

					 

					 // check for already reviewed

					 $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='".$row->id."' AND  imei='".$imei."' ";

					 $_alreadyRev = mysql_query($_SQL);

					 
					 
					 
					 $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=".$row->id;

					 $res_rateC = mysql_query($sqlrateC);

					 $row_rateC = mysql_fetch_object($res_rateC);
					 
					 $data[$x]['review_count']= $row_rateC->rating;
					 
					 
					 

					 //print_r($row_rate);

					 if (mysql_num_rows($_alreadyRev)>0)

					  $data[$x]['already_reviewd']= "true";

					  else

					  $data[$x]['already_reviewd']= "false";

					 

					  $data[$x]['rating']= $row_rate->rating;

					  //exit();

					  

					 	 $data[$x]['label']= $row->label;

						$data[$x]['street']= $row->street;
						$data[$x]['location']= $row->location;

						 $data[$x]['city']= $row->city;

						 $data[$x]['region']= $row->region;

						 $data[$x]['country']= $row->country;

						 $data[$x]['pincode']= $row->pincode;

						 $data[$x]['type']= $row->type;

						 $data[$x]['typeHex']= $row->typeHex;

						 $data[$x]['phone']= $row->phone;

						 $data[$x]['latitude']= $row->latitude;

						 $data[$x]['longitude']= $row->longitude;

						 

						 

						

						 $data[$x]['distance']= $row->distance;

						 

					$x++;

					}

					$return = array(

								'error' => 0,

								'posts' => $data

								

							);

				}

				else{

					$return = array(

								'error' => 0,

								'posts' => 'No result'

								

							);

				}

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break;
		
		case 'getPOIDetail':

		$imei = ((isset($_REQUEST['imei'])) ? $_REQUEST['imei'] : '');
		$pid = ((isset($_REQUEST['pid'])) ? $_REQUEST['pid'] : '');

           

			if( $pid !=''){

			
			$sql="SELECT *

					FROM navigar_fetch_xmldata 

					WHERE id = '".$pid."' ";
				

		$res= mysql_query($sql);

				

				$x=0;

				$data=array();

				$num= mysql_num_rows($res);

				

				

				if($num>0){

					while($row=mysql_fetch_object($res)){

					

					 $data[$x]['id']= $row->id;

					$sqlrate = "select IFNULL((sum(t3.rate)/count(t3.id)),0) as rating  from navigar_reviews as t3 where t3.poi_id=".$row->id;

					 $res_rate = mysql_query($sqlrate);

					 $row_rate = mysql_fetch_object($res_rate);

					 

					 // check for already reviewed

					 $_SQL = "SELECT * FROM navigar_reviews WHERE poi_id='".$row->id."' AND  imei='".$imei."' ";

					 $_alreadyRev = mysql_query($_SQL);

					 
					 
					 
					 $sqlrateC = "select count(t3.id) as rating  from navigar_reviews as t3 where t3.poi_id=".$row->id;

					 $res_rateC = mysql_query($sqlrateC);

					 $row_rateC = mysql_fetch_object($res_rateC);
					 
					 $data[$x]['review_count']= $row_rateC->rating;
					 
					 
					 

					 //print_r($row_rate);

					 if (mysql_num_rows($_alreadyRev)>0)

					  $data[$x]['already_reviewd']= "true";

					  else

					  $data[$x]['already_reviewd']= "false";

					 

					  $data[$x]['rating']= $row_rate->rating;

					  //exit();

					  

					 	 $data[$x]['label']= $row->label;

						 $data[$x]['street']= $row->street;
						 $data[$x]['location']= $row->location;
						 					 
						 $data[$x]['city']= $row->city;

						 $data[$x]['region']= $row->region;

						 $data[$x]['country']= $row->country;

						 $data[$x]['pincode']= $row->pincode;

						 $data[$x]['type']= $row->type;

						 $data[$x]['typeHex']= $row->typeHex;

						 $data[$x]['phone']= $row->phone;

						 $data[$x]['latitude']= $row->latitude;

						 $data[$x]['longitude']= $row->longitude;

						 

						 

						

						 $data[$x]['distance']= $row->distance;

						 

					$x++;

					}

					$return = array(

								'error' => 0,

								'posts' => $data

								

							);

				}

				else{

					$return = array(

								'error' => 0,

								'posts' => 'No result'

								

							);

				}

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break;

		case "routeInsert":

		$road_name = $_REQUEST['road_name'];

		$sql_roadname = "insert into navigar_roadname set road_name='".$road_name."'";

		mysql_query($sql_roadname);

		$last_id = mysql_insert_id();

		

		$jsonContent = $_REQUEST["coordinates"];

		//print_r($jsonContent);

		/*$array = array("msg" => "Hello" .$jsonContent[0]["review_desc"]);

		echo json_encode($array);

		exit;*/

		//echo sizeof($jsonContent);

		for($i=0; $i<(sizeof($jsonContent)); $i++){

			$sql_road_details = "insert into navigar_roadname_details set road_id=".$last_id.",latitude = '".$jsonContent[$i]['latitude']."', longitude='".$jsonContent[$i]['longitude']."'";

			mysql_query($sql_road_details);

		}

		$return = array(

								'error' => 0,

								'posts' => 'Records added successfully'

								

							);

		

		break;

		 case 'getCostaricaPOI':

		

		 $limit = ((isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : '');

           

          $limitVal = '';

		  if($limit != ''){

		  $limitVal = " LIMIT ".$limit;

		  } 

			

			

				

					$sql="SELECT DISTINCT t1.id,t1.label,t1.street,t1.latitude,t1.longitude,IFNULL(t3.category_image,(select category_image from navigar_maincategories where id='11')) as category_image from `navigar_fetch_xmldata` as t1 LEFT JOIN navigar_subcategories as t2 ON t2.id=t1.typeHex LEFT JOIN navigar_maincategories as t3 ON t3.id=t2.parent_id   where `country`='COSTA RICA'".$limitVal;

					//echo $sql;

				

				

		$res= mysql_query($sql);

				

				

				$data=array();

				

				

				if($res){

				while($row=mysql_fetch_object($res)){

				

				 $data[] = $row;

				}

					

					$return = array(

								'error' => 0,

								'posts' => $data

								

							);

				}

				else{

					$return = array(

								'error' => 0,

								'posts' => 'No result'

								

							);

				}

			

			

			

			

			

			

			

		break;  

		

		

		

		

		case 'addPOINEW_3':

		 $latitude = ((isset($_REQUEST['latitude'])) ? $_REQUEST['latitude'] : '');

         $longitude = ((isset($_REQUEST['longitude'])) ? $_REQUEST['longitude'] : '');

         $title = ((isset($_REQUEST['title'])) ? $_REQUEST['title'] : '');

         $street = ((isset($_REQUEST['street'])) ? $_REQUEST['street'] : '');

		 

		 $main_category_id = ((isset($_REQUEST['main_category_id'])) ? $_REQUEST['main_category_id'] : '');

		 $subcategory_name = ((isset($_REQUEST['subcategory_name'])) ? $_REQUEST['subcategory_name'] : '');

		 

		 if( $latitude !='' && $longitude !='' && $title !=''&& $street !=''){

		 	$typeHex = rand(1000,99999);

			$sql = "INSERT INTO navigar_subcategories SET parent_id='".$main_category_id."', category_name='".$subcategory_name."', id='".$typeHex."' "	;

			$subcatRes = mysql_query($sql);

		 	$subcat_id = mysql_insert_id($subcatRes);

			

			$sql="insert into navigar_fetch_xmldata set 

				`label` = '".$title."',

				`comment` = '".$description_new."',

				`street` = '".$street."',

				`latitude` = '".$latitude."',

				`typeHex` = '".$typeHex."',

				`longitude` = '".$longitude."'";

				

		$res=mysql_query($sql); 

		$last_insert_id=mysql_insert_id(); 

		  if($last_insert_id){

			  $return = array(

        		'error' => 0,

        		'msg' => 'inserted successully'

    			);

			}else{

				$return = array(

        		'error' => 1,

        		'msg' => 'error in insert'

    			);

			}		

			

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

		   

		   

			if( $latitude !='' && $longitude !='' && $title !=''){

			

			$description_new= mysql_escape_string($description);

			//$day=date('Y-m-d h:i:s');

				

				if ($typeHex==""){

					$typeHex = rand(1000,99999);

					

					## CHECK IF MAIN CATEGORY EXIST. IF NNOT ADD IT

					$SQL = " SELECT * FROM navigar_maincategories WHERE category_name = '".$business_type."'   ";

					$_res = mysql_query($SQL);

					if (mysql_num_rows($_res)==0){

						$SQL = "INSERT INTO navigar_maincategories SET category_name='".$business_type."', category_image='http://www.your242.com/newdts/Code/Code016/bluejay/trackIt/webservices/category_images/11.png'  ";

						mysql_query($SQL);

						$main_category_id = mysql_insert_id();

						$update = true;

					}else{

						$_fetch = mysql_fetch_array($_res);

						$main_category_id = $_fetch["id"];

						$update = true;

					}

					

					

					$fetchMaincat = mysql_fetch_array(mysql_query("SELECT hexcode_range FROM navigar_maincategories WHERE id='".$main_category_id."'"));

					

					

					

					if ($fetchMaincat["hexcode_range"]!=""){

						$hexcode_range = $fetchMaincat["hexcode_range"].",".$typeHex;

					}else{

						$hexcode_range = $typeHex;

					}

					if ($update){

						$SQL = "UPDATE navigar_maincategories  SET hexcode_range='".$hexcode_range."' WHERE id='".$main_category_id."' ";

						mysql_query($SQL);

					}

					

				}

				

				

				$sql="insert into navigar_fetch_xmldata set 

				`label` = '".$title."',
				
				`phone` = '".$phone."',

				`comment` = '".$description_new."',

				`street` = '".$street."',

				`latitude` = '".$latitude."',

				`typeHex` = '".$typeHex."',

				`longitude` = '".$longitude."'";

		  

		  		$res=mysql_query($sql);

		  

		 		 $last_insert_id=mysql_insert_id();

				

				 

		  if($last_insert_id){

			  $return = array(

        		'error' => 0,

        		'msg' => 'inserted successully'

    			);

			}else{

				$return = array(

        		'error' => 1,

        		'msg' => 'error in insert'

    			);

			}	

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break; 

		case 'getCameraAlert':

		

		 $sql="select * from `navigar_cameras_alert`";

					//echo $sql;

				

				

		$res= mysql_query($sql);

				

				

				$data=array();

				

				

				if($res){

				while($row=mysql_fetch_object($res)){

				

				 $data[] = $row;

				}

					

					$return = array(

								'error' => 0,

								'posts' => $data

								

							);

				}

				else{

					$return = array(

								'error' => 0,

								'posts' => 'No result'

								

							);

				}

			

			

			

			

			

			

			

		break; 

		case 'getRouteForTwoPoint':

		

		 $start = ((isset($_REQUEST['start'])) ? $_REQUEST['start'] : '');

            $destination = ((isset($_REQUEST['destination'])) ? $_REQUEST['destination'] : '');

			$mode = ((isset($_REQUEST['mode'])) ? $_REQUEST['mode'] : '');

			

			if( $start !='' && $destination !='' && $mode !=''){

			

				$data_all = file_get_contents(base64_decode(APPSTRING).'xml?origin='.$start.'&destination='.$destination.'&sensor=false&mode='.$mode);

				//echo $data_all;

				$xml= xml2array($data_all);

				//echo '<pre>';

				//print_r($xml);

				$amain=array();

				$data=array();

				$data['routes'] = $xml['DirectionsResponse']['route'];

				$amain= $xml['DirectionsResponse']['route']['leg']['step'];

				if(!empty($amain)){

				//echo '<pre>';

				//$val = decodePolylineToArray('e`miGhmocNgBf@cBb@KBiGnB');

				//print_r($val);

				

				for($i=0;$i<count($amain);$i++) {

				

				//echo '<pre>';

				//print_r(getdata($amain[$i]['description']));

				

				$point = decodePolylineToArray($amain[$i]['polyline']['points']);	

				//print_r($point);

				

				

					for($j=0;$j<count($point);$j++) {

					$valueP = $point[$j][0].",".$point[$j][1]; 

						if (!in_array($valueP, $data['route_geometry'])) {

						$data['route_geometry'][] = $point[$j][0].",".$point[$j][1];

						}

					}

				

				}

           $return = array(

								'error' => 0,

								'posts' => $data

								

							);

			

			}else{

			

				$return = array(

        		'error' => 1,

        		'msg' => 'no result'

    			);

			

			

			}

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break; 

		case 'gaaetRouteForWayPoints':

		

		 $start = ((isset($_REQUEST['start'])) ? $_REQUEST['start'] : '');

            $destination = ((isset($_REQUEST['destination'])) ? $_REQUEST['destination'] : '');

			$waypoint = ((isset($_REQUEST['waypoint'])) ? $_REQUEST['waypoint'] : '');

			$mode = ((isset($_REQUEST['mode'])) ? $_REQUEST['mode'] : '');

			$alternatives = ((isset($_REQUEST['alternatives'])) ? "&alternatives=".$_REQUEST['alternatives'] : '');

			

			

			if( $start !='' && $destination !=''  && $mode !=''){

			

		

				if ($waypoint!="")

				$data_all = file_get_contents(base64_decode(APPSTRING).'json?origin='.$start.'&destination='.$destination.'&waypoints=optimize:true|'.$waypoint.'&sensor=false&mode='.$mode.$alternatives);

				else

				$data_all = file_get_contents(base64_decode(APPSTRING).'json?origin='.$start.'&destination='.$destination.'&sensor=false&mode='.$mode.$alternatives);

			

			//	echo $data_all;

				

				$response = json_decode($data_all,true);

				//print_r($response);

				

				$overall = $response['routes'][0]['overview_polyline']['points'];

				$ove_Val = decodePolylineToArray($overall);

				//print_r($ove_Val);

				

				for($ov=0;$ov<count($ove_Val);$ov++) {

					$valueP = $ove_Val[$ov][0].",".$ove_Val[$ov][1]; 

						if (!in_array($valueP, $data['overall_route'])) {

						 $response['overall_route'][] = $ove_Val[$ov][0].",".$ove_Val[$ov][1];

						}

					}

				

					$amaink= $response['routes'][0]['legs'];

					

					if(!empty($amaink)){

					//echo sizeof($amaink);

				for($k=0;$k<count($amaink);$k++) {

				

				$amain = $amaink[$k]['steps'];

				for($i=0;$i<count($amain);$i++) {

				

			

				

				$point = decodePolylineToArray($amain[$i]['polyline']['points']);	

				

				

				

					for($j=0;$j<count($point);$j++) {

					$valueP = $point[$j][0].",".$point[$j][1]; 

						if (!in_array($valueP, $data['route_geometry'])) {

						$response['route_geometry'][] = $point[$j][0].",".$point[$j][1];

						}

					}

				

				}

			}

			}

					

				

				$posts["posts"] = $response;

				$posts["error"] = 0; 

				 

				

				echo json_encode($posts);

				

				exit;

				

				

				

				//echo $data_all;

				$xml= xml2array($data_all);

				//echo '<pre>';

				//print_r($xml);

				//print_r($xml['DirectionsResponse']['route']);

				//exit();

				$amain=array();

				$data=array();

				$data['routes'] = $xml['DirectionsResponse']['route'];

				//print_r($data['routes']);

				$overall = $xml['DirectionsResponse']['route']['overview_polyline']['points'];

				$ove_Val = decodePolylineToArray($overall);

				//print_r($ove_Val);

				

				for($ov=0;$ov<count($ove_Val);$ov++) {

					$valueP = $ove_Val[$ov][0].",".$ove_Val[$ov][1]; 

						if (!in_array($valueP, $data['overall_route'])) {

						$data['overall_route'][] = $ove_Val[$ov][0].",".$ove_Val[$ov][1];

						}

					}

					//print_r($data['overall_route']);

				//exit();

				$amaink= $xml['DirectionsResponse']['route']['leg'];

				//print_r($amaink);

				//exit();

				if(!empty($amaink)){

				for($k=0;$k<count($amaink);$k++) {

				

				$amain = $amaink[$k]['step'];

				for($i=0;$i<count($amain);$i++) {

				

				//echo '<pre>';

				//print_r(getdata($amain[$i]['description']));

				

				$point = decodePolylineToArray($amain[$i]['polyline']['points']);	

				//print_r($point);

				

				

					for($j=0;$j<count($point);$j++) {

					$valueP = $point[$j][0].",".$point[$j][1]; 

						if (!in_array($valueP, $data['route_geometry'])) {

						$data['route_geometry'][] = $point[$j][0].",".$point[$j][1];

						}

					}

				

				}

			}

           $return = array(

								'error' => 0,

								'posts' => $data

								

							);

			

			}else{

			

				$return = array(

        		'error' => 1,

        		'msg' => 'no result'

    			);

			

			

			}

			

			

			

			}else{

				throw new Exception("fields can not be null");

			}

			

			

			

		break; 
		
		case 'getRouteForWayPoints':
		
		 $start = ((isset($_REQUEST['start'])) ? $_REQUEST['start'] : '');
            $destination = ((isset($_REQUEST['destination'])) ? $_REQUEST['destination'] : '');
			$waypoint = ((isset($_REQUEST['waypoint'])) ? $_REQUEST['waypoint'] : '');
			$mode = ((isset($_REQUEST['mode'])) ? $_REQUEST['mode'] : '');
			$alternatives = ((isset($_REQUEST['alternatives'])) ? "&alternatives=".$_REQUEST['alternatives'] : '');
			
			//echo 'aaa';
			
			if( $start !='' && $destination !=''  && $mode !=''){
			
			$data_all = file_get_contents('http://routes.cloudmade.com/0dadda39e8f44f74809db0445e02743f/api/0.3/' . $start . ',' . $destination . '/car/fastest.js');
$mainRoute = json_decode($data_all, true);
$dataarr = array();
$steps = array();
$totalDistance = 0;
$duraTion = 0;
foreach ($mainRoute['route_instructions'] as $key => $route) {
    $steps['steps'][] = array(
        'distance' => array(
            'text' => $route[4],
            'value' => $route[1]
        ),
        'duration' => array(
            'value' => $route[3],
            'text' => round(($route[3] / 60), 2) . ' mins'
        ),
        'html_instructions' => $route[0],
        'polyline' =>array(
			'points'=> generatePolyline($mainRoute, $key)
		)
    );
    $totalDistance+=$route[1];
    $duraTion+=$route[3];
}
$containerArray = array('posts' => array(
        'routes' => array(
            '0' => array(
                'legs' => array(
                    '0' => array(
                        'distance' => array(
                            'text' => round(($totalDistance / 1000), 2) . ' Km',
                            'value' => $totalDistance
                        ),
                        'duration' => array(
                            'text' =>round(($duraTion / 60),2) . ' mins',
                            'value' => $duraTion
                        ),
                        'steps' => $steps['steps'],
                        'via_waypoint' => array()
                    )
                ),
                'waypoint_order' => array()
            )
        ),
        'status' => 'OK',
        'route_geometry' => createRouteGeometry($mainRoute),
    ),
    'error' => 0
);

echo json_encode($containerArray);
				
				exit;
			
			}else{
				throw new Exception("fields can not be null");
			}
			
			
			
		break;

		 default:

            throw new Exception("Sorry no Action defined");

            break;

    }

} catch (Exception $exc) {

    $return = array(

        'error' => 1,

        'msg' => $exc->getMessage(),

		'posts' => ''

    );

}



echo json_encode($return);

exit();

?>