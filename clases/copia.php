<?php

    class Copia{

        function __construct(){
            require_once('conexion.php');
		    $this->conexion = new Conexion();
        }

        function obtenerIdLibroIsbn($isbn) {
        $consulta = "SELECT pkLibro FROM libro WHERE isbn = '{$isbn}'";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['pkLibro'];
        }// validar que exista el libro -_-
        return null;
    }

        function guardar($isbn, $folio, $fkEstanteria){
		$fkLibro = $this->obtenerIdLibroIsbn($isbn);

        if (!$fkLibro) {
            // ISBN no existe
            return false;
        }

        $consulta = "INSERT INTO copiaF (folio, fkLibro, fkEstanteria, fechaAdquisicion)
                     VALUES ('{$folio}', '{$fkLibro}', '{$fkEstanteria}', NOW())";
        return $this->conexion->query($consulta);
	}

    function lista(){
    $consulta = "
        SELECT 
            c.folio,
            l.isbn,
            l.titulo,
            s.nombreSubCategoria,
            e.codigoEstanteria
        FROM copiaF c
        INNER JOIN libro l ON c.fkLibro = l.pkLibro
        INNER JOIN subCategoria s ON l.fkSubCategoria = s.pkSubCategoria
        INNER JOIN estanteria e ON c.fkEstanteria = e.pkEstanteria
        WHERE c.estatus = 'A'
        ORDER BY c.pkCopiaF ASC
    ";
    $resultado = $this->conexion->query($consulta);
    return $resultado->fetch_all(MYSQLI_ASSOC);
    }

}

?>