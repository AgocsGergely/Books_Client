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

    public function __construct(array $book, array $authors = [], array $categories = [], array $publishers = [], array $series = [])
    {
        $this->book = $book;
        $this->authors = $authors;
        $this->categories = $categories;
        $this->publishers = $publishers;
        $this->series = $series;
    }

    private function generateOptions(array $items, ?int $selectedId, string $labelKey = 'name'): string
    {
        $options = '<option value="">Válasszon...</option>';
        // Remove 'code' key if API returns it in the array wrapper
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
        $authorOptions = $this->generateOptions($this->authors, $this->book['author_id'] ?? null);
        $categoryOptions = $this->generateOptions($this->categories, $this->book['category_id'] ?? null);
        $publisherOptions = $this->generateOptions($this->publishers, $this->book['publisher_id'] ?? null);
        $seriesOptions = $this->generateOptions($this->series, $this->book['series_id'] ?? null, 'title');

        $content = <<<HTML
        <style>
            .book-form-container { max-width:900px; margin:40px auto; background:white; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.15); padding:30px; display:flex; gap:40px; }
            .book-cover { width:250px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.3); align-self: flex-start; }
            .form-section { flex:1; display:flex; flex-direction:column; }
            .form-section label { font-weight:bold; margin-top:15px; font-size: 0.9rem; color: #444; }
            .form-section input, .form-section textarea, .form-section select { 
                padding:10px; border-radius:6px; border:1px solid #ccc; margin-top:5px; font-family: inherit;
            }
            .form-buttons { margin-top:30px; display:flex; gap:10px; }
            .btn { padding:10px 18px; border:none; border-radius:6px; cursor:pointer; text-decoration:none; font-size:14px; text-align: center; }
            .btn-save { background:#28a745; color:white; }
            .btn-delete { background:#dc3545; color:white; }
            .btn-back { background:#6c757d; color:white; }
        </style>

        <div class="book-form-container">
            <img src="{$this->book['photo']}" class="book-cover" alt="Borító">

            <form method="post" action="/books/edit/{$this->book['id']}" class="form-section">
                <label>Könyv címe</label>
                <input type="text" name="name" value="{$this->book['name']}" required>

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

                <label>Megjelenési év</label>
                <input type="number" name="release_year" value="{$this->book['release_year']}">

                <label>Leírás</label>
                <textarea name="description" rows="6">{$this->book['description']}</textarea>

                <label>Kép URL</label>
                <textarea name="photo" rows="6">{$this->book['photo']}</textarea>

                <label>Széria sorszám</label>
                <input type="number"name="series_num" value="{$this->book['series_num']}">

                <div class="form-buttons">
                    <button type="submit" class="btn btn-save">Mentés</button>
                    <a href="/books" class="btn btn-back">Vissza</a>
                    <a href="/books/delete/{$this->book['id']}" class="btn btn-delete">Törlés</a>
                </div>
            </form>
        </div>
        HTML;

        echo "<script>console.log('Book data:', " . json_encode($this->book) . ");</script>";
        return (new LayoutView($content, $this->book['name']))->render();
    }
}
