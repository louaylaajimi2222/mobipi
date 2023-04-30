<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412011713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD souscategorie VARCHAR(25) NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE image image LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404E92F8F78');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F624B39D');
        $this->addSql('DROP INDEX IDX_CE606404E92F8F78 ON reclamation');
        $this->addSql('DROP INDEX IDX_CE606404F624B39D ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP sender_id, DROP recipient_id, DROP object, DROP description, DROP created_at, DROP is_read');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP souscategorie');
        $this->addSql('ALTER TABLE categorie CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD sender_id INT NOT NULL, ADD recipient_id INT NOT NULL, ADD object VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD created_at DATETIME NOT NULL, ADD is_read TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404E92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE606404E92F8F78 ON reclamation (recipient_id)');
        $this->addSql('CREATE INDEX IDX_CE606404F624B39D ON reclamation (sender_id)');
    }
}
