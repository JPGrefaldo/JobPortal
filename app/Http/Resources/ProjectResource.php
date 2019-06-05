<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'location'     => $this->location,
            'project_type' => $this->type->name,
            'owner'        => $this->owner->nickname,
            'production'   => $this->production_name,
            'status'       => $this->status,
        ];
    }
}
