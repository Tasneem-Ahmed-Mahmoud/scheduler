<?php

namespace App\Http\Resources;

use App\Http\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'content'         => $this->content,
            'image_url'       => $this->image_url ? HelperService::getImageUrl($this->image_url) : null,
            'scheduled_time'  => $this->scheduled_time,
            'status'          => $this->status,
            'platforms'       => $this->platforms->map(function ($platform) {
                return [
                    'id'              => $platform->id,
                    'name'            => $platform->name,
                    'platform_status' => $platform->pivot->platform_status,
                ];
            }),
        ];
    }
}
