<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //Would return all data 
        // return parent::toArray($request);
        $author = User::find($this->user_id);
        return [
            'id' => $this->id,
            'post' => $this->post,
            'author' => $author->name,
            'author_id' => $author->id,
            'edit' => false,
        ];


    }
}
