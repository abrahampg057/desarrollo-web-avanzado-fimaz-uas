<?php

class Productos
{
    private $conn;
    private $table = "productos";

    // Propiedades del producto
    public $idProducto;
    public $nombreproducto;
    public $descripcion;
    public $precioCompra;
    public $precioVenta;
    public $existencia;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Obtener todos los productos
    public function getProductos()
    {
        $query = "SELECT idProducto, nombreproducto, descripcion, precioCompra, precioVenta, existencia FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un producto por ID
    public function getProducto()
    {
        $query = "SELECT idProducto, nombreproducto, descripcion, precioCompra, precioVenta, existencia FROM " . $this->table . " WHERE idProducto = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idProducto);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nombreproducto = $row['nombreproducto'];
            $this->descripcion = $row['descripcion'];
            $this->precioCompra = $row['precioCompra'];
            $this->precioVenta = $row['precioVenta'];
            $this->existencia = $row['existencia'];
            return true;
        }

        return false;
    }

    // Crear un producto
    public function setProductos()
    {
        $query = "INSERT INTO " . $this->table . " (nombreproducto, descripcion, precioCompra, precioVenta, existencia) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombreproducto = htmlspecialchars(strip_tags($this->nombreproducto));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precioCompra = htmlspecialchars(strip_tags($this->precioCompra));
        $this->precioVenta = htmlspecialchars(strip_tags($this->precioVenta));
        $this->existencia = htmlspecialchars(strip_tags($this->existencia));

        // Validaciones
        if (empty($this->nombreproducto)) {
            return "El nombre del producto es obligatorio";
        }

        if ($this->precioCompra < 0) {
            return "El precio de compra no puede ser negativo";
        }

        if ($this->precioVenta < 0) {
            return "El precio de venta no puede ser negativo";
        }

        if ($this->existencia < 0) {
            return "La existencia no puede ser negativa";
        }

        if ($this->precioVenta < $this->precioCompra) {
            return "El precio de venta debe ser mayor o igual al precio de compra";
        }

        // Vincular parámetros
        $stmt->bindParam(1, $this->nombreproducto);
        $stmt->bindParam(2, $this->descripcion);
        $stmt->bindParam(3, $this->precioCompra);
        $stmt->bindParam(4, $this->precioVenta);
        $stmt->bindParam(5, $this->existencia);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Actualizar un producto
    public function updateProducto()
    {
        $query = "UPDATE " . $this->table . " SET nombreproducto = ?, descripcion = ?, precioCompra = ?, precioVenta = ?, existencia = ? WHERE idProducto = ?";
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombreproducto = htmlspecialchars(strip_tags($this->nombreproducto));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precioCompra = htmlspecialchars(strip_tags($this->precioCompra));
        $this->precioVenta = htmlspecialchars(strip_tags($this->precioVenta));
        $this->existencia = htmlspecialchars(strip_tags($this->existencia));
        $this->idProducto = htmlspecialchars(strip_tags($this->idProducto));

        // Validaciones
        if (empty($this->nombreproducto)) {
            return "El nombre del producto es obligatorio";
        }

        if ($this->precioCompra < 0) {
            return "El precio de compra no puede ser negativo";
        }

        if ($this->precioVenta < 0) {
            return "El precio de venta no puede ser negativo";
        }

        if ($this->existencia < 0) {
            return "La existencia no puede ser negativa";
        }

        if ($this->precioVenta < $this->precioCompra) {
            return "El precio de venta debe ser mayor o igual al precio de compra";
        }

        // Vincular parámetros
        $stmt->bindParam(1, $this->nombreproducto);
        $stmt->bindParam(2, $this->descripcion);
        $stmt->bindParam(3, $this->precioCompra);
        $stmt->bindParam(4, $this->precioVenta);
        $stmt->bindParam(5, $this->existencia);
        $stmt->bindParam(6, $this->idProducto);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar un producto
    public function borrarProducto()
    {
        $query = "DELETE FROM " . $this->table . " WHERE idProducto = ?";
        $stmt = $this->conn->prepare($query);

        $this->idProducto = htmlspecialchars(strip_tags($this->idProducto));

        $stmt->bindParam(1, $this->idProducto);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>