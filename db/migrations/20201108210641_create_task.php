<?php


use Phinx\Migration\AbstractMigration;

class CreateTask extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('task');
        $table
            ->addColumn('username', 'text')
            ->addColumn('email', 'text')
            ->addColumn('description', 'text')
            ->create();
    }
}
