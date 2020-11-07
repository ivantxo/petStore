<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration for table pets_photos
 */
final class Version20201106213548 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE pets_photos (
  pet_id INT UNSIGNED NOT NULL,
  photo_id INT UNSIGNED NOT NULL,
  PRIMARY KEY(pet_id, photo_id),
  FOREIGN KEY (pet_id) REFERENCES pets(id),
  FOREIGN KEY (photo_id) REFERENCES photos(id)
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE pets_photos');
    }
}
