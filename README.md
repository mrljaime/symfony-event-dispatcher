## Symfony Event Dispatcher

Este proyecto está desarrollado como parte de una entrada en mi perfil 
de [Medium]() donde relato cuál es el uso del patron Observer y como 
se utiliza en Symfony a través del componente Event Dispatcher, el cual nos  
permitir desacoplar funcionalidades y responsabilidades. 

Este proyecto hace uso específico de los paquetes siguientes de PHP para su correcto funcionamiento:
- PHP >= 7.2
- ext-json
- ext-sqlite
- ext-iconv
- ext-ctype

Este proyecto hace uso de una base de datos SQLite que está definida
en el archivo de configuración de variables de ambiente, sin embargo 
puedo ser usado con cualquier otro motor de base de datos (ej: MariaDB, MySQL)
soportado por [Doctrine](https://www.doctrine-project.org/projects/orm.html)

*** 
#### Después de clonar este proyecto 
Después de clonar este proyecto se necesitará que hagas uso de composer para poder 
instalar los paquetes necesarios para que este proyecto pueda trabajar. 

- `composer install` para instalar los paquetes del proyecto 
- `php bin/console doctrine:database:create` para crear la base de datos
- `php bin/console make:migration` para poder generar las consultas necesarias de sql para
crear las tablas del proyecto 
- `php bin/console doctrine:migrations:migrate` para ejecutar las consultas en la base de datos
y crear, hasta este momento, las tablas necesarias para poder ejecutar la aplicación
- `php -S 127.0.0.1:9091 public/index.php` para correr el servidor web que PHP puede crear 
por sí mismo para fines de desarrollo 

