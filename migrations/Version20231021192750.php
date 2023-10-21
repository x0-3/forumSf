<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231021192750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_topic (user_id INT NOT NULL, topic_id INT NOT NULL, INDEX IDX_7F822543A76ED395 (user_id), INDEX IDX_7F8225431F55203D (topic_id), PRIMARY KEY(user_id, topic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_topic ADD CONSTRAINT FK_7F822543A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_topic ADD CONSTRAINT FK_7F8225431F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_topic DROP FOREIGN KEY FK_7F822543A76ED395');
        $this->addSql('ALTER TABLE user_topic DROP FOREIGN KEY FK_7F8225431F55203D');
        $this->addSql('DROP TABLE user_topic');
    }
}
