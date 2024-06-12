<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612134638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feed_back (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, username_id INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, rate INT DEFAULT NULL, INDEX IDX_ED592A6059D8A214 (recipe_id), INDEX IDX_ED592A60ED766068 (username_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feed_back ADD CONSTRAINT FK_ED592A6059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE feed_back ADD CONSTRAINT FK_ED592A60ED766068 FOREIGN KEY (username_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445859D8A214');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458ED766068');
        $this->addSql('DROP TABLE feedback');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, username_id INT NOT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, rate INT DEFAULT NULL, INDEX IDX_D229445859D8A214 (recipe_id), INDEX IDX_D2294458ED766068 (username_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445859D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458ED766068 FOREIGN KEY (username_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE feed_back DROP FOREIGN KEY FK_ED592A6059D8A214');
        $this->addSql('ALTER TABLE feed_back DROP FOREIGN KEY FK_ED592A60ED766068');
        $this->addSql('DROP TABLE feed_back');
    }
}
