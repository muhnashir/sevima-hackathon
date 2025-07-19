<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository
{
    protected $image;

    public function __construct(){
        $this->image = new Image();
    }

    public function create(array $data){
        return $this->image->create($data);
    }

    public function finByName(string $name){
        return $this->where('name', $name)->first();
    }

}
