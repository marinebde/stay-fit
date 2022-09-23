<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920121457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659460D6DC42');
        $this->addSql('DROP INDEX IDX_2692659460D6DC42 ON partenaires_modules');
        $this->addSql('DROP INDEX `primary` ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules CHANGE modules_id module_id INT NOT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_26926594AFC2B591 FOREIGN KEY (module_id) REFERENCES modules (id)');
        $this->addSql('CREATE INDEX IDX_26926594AFC2B591 ON partenaires_modules (module_id)');
        $this->addSql('ALTER TABLE partenaires_modules ADD PRIMARY KEY (partenaire_id, module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_26926594AFC2B591');
        $this->addSql('DROP INDEX IDX_26926594AFC2B591 ON partenaires_modules');
        $this->addSql('DROP INDEX `PRIMARY` ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules CHANGE module_id modules_id INT NOT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659460D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id)');
        $this->addSql('CREATE INDEX IDX_2692659460D6DC42 ON partenaires_modules (modules_id)');
        $this->addSql('ALTER TABLE partenaires_modules ADD PRIMARY KEY (partenaire_id, modules_id)');
    }
}
