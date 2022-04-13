<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added article tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE article (id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('CREATE TABLE article_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2EEA2F082C2AC5D3 ON article_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX article_translation_unique_translation ON article_translation (translatable_id, locale)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_translation ADD CONSTRAINT FK_2EEA2F082C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('INSERT INTO article (id, user_id, file_fn, created_at, updated_at) VALUES 
            (1, 1, \'www.jpg\', \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (2, 1, \'SEO.jpg\', \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (3, 1, \'CMS.jpg\', \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\');
        ');
        $this->addSql('INSERT INTO article_translation (id, translatable_id, title, description, locale) VALUES 
            (1, 1, \'STRONY INTERNETOWE\', \'Tworze responsywne strony www w oparciu o swój autorski system zarządzania treścią. Zapraszam do oferty.\', \'pl\'),
            (2, 1, \'WEBSITES\', \'I create web applications and microservices.\', \'en\'),
            (3, 2, \'POZYCJONOWANIE\', \'Dbam o SEO, dzięki czemu strona będzie lepiej wypozycjonowana w wyszukiwarce google.\', \'pl\'),
            (4, 2, \'POSITIONING\', \'I care about SEO, thanks to which the website will be better positioned in google search engine.\', \'en\'),
            (5, 3, \'APLIKACJE INTERNETOWE\', \'Tworze aplikacje internetowe oraz mikroserwisy. Oferuje: systemy zarządzania/przetwarzania treścią, autoryzacje, generowanie raportów/plików/wykresów, system powiadomień oraz inne Twoje pomysły/wymagania. Przykładowe realizacje poniżej.\', \'pl\'),
            (6, 3, \'WEB APPLICATIONS\', \'I create web applications and microservices.\', \'en\');'
        );

        $this->addSql('CREATE SEQUENCE article_id_seq');
        $this->addSql('SELECT setval(\'article_id_seq\', (SELECT MAX(id) FROM article))');
        $this->addSql('ALTER TABLE article ALTER id SET DEFAULT nextval(\'article_id_seq\')');
        $this->addSql('CREATE SEQUENCE article_translation_id_seq');
        $this->addSql('SELECT setval(\'article_translation_id_seq\', (SELECT MAX(id) FROM article_translation))');
        $this->addSql('ALTER TABLE article_translation ALTER id SET DEFAULT nextval(\'article_translation_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article_translation DROP CONSTRAINT FK_2EEA2F082C2AC5D3');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E66A76ED395');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE article_translation_id_seq CASCADE');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_translation');
    }
}
