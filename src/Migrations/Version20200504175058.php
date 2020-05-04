<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504175058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, target_id INT DEFAULT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_9474526CA76ED395 (user_id), UNIQUE INDEX UNIQ_9474526C158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_post (comment_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_7CBCCE61F8697D13 (comment_id), INDEX IDX_7CBCCE614B89032C (post_id), PRIMARY KEY(comment_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C158E0B66 FOREIGN KEY (target_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_post ADD CONSTRAINT FK_7CBCCE61F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment_post ADD CONSTRAINT FK_7CBCCE614B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment_post DROP FOREIGN KEY FK_7CBCCE61F8697D13');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comment_post');
    }
}
