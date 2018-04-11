<?php

function UserLogeado(){
  if(isset($_GET['pagina'])){
    if(strtolower($_GET['pagina']) == "login.html"){

    }else{
      if(empty($_SESSION['IDUser'])){
        header('location: ?pagina=login.html');
      }else {
        //echo "<script>alert('LOGEADO');</script>";
      }
    }
  }else {
    if(empty($_SESSION['IDUser'])){
      header('location: ?pagina=login.html');
    }else {
      //echo "<script>alert('LOGEADO');</script>";
    }
  }

}

?>
