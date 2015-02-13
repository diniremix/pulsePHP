# PulsePHP
PHP **RESTful** API


## Requisitos
- [Apache](http://www.apache.org/) Version 2.2.x o compatible
- [PHP](http://www.php.net/) Version 5.3.8 o superior
- [Slim a PHP micro framework (incluido)](http://www.slimframework.com/) Version 2.4.2 o superior
- [RedBean on-the-fly ORM for PHP (incluido)](http://redbeanphp.com/) Version 3.5 o superior


## Instalacion
Clonar este repositorio y alojarlo en una carpeta publica de su servidor web

	git clone git://github.com/diniremix/pulsePHP.git


Puede también descargar la versión mas reciente de **pulsePHP** [por aquí](https://github.com/diniremix/pulsePHP/archive/master.zip)


## Configuracion
Si bien **pulsePHP** viene con una configuración basica y listo para usar, por defecto no se usa ningún Motor de Bases de Datos, puede cambiar esto, modificando el archivo **/app/config/databases.php**, ubicar la línea siguiente:
 
```php
'DB_DEFAULT' => 'none',
```
y reemplazar por el Motor de Bases de Datos de su preferencia, para más información véase el [apartado de Bases de Datos.](https://github.com/diniremix/pulsePHP/wiki/databases)

**Ejemplo:**
```php
'DB_DEFAULT' => 'mysql',
```


## Bases de Datos soportadas
**pulsePHP** soporta **MySQL** (*InnoDB*), **PostgreSQL**, **SQLite3**, y **CUBRID.** via [RedBeanPHP](http://redbeanphp.com/)


## Documentación 
La documentación de **pulsePHP** puede ser encontrada en la [Wiki del proyecto](https://github.com/diniremix/pulsePHP/wiki)


## Licencia
**PulsePHP** es Software de código abierto [bajo la licencia **MIT**](http://opensource.org/licenses/MIT)

El texto completo de la licencia puede ser encontrado en el archivo **MIT-LICENSE.txt**


## Contacto
[Diniremix on GitHub](https://github.com/diniremix)

email: *diniremix [at] gmail [dot] com*
