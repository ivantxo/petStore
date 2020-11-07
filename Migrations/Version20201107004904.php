<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration for table photos
 */
final class Version20201106213546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE photos (
  id INT UNSIGNED AUTO_INCREMENT NOT NULL,
  url VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY(id)
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE photos');
    }
}
