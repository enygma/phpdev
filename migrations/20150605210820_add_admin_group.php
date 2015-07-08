<?php

use Phinx\Migration\AbstractMigration;

class AddAdminGroup extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query('insert into groups (name, description, created, updated)'
            .' values ("admin", "Administrators", now(), now())');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query('delete from groups where name ="admin"');
    }
}