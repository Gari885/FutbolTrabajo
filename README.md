# ⚽ FutbolPersistence

Aplicación web desarrollada en **PHP** que permite visualizar equipos y sus partidos.  
El proyecto implementa un sistema de persistencia mediante **DAO (Data Access Object)** para acceder a la base de datos, garantizando una estructura limpia y modular.

---

## 🧱 Tecnologías utilizadas

- **PHP 8.x**
- **MySQL** (gestionado con **HeidiSQL**)
- **Bootstrap 4**
- **HTML5 / CSS3**
- **XAMPP** como entorno de ejecución local

---

## 🚀 Ejecución del proyecto

### 1️⃣ Requisitos previos

- Tener instalado **XAMPP** (con Apache y MySQL activos).  
- Tener instalado **HeidiSQL** (u otro cliente MySQL).  
- Clonar o descomprimir el proyecto dentro de la carpeta:
  ```
  C:\xampp\htdocs\
  ```
  de modo que la ruta final sea:
  ```
  C:\xampp\htdocs\FutbolPersistence\
  ```

---

### 2️⃣ Base de datos

1. Iniciar **MySQL** desde el panel de control de XAMPP.  
2. Abrir **HeidiSQL** y conectarse al servidor local.  
3. Crear una **base de datos** con el mismo nombre que espera el proyecto.  
   > ⚠️ Es importante que el nombre de la base de datos y sus tablas coincidan exactamente con los definidos en el código y los scripts SQL incluidos.  
4. Importar el script SQL correspondiente (si existe un archivo `.sql` dentro del proyecto).  
5. Comprobar que existen las tablas necesarias (por ejemplo: `usuarios`, `equipos`, `partidos`).

---

### 3️⃣ Rutas y configuración

El proyecto utiliza rutas relativas basadas en la siguiente estructura:

```
FutbolPersistence/
│
├── app/               → Contiene los archivos PHP principales (login, signup, controladores, etc.)
├── persistence/       → DAO y clases de acceso a la base de datos
├── templates/         → Cabecera, pie y elementos comunes
├── utils/             → Clases auxiliares (gestión de sesión, helpers, etc.)
└── assets/            → Archivos CSS, JS e imágenes
```

Asegúrate de que las rutas internas (por ejemplo, en `header.php` o `login.php`) coincidan con la estructura real de carpetas.

Si se cambia el nombre de la carpeta del proyecto, también debe actualizarse la variable `$urlBase` definida en:
```
templates/header.php
```
para evitar problemas con las redirecciones.

---

### 4️⃣ Ejecución

1. Abrir el navegador y acceder a:
   ```
   http://localhost/FutbolPersistence/app/login.php
   ```
2. Iniciar sesión o registrarse según corresponda.  
3. Visualizar los equipos y partidos desde la página principal.

---

## 🧩 Estructura básica del sistema

- `UserDAO` → Gestiona los usuarios en la base de datos.  
- `SessionHelper` → Maneja las sesiones (inicio, cierre y verificación de sesión activa).  
- `header.php` → Barra de navegación dinámica según el estado del usuario.  
- `login.php` / `signup.php` → Formularios de autenticación.  
- `index.php` → Página principal que muestra la información de los equipos y partidos.

---

## 📄 Notas importantes

- Las **rutas y nombres de las bases de datos deben coincidir exactamente** con los definidos en el código fuente para que la aplicación funcione correctamente.  
- Se recomienda no modificar las rutas internas si no se actualiza también el valor de `$urlBase` en el `header.php`.  
- El proyecto está diseñado para ejecutarse en entorno **local (localhost)** mediante **XAMPP**.  

---

## 🧠 Propósito académico

Este proyecto forma parte de una práctica de programación orientada a la **persistencia de datos en PHP**, aplicando buenas prácticas como el uso del patrón **DAO**, la gestión de sesiones y la separación por capas de lógica y presentación.
