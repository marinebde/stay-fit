<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007100802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module ADD structure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426282534008B FOREIGN KEY (structure_id) REFERENCES structure_modules (id)');
        $this->addSql('CREATE INDEX IDX_C2426282534008B ON module (structure_id)');
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E6AA95C5C1');
        $this->addSql('DROP INDEX IDX_F51533E6AA95C5C1 ON structure_modules');
        $this->addSql('ALTER TABLE structure_modules CHANGE structure_id_id structure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E62534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_F51533E62534008B ON structure_modules (structure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426282534008B');
        $this->addSql('DROP INDEX IDX_C2426282534008B ON module');
        $this->addSql('ALTER TABLE module DROP structure_id');
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E62534008B');
        $this->addSql('DROP INDEX IDX_F51533E62534008B ON structure_modules');
        $this->addSql('ALTER TABLE structure_modules CHANGE structure_id structure_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E6AA95C5C1 FOREIGN KEY (structure_id_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_F51533E6AA95C5C1 ON structure_modules (structure_id_id)');
    }
}
