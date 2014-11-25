TODO
-----------
1-Busqueda por alias (Ej:"BK" y "MC").    /*MALO*/

2-La lista de resultados se ordena por distancia, lo anterior cuando se  realiza una búsqueda por un termino simple  (Ej: "Bar","Pasteles" ) . /*FUNCIONA*/
      ***Busqueda por terminos compuestos ("tomar presion") . /*FUNCIONA*/
      
3-Busqueda termino + nombre (Ej: "Bar Malibu" , "Ferreteria EPA" y "Banco Davivienda") . /*FUNCIONA*/

4-Sí se busca una sola palabra (EJ: Lavacar, Farmacia)se utiliza el método de búsqueda y ordenación por cercania./*FUNCIONA*/



5-Sí se busca usando más de una palabra (EJ: Banco nacional, Plaza Rohrmoser ), se ordena por mejor concordancia  , en algunos casos se ordenara por distancia , lo anterior sucede si no encuentra un concordancia alta . /*FUNCIONA*/

6-Se pueden hacer búsquedas por zonas escribiendo al final el nombre del poblado (funciona en apropiadamente el 90% de las búsquedas) , por ejemplo:
          o    “INA de San Rafael de Alajuela” , busca algún INA en San Rafal  Alajuela .
          o	“Taco Bell de Cartago” , busca los Taco Bell en Cartago .     /*FUNCIONA*/
          
7-Se pueden hacer búsquedas por términos y además filtrando por zonas (funciona en apropiadamente el 85% de las búsquedas , se basa en el Street*) , por ejemplo:
          o	“Playas en Limón” , Playas es un término , por lo cual solo mostrara las playas de limón .
          o	“Farmacias en Pavas” , Farmacias es un término , solo mostrara las Farmacias de Pavas. /*FUNCIONA*/
          
          
8-Sí busca el nombre de un POI + la zona (EJ: "spoon de Heredia" , )        /*FUNCIONA*/   

9-Sí busca el nombre de un POI + la zona , PERO SIN USAR DE O EN  (EJ: "spoon Heredia" , )     /*MALO*/
          

