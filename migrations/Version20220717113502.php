<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717113502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added dropbox constants.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB6AD5D82B36786B ON constant (title)');
        $this->addSql(
            'INSERT INTO constant (id, title, description) VALUES 
                (DEFAULT, \'DROPBOX_AUTHORIZATION_CODE\', \'\'), 
                (DEFAULT, \'DROPBOX_ACCESS_TOKEN\', \'\'),
                (DEFAULT, \'DROPBOX_REFRESH_TOKEN\', \'\');'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX title_position_type ON position (title, position_type)');
        $this->addSql('DELETE FROM constant where title in (\'DROPBOX_AUTHORIZATION_CODE\',\'DROPBOX_ACCESS_TOKEN\',\'DROPBOX_REFRESH_TOKEN\');');
    }
}
