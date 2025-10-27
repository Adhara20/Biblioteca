<?php
//esto es una forma de hacer conexion a la base de datos
class Conexion extends mysqli{
function __construct(){
parent:: __construct('localhost','root','mysql','biblioteca');
}
}
?>