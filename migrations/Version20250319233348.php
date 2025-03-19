<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319233348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE games (id SERIAL NOT NULL, code VARCHAR(100) NOT NULL, host_name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF232B3177153098 ON games (code)');
        $this->addSql('CREATE TABLE messages (id SERIAL NOT NULL, game_id INT NOT NULL, sender_id INT NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, chat_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB021E96E48FD905 ON messages (game_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96F624B39D ON messages (sender_id)');
        $this->addSql('CREATE TABLE players (id SERIAL NOT NULL, game_id INT NOT NULL, name VARCHAR(100) NOT NULL, is_alive BOOLEAN NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_264E43A6E48FD905 ON players (game_id)');
        $this->addSql('CREATE TABLE votes (id SERIAL NOT NULL, game_id INT NOT NULL, voter_id INT NOT NULL, target_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_final BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_518B7ACFE48FD905 ON votes (game_id)');
        $this->addSql('CREATE INDEX IDX_518B7ACFEBB4B8AD ON votes (voter_id)');
        $this->addSql('CREATE INDEX IDX_518B7ACF158E0B66 ON votes (target_id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96E48FD905 FOREIGN KEY (game_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A6E48FD905 FOREIGN KEY (game_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACFE48FD905 FOREIGN KEY (game_id) REFERENCES games (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACFEBB4B8AD FOREIGN KEY (voter_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF158E0B66 FOREIGN KEY (target_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96E48FD905');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE players DROP CONSTRAINT FK_264E43A6E48FD905');
        $this->addSql('ALTER TABLE votes DROP CONSTRAINT FK_518B7ACFE48FD905');
        $this->addSql('ALTER TABLE votes DROP CONSTRAINT FK_518B7ACFEBB4B8AD');
        $this->addSql('ALTER TABLE votes DROP CONSTRAINT FK_518B7ACF158E0B66');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE votes');
    }
}
