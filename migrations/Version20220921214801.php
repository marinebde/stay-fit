<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921214801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module ADD partenaire_modules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628A895F151 FOREIGN KEY (partenaire_modules_id) REFERENCES partenaire_module (id)');
        $this->addSql('CREATE INDEX IDX_C242628A895F151 ON module (partenaire_modules_id)');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB60D6DC42');
        $this->addSql('DROP INDEX IDX_27599FFB60D6DC42 ON partenaire_module');
        $this->addSql('ALTER TABLE partenaire_module DROP modules_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628A895F151');
        $this->addSql('DROP INDEX IDX_C242628A895F151 ON module');
        $this->addSql('ALTER TABLE module DROP partenaire_modules_id');
        $this->addSql('ALTER TABLE partenaire_module ADD modules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB60D6DC42 FOREIGN KEY (modules_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_27599FFB60D6DC42 ON partenaire_module (modules_id)');
    }
}
