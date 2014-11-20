<?php 	

/*
*	SEGMENTO PARA EL SWITCH  'getallData'
*	CREACION : 18/11/2014
*	
*/




 foreach ($_REQUEST as $key => $val) {
                
          $_REQUEST[$key] = strtolower($val);
                
         }
            
            
            
            $latitude = ((isset($_REQUEST['latitude'])) ? $_REQUEST['latitude'] : '9.954376');
            
            $longitude = ((isset($_REQUEST['longitude'])) ? $_REQUEST['longitude'] : '-84.127636');
            
            
            
            $location = $latitude . ',' . $longitude;
            
            //$location = ((isset($_REQUEST['location'])) ? $_REQUEST['location'] : '-33.8670522,151.1957362');
            
            $distance = ((isset($_REQUEST['distance'])) ? $_REQUEST['distance'] : 500);
            
            $rankby = ((isset($_REQUEST['rankby'])) ? $_REQUEST['rankby'] : 'distance');
            
            $types = ((isset($_REQUEST['types'])) ? $_REQUEST['types'] : 'food');
            
            $sensor = ((isset($_REQUEST['sensor'])) ? $_REQUEST['sensor'] : 'false');
            
            $key = ((isset($_REQUEST['key'])) ? $_REQUEST['key'] : 'AIzaSyCUNEgXFYxE3IzHKveGclIlCgDe6esSeWU');
            
            $subtype = ((isset($_REQUEST['subtype'])) ? $_REQUEST['subtype'] : '');
            













 ?>


