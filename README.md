## Integrantes

- Lucas Mosquera, 202273504-k
- Joaquín Dominguez, 202273545-7

## Instrucciones

Para desarrollar la aplicación web, nosotros ocupamos WSL2, usando los paquetes `php php-mysql mysql-server`.

### Conectarse al web server

Para conectarnos a un web server local ocupamos el probeído por PHP, con el siguiente comando:

```sh
php -S 127.0.0.1:8000 -t .
```

Entrando al link que provee luego el comando, podras acceder al sitio web, la primera página que aparece es el `index.html`, de donde podra ir a las otras páginas con el contenido de la tarea.

Las páginas que hay aparte de `index.html` son:

- `/php/reserva_habitación.php`, donde se reservan las habitaciones.
- `/php/reserva_tours.php`, donde se reservan los tours por parte de las habitaciones.
- `/php/reportes.php`, donde se ven los reportes de las habitaciones
- `/php/checkout.php`, donde se hace el checkout de las habitaciones

### Importar la base de datos


Para importar la base de datos se ocupa el siguiente comando desde la carpeta principal del proyecto:

```sh
mysql -u root -p Tarea2 < ./bd/Tarea2.sql
```

Para exportarlo se ocupa:

```sh
mysqldump -u root -p Tarea2 > ./bd/Tarea2.sql
```

De forma alternativa, con el siguiente link `localhost:8000/php/recreate.php`, puede crear la base de datos de 0, pero solo estarán los datos de las habitaciones y de los tours, los otros datos se tendrían que poner manualmente.

### Aclaraciones
- El index.html necesita estar fuera de la carpera php para ser un punto de entrada a la pagina.
- Se asumen inputs correctos.