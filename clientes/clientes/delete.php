<?php
    require 'data.php';
    if(isset($_GET['id'])){
        $cliente = new Data();
        $id = intval($_GET['id']);
        $respuesta = $cliente->delete($id);
        session_start();
        if($respuesta){
            $_SESSION['mensaje'] = "Eliminado Correctamente!"; 
        }else{
            $_SESSION['mensaje'] = "No existe el Cliente";
        }
        header("location:index.php");
    }
    ?>