<?php
/*
*	FUNCIONES UTILES EN EL SISTEMA DE BUSQUENDA PARA NAVIGAR
*	CREACION : 18/11/2014
*	
*
*/

include('includes/config.php');

/************************
/* FUNCION PARA ELIMINAR CARACTERES EXTRAÑOS O ACENTOS .
/************************/

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



/************************
/* FUNCION PARA COMPROBAR Y ELIMINAR PALABRAS COMUNES (BLACK WORDS). 
/************************/


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
    
    return implode(' ', array_filter(explode(' ', $cadena), function($word) use ($PalabrasComunes)
    {
        return !in_array($word, $PalabrasComunes);
    }));
    
}


/************************
/* FUNCION PARA  ELIMINAR PALABRAS COMUNES *EXTRAS* 
/************************/


function EliminarPalabrasComunesExtras($cadena)
{
    
    $PalabrasComunes = array(
        
        'de',
        'en'
        

    );  
    
    return implode(' ', array_filter(explode(' ', $cadena), function($word) use ($PalabrasComunes)
    {
        return !in_array($word, $PalabrasComunes);
    }));
    
}



/************************
/* FUNCION PARA COMPROBAR Y ELIMINAR SI UNA ENTRADA CONCUERDA CON EL NOMBRE DE UN POBLADO. 
/************************/

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


    return in_array($cadena, $PalabraDisPobla);

    
}





/************************
/* FUNCION PARA OBTENER TODOS LOS TERMINOS CREADOS EN LA BD.
/************************/

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






?>