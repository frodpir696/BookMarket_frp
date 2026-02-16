<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migración inicial adaptada al modelo final de BookMarket (6 entidades).
 */
final class Version20260112114525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crea tablas de User, Book, Categoria, Mensaje, Pedido y Carrito con relaciones DAW.';
    }

    public function up(Schema $schema): void
    {
        // Tabla de usuarios.
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(120) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, rol VARCHAR(20) NOT NULL, fecha_registro DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Tabla de categorías.
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, descripcion LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Tabla de mensajes.
        $this->addSql('CREATE TABLE mensaje (id INT AUTO_INCREMENT NOT NULL, contenido LONGTEXT NOT NULL, fecha DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Tabla de carrito (1:1 con usuario).
        $this->addSql('CREATE TABLE carrito (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, fecha_creacion DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', total DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_BA388B8FDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Tabla de pedidos (N:1 con usuario).
        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, fecha DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', total DOUBLE PRECISION NOT NULL, estado VARCHAR(50) NOT NULL, INDEX IDX_6FF2B138DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Tabla de libros (N:1 con categoría y usuario).
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, usuario_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, autor VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, precio DOUBLE PRECISION NOT NULL, estado VARCHAR(50) NOT NULL, fecha_publicacion DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CBE5A3313397707A (categoria_id), INDEX IDX_CBE5A331DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Tabla intermedia N:M carrito-libro.
        $this->addSql('CREATE TABLE carrito_book (carrito_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_EE7A163E1A142F3D (carrito_id), INDEX IDX_EE7A163E16A2B381 (book_id), PRIMARY KEY(carrito_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Claves foráneas.
        $this->addSql('ALTER TABLE carrito ADD CONSTRAINT FK_BA388B8FDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_6FF2B138DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3313397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE carrito_book ADD CONSTRAINT FK_EE7A163E1A142F3D FOREIGN KEY (carrito_id) REFERENCES carrito (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrito_book ADD CONSTRAINT FK_EE7A163E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE carrito_book DROP FOREIGN KEY FK_EE7A163E1A142F3D');
        $this->addSql('ALTER TABLE carrito_book DROP FOREIGN KEY FK_EE7A163E16A2B381');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3313397707A');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331DB38439E');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_6FF2B138DB38439E');
        $this->addSql('ALTER TABLE carrito DROP FOREIGN KEY FK_BA388B8FDB38439E');
        $this->addSql('DROP TABLE carrito_book');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE carrito');
        $this->addSql('DROP TABLE mensaje');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE user');
    }
}
