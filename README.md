## Descripción del dominio del problema
BookMarket es una aplicación web de compraventa de libros de segunda mano. Permite que los usuarios se registren, publiquen libros, exploren el catálogo por categorías y gestionen un carrito de compra básico para simular el proceso de compra.

## Requisitos previos
Antes de arrancar, asegúrate de tener instalado:

- PHP 8.2+
- Composer
- MariaDB o MySQL
- (Opcional) Symfony CLI

## Montaje de la aplicación (paso a paso)

### 1) Clonar proyecto y entrar en la carpeta
```bash
git clone <URL_DEL_REPO>
cd BookMarket_frp2
```

### 2) Instalar dependencias PHP
```bash
composer install
```

### 3) Configurar la conexión a base de datos
Edita el archivo `.env` y ajusta `DATABASE_URL` con tus credenciales locales:

```env
DATABASE_URL="mysql://USUARIO:PASSWORD@127.0.0.1:3306/bookmarket?serverVersion=8.0&charset=utf8mb4"
```

Ejemplo en local:

```env
DATABASE_URL="mysql://root:root@127.0.0.1:3306/bookmarket?serverVersion=8.0&charset=utf8mb4"
```

### 4) Crear la base de datos
```bash
php bin/console doctrine:database:create
```

### 5) Crear tablas con migraciones
```bash
php bin/console doctrine:migrations:migrate
```

> Si te pregunta confirmación, responde `yes`.

---

## Importar datos de ejemplo desde SQL (paso a paso)

El proyecto incluye un dataset de prueba amplio en:

- `database/bookmarket_mariadb_datos.sql`

### Opción A (recomendada): importar con CLI de MySQL/MariaDB
Desde la raíz del proyecto:

```bash
mysql -u root -p bookmarket < database/bookmarket_mariadb_datos.sql
```

Si usas otro usuario/base de datos:

```bash
mysql -u TU_USUARIO -p TU_BASE_DE_DATOS < database/bookmarket_mariadb_datos.sql
```

### Opción B: importar con cliente gráfico
1. Abre phpMyAdmin / DBeaver / HeidiSQL.
2. Selecciona la base de datos `bookmarket`.
3. Usa la opción **Importar**.
4. Carga el archivo `database/bookmarket_mariadb_datos.sql`.
5. Ejecuta la importación.

### Verificación rápida de importación
Puedes comprobar que hay datos ejecutando:

```bash
mysql -u root -p -e "USE bookmarket; SELECT COUNT(*) AS total_libros FROM book; SELECT COUNT(*) AS total_categorias FROM categoria;"
```

---

## Arrancar la aplicación

### Con Symfony CLI
```bash
symfony serve
```

### Sin Symfony CLI
```bash
php -S 127.0.0.1:8000 -t public
```

Abrir en navegador:

- http://127.0.0.1:8000

- 
## Credenciales de prueba
En el SQL de ejemplo, todos los usuarios insertados tienen contraseña:

- `123456`

Ejemplos de login:

- Admin: `admin@bookmarket.com` / `123456`
- Usuario: `laura@bookmarket.com` / `123456`

- 
## Problemas frecuentes
- **Error de conexión a DB**: revisa `DATABASE_URL` en `.env`.
- **Tablas no existentes**: ejecuta migraciones antes de importar datos.
- **No puedes iniciar sesión**: verifica que importaste el SQL correcto y que estás usando la contraseña `123456`.
