<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public static $wrap = null;
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'subject'      => $this->subject,
            'description'  => $this->description,
            'status'       => $this->status,
            'type'         => $this->type,
            'start_date'   => $this->start_date,
            'due_date'     => $this->due_date,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
