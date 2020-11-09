<?php


use Phinx\Migration\AbstractMigration;

class AddTaskState extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('task');
        $table
            ->addColumn('state', 'boolean', ['default' => false])
            ->update();
    }
}
