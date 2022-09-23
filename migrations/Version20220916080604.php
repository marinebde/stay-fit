<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916080604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499D3ED38D');
        $this->addSql('DROP INDEX IDX_8D93D6499D3ED38D ON user');
        $this->addSql('ALTER TABLE user ADD structures VARCHAR(255) DEFAULT NULL, DROP structures_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD structures_id INT DEFAULT NULL, DROP structures');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499D3ED38D FOREIGN KEY (structures_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499D3ED38D ON user (structures_id)');
    }
}
