<?php 
include 'dbconfig.php';
//avvio la sessione
session_start();
//elimino la sessione
session_destroy();
//vado alla login
header("location: login.php");
exit;


/*session_start è necessaria per ricollegarsi alla sessione esistente, senza di essa la sessione non
 si potrebbe chiudere perchè non conosce la sessione attiva in quel momento e quindi non 
 saprebbe quale chiudere*/

?>

