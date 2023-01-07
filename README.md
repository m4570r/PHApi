# PHApi
Este código es un script escrito en PHP que maneja diferentes tipos de solicitudes HTTP. La clase incluye métodos para manejar solicitudes GET, POST, PUT y DELETE, así como un método para devolver la versión de la API. También incluye una conexión a una base de datos MySQL y utiliza consultas preparadas PDO para interactuar con la base de datos.

## Descripción
Esta aplicación es una API escrita en PHP que permite interactuar con una base de datos MySQL. La API proporciona un conjunto de métodos que permiten realizar operaciones CRUD (crear, leer, actualizar y eliminar) en la tabla de usuarios de la base de datos. La API también incluye un método para devolver la versión de la API.

El propósito de esta aplicación es proporcionar una forma sencilla de interactuar con la base de datos MySQL y realizar operaciones básicas en la tabla de usuarios a través de una interfaz de programación de aplicaciones (API). La API se puede utilizar para crear, leer, actualizar y eliminar usuarios de la base de datos y también se puede utilizar para obtener información sobre la versión de la API.

## Instalación:

  1. Descarga o clona el repositorio de la aplicación en tu servidor web.
  2. Asegúrate de que tienes una instalación de PHP y un servidor web (como Apache o Nginx) configurados en tu servidor.
  3. Crea una base de datos MySQL y una tabla de usuarios con los campos 'id', 'nombre' y 'edad'.
  4. Modifica el archivo config.php con los detalles de tu base de datos.
  5. Accede a la aplicación a través de tu navegador web utilizando la URL del servidor.

## Configuración:

  1. El archivo config.php incluye la configuración de conexión a la base de datos. Asegúrate de actualizar los valores de $host, $user, $password y $database con los detalles de tu base de datos.
  2. Si deseas cambiar la tabla de usuarios con la que la aplicación interactúa, puedes modificar el valor de $table en el archivo config.php.

Una vez que hayas completado estos pasos, deberías ser capaz de acceder a la aplicación y empezar a utilizarla.

## Integracíon

La aplicación se puede integrar con otros sistemas o componentes a través de su API. La API es un conjunto de métodos que pueden ser invocados mediante solicitudes HTTP y que proporcionan acceso a las funcionalidades de la aplicación.

La API soporta las siguientes solicitudes HTTP:

  - GET: para obtener información de la base de datos o de la API.
  - POST: para crear un nuevo registro en la base de datos.
  - PUT: para actualizar un registro existente en la base de datos.
  - DELETE: para eliminar un registro de la base de datos.
  - La API también incluye un método para obtener la versión de la API.

Para integrarse con la aplicación, otro sistema o componente necesitaría enviar solicitudes HTTP a la API utilizando la URL del servidor y el método adecuado según sea necesario. La API devolvería una respuesta en formato JSON con los resultados de la solicitud.

## Documentación

La API de esta aplicación se puede utilizar para interactuar con la aplicación y realizar operaciones en la base de datos. La API es accesible a través de solicitudes HTTP y proporciona un conjunto de métodos que pueden ser invocados según sea necesario.

A continuación se proporciona una descripción de cada método de la API y cómo se utiliza:

  - GET: Este método se utiliza para obtener información de la base de datos o de la API. Para hacer una solicitud GET a la API, envía una solicitud HTTP GET a la URL del servidor con el siguiente formato: 
  ```
  http://<server>/api/<method>?<parameter1>=<value1>&<parameter2>=<value2>
  ```
  Los parámetros son opcionales y se pueden utilizar para filtrar los resultados.
Ejemplo: 
  ```
  http://localhost/api/get?nombre=John 
  ```
  devolvería todos los usuarios con el nombre "John" de la base de datos.

  - POST: Este método se utiliza para crear un nuevo registro en la base de datos. Para hacer una solicitud POST a la API, envía una solicitud HTTP POST a la URL del servidor con el siguiente formato: 
  ```
  http://<server>/api/<method>
  ```
  La solicitud debe incluir un cuerpo de solicitud en formato JSON con los datos del nuevo registro.
Ejemplo: 
  ```
  http://localhost/api/post 
  ```
  con un cuerpo de solicitud 
  ```
  {"nombre": "Alice", "edad": 25}
  ```
  crearía un nuevo usuario con el nombre "Alice" y la edad 25 en la base de datos.

  - PUT: Este método se utiliza para actualizar un registro existente en la base de datos. Para hacer una solicitud PUT a la API, envía una solicitud HTTP PUT a la URL del servidor con el siguiente formato: 
  ```
  http://<server>/api/<method>?<parameter1>=<value1>&<parameter2>=<value2>
  ```
  La solicitud debe incluir un cuerpo de solicitud en formato JSON con los datos actualizados. Los parámetros son opcionales y se pueden utilizar para filtrar los resultados.
Ejemplo: 
  ```
  http://localhost/api/put?nombre=Alice
  ```
  con un cuerpo de solicitud 
  ```
  {"id": 1, "edad": 26} 
  ```
  actualizaría la edad del usuario con el nombre "Alice" a 26 en la base de datos.

  - DELETE: Este método se utiliza para eliminar un registro de la base de datos. Para hacer una solicitud DELETE a la API, envía una solicitud HTTP DELETE a la URL del servidor con el siguiente formato:
  ```
  http://<server>/api/<method>?<parameter1>=<value1>&<parameter2>=<value2>
  ```
Los parámetros son opcionales y se pueden utilizar para filtrar los resultados.
Ejemplo: 
  ```
  http://localhost/api/delete?nombre=Alice 
  ```
  eliminaría al usuario con el nombre "Alice" de la base de datos.

Versión: Este método se utiliza para obtener la versión de la API. Para hacer una solicitud al método de versión, envía una solicitud HTTP GET a la URL del servidor con el siguiente formato:
```
http://<server>/api/version.
```
Ejemplo: 
  ```
  http://localhost/api/version
  ```
  devolvería la versión de la API.


Eso por el momento, estare actualizando el codigo saludos ante cualquier duda o consulta miguel.php@gmail.com
