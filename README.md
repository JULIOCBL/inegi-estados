# INEGI Estados

Proyecto base con Laravel 11, MySQL, Bootstrap 5 y Vite.

## Prueba técnica

### Laravel + MySQL + Bootstrap

### Tecnologías por utilizar

- Laravel 6 o superior
- Bootstrap
- MySQL

### Instrucciones

#### 1. Estados

Obtener el listado de las 32 entidades federativas utilizando el Servicio Web del Catálogo Único de Claves Geoestadísticas del INEGI.

Endpoint:

[https://gaia.inegi.org.mx/wscatgeo/v2/mgee/](https://gaia.inegi.org.mx/wscatgeo/v2/mgee/)

Guardar los estados en una tabla llamada `estados`.

La información almacenada deberá incluir, como mínimo:

- Clave del estado, utilizando el campo `cve_ent`.
- Nombre del estado, utilizando el campo `nomgeo`.
- Población total, utilizando el campo `pob_total`.

Mostrar los estados en un listado, idealmente utilizando DataTables, con las siguientes columnas:

- Clave.
- Estado.
- Población total.

El listado deberá contar con:

- Paginación.
- Búsqueda.
- Ordenamiento.

La población total deberá mostrarse en un formato legible, incluyendo separadores de miles.

Ejemplo:

`798447` deberá mostrarse como `798,447`.

Evitar registros duplicados si se vuelve a ejecutar la carga; es decir, el proceso deberá ser idempotente.

#### 2. Municipios por estado

Al dar clic en un estado del listado, consultar sus municipios utilizando el Servicio Web del Catálogo Único de Claves Geoestadísticas del INEGI.

Endpoint:

[https://gaia.inegi.org.mx/wscatgeo/v2/mgem/{CLAVE_ESTADO}](https://gaia.inegi.org.mx/wscatgeo/v2/mgem/%7BCLAVE_ESTADO%7D)

La clave del estado corresponde al campo `cve_ent` obtenido en la consulta de entidades federativas.

Ejemplo para Aguascalientes, cuya clave es `01`:

[https://gaia.inegi.org.mx/wscatgeo/v2/mgem/01](https://gaia.inegi.org.mx/wscatgeo/v2/mgem/01)

Mostrar todos los municipios correspondientes al estado seleccionado.

## Versiones usadas

Estas son las versiones con las que quedó montado el proyecto:

- PHP `8.2.28`
- Node.js `20.13.1`
- npm `10.5.2`

Si quieren levantarlo igual que aquí, usen esas versiones.

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js 20
- npm
- MySQL 8 o MariaDB compatible

## Cómo levantar el proyecto

1. Clonar el repositorio.
2. Entrar a la carpeta del proyecto.
3. Instalar dependencias de PHP:

```bash
composer install
```

4. Instalar dependencias de frontend:

```bash
npm install
```

5. Crear el archivo de entorno:

```bash
cp .env.example .env
```

6. Configurar la base de datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inegi_estados
DB_USERNAME=root
DB_PASSWORD=
```

7. Generar la clave de Laravel:

```bash
php artisan key:generate
```

8. Crear la base de datos `inegi_estados` en MySQL o MariaDB.
9. Ejecutar migraciones:

```bash
php artisan migrate
```

10. Levantar Vite en local:

```bash
npm run dev
```

11. Levantar Laravel:

```bash
php artisan serve
```

## Cómo compilar Vite

Para generar los archivos finales de frontend:

```bash
npm run build
```

Ese comando genera los archivos compilados en:

- `public/build/manifest.json`
- `public/build/assets/*.css`
- `public/build/assets/*.js`

## Qué subir al servidor Apache

Si tu flujo es subir el build ya generado, entonces antes de subir ejecuta:

```bash
npm run build
```

Luego sube el proyecto incluyendo la carpeta:

- `public/build`

No subas:

- `node_modules`

## Nota para Apache

- El `DocumentRoot` debe apuntar a `public/`
- Laravel leerá los assets compilados desde `public/build`
- El `.gitignore` ya está preparado para permitir versionar `public/build`

## Archivos importantes

- `resources/css/app.css`: estilos principales
- `resources/js/app.js`: JavaScript principal
- `vite.config.js`: configuración de Vite
- `resources/views/welcome.blade.php`: pantalla inicial
