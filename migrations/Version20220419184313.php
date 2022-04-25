<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419184313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create daily image table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE daily_image (id INT NOT NULL, name VARCHAR(255) NOT NULL, image TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');

        $this->addSql(file_get_contents(__dir__ . '/daily_images.sql'));

        $this->addSql('CREATE SEQUENCE daily_image_id_seq');
        $this->addSql('SELECT setval(\'daily_image_id_seq\', null)');
        $this->addSql('ALTER TABLE daily_image ALTER id SET DEFAULT nextval(\'daily_image_id_seq\')');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE daily_image_id_seq CASCADE');
        $this->addSql('DROP TABLE daily_image');
    }
}
