<?php

namespace App\Actions\Tasks;

use App\Models\Task;

class CreateTaskAction
{
    public function execute(array $fields): Task
    {
        return Task::query()->create($fields);
    }
}
