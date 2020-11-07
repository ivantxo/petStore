<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Modifying table users, set status active by default
 */
final class Version20201107065051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users MODIFY COLUMN status ENUM(\'active\', \'inactive\') DEFAULT (\'active\')');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users MODIFY COLUMN status ENUM(\'active\', \'inactive\') DEFAULT NULL');
    }
}
