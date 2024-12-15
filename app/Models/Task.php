<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $description_content
 * @property TaskStatusEnum $status
 * @property int $author_id
 * @property int|null $assignee_id
 * @property Carbon|null $deadline_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $author
 * @property-read User|null $assignee
 */
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description_content',
        'status',
        'author_id',
        'assignee_id',
        'deadline_at',
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'deadline_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
