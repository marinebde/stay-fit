<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923134458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaire_module (partenaire_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_27599FFB98DE13AC (partenaire_id), INDEX IDX_27599FFBAFC2B591 (module_id), PRIMARY KEY(partenaire_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFBAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB98DE13AC');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFBAFC2B591');
        $this->addSql('DROP TABLE partenaire_module');
    }
}
