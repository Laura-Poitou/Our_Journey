<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420131157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tip ADD user_id INT DEFAULT NULL, ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tip ADD CONSTRAINT FK_4883B84CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tip ADD CONSTRAINT FK_4883B84C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_4883B84CA76ED395 ON tip (user_id)');
        $this->addSql('CREATE INDEX IDX_4883B84C7294869C ON tip (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tip DROP FOREIGN KEY FK_4883B84CA76ED395');
        $this->addSql('ALTER TABLE tip DROP FOREIGN KEY FK_4883B84C7294869C');
        $this->addSql('DROP INDEX IDX_4883B84CA76ED395 ON tip');
        $this->addSql('DROP INDEX IDX_4883B84C7294869C ON tip');
        $this->addSql('ALTER TABLE tip DROP user_id, DROP article_id');
    }
}
