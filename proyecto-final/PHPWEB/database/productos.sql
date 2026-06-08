CREATE DATABASE IF NOT EXISTS productos;
USE productos;

CREATE TABLE IF NOT EXISTS productos (
    idProducto INT AUTO_INCREMENT PRIMARY KEY,
    nombreproducto VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precioCompra DECIMAL(10,2) NOT NULL,
    precioVenta DECIMAL(10,2) NOT NULL,
    existencia INT NOT NULL
);