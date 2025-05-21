Instrucciones de Instalacion.

1.- Clonar el repositorio de github
2.- intalacion de dependencias de composer con composer install.
3.- En el proyecto se integra JWT para la autenticacion de los usarios y midleware si es necesario generar una key nueva se puede generar con php artisan jtw:generate
4.- Copiar el contenido del archivo .env-example y crear un archivo nuevo en la raiz del proyecto llamado .env
5.- Correr el comando php artisan migrate para la migracion de schema de las tablas sql.
6.- levantar el servidor con php artisan serve.
