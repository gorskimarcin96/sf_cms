<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240726060624 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE article (id SERIAL NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('CREATE TABLE article_translation (id SERIAL NOT NULL, translatable_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, locale VARCHAR(2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2EEA2F082C2AC5D3 ON article_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2EEA2F082C2AC5D34180C698 ON article_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE realization (id SERIAL NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CDAA30C6A76ED395 ON realization (user_id)');
        $this->addSql('CREATE TABLE realization_translation (id SERIAL NOT NULL, translatable_id INT NOT NULL, description TEXT NOT NULL, locale VARCHAR(2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8AD5BF7A2C2AC5D3 ON realization_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8AD5BF7A2C2AC5D34180C698 ON realization_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE slider (id SERIAL NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CFC71007A76ED395 ON slider (user_id)');
        $this->addSql('CREATE TABLE slider_translation (id SERIAL NOT NULL, translatable_id INT NOT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CDA703942C2AC5D3 ON slider_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CDA703942C2AC5D34180C698 ON slider_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_translation ADD CONSTRAINT FK_2EEA2F082C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realization ADD CONSTRAINT FK_CDAA30C6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realization_translation ADD CONSTRAINT FK_8AD5BF7A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES realization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE slider_translation ADD CONSTRAINT FK_CDA703942C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES slider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE article_translation DROP CONSTRAINT FK_2EEA2F082C2AC5D3');
        $this->addSql('ALTER TABLE realization DROP CONSTRAINT FK_CDAA30C6A76ED395');
        $this->addSql('ALTER TABLE realization_translation DROP CONSTRAINT FK_8AD5BF7A2C2AC5D3');
        $this->addSql('ALTER TABLE slider DROP CONSTRAINT FK_CFC71007A76ED395');
        $this->addSql('ALTER TABLE slider_translation DROP CONSTRAINT FK_CDA703942C2AC5D3');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_translation');
        $this->addSql('DROP TABLE realization');
        $this->addSql('DROP TABLE realization_translation');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE slider_translation');
        $this->addSql('DROP TABLE "user"');
    }
}
