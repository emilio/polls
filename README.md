# Encuestas con PHP y MySQL
Un ejemplo de lo que se puede hacer con el pequeño [framework que creé](https://github.com/ecoal95/framework).

## Instrucciones
Descarga los archivos y súbelos a tu servidor. Acuérdate de tener las tablas preparadas (con ejecutar `tables.sql` vale).

Edita config.php con los datos de la base de datos, y con tu usuario (abajo del todo).

Vete a `/admin/password`, introduce tu usuario, y genera una contraseña. Introdúcela en config.php

```php
// config.php
'admin' => array(
	'user' => 'TU USUARIO',
	'password' => 'LA CONTRASEÑA OBTENIDA'
)
```

Listo! Vete a `/admin/`, loguéate, y crea encuestas como un loco.

## El autor
Hecho con orgullo por [Emilio Cobos](http://emiliocobos.net)
