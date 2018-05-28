<?php

unset($_SESSION['IDUser'], $_SESSION['Permiso'], $_SESSION['linkExcelN'], $_SESSION['Sudo'], $_SESSION['notiExcel'], $_SESSION['Dep'], $_SESSION['DB'], $_SESSION['User']);
session_destroy();
header('location: ?pagina=login.html');

?>
