<?php


use Phinx\Seed\AbstractSeed;

class TaskSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'username'    => 'Alex',
                'email' => 'alex@alex.uk',
                'description' => 'Feed the server hamster'
            ],
            [
                'username'    => 'Bob',
                'email' => 'bob@bob.ca',
                'description' => 'Run some tests'
            ]
        ];

        $posts = $this->table('task');
        $posts->insert($data)
              ->save();
    }
}
