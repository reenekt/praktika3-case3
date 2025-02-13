<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Task $resource */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description_content' => $this->resource->description_content,
            'status' => $this->resource->status,
            'author_id' => $this->resource->author_id,
            'assignee_id' => $this->resource->assignee_id,
            'deadline_at' => $this->resource->deadline_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'author' => UserResource::make($this->whenLoaded('author')),
            'assignee' => UserResource::make($this->whenLoaded('assignee')),
        ];
    }
}
