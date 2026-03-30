<?php

namespace App\Views\Categories;

use App\Views\Layout\LayoutView;

class CategoryFormView
{
    private array $category;

    // Defaulting to an empty array for new records
    public function __construct(array $category = [])
    {
        $this->category = $category;
    }

    public function render(): string
    {
        // Safely extract values to prevent warnings
        $id = $this->category['id'] ?? null;
        $nameValue = $this->category['name'] ?? '';

        $title = $id ? "Kategória szerkesztése" : "Új kategória";
        $action = $id ? "/categories/edit/{$id}" : "/categories/create";

        // Build the delete button conditionally
        $deleteButton = "";
        if ($id) {
            $deleteButton = "<a href=\"/categories/delete/{$id}\" style=\"background:#dc3545; color:white; text-decoration:none; padding:10px 20px; border-radius:6px;\">Törlés</a>";
        }

        $content = <<<HTML
        <div class="form-container" style="max-width:600px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.15);">
            <form method="post" action="{$action}" style="display:flex; flex-direction:column; gap:15px;">
                <label style="font-weight:bold;">Kategória neve</label>
                <input type="text" name="name" value="{$nameValue}" required style="padding:10px; border-radius:6px; border:1px solid #ccc;">
                
                <div style="display:flex; gap:10px; margin-top:10px;">
                    <button type="submit" style="background:#28a745; color:white; border:none; padding:10px 20px; border-radius:6px; cursor:pointer;">Mentés</button>
                    <a href="/categories" style="background:#6c757d; color:white; text-decoration:none; padding:10px 20px; border-radius:6px;">Vissza</a>
                    {$deleteButton}
                </div>
            </form>
        </div>
        HTML;

        return (new LayoutView($content, $title))->render();
    }
}