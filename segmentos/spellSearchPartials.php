
<?php
/*
*   SEGMENTO PARA EL SWITCH  'getallData'
*   CREACION : 18/11/2014
*   
*/

//require('includes/config.php');

require('helpers.php');

function buscarConcordanciaTermino($palabraInicial,$search_termIntacto)
{



                 $ArregloTermino = ObtenerTerminosDirectorio();

                // ******************************************  
                 // BUSQUEDA DE TERMINOS COMPUESTOS POR VARIAS PALABRAS  */
                 // ******************************************  

                     foreach ($ArregloTermino as $obj_key => $termino) {
                    
                    foreach ($termino as $key => $value) {
                        
                        if ($coincidencia == 1) {
                            $var_id            = $value;
                            $TerminoEncontrado = 1;
                            break;
                        }
                        
                        if ($value == $search_termIntacto) //encuentra una similitud sin modificar el texto ingresado por el usuario 
                            $coincidencia = 1;
                    }
                    
                    //if para evitar delay
                    if ($coincidencia == 1) {
                        break;
                    } else {
                        $coincidencia = 0;
                    }
                    
                }




                
                 // ******************************************  
                 // BUSQUEDA DE TERMINOS BASADO EN UNA PALABRA  */
                 // ******************************************  
                 
                if ($TerminoEncontrado == 0) {

                
                foreach ($ArregloTermino as $obj_key => $termino) {
                    
                    foreach ($termino as $key => $value) {
                        
                        if ($coincidencia == 1) {
                            $var_id            = $value;
                            $TerminoEncontrado = 1;
                            break;
                        }
                        
                        if ($value == $palabraInicial) //encuentra una similitud con la primera palabra escrita por el usuario.
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


return $var_id;

}





















