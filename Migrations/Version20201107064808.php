<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Modifying all created_at columns default to current timestamp
 */
final class Version20201107064808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE categories MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE pets MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE photos MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE tags MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE categories MODIFY COLUMN created_at DATETIME');
        $this->addSql('ALTER TABLE pets MODIFY COLUMN created_at DATETIME');
        $this->addSql('ALTER TABLE photos MODIFY COLUMN created_at DATETIME');
        $this->addSql('ALTER TABLE tags MODIFY COLUMN created_at DATETIME');
    }
}
