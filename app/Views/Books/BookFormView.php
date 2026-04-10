<?php

namespace App\Views\Books;

use App\Views\Layout\LayoutView;

class BookFormView
{
    private array $book;
    private array $authors;
    private array $categories;
    private array $publishers;
    private array $series;

    public function __construct(array $book = [], array $authors = [], array $categories = [], array $publishers = [], array $series = [])
    {
        // Eltávolítjuk a 'code' kulcsot, ha az API válasz része
        unset($book['code']);
        $this->book = $book;
        $this->authors = $authors;
        $this->categories = $categories;
        $this->publishers = $publishers;
        $this->series = $series;
    }

    private function generateOptions(array $items, ?int $selectedId, string $labelKey = 'name'): string
    {
        $options = '<option value="">Válasszon...</option>';
        unset($items['code']); 
        
        foreach ($items as $item) {
            if (!is_array($item)) continue;
            $id = $item['id'];
            $label = $item[$labelKey] ?? $item['title'] ?? $item['name'] ?? 'Nincs név';
            $selected = ($id == $selectedId) ? 'selected' : '';
            $options .= "<option value=\"$id\" $selected>$label</option>";
        }
        return $options;
    }

    public function render(): string
    {
        // Biztonságos adatkinyerés
        $id = $this->book['id'] ?? null;
        $nameValue = $this->book['name'] ?? '';
        $releaseYear = $this->book['release_year'] ?? '';
        $description = $this->book['description'] ?? '';
        $photoUrl = $this->book['photo'] ?? 'https://via.placeholder.com/250x380?text=Nincs+kep';
        $seriesNum = $this->book['series_num'] ?? '';

        // Dinamikus elemek
        $title = $id ? "Könyv szerkesztése" : "Új könyv felvétele";
        $action = $id ? "/books/edit/{$id}" : "/books/create";

        $authorOptions = $this->generateOptions($this->authors, $this->book['author_id'] ?? null);
        $categoryOptions = $this->generateOptions($this->categories, $this->book['category_id'] ?? null);
        $publisherOptions = $this->generateOptions($this->publishers, $this->book['publisher_id'] ?? null);
        $seriesOptions = $this->generateOptions($this->series, $this->book['series_id'] ?? null);

        // Törlés gomb csak szerkesztésnél
        $deleteButton = "";
        if ($id) {
            $deleteButton = "<a href=\"/books/delete/{$id}\" class=\"btn btn-delete\" onclick=\"return confirm('Biztosan törölni akarja?')\">Törlés</a>";
        }

        $photoFieldValue = $this->book['photo'] ?? '';

        $content = <<<HTML
        <style>
            .book-form-container { max-width:900px; margin:40px auto; background:white; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.15); padding:30px; display:flex; gap:40px; }
            .book-cover { width:250px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.3); align-self: flex-start; }
            .form-section { flex:1; display:flex; flex-direction:column; }
            .form-section h1 { margin-top: 0; color: #333; }
            .form-section label { font-weight:bold; margin-top:15px; font-size: 0.9rem; color: #444; }
            .form-section input, .form-section textarea, .form-section select { 
                padding:10px; border-radius:6px; border:1px solid #ccc; margin-top:5px; font-family: inherit; width: 100%; box-sizing: border-box;
            }
            .form-buttons { margin-top:30px; display:flex; gap:10px; }
            .btn { padding:10px 18px; border:none; border-radius:6px; cursor:pointer; text-decoration:none; font-size:14px; text-align: center; font-weight: bold; }
            .btn-save { background:#28a745; color:white; }
            .btn-delete { background:#dc3545; color:white; }
            .btn-back { background:#6c757d; color:white; }
        </style>

        <div class="book-form-container">
            <div>
                <img src="{$photoUrl}" class="book-cover" alt="Borító">
                <p style="text-align:center; color:#666; font-size:0.8rem; margin-top:10px;">Előnézet</p>
            </div>

            <form method="post" action="{$action}" class="form-section">
                <h1>{$title}</h1>

                <label>Könyv címe</label>
                <input type="text" name="name" value="{$nameValue}" required>
                <label>ISBN</label>
                <input type="number" name="id" value="{$id}" required>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label>Szerző</label>
                        <select name="author_id">{$authorOptions}</select>
                    </div>
                    <div>
                        <label>Kategória</label>
                        <select name="category_id">{$categoryOptions}</select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label>Kiadó</label>
                        <select name="publisher_id">{$publisherOptions}</select>
                    </div>
                    <div>
                        <label>Sorozat</label>
                        <select name="series_id">{$seriesOptions}</select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label>Megjelenési év</label>
                        <input type="number" name="release_year" value="{$releaseYear}">
                    </div>
                    <div>
                        <label>Széria sorszám</label>
                        <input type="number" name="series_num" value="{$seriesNum}">
                    </div>
                </div>

                <label>Leírás</label>
                <textarea name="description" rows="4">{$description}</textarea>

                <label>Kép URL</label>
                <input type="text" name="photo" value="{$photoFieldValue}" placeholder="https://...">

                <div class="form-buttons">
                    <button type="submit" class="btn btn-save">Mentés</button>
                    <a href="/books" class="btn btn-back">Vissza</a>
                    {$deleteButton}
                </div>
            </form>
        </div>
        HTML;

        return (new LayoutView($content, $title))->render();
    }
}