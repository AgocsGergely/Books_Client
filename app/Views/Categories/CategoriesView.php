<?php

namespace App\Views\Categories;

use App\Views\Layout\LayoutView;

class CategoriesView
{
    private array $categories;

    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    public function render(): string
    {
        $list = "";
        unset($this->categories['code']);
        
        foreach ($this->categories as $category) {
            $list .= <<<HTML
            <a href="/categories/edit/{$category['id']}" style="display:block; padding:15px; margin-bottom:10px; background:white; border-radius:8px; text-decoration:none; color:#333; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition: 0.2s;">
                <strong>{$category['name']}</strong>
            </a>
            HTML;
        }

        $content = <<<HTML
        <div style="max-width:800px; margin: 20px auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h1 style="text-align:center;">Kategóriák</h1>
                <a href="/categories/create" style="background:#007bff; color:white; padding:10px 20px; border-radius:6px; text-decoration:none;">+ Új kategória</a>
            </div>
            $list
        </div>
        HTML;

        return (new LayoutView($content, "Kategóriák"))->render();
    }
}