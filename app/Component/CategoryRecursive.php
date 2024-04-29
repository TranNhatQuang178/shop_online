<?php

namespace App\Component;

use App\Models\Category;

class CategoryRecursive
{
    private $html = '';
    function __construct()
    {
        $this->html = '';
    }
    public function categoryRecursive($parent_id, $parentId = 0, $subMark = '')
    {
        $categories = Category::where('parent_id', $parentId)->get();
        foreach ($categories as $category) {
            if (!empty($parent_id) && $parent_id == $category->id) {
                $this->html .= "<option value='$category->id' selected>$subMark $category->name</option>";
            } else {
                $this->html .= "<option value='$category->id'>$subMark $category->name</option>";
            }
            $this->categoryRecursive($parent_id, $category->id, $subMark . '---|');
        }
        return $this->html;
    }

}
