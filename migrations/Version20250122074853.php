<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122074853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2BDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('CREATE INDEX IDX_5799AD2BDA04E6A9 ON libro (socio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2BDA04E6A9');
        $this->addSql('DROP INDEX IDX_5799AD2BDA04E6A9 ON libro');
        $this->addSql('ALTER TABLE libro DROP socio_id');
    }
}
