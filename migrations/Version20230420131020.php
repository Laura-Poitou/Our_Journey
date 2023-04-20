<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420131020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_traveler (user_id INT NOT NULL, traveler_id INT NOT NULL, INDEX IDX_88CC1616A76ED395 (user_id), INDEX IDX_88CC161659BBE8A3 (traveler_id), PRIMARY KEY(user_id, traveler_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_travel (user_id INT NOT NULL, travel_id INT NOT NULL, INDEX IDX_485970F3A76ED395 (user_id), INDEX IDX_485970F3ECAB15B3 (travel_id), PRIMARY KEY(user_id, travel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_traveler ADD CONSTRAINT FK_88CC1616A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_traveler ADD CONSTRAINT FK_88CC161659BBE8A3 FOREIGN KEY (traveler_id) REFERENCES traveler (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_traveler DROP FOREIGN KEY FK_88CC1616A76ED395');
        $this->addSql('ALTER TABLE user_traveler DROP FOREIGN KEY FK_88CC161659BBE8A3');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3A76ED395');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3ECAB15B3');
        $this->addSql('DROP TABLE user_traveler');
        $this->addSql('DROP TABLE user_travel');
    }
}
