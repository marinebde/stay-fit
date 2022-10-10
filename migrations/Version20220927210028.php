<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927210028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_module MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB98DE13AC');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFBAFC2B591');
        $this->addSql('DROP INDEX `primary` ON partenaire_module');
        $this->addSql('ALTER TABLE partenaire_module DROP id, DROP is_active, CHANGE partenaire_id partenaire_id INT NOT NULL, CHANGE module_id module_id INT NOT NULL');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFBAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_module ADD PRIMARY KEY (partenaire_id, module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB98DE13AC');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFBAFC2B591');
        $this->addSql('ALTER TABLE partenaire_module ADD id INT AUTO_INCREMENT NOT NULL, ADD is_active TINYINT(1) NOT NULL, CHANGE partenaire_id partenaire_id INT DEFAULT NULL, CHANGE module_id module_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFBAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
    }
}
