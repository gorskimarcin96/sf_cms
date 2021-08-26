<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210818191241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create article table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, locale VARCHAR(255) CHECK(locale IN (\'pl\', \'en\')) NOT NULL, file_fn VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('COMMENT ON COLUMN article.locale IS \'(DC2Type:LocaleType)\'');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('INSERT INTO public.article (id, user_id, title, description, locale, file_fn, created_at, updated_at) VALUES (2, 1, \'STRONY INTERNETOWE\', \'<div>Tworze responsywne strony www w oparciu o swój autorski system zarządzania treścią. Zapraszam do oferty.</div>\', \'pl\', \'www.jpg\', \'2021-08-18 19:31:52\', \'2021-08-18 19:31:52\');');
        $this->addSql('INSERT INTO public.article (id, user_id, title, description, locale, file_fn, created_at, updated_at) VALUES (3, 1, \'POZYCJONOWANIE\', \'<div>Dbam o SEO, dzięki czemu strona będzie lepiej wypozycjonowana w wyszukiwarce google.</div>\', \'pl\', \'SEO.jpg\', \'2021-08-18 19:43:51\', \'2021-08-18 19:43:51\');');
        $this->addSql('INSERT INTO public.article (id, user_id, title, description, locale, file_fn, created_at, updated_at) VALUES (4, 1, \'APLIKACJE INTERNETOWE\', \'<div>Tworze aplikacje internetowe oraz mikroserwisy. Oferuje: systemy zarządzania/przetwarzania treścią, autoryzacje, generowanie raportów/plików/wykresów, system powiadomień oraz inne Twoje pomysły/wymagania. Przykładowe realizacje poniżej.<br><br></div><div><br></div>\', \'pl\', \'CMS.jpg\', \'2021-08-18 19:44:26\', \'2021-08-18 19:44:26\');');
        $this->addSql('INSERT INTO public.article (id, user_id, title, description, locale, file_fn, created_at, updated_at) VALUES (5, 1, \'WEBSITES\', \'<div>I create web applications and microservices.</div>\', \'en\', \'www.jpg\', \'2021-08-18 19:45:30\', \'2021-08-18 19:45:30\');');
        $this->addSql('INSERT INTO public.article (id, user_id, title, description, locale, file_fn, created_at, updated_at) VALUES (6, 1, \'POSITIONING\', \'<div>I care about SEO, thanks to which the website will be better positioned in google search engine.</div>\', \'en\', \'SEO.jpg\', \'2021-08-18 19:45:48\', \'2021-08-18 19:45:48\');');
        $this->addSql('INSERT INTO public.article (id, user_id, title, description, locale, file_fn, created_at, updated_at) VALUES (7, 1, \'WEB APPLICATIONS\', \'<div>I create web applications and microservices.</div>\', \'en\', \'CMS.jpg\', \'2021-08-18 19:46:02\', \'2021-08-18 19:46:02\');');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP TABLE article');
    }
}
