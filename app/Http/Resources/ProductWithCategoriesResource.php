<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        //iliskisel_relational_data_resource_GET
       /*  return [
            'id' => $this->id,
            'name' => $this->name,
            'categories' => CategoryResource::collection($this->categories)
        ]; */

       //Koşullu_Conditinoal_GET
        return [
            'id' => $this->id,
            'name' => $this->name,
            'categories' => CategoryResource::collection($this->whenLoaded('categories'))   //categoryresource alıyoruz
        ];
    }
}
