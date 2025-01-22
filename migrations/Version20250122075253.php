<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122075253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro ADD isbn VARCHAR(255) NOT NULL, ADD precio_compra INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5799AD2BCC1CF4E6 ON libro (isbn)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_5799AD2BCC1CF4E6 ON libro');
        $this->addSql('ALTER TABLE libro DROP isbn, DROP precio_compra');
    }
}
