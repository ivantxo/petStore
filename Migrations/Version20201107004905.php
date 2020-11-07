<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration for table orders
 */
final class Version20201106210242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE orders (
  id INT UNSIGNED AUTO_INCREMENT NOT NULL,
  pet_id INT UNSIGNED NOT NULL,
  quantity INT UNSIGNED NOT NULL,
  ship_date DATETIME NOT NULL,
  status ENUM ('placed', 'approved', 'delivered') DEFAULT NULL,
  complete BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY(id),
  FOREIGN KEY (pet_id) REFERENCES pets(id)
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE orders');
    }
}
