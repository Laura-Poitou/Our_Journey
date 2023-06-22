<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230622101159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tip_like (id INT AUTO_INCREMENT NOT NULL, tip_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_6F508341476C47F6 (tip_id), INDEX IDX_6F508341A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tip_like ADD CONSTRAINT FK_6F508341476C47F6 FOREIGN KEY (tip_id) REFERENCES tip (id)');
        $this->addSql('ALTER TABLE tip_like ADD CONSTRAINT FK_6F508341A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY article_ibfk_1');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id)');
        $this->addSql('ALTER TABLE travel_destination DROP FOREIGN KEY travel_destination_ibfk_2');
        $this->addSql('ALTER TABLE travel_destination DROP FOREIGN KEY travel_destination_ibfk_3');
        $this->addSql('ALTER TABLE travel_destination ADD CONSTRAINT FK_21450825ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_destination ADD CONSTRAINT FK_21450825816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_traveler DROP FOREIGN KEY travel_traveler_ibfk_1');
        $this->addSql('ALTER TABLE travel_traveler DROP FOREIGN KEY travel_traveler_ibfk_2');
        $this->addSql('ALTER TABLE travel_traveler ADD CONSTRAINT FK_2309153ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_traveler ADD CONSTRAINT FK_230915359BBE8A3 FOREIGN KEY (traveler_id) REFERENCES traveler (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_traveler DROP FOREIGN KEY user_traveler_ibfk_1');
        $this->addSql('ALTER TABLE user_traveler DROP FOREIGN KEY user_traveler_ibfk_2');
        $this->addSql('ALTER TABLE user_traveler ADD CONSTRAINT FK_88CC1616A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_traveler ADD CONSTRAINT FK_88CC161659BBE8A3 FOREIGN KEY (traveler_id) REFERENCES traveler (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY user_travel_ibfk_1');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY user_travel_ibfk_2');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tip_like DROP FOREIGN KEY FK_6F508341476C47F6');
        $this->addSql('ALTER TABLE tip_like DROP FOREIGN KEY FK_6F508341A76ED395');
        $this->addSql('DROP TABLE tip_like');
        $this->addSql('ALTER TABLE travel_destination DROP FOREIGN KEY FK_21450825ECAB15B3');
        $this->addSql('ALTER TABLE travel_destination DROP FOREIGN KEY FK_21450825816C6140');
        $this->addSql('ALTER TABLE travel_destination ADD CONSTRAINT travel_destination_ibfk_2 FOREIGN KEY (destination_id) REFERENCES destination (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_destination ADD CONSTRAINT travel_destination_ibfk_3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_traveler DROP FOREIGN KEY FK_2309153ECAB15B3');
        $this->addSql('ALTER TABLE travel_traveler DROP FOREIGN KEY FK_230915359BBE8A3');
        $this->addSql('ALTER TABLE travel_traveler ADD CONSTRAINT travel_traveler_ibfk_1 FOREIGN KEY (traveler_id) REFERENCES traveler (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_traveler ADD CONSTRAINT travel_traveler_ibfk_2 FOREIGN KEY (travel_id) REFERENCES travel (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3A76ED395');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3ECAB15B3');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT user_travel_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT user_travel_ibfk_2 FOREIGN KEY (travel_id) REFERENCES travel (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_traveler DROP FOREIGN KEY FK_88CC1616A76ED395');
        $this->addSql('ALTER TABLE user_traveler DROP FOREIGN KEY FK_88CC161659BBE8A3');
        $this->addSql('ALTER TABLE user_traveler ADD CONSTRAINT user_traveler_ibfk_1 FOREIGN KEY (traveler_id) REFERENCES traveler (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_traveler ADD CONSTRAINT user_traveler_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66ECAB15B3');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT article_ibfk_1 FOREIGN KEY (travel_id) REFERENCES travel (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
