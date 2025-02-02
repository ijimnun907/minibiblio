<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250129182004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, fecha_nacimiento DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autor_libro (autor_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_59ADB71014D45BBE (autor_id), INDEX IDX_59ADB710C0238522 (libro_id), PRIMARY KEY(autor_id, libro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editorial (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, localidad VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro (id INT AUTO_INCREMENT NOT NULL, editorial_id INT DEFAULT NULL, socio_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, anio_publicacion DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', paginas INT NOT NULL, isbn VARCHAR(255) NOT NULL, precio_compra INT DEFAULT NULL, UNIQUE INDEX UNIQ_5799AD2BCC1CF4E6 (isbn), INDEX IDX_5799AD2BBAF1A24D (editorial_id), INDEX IDX_5799AD2BDA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE socio (id INT AUTO_INCREMENT NOT NULL, dni VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, es_docente TINYINT(1) NOT NULL, es_estudiante TINYINT(1) NOT NULL, telefono VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_38B653097F8F253B (dni), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE autor_libro ADD CONSTRAINT FK_59ADB71014D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE autor_libro ADD CONSTRAINT FK_59ADB710C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2BBAF1A24D FOREIGN KEY (editorial_id) REFERENCES editorial (id)');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2BDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE autor_libro DROP FOREIGN KEY FK_59ADB71014D45BBE');
        $this->addSql('ALTER TABLE autor_libro DROP FOREIGN KEY FK_59ADB710C0238522');
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2BBAF1A24D');
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2BDA04E6A9');
        $this->addSql('DROP TABLE autor');
        $this->addSql('DROP TABLE autor_libro');
        $this->addSql('DROP TABLE editorial');
        $this->addSql('DROP TABLE libro');
        $this->addSql('DROP TABLE socio');
    }
}
