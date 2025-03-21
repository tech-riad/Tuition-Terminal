<?php

namespace App\Transformers;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //  return parent::toArray($request);
        return
        [
            'id' => $this->id ?? '',
            'title'=>$this->subject->title ?? '',
        ];
    }
}
