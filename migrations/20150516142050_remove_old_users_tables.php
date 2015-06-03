<?php

use Phinx\Migration\AbstractMigration;

class RemoveOldUsersTables extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->dropTable('users');
        $this->dropTable('user_feed');
        $this->dropTable('users_groups');
        $this->dropTable('user_groups');
        $this->dropTable('usersOnline');
        $this->dropTable('groups');
        $this->dropTable('group_access');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}