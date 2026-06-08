<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos de configuración y clases
include_once '../configuracion/Database.php';
include_once '../clases/Productos.php';

// Instanciar base de datos y conexión
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto productos
$productos = new Productos($db);

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener la URL solicitada
$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$url = explode('/', trim($url, '/'));

// Variable para el ID (si se proporciona)
$id = null;

// Verificar si se proporciona un ID en la URL
if (isset($url[1])) {
    $id = intval($url[1]);
}

// Variable para la respuesta
$response = array();

switch ($metodo) {
    case 'GET':
        if ($id) {
            // Obtener un producto por ID
            $productos->idProducto = $id;

            if ($productos->getProducto()) {
                $producto_item = array(
                    "idProducto" => $productos->idProducto,
                    "nombreproducto" => $productos->nombreproducto,
                    "descripcion" => $productos->descripcion,
                    "precioCompra" => $productos->precioCompra,
                    "precioVenta" => $productos->precioVenta,
                    "existencia" => $productos->existencia
                );

                http_response_code(200);
                echo json_encode($producto_item);
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "Producto no encontrado"));
            }
        } else {
            // Obtener todos los productos
            $stmt = $productos->getProductos();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $productos_arr = array();
                $productos_arr["registros"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $producto_item = array(
                        "idProducto" => $idProducto,
                        "nombreproducto" => $nombreproducto,
                        "descripcion" => $descripcion,
                        "precioCompra" => $precioCompra,
                        "precioVenta" => $precioVenta,
                        "existencia" => $existencia
                    );

                    array_push($productos_arr["registros"], $producto_item);
                }

                http_response_code(200);
                echo json_encode($productos_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "No se encontraron productos"));
            }
        }
        break;

    case 'POST':
        // Obtener datos enviados
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nombreproducto) &&
            !empty($data->descripcion) &&
            !empty($data->precioCompra) &&
            !empty($data->precioVenta) &&
            isset($data->existencia)
        ) {
            // Asignar valores
            $productos->nombreproducto = $data->nombreproducto;
            $productos->descripcion = $data->descripcion;
            $productos->precioCompra = $data->precioCompra;
            $productos->precioVenta = $data->precioVenta;
            $productos->existencia = $data->existencia;

            // Crear producto
            $resultado = $productos->setProductos();

            if ($resultado === true) {
                http_response_code(201);
                echo json_encode(array("mensaje" => "Producto creado correctamente"));
            } else {
                http_response_code(400);
                echo json_encode(array("mensaje" => $resultado));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Datos incompletos. Todos los campos son obligatorios."));
        }
        break;

    case 'PUT':
        // Obtener datos enviados
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nombreproducto) &&
            !empty($data->descripcion) &&
            !empty($data->precioCompra) &&
            !empty($data->precioVenta) &&
            isset($data->existencia)
        ) {
            // Asignar valores
            $productos->idProducto = $id;
            $productos->nombreproducto = $data->nombreproducto;
            $productos->descripcion = $data->descripcion;
            $productos->precioCompra = $data->precioCompra;
            $productos->precioVenta = $data->precioVenta;
            $productos->existencia = $data->existencia;

            // Actualizar producto
            $resultado = $productos->updateProducto();

            if ($resultado === true) {
                http_response_code(200);
                echo json_encode(array("mensaje" => "Producto actualizado correctamente"));
            } else {
                http_response_code(400);
                echo json_encode(array("mensaje" => $resultado));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Datos incompletos. Todos los campos son obligatorios."));
        }
        break;

    case 'DELETE':
        // Verificar que se proporcione un ID
        if ($id) {
            $productos->idProducto = $id;

            if ($productos->borrarProducto()) {
                http_response_code(200);
                echo json_encode(array("mensaje" => "Producto eliminado correctamente"));
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "Producto no encontrado"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Se requiere el ID del producto"));
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(array("mensaje" => "Método no permitido"));
        break;
}

?>