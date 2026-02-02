# BookMarket

Proyecto final del módulo de PHP / Symfony.

BookMarket es una aplicación web desarrollada con Symfony para la gestión de libros usados, incluyendo categorías, pedidos y usuarios.  
Actualmente, el proyecto cuenta con las **entidades principales** y sus **controladores CRUD básicos**.

---

## Historial de versiones

### v0.1 – 12/01/2026
- Creación del proyecto base en Symfony
- Configuración inicial del framework
- Inicialización del repositorio Git local
- Enlace del proyecto con GitHub (`bookmarket_frp`)
- Creación del archivo README.md con datos del autor y curso

### v0.2 – 02/02/2026
- Creación de las entidades:
    - `Book` (libros)
    - `Categoria` (categorías de libros)
    - `User` (usuarios)
    - `Pedido` (pedidos)
    - `Mensaje` (mensajes)
    - `Valoracion` (valoraciones de libros)
- Implementación de **controladores CRUD** para:
    - `Book`
    - `Categoria`
    - `User`
    - `Pedido`
- Configuración de relaciones entre `Book` y `Categoria`
- Formularios básicos generados (`BookType`, `CategoriaType`, `UserType`, `PedidoType`)
- Configuración inicial de rutas para las entidades

*(Próximamente se implementarán la autenticación de usuarios, gestión de valoraciones y mensajes, y mejora de formularios y vistas.)*

---

## Tecnologías previstas

- PHP 8.1
- Symfony 6
- Doctrine ORM
- Twig
- MySQL
- Git y GitHub

---

## Autor

**Francisco Rodríguez Pires**  
Curso DAW

