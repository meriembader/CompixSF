<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222194355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY fk_ticket_event');
        $this->addSql('DROP INDEX fk_ticket_event ON ticket');
        $this->addSql('ALTER TABLE ticket CHANGE id_evenement id_evenement INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket CHANGE id_evenement id_evenement INT DEFAULT 2 NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT fk_ticket_event FOREIGN KEY (id_evenement) REFERENCES evenement (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_ticket_event ON ticket (id_evenement)');
    }
}
