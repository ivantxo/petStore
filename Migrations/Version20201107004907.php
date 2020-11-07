<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration for table pets
 */
final class Version20201106210214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE pets (
  id INT UNSIGNED AUTO_INCREMENT NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  name VARCHAR(255) NOT NULL,
  status ENUM ('available', 'pending', 'sold') DEFAULT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE pets');
    }
}
