
# Docker LAMP
Linux + Apache + MariaDB (MySQL) + PHP 7.2 on Docker Compose. Mod_rewrite enabled by default.

## Instructions


Clona el repositorio:

```bash
$git clone git@github.com:JavierTorralbaSanz/docker-lamp.git

```
Entra donde has clonado el repositorio:
```bash
$ cd docker-lamp

```
Pon el siguiente comando para poner en marcha los containers:
```bash
$ docker-compose up -d
```

Para paralos, usa esto:
```bash
$ docker-compose stop
```

En otra terminal, veremos los puertos del sistema ejecutaremos el comando:

```bash
$ docker-compose ps
```
Se estarán usando los puertos 81, 8890 y 8891. Introducineros en el navegador:

localhost:81/, para acceder al sistema
localhost:8890/, para acceder a phpmyadmin. En phpmyadmin entraremos con el usuario "admin" y con la contraseá "test". Una vez dentro se creará una base de datos llamada database. La seleccionamos e importamos la base de datos del proyecto llamada database.sql

## Miembros
	-Peio Orbe
	-Javier Torralba
	-Jon Izaguirre
	-Iker Marin
	-Raúl Álvarez
	-Eneko De la Fuente
	
