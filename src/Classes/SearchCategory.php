<?php

namespace App\Classes;

use App\Entity\Category;



class SearchCategory
{

    /**
     * @var string
     */
    public $string = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    public function __toString()
    {
        return $this->string;
    }
}
