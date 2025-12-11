<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClubResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $authUser = $request->user();
        $isFriend = false;
        
        if ($authUser && $this->user) {
            $isFriend = $authUser->isFriendWith($this->user);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country,
            'founded' => $this->founded,
            'president' => $this->president,
            'stadium' => $this->stadium,
            'capacity' => $this->capacity,
            'trophies' => $this->trophies,
            'description' => $this->description,
            'image_path' => $this->image_path ? asset($this->image_path) : null,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'is_friend' => $isFriend,
            'players_count' => $this->players->count(),
            'comments_count' => $this->comments->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}