<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211116202509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, url_to_image LONGTEXT NOT NULL, published_at DATETIME NOT NULL, external_link LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_authors (articles_id INT NOT NULL, authors_id INT NOT NULL, INDEX IDX_CB694EF01EBAF6CC (articles_id), INDEX IDX_CB694EF06DE2013A (authors_id), PRIMARY KEY(articles_id, authors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_category (articles_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A7D8EFDB1EBAF6CC (articles_id), INDEX IDX_A7D8EFDB12469DE2 (category_id), PRIMARY KEY(articles_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, articles_id INT NOT NULL, users_id VARCHAR(36) NOT NULL, content VARCHAR(255) NOT NULL, posted_at DATETIME NOT NULL, INDEX IDX_5F9E962A1EBAF6CC (articles_id), INDEX IDX_5F9E962A67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id VARCHAR(36) NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, created_at DATETIME NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles_authors ADD CONSTRAINT FK_CB694EF01EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_authors ADD CONSTRAINT FK_CB694EF06DE2013A FOREIGN KEY (authors_id) REFERENCES authors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_category ADD CONSTRAINT FK_A7D8EFDB1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_category ADD CONSTRAINT FK_A7D8EFDB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles_authors DROP FOREIGN KEY FK_CB694EF01EBAF6CC');
        $this->addSql('ALTER TABLE articles_category DROP FOREIGN KEY FK_A7D8EFDB1EBAF6CC');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A1EBAF6CC');
        $this->addSql('ALTER TABLE articles_authors DROP FOREIGN KEY FK_CB694EF06DE2013A');
        $this->addSql('ALTER TABLE articles_category DROP FOREIGN KEY FK_A7D8EFDB12469DE2');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A67B3B43D');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE articles_authors');
        $this->addSql('DROP TABLE articles_category');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE users');
    }
}
