<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
            'uuid' => $this->uuid,
            'creation_date' => $this->created_at->format('d-m-Y H:i:s'),
            'comments' => $this->when(
                $this->comments->isNotEmpty(),
                $this->comments->map(fn($comment) => $comment->only(['content', 'owner']))
            ),
        ];
    }
}
