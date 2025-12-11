<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $authUser = $request->user();
        $isFriend = false;
        
        if ($authUser && $this->club && $this->club->user) {
            $isFriend = $authUser->isFriendWith($this->club->user);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'number' => $this->number,
            'nationality' => $this->nationality,
            'age' => $this->age,
            'club' => [
                'id' => $this->club->id,
                'name' => $this->club->name,
                'country' => $this->club->country,
                'user' => [
                    'id' => $this->club->user->id,
                    'name' => $this->club->user->name,
                ],
            ],
            'is_friend' => $isFriend,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}