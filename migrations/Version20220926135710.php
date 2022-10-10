<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926135710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB98DE13AC');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFBAFC2B591');
        $this->addSql('DROP INDEX IDX_27599FFBAFC2B591 ON partenaire_module');
        $this->addSql('DROP INDEX IDX_27599FFB98DE13AC ON partenaire_module');
        $this->addSql('ALTER TABLE partenaire_module ADD id INT AUTO_INCREMENT NOT NULL, ADD partenaire_id_id INT DEFAULT NULL, ADD module_id_id INT DEFAULT NULL, ADD is_active TINYINT(1) NOT NULL, DROP partenaire_id, DROP module_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFBB6A7DFED FOREIGN KEY (partenaire_id_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB7648EE39 FOREIGN KEY (module_id_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_27599FFBB6A7DFED ON partenaire_module (partenaire_id_id)');
        $this->addSql('CREATE INDEX IDX_27599FFB7648EE39 ON partenaire_module (module_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_module MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFBB6A7DFED');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB7648EE39');
        $this->addSql('DROP INDEX IDX_27599FFBB6A7DFED ON partenaire_module');
        $this->addSql('DROP INDEX IDX_27599FFB7648EE39 ON partenaire_module');
        $this->addSql('DROP INDEX `PRIMARY` ON partenaire_module');
        $this->addSql('ALTER TABLE partenaire_module ADD partenaire_id INT NOT NULL, ADD module_id INT NOT NULL, DROP id, DROP partenaire_id_id, DROP module_id_id, DROP is_active');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFBAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_27599FFBAFC2B591 ON partenaire_module (module_id)');
        $this->addSql('CREATE INDEX IDX_27599FFB98DE13AC ON partenaire_module (partenaire_id)');
        $this->addSql('ALTER TABLE partenaire_module ADD PRIMARY KEY (partenaire_id, module_id)');
    }
}
