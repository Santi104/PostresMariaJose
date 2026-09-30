# 🍰 Postres María José

Sistema de gestión de inventario y ventas desarrollado con **Laravel**, **Livewire** y **MySQL/MariaDB**.

El sistema permite gestionar diferentes procesos relacionados con el inventario y las ventas de la empresa, facilitando la administración de productos, categorías, ventas, movimientos de inventario y demás información relacionada con la operación del negocio.

---

# 📋 Requisitos

Antes de instalar el proyecto, asegúrate de tener instalados los siguientes programas:

* [PHP](https://www.php.net/)
* [Composer](https://getcomposer.org/)
* [Node.js y npm](https://nodejs.org/)
* [Git](https://git-scm.com/)
* XAMPP u otro servidor local con **MySQL/MariaDB**

> **Importante:** El proyecto utiliza el puerto `3307` para la conexión con MySQL/MariaDB. Si tu instalación utiliza otro puerto, deberás modificarlo en el archivo `.env`.

---

# 🚀 Instalación

## 1. Clonar el repositorio

Clona el repositorio utilizando Git:

```bash
git clone URL_DEL_REPOSITORIO
```

Luego, entra a la carpeta del proyecto:

```bash
cd Postres-Maria-Jose
```

---

## 2. Instalar las dependencias de PHP

Ejecuta el siguiente comando para instalar las dependencias necesarias de Laravel:

```bash
composer install
```

---

## 3. Crear el archivo `.env`

El proyecto utiliza un archivo `.env` para almacenar la configuración del entorno local.

Copia el archivo `.env.example` y crea tu propio archivo `.env`.

### Windows - PowerShell

```powershell
Copy-Item .env.example .env
```

### Windows - CMD

```cmd
copy .env.example .env
```

### Linux / macOS

```bash
cp .env.example .env
```

> **Nota:** El archivo `.env` es específico de cada entorno y no debe compartirse ni subirse al repositorio.

---

## 4. Generar la clave de Laravel

Ejecuta:

```bash
php artisan key:generate
```

Este comando generará automáticamente la `APP_KEY` necesaria para que Laravel pueda funcionar correctamente.

---

# 🗄️ 5. Configurar la base de datos

El proyecto utiliza una base de datos llamada:

```text
postres_mj
```

La configuración esperada en el archivo `.env` es:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=postres_mj
DB_USERNAME=root
DB_PASSWORD=
```

En caso de que tu base de datos tenga otro nombre:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE="Pon aqui el nombre de tu BDD"
DB_USERNAME=root
DB_PASSWORD=
```


Si tu instalación de MySQL/MariaDB utiliza un usuario, contraseña o puerto diferente, modifica estos valores de acuerdo con tu configuración local.

---

# 6. Crear la base de datos

Antes de ejecutar las migraciones, es necesario crear la base de datos `postres_mj`.

Puedes hacerlo utilizando **phpMyAdmin**.

### Con XAMPP

1. Abre el **XAMPP Control Panel**.
2. Inicia **Apache** y **MySQL**.
3. Abre phpMyAdmin desde:

```text
http://localhost/phpmyadmin
```

4. Selecciona **Nueva**.
5. Crea una base de datos llamada:

```text
postres_mj
```

6. Utiliza la siguiente codificación/cotejamiento:

```text
utf8mb4_unicode_ci
```

> **Importante:** No es necesario crear las tablas manualmente. Laravel se encargará de crearlas mediante las migraciones.

---

# 🏗️ 7. Ejecutar las migraciones

Una vez creada la base de datos, ejecuta:

```bash
php artisan migrate
```

Las migraciones crearán automáticamente la estructura necesaria para el funcionamiento del sistema.

Entre las tablas creadas se encuentran las relacionadas con:

* Usuarios
* Categorías
* Productos
* Métodos de pago
* Turnos de caja
* Ventas
* Detalles de ventas
* Pagos de ventas
* Movimientos de inventario
* Arqueos
* Caché y trabajos de Laravel

> **Importante:** No es necesario importar manualmente un archivo `.sql` cuando las migraciones del proyecto están actualizadas.

---

# 🌱 8. Cargar datos iniciales

Ya que el proyecto cuenta con **seeders**, puedes ejecutarlos mediante:

```bash
php artisan db:seed
```

---

# 📦 9. Instalar las dependencias de JavaScript

Ejecuta:

```bash
npm install
```

Esto instalará las dependencias necesarias para los recursos frontend del proyecto.

---

# ▶️ 10. Ejecutar el proyecto

Para iniciar el servidor de Laravel, ejecuta:

```bash
php artisan serve
```

El proyecto estará disponible normalmente en:

```text
http://127.0.0.1:8000
```

En otra terminal, ejecuta:

```bash
npm run dev
```

Mantén este proceso activo mientras utilices el proyecto.

---

# 📁 Estructura básica del proyecto

```text
Postres-Maria-Jose/
│
├── app/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
├── routes/
├── storage/
├── .env
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

---

# 🔄 Actualizar el proyecto

Si ya tienes el proyecto instalado y quieres obtener la versión más reciente del repositorio, ejecuta:

```bash
git pull
```

Si se han agregado o actualizado dependencias de PHP:

```bash
composer install
```

Si se han agregado o actualizado dependencias de JavaScript:

```bash
npm install
```

Si se han agregado nuevas migraciones:

```bash
php artisan migrate
```

---

# ⚠️ Problemas comunes

## Error de conexión con la base de datos

Si aparece un error relacionado con la conexión a MySQL/MariaDB, verifica que los valores del archivo `.env` sean correctos:

```env
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=postres_mj
DB_USERNAME=root
DB_PASSWORD=
```

También verifica que MySQL/MariaDB se encuentre iniciado.

---

## La base de datos no existe

Si Laravel muestra un error indicando que la base de datos `postres_mj` no existe:

1. Abre phpMyAdmin.
2. Crea una base de datos llamada:

```text
postres_mj
```

3. Verifica la configuración del archivo `.env`.
4. Ejecuta nuevamente:

```bash
php artisan migrate
```

---

## Las migraciones generan errores

Si estás realizando una instalación desde cero o trabajando en un entorno de desarrollo y necesitas reconstruir completamente la base de datos, puedes utilizar:

```bash
php artisan migrate:fresh
```

Para reconstruir las tablas y ejecutar los seeders:

```bash
php artisan migrate:fresh --seed
```

> ⚠️ **Advertencia:** `migrate:fresh` elimina todas las tablas existentes de la base de datos. No utilices este comando si necesitas conservar información almacenada en ella.

---

# 🔐 Configuración del entorno

El archivo `.env` contiene información específica del entorno local, como las credenciales de la base de datos y la clave de aplicación.

Por seguridad:

* No compartas tu archivo `.env`.
* No subas el archivo `.env` al repositorio.
* Utiliza `.env.example` como referencia para configurar el entorno.
* Genera una nueva `APP_KEY` utilizando:

```bash
php artisan key:generate
```

---

# ⚡ Instalación rápida

Si ya tienes PHP, Composer, Node.js, npm, Git y MySQL/MariaDB instalados, puedes seguir estos pasos:

```bash
git clone URL_DEL_REPOSITORIO

cd Postres-Maria-Jose

composer install

Copy-Item .env.example .env

php artisan key:generate

npm install
```

Después:

1. Inicia MySQL/MariaDB.
2. Crea la base de datos `postres_mj`.
3. Configura el archivo `.env`.
4. Ejecuta las migraciones:

```bash
php artisan migrate
```

5. Si existen datos iniciales, ejecuta:

```bash
php artisan db:seed
```

6. Inicia Laravel:

```bash
php artisan serve
```

7. En otra terminal, inicia los recursos frontend:

```bash
npm run dev
```

Finalmente, abre:

```text
http://127.0.0.1:8000
```

---

# ✅ Proyecto listo

Una vez completados los pasos anteriores, **Postres María José** estará instalado y listo para ejecutarse en tu entorno local.
