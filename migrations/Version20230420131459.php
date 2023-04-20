<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420131459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE travel_destination (travel_id INT NOT NULL, destination_id INT NOT NULL, INDEX IDX_21450825ECAB15B3 (travel_id), INDEX IDX_21450825816C6140 (destination_id), PRIMARY KEY(travel_id, destination_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travel_traveler (travel_id INT NOT NULL, traveler_id INT NOT NULL, INDEX IDX_2309153ECAB15B3 (travel_id), INDEX IDX_230915359BBE8A3 (traveler_id), PRIMARY KEY(travel_id, traveler_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE travel_destination ADD CONSTRAINT FK_21450825ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_destination ADD CONSTRAINT FK_21450825816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_traveler ADD CONSTRAINT FK_2309153ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_traveler ADD CONSTRAINT FK_230915359BBE8A3 FOREIGN KEY (traveler_id) REFERENCES traveler (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE travel_destination DROP FOREIGN KEY FK_21450825ECAB15B3');
        $this->addSql('ALTER TABLE travel_destination DROP FOREIGN KEY FK_21450825816C6140');
        $this->addSql('ALTER TABLE travel_traveler DROP FOREIGN KEY FK_2309153ECAB15B3');
        $this->addSql('ALTER TABLE travel_traveler DROP FOREIGN KEY FK_230915359BBE8A3');
        $this->addSql('DROP TABLE travel_destination');
        $this->addSql('DROP TABLE travel_traveler');
    }
}
