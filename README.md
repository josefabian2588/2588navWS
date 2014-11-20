TODO
-----------
1-Busqueda por alias (Ej:"BK" y "MC").    /*FUNCIONA*/

2-La lista de resultados se ordena por distancia, lo anterior cuando se  realiza una búsqueda por un termino simple  (Ej: "Bar","Pasteles" ) . /*FUNCIONA*/
      ***Busqueda por terminos compuestos ("tomar presion") . /*MALO*/
      
3-Busqueda termino + nombre (Ej: "Bar Malibu" , "Ferreteria EPA" y "Banco Davivienda") . /*MALO*/

4-Sí se busca una sola palabra (EJ: Lavacar, Farmacia)se utiliza el método de búsqueda y ordenación por cercania./*FUNCIONA*/

5-Sí se busca usando más de una palabra (EJ: Banco nacional, Plaza Rohrmoser ), se ordena por mejor concordancia  , en algunos casos se ordenara por distancia , lo anterior sucede si no encuentra un concordancia alta . /*MALO*/

6-Se pueden hacer búsquedas por zonas escribiendo al final el nombre del poblado (funciona en apropiadamente el 75% de las búsquedas) , por ejemplo:
          o “INA de San Rafael de Alajuela” , busca algún INA en San Rafal  Alajuela .
          o	“Taco Bell de Cartago” , busca los Taco Bell en Cartago .     /*PARCIAL*/
          
7-Se pueden hacer búsquedas por términos y además filtrando por zonas (funciona en apropiadamente el 75% de las búsquedas , se basa en el Street*) , por ejemplo:
          o	“Playas en Limón” , Playas es un término , por lo cual solo mostrara las playas de limón .
          o	“Farmacias en Pavas” , Farmacias es un término , solo mostrara las Farmacias de Pavas. /*FUNCIONA*/
          
          
          
          

