<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'sistema';

	try {
		$conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
		// Establece el modo de error PDO a excepción
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

	// Crea una clase para manejar las solicitudes del servidor web
	class RequestHandler {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

	// Maneja la solicitud GET 
	public function do_GET() {
		$sql = 'SELECT * FROM usuarios';
		$filters = [];
		if (!empty($_GET)) {
			$validFields = ['nombre', 'id', 'edad'];
			foreach ($_GET as $field => $value) {
				if (in_array($field, $validFields) && isset($_GET[$field])) {
					$filters[$field] = $value;
				} else {
					// Si el parámetro no es válido, se devuelve un error
					http_response_code(400);
					header('Content-Type: application/json');
					$response = ['error' => 'Invalid parameter'];
				}
			}
		}
		if (!empty($filters)) {
			$where = ' WHERE TRUE';
			foreach ($filters as $field => $value) {
				$where .= " AND $field = :$field";
			}
			$sql .= $where;
		}
		// Ejecuta la consulta a la base de datos MySQL
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($filters);
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// Devuelve los resultados de la consulta como una respuesta JSON
	if (isset($response)) {
		echo json_encode($response);
		return;
	}
	http_response_code(200);
	header('Content-Type: application/json');
	$response = $results;
	echo json_encode($response);

}

	  public function do_GET_version() {
  http_response_code(200);
  header('Content-Type: application/json');
  $response = ['version' => 'API escrita en PHP'];
  echo json_encode($response);
}

	// Maneja la solicitud POST
	public function do_POST($parsed_url, $parsed_query, $data) {
		// Agrega un nuevo usuario a la base de datos
		$stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, edad) VALUES (:nombre, :edad)");
		$stmt->bindParam(':nombre', $data['nombre']);
		$stmt->bindParam(':edad', $data['edad']);
		$stmt->execute();
		http_response_code(201);
		header('Content-Type: application/json');
		echo json_encode(['id' => $this->conn->lastInsertId()]);
	}

	
		// Maneja la solicitud PUT
		public function do_PUT($parsed_url, $parsed_query, $data) {
		// Actualiza la información de un usuario en la base de datos
		$stmt = $this->conn->prepare("UPDATE usuarios SET nombre=:nombre, edad=:edad WHERE id=:id");
		$stmt->bindParam(':nombre', $data['nombre']);
		$stmt->bindParam(':edad', $data['edad']);
		$stmt->bindParam(':id', $parsed_query['id'][0]);
		$stmt->execute();
		http_response_code(204);
	}


	public function do_DELETE($parsed_url, $parsed_query, $data) {
	  // Si no se envía el ID del usuario en el payload, se devuelve un error
	  if (!isset($data['id'])) {
		http_response_code(400);
		header('Content-Type: application/json');
		echo json_encode(['error' => 'ID not provided']);
		return;
	  }
	  
	  // Obtiene el ID del usuario a eliminar
	  $id = $data['id'];

	  // Realiza una consulta SELECT para verificar si el ID existe en la base de datos
	  $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id=:id");
	  $stmt->bindParam(':id', $id);
	  $stmt->execute();

	  // Si la consulta no devuelve resultados, significa que el ID no existe
	  if ($stmt->rowCount() === 0) {
		http_response_code(400);
		header('Content-Type: application/json');
		echo json_encode(['error' => 'ID not found']);
		return;
	  }

	  // Si el ID existe, ejecuta una consulta DELETE en la base de datos
	  $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id=:id");
	  $stmt->bindParam(':id', $id);
	  $stmt->execute();

	  // Envía una respuesta al cliente indicando que la operación se realizó correctamente
	  http_response_code(200);
	  header('Content-Type: application/json');
	  echo json_encode(['message' => 'Record deleted successfully']);
	}

}

	// Obtiene la URL de la solicitud
	$url = $_SERVER['REQUEST_URI'];

	// Parsea la URL para obtener los componentes de la URL
	$parsed_url = parse_url($url);

	// Obtiene los parámetros de la URL
	$parsed_query = array();
	if (isset($parsed_url['query'])) {
		parse_str($parsed_url['query'], $parsed_query);
	}

	// Obtiene el método de solicitud
	$method = $_SERVER['REQUEST_METHOD'];

	// Crea una instancia de la clase RequestHandler
	$request_handler = new RequestHandler($conn);

	// Obtiene el cuerpo de la solicitud
	$data = json_decode(file_get_contents('php://input'), true);

	// Llama al método correcto de la clase RequestHandler dependiendo del método de solicitud
	switch ($method) {
	  case 'GET':
		// Check if the request URI ends with '/version'
		if (preg_match('/\/version$/', $_SERVER['REQUEST_URI'])) {
		// code to execute if the request is a GET request to the '/version' endpoint
		$endpoint = 'version';
		// Crea una instancia de la clase RequestHandler
		$request_handler = new RequestHandler($conn);
		// Llamamos al método do_GET_version a través d	e la instancia de la clase
		$request_handler->do_GET_version();
		} else {
		$request_handler->do_GET($parsed_url, $parsed_query);
		}
		break;
	  case 'POST':
		$request_handler->do_POST($parsed_url, $parsed_query, $data);
		break;
	  case 'PUT':
		$request_handler->do_PUT($parsed_url, $parsed_query, $data);
		break;
	  case 'DELETE':
		$request_handler->do_DELETE($parsed_url, $parsed_query, $data);
		break;
	  default:
		// Envía una respuesta de error si el método de solicitud no es válido
		http_response_code(405);
		header('Content-Type: application/json');
		echo json_encode(['error' => 'Method not allowed']);
		break;
	}

?>