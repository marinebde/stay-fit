<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007095128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_module DROP FOREIGN KEY FK_159DC1022534008B');
        $this->addSql('ALTER TABLE structure_module DROP FOREIGN KEY FK_159DC102AFC2B591');
        $this->addSql('DROP TABLE structure_module');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE structure_module (structure_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_159DC102AFC2B591 (module_id), INDEX IDX_159DC1022534008B (structure_id), PRIMARY KEY(structure_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE structure_module ADD CONSTRAINT FK_159DC1022534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structure_module ADD CONSTRAINT FK_159DC102AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
    }
}
