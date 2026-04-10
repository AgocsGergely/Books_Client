<?php

namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Books\BooksView;
use App\Views\Books\BookFormView;

class BooksController
{
    private ApiRequest $api;

    public function __construct()
    {
        $this->api = new ApiRequest();
    }

    public function index(): string
    {
        $books = $this->api->get("/books");
        return (new BooksView($books))->render();
    }

   public function create(): string
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        // Segédfüggvény az üres stringek NULL-ra alakításához (hogy az API ne kapjon hibás adatot)
        $toNullableInt = function($value) {
            return (isset($value) && $value !== '') ? (int)$value : null;
        };

        $data = [
            "id"           => $toNullableInt($_POST["id"]), // Ha manuális ISBN/ID kell
            "name"         => $_POST["name"] ?? null,
            "release_year" => $toNullableInt($_POST["release_year"]),
            "description"  => $_POST["description"] ?? '',
            "photo"        => $_POST["photo"] ?? '',
            "series_num"   => $toNullableInt($_POST["series_num"]),
            "author_id"    => $toNullableInt($_POST["author_id"]),
            "category_id"  => $toNullableInt($_POST["category_id"]),
            "publisher_id" => $toNullableInt($_POST["publisher_id"]),
            "series_id"    => $toNullableInt($_POST["series_id"]),
        ];

        $this->api->post("/books", $data);

        header("Location: /books");
        exit;
    }

    // Listák lekérése a legördülő menükhöz (Comboboxokhoz)
    $authors    = $this->api->get("/authors");
    $categories = $this->api->get("/categories");
    $publishers = $this->api->get("/publishers");
    $series     = $this->api->get("/series");

    // Üres tömbbel hívjuk meg a könyv adatot, de átadjuk a segédlistákat
    return (new BookFormView(
        [], 
        $authors, 
        $categories, 
        $publishers, 
        $series
    ))->render();
}

    public function edit(?int $id): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        // Helper function to handle the empty string vs null issue
        $toNullableInt = function($value) {
            return (isset($value) && $value !== '') ? (int)$value : null;
        };

        $data = [
            "name"         => $_POST["name"] ?? null,
            "release_year" => $toNullableInt($_POST["release_year"]),
            "description"  => !empty($_POST["description"]) ? $_POST["description"] : null,
            "photo"        => !empty($_POST["photo"]) ? $_POST["photo"] : null,
            "series_num"   => $toNullableInt($_POST["series_num"]),
            "author_id"    => $toNullableInt($_POST["author_id"]),
            "category_id"  => $toNullableInt($_POST["category_id"]),
            "publisher_id" => $toNullableInt($_POST["publisher_id"]),
            "series_id"    => $toNullableInt($_POST["series_id"]),
        ];

        $response = $this->api->put("/books/$id", $data);

        // If the API returns an empty array, it's a fail.
        // To debug further, you'd need to check the API's internal code.
        if (empty($response)) {
            echo "<h2>Hiba történt a mentés során!</h2>";
            echo "<p>Az API nem küldött választ. Valószínűleg adatbázis hiba vagy érvénytelen mező formátum.</p>";
            echo "<pre>Küldött adatok: " . print_r($data, true) . "</pre>";
            exit;
        }

        header("Location: /books");
        exit;
    
        }

        // 1. Fetch the specific book
        $book = $this->api->get("/books/$id");

        // 2. Fetch all list data for the comboboxes
        $authors    = $this->api->get("/authors");
        $categories = $this->api->get("/categories");
        $publishers = $this->api->get("/publishers");
        $series     = $this->api->get("/series");

        // 3. Pass everything to the View
        return (new BookFormView(
            $book, 
            $authors, 
            $categories, 
            $publishers, 
            $series
        ))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/books/$id");

        header("Location: /books");
        exit;
    }
}