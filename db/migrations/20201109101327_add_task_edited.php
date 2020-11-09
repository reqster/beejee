<?php


use Phinx\Migration\AbstractMigration;

class AddTaskEdited extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('task');
        $table
            ->addColumn('edited', 'boolean', ['default' => false])
            ->update();
    }
}
