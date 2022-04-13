<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added slider tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE slider (id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE slider_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE slider_translation ADD CONSTRAINT FK_CDA703942C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES slider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CFC71007A76ED395 ON slider (user_id)');
        $this->addSql('CREATE INDEX IDX_CDA703942C2AC5D3 ON slider_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX slider_translation_unique_translation ON slider_translation (translatable_id, locale)');

        $this->addSql('INSERT INTO slider (id, user_id, created_at, updated_at, file_fn) VALUES 
            (1, 1, \'2021-08-19 20:00:00\', \'2021-08-19 20:00:00\', \'slide.jpg\'),
            (2, 1, \'2021-08-19 20:00:00\', \'2021-08-19 20:00:00\', \'slide2.jpg\');
        ');
        $this->addSql('INSERT INTO slider_translation (id, translatable_id, title, locale) VALUES 
            (1, 1, \'Creating web applications.\', \'en\'),
            (2, 1, \'Aplikacjie webowe php, mysql, js.\', \'pl\'),
            (3, 2, \'Making a high quality website.\', \'en\'),
            (4, 2, \'Strony internetowe.\', \'pl\');
        ');

        $this->addSql('CREATE SEQUENCE slider_id_seq');
        $this->addSql('SELECT setval(\'slider_id_seq\', (SELECT MAX(id) FROM slider))');
        $this->addSql('ALTER TABLE slider ALTER id SET DEFAULT nextval(\'slider_id_seq\')');
        $this->addSql('CREATE SEQUENCE slider_translation_id_seq');
        $this->addSql('SELECT setval(\'slider_translation_id_seq\', (SELECT MAX(id) FROM slider_translation))');
        $this->addSql('ALTER TABLE slider_translation ALTER id SET DEFAULT nextval(\'slider_translation_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE slider_translation DROP CONSTRAINT FK_CDA703942C2AC5D3');
        $this->addSql('ALTER TABLE slider DROP CONSTRAINT FK_CFC71007A76ED395');
        $this->addSql('DROP SEQUENCE slider_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE slider_translation_id_seq CASCADE');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE slider_translation');
    }
}
