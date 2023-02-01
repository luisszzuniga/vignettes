<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201095351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post CHANGE grid_size_id grid_size_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF5CBC1FB FOREIGN KEY (grid_size_id) REFERENCES grid_size (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF5CBC1FB ON post (grid_size_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF5CBC1FB');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF5CBC1FB ON post');
        $this->addSql('ALTER TABLE post CHANGE grid_size_id grid_size_id INT NOT NULL');
    }
}
