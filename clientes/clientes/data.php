<?php
require 'cliente.php';

class Data
{
    private $con;
    private $host;
    private $user;
    private $pass;
    private $base;
    private $port;

    public function __contruct()
    {
        $this->host = "localhost";
        $this->user = "root";
        $this->pass = "1234";
        $this->base = "sistema_poo";
        $this->port = 3309;
    }
    public function connect()
    {
        $this->con = new mysqli($this->host,"root", "1234", "sistema_poo", 3309); //averiguar porque no me deja llamar las referencias del constructor y si me lo toma si lo harcodeo
        if ($this->con->connect_error) {
            die("No se logro la conexion a la base de datos!!" . $this->con->connect_error);
        } else {
            return $this->con;
        }
    }

    public function create(Cliente $objCliente)
    {
        $nombre = $this->connect()->real_escape_string($objCliente->getNombre());
        $apellido = $this->connect()->real_escape_string($objCliente->getApellido());
        $direccion = $this->connect()->real_escape_string($objCliente->getDireccion());
        $telefono = $this->connect()->real_escape_string($objCliente->getTelefono());
        $correo = $this->connect()->real_escape_string($objCliente->getCorreo());

        $sql = "SELECT * FROM clientes WHERE correo='$correo';";
        $res = $this->connect()->query($sql);
        if ($res->num_rows > 0) {
            return false;
        } else {
            $sql = "INSERT INTO clientes VALUES(DEFAULT,'$nombre','$apellido','$telefono','$direccion','$correo');";
            $res = $this->connect()->query($sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function listar()
    {
        $datos = array();

        $sql = "SELECT * FROM clientes;";

        $res = $this->connect()->query($sql);
        if ($res->num_rows > 0) {
            while($fila = $res->fetch_object()){
                $datos[] = $fila;
            }
           
            return $datos;
        }
    }

    public function delete($id)
    {
        $id = $this->connect()->real_escape_string($id);
        $sql = "DELETE FROM clientes WHERE id=$id;";

        $res = $this->connect()->query($sql);
        if ($res) {
           return true;   
       }else{
            return false;
       }
    }

    public function find($id):Cliente
    {
        $cliente = new Cliente();
        $id = $this->connect()->real_escape_string($id);
        $sql = "SELECT * FROM clientes WHERE id= $id;";
        $res = $this->connect()->query($sql);
        if ($res->num_rows > 0) {
            $datos = $res->fetch_object();
            $cliente->setId($datos->id);
            $cliente->setNombre($datos->nombre);
            $cliente->setApellido($datos->apellido);
            $cliente->setDireccion($datos->direccion);
            $cliente->setTelefono($datos->telefono);
            $cliente->setCorreo($datos->correo);
            return $cliente;
        }
    }

    public function update(Cliente $objCliente)
    {
        $id = $this->connect()->real_escape_string($objCliente->getId());
        $nombre = $this->connect()->real_escape_string($objCliente->getNombre());
        $apellido = $this->connect()->real_escape_string($objCliente->getApellido());
        $direccion = $this->connect()->real_escape_string($objCliente->getDireccion());
        $telefono = $this->connect()->real_escape_string($objCliente->getTelefono());
        $correo = $this->connect()->real_escape_string($objCliente->getCorreo());

        $sql = "SELECT * FROM clientes WHERE id='$id';";
        
        $res = $this->connect()->query($sql);
        
        if ($res->num_rows == 0) {
            return false;
        } else {
            $sql = "UPDATE clientes SET nombre = '$nombre',apellido = '$apellido',telefono = '$telefono',direccion = '$direccion',correo ='$correo' WHERE id=$id;";
            $res = $this->connect()->query($sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }
    }


}
