<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326194902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Updated structure/data for package "knplabs/doctrine-behaviors".';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE article_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offer_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE slider_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2EEA2F082C2AC5D3 ON article_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX article_translation_unique_translation ON article_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE offer_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_354BF9612C2AC5D3 ON offer_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX offer_translation_unique_translation ON offer_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE slider_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CDA703942C2AC5D3 ON slider_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX slider_translation_unique_translation ON slider_translation (translatable_id, locale)');
        $this->addSql('ALTER TABLE article_translation ADD CONSTRAINT FK_2EEA2F082C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offer_translation ADD CONSTRAINT FK_354BF9612C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES offer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE slider_translation ADD CONSTRAINT FK_CDA703942C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES slider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article DROP title');
        $this->addSql('ALTER TABLE article DROP description');
        $this->addSql('ALTER TABLE article DROP locale');
        $this->addSql('ALTER TABLE cron_report ADD error TEXT NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE offer DROP title');
        $this->addSql('ALTER TABLE offer DROP locale');
        $this->addSql('ALTER TABLE slider DROP title');
        $this->addSql('ALTER TABLE slider DROP locale');
        $this->addSql('ALTER TABLE todo_task ALTER file_fn SET NOT NULL');
        $this->addSql('DELETE FROM slider WHERE id in (3,4)');
        $this->addSql('DELETE FROM article WHERE id in (5,6,7)');
        $this->addSql('DELETE FROM offer WHERE id in (8,9,10,11,12,13,14)');
        $this->addSql('INSERT INTO article_translation (id, translatable_id, title, description, locale) VALUES 
            (1, 2, \'STRONY INTERNETOWE\', \'Tworze responsywne strony www w oparciu o swój autorski system zarządzania treścią. Zapraszam do oferty.\', \'pl\'),
            (2, 2, \'WEBSITES\', \'I create web applications and microservices.\', \'en\'),
            (3, 3, \'POZYCJONOWANIE\', \'Dbam o SEO, dzięki czemu strona będzie lepiej wypozycjonowana w wyszukiwarce google.\', \'pl\'),
            (4, 3, \'POSITIONING\', \'I care about SEO, thanks to which the website will be better positioned in google search engine.\', \'en\'),
            (5, 4, \'APLIKACJE INTERNETOWE\', \'Tworze aplikacje internetowe oraz mikroserwisy. Oferuje: systemy zarządzania/przetwarzania treścią, autoryzacje, generowanie raportów/plików/wykresów, system powiadomień oraz inne Twoje pomysły/wymagania. Przykładowe realizacje poniżej.\', \'pl\'),
            (6, 4, \'WEB APPLICATIONS\', \'I create web applications and microservices.\', \'en\');'
        );
        $this->addSql('INSERT INTO slider_translation (id, translatable_id, title, locale) VALUES 
            (2, 1, \'Creating web applications.\', \'en\'),
            (1, 1, \'Aplikacjie webowe php, mysql, js.\', \'pl\'),
            (3, 2, \'Strony internetowe.\', \'pl\'),
            (4, 2, \'Making a high quality website.\', \'en\');
        ');
        $this->addSql('INSERT INTO offer_translation (id, translatable_id, title, locale) VALUES 
            (1, 1, \'Wykonanie graficznej strony według Twoich preferencji.\', \'pl\'),
            (2, 1, \'Making a graphic page according to your preferences.\', \'en\'),
            (3, 2, \'SEO - Wykonanie wysokiej jakości strony, dzięki czemu strona będzie lepiej wypozycjonowana.\', \'pl\'),
            (4, 2, \'SEO - Implementation of a high quality page, thanks to which the website will be better positioned.\', \'en\'),
            (5, 3, \'Pomoc w zakupie hostingu oraz domeny internetowej.\', \'pl\'),
            (6, 3, \'Help in buying web hosting and domain.\', \'en\'),
            (7, 4, \'Panel administracyjny do uaktualniania strony.\', \'pl\'),
            (8, 4, \'Administrative panel for updating the page.\', \'en\'),
            (9, 5, \'Implementuje google analytics w celu śledzenia "ruchu" na stronie oraz dodaje autorski licznik wejść.\', \'pl\'),
            (10, 5, \'Implementation of google analytics in order to squeeze "traffic" on the website and the author\'\'s input counter.\', \'en\'),
            (11, 6, \'Responywność, strona będzie skalowalna na wszystkie urządzenia.\', \'pl\'),
            (12, 6, \'Responsiveness, the site will be scalable to all devices.\', \'en\'),
            (13, 7, \'Wdrażanie dodatkowych funkcjonalności, których potrzebujesz.\', \'pl\'),
            (14, 7, \'Implementing additional functionalities that you need.\', \'en\');'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE article_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offer_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE slider_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP TABLE article_translation');
        $this->addSql('DROP TABLE offer_translation');
        $this->addSql('DROP TABLE slider_translation');
        $this->addSql('ALTER TABLE article ADD title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article ADD description TEXT NOT NULL');
        $this->addSql('ALTER TABLE article ADD locale VARCHAR(255) CHECK(locale IN (\'pl\', \'en\')) NOT NULL');
        $this->addSql('COMMENT ON COLUMN article.locale IS \'(DC2Type:LocaleType)\'');
        $this->addSql('ALTER TABLE offer ADD title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offer ADD locale VARCHAR(255) CHECK(locale IN (\'pl\', \'en\')) NOT NULL');
        $this->addSql('COMMENT ON COLUMN offer.locale IS \'(DC2Type:LocaleType)\'');
        $this->addSql('CREATE SEQUENCE messenger_messages_id_seq');
        $this->addSql('SELECT setval(\'messenger_messages_id_seq\', (SELECT MAX(id) FROM messenger_messages))');
        $this->addSql('ALTER TABLE messenger_messages ALTER id SET DEFAULT nextval(\'messenger_messages_id_seq\')');
        $this->addSql('ALTER TABLE slider ADD title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE slider ADD locale VARCHAR(255) CHECK(locale IN (\'pl\', \'en\')) NOT NULL');
        $this->addSql('COMMENT ON COLUMN slider.locale IS \'(DC2Type:LocaleType)\'');
        $this->addSql('ALTER TABLE cron_report DROP error');
        $this->addSql('ALTER TABLE todo_task ALTER file_fn DROP NOT NULL');
    }
}
