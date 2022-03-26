<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819172903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created offer table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE offer (id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) CHECK(locale IN (\'pl\', \'en\')) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29D6873EA76ED395 ON offer (user_id)');
        $this->addSql('COMMENT ON COLUMN offer.locale IS \'(DC2Type:LocaleType)\'');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (1, 1, \'Wykonanie graficznej strony według Twoich preferencji.\', \'pl\', \'2021-08-18 19:50:21\', \'2021-08-18 19:50:21\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (2, 1, \'SEO - Wykonanie wysokiej jakości strony, dzięki czemu strona będzie lepiej wypozycjonowana.\', \'pl\', \'2021-08-18 19:50:40\', \'2021-08-18 19:50:40\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (3, 1, \'Pomoc w zakupie hostingu oraz domeny internetowej.\', \'pl\', \'2021-08-18 19:50:43\', \'2021-08-18 19:50:43\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (4, 1, \'Panel administracyjny do uaktualniania strony.\', \'pl\', \'2021-08-18 19:50:49\', \'2021-08-18 19:50:49\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (5, 1, \'Implementuje google analytics w celu śledzenia "ruchu" na stronie oraz dodaje autorski licznik wejść.\', \'pl\', \'2021-08-18 19:50:57\', \'2021-08-18 19:50:57\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (6, 1, \'Responywność, strona będzie skalowalna na wszystkie urządzenia.\', \'pl\', \'2021-08-18 19:51:10\', \'2021-08-18 19:51:10\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (7, 1, \'Wdrażanie dodatkowych funkcjonalności, których potrzebujesz.\', \'pl\', \'2021-08-18 19:51:14\', \'2021-08-18 19:51:14\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (8, 1, \'Making a graphic page according to your preferences.\', \'en\', \'2021-08-18 20:04:45\', \'2021-08-18 20:04:45\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (9, 1, \'SEO - Implementation of a high quality page, thanks to which the website will be better positioned.\', \'en\', \'2021-08-18 20:04:51\', \'2021-08-18 20:04:51\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (10, 1, \'Help in buying web hosting and domain.\', \'en\', \'2021-08-18 20:04:57\', \'2021-08-18 20:04:57\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (11, 1, \'Administrative panel for updating the page.\', \'en\', \'2021-08-18 20:05:02\', \'2021-08-18 20:05:02\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (12, 1, \'Implementation of google analytics in order to squeeze "traffic" on the website and the author\'\'s input counter.\', \'en\', \'2021-08-18 20:06:17\', \'2021-08-18 20:06:17\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (13, 1, \'Responsiveness, the site will be scalable to all devices.\', \'en\', \'2021-08-18 20:06:40\', \'2021-08-18 20:06:40\');');
        $this->addSql('INSERT INTO offer (id, user_id, title, locale, created_at, updated_at) VALUES (14, 1, \'Implementing additional functionalities that you need.\', \'en\', \'2021-08-18 20:06:46\', \'2021-08-18 20:06:46\');');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE offer_id_seq CASCADE');
        $this->addSql('DROP TABLE offer');
    }
}
