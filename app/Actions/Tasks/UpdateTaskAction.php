<?php

namespace App\Actions\Tasks;

use App\Models\Task;

class UpdateTaskAction
{
    public function execute(Task $task, array $fields): Task
    {
        $task->update($fields);

        return $task;
    }
}
