<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FangDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' =>$this->fang_name,
            'xiaoqu' =>$this->fang_xiaoqu,
            'area' =>$this->fang_build_area,
            'room' => $this->fang_shi.'室'.$this->fang_ting.'厅'.$this->fang_wei.'卫',
            'img' => $this->fang_pic[0],
            'rent' => $this->fang_rent,
            'dir' =>new FangAttrResource($this->dir),
            'fangowner' => $this->fangOwner,
            'year' => new FangAttrResource($this->year),
            'config' =>new FangAttrResource($this->config),
            'latitude' =>$this->latitude,
            'longitude' => $this->longitude

        ];
    }
}
