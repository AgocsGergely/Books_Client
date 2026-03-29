<?php

namespace App\Views\Publishers;

use App\Views\Layout\LayoutView;

class PublisherFormView
{
    private array $publisher;

    public function __construct(array $publisher = ['id' => '', 'name' => '', 'address' => ''])
    {
        $this->publisher = $publisher;
    }

    public function render(): string
    {
        $title = $this->publisher['id'] ? "Kiadó szerkesztése" : "Új kiadó";
        $action = $this->publisher['id'] ? "/publishers/edit/{$this->publisher['id']}" : "/publishers/create";

        $content = <<<HTML
        <style>
            .form-container{ max-width:900px; margin:40px auto; background:white; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.15); padding:30px; display:flex; gap:40px; }
            .form-section{ flex:1; display:flex; flex-direction:column; }
            .form-section label{ font-weight:bold; margin-top:10px; }
            .form-section input, .form-section textarea{ padding:8px; border-radius:6px; border:1px solid #ccc; margin-top:5px; }
            .form-buttons{ margin-top:20px; display:flex; gap:10px; }
            .btn{ padding:8px 14px; border:none; border-radius:6px; cursor:pointer; text-decoration:none; font-size:14px; }
            .btn-save{ background:#28a745; color:white; }
            .btn-delete{ background:#dc3545; color:white; }
            .btn-back{ background:#6c757d; color:white; }
        </style>
        <div class="form-container">
            <form method="post" action="{$action}" class="form-section">
                <label>Kiadó neve</label>
                <input type="text" name="name" value="{$this->publisher['name']}" required>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-save">Mentés</button>
                    <a href="/publishers" class="btn btn-back">Vissza</a>
                    <?php if({$this->publisher['id']}): ?>
                    <a href="/publishers/delete/{$this->publisher['id']}" class="btn btn-delete">Törlés</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        HTML;

        return (new LayoutView($content, $title))->render();
    }
}