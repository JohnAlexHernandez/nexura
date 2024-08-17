Gestión de empleados

App que permite la gestión de empleados, areas y roles 🚀

Para obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas sigue las siguientes instrucciones:

1. Abrir una terminal

2. Cambia el directorio de trabajo actual a la ubicación en donde quieres clonar el directorio.

3. Escribe git clone https://github.com/JohnAlexHernandez/nexura.git

Pre-requisitos 📋

PHP >= 5.5.9
Composer 1.10.22
Bootstrap v5.3.3
MariaBD 10.1.29
Xampp 7.2.0

Para deplegar el proyecto sigue las siguientes instrucciones:

Antes de iniciar la configuración del proyecto es necesario tener instalado y confurado un stack que incluya Apache, MySQL y PHP con las características defnidas en los pre-requisitos

1. Ubicado en el directorio raiz del proyecto ejecute el comando composer install para instalar todas las dependencias necesarias para el correcto funcionamiento del proyecto.

2. Instale bootstrap mediante el comando npm install bootstrap

3. En seguida ejecute los comandos php bin/console doctrine:database:create y php bin/console doctrine:schema:update –force para crear y actualizar la base de datos

4. Iniciamos el servidor integrado de Symfony mediante el comando php bin/console server:run

3. Acceder a la ruta http://127.0.0.1:8000/empleados desde su navegador para visualizar la aplicación

Construído con 🛠️

    [Symfony](version 3.4) - Framework de PHP

Autores ✒️

    John Alexander Hernández - Creador - JohnAlexHernandez
