<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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

        return [
            'id' => $this->id,
            'post' => $this->post
        ];


    }
}
