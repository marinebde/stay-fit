<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007101541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_modules ADD module_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E6AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_F51533E6AFC2B591 ON structure_modules (module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E6AFC2B591');
        $this->addSql('DROP INDEX IDX_F51533E6AFC2B591 ON structure_modules');
        $this->addSql('ALTER TABLE structure_modules DROP module_id');
    }
}
