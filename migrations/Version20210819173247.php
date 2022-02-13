<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819173247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create slider table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE slider_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE slider (id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) CHECK(locale IN (\'pl\', \'en\')) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CFC71007A76ED395 ON slider (user_id)');
        $this->addSql('COMMENT ON COLUMN slider.locale IS \'(DC2Type:LocaleType)\'');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('INSERT INTO slider (id, user_id, title, locale, created_at, updated_at, file_fn) VALUES (1, 1, \'Aplikacjie webowe php, mysql, js.\', \'pl\', \'2021-08-19 17:44:02\', \'2021-08-19 17:44:02\', \'slide.jpg\');');
        $this->addSql('INSERT INTO slider (id, user_id, title, locale, created_at, updated_at, file_fn) VALUES (2, 1, \'Strony internetowe.\', \'pl\', \'2021-08-19 17:44:15\', \'2021-08-19 17:44:15\', \'slide2.jpg\');');
        $this->addSql('INSERT INTO slider (id, user_id, title, locale, created_at, updated_at, file_fn) VALUES (3, 1, \'Creating web applications.\', \'en\', \'2021-08-19 17:44:47\', \'2021-08-19 17:57:09\', \'slide2.jpg\');');
        $this->addSql('INSERT INTO slider (id, user_id, title, locale, created_at, updated_at, file_fn) VALUES (4, 1, \'Making a high quality website.\', \'en\', \'2021-08-19 17:45:09\', \'2021-08-19 17:57:15\', \'slide.jpg\');');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE slider_id_seq CASCADE');
        $this->addSql('DROP TABLE slider');
    }
}
