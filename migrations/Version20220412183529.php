<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added offer tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE offer (id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29D6873EA76ED395 ON offer (user_id)');
        $this->addSql('CREATE TABLE offer_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_354BF9612C2AC5D3 ON offer_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX offer_translation_unique_translation ON offer_translation (translatable_id, locale)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offer_translation ADD CONSTRAINT FK_354BF9612C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES offer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        
        $this->addSql('INSERT INTO offer (id, user_id, created_at, updated_at) VALUES 
            (1, 1, \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (2, 1, \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (3, 1, \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (4, 1, \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (5, 1, \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (6, 1, \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\'),
            (7, 1, \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\');
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

        $this->addSql('CREATE SEQUENCE offer_id_seq');
        $this->addSql('SELECT setval(\'offer_id_seq\', (SELECT MAX(id) FROM offer))');
        $this->addSql('ALTER TABLE offer ALTER id SET DEFAULT nextval(\'offer_id_seq\')');
        $this->addSql('CREATE SEQUENCE offer_translation_id_seq');
        $this->addSql('SELECT setval(\'offer_translation_id_seq\', (SELECT MAX(id) FROM offer_translation))');
        $this->addSql('ALTER TABLE offer_translation ALTER id SET DEFAULT nextval(\'offer_translation_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE offer_translation DROP CONSTRAINT FK_354BF9612C2AC5D3');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873EA76ED395');
        $this->addSql('DROP SEQUENCE offer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offer_translation_id_seq CASCADE');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_translation');
    }
}
