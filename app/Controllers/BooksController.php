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
            $this->api->post("/books", [
                "name" => $_POST["name"]
                
            ]);

            header("Location: /books");
            exit;
        }

        return (new BookFormView())->render();
    }

    public function edit(?int $id): string
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $this->api->put("/books/$id", [
            "name"         => $_POST["name"],
            "release_year" => $_POST["release_year"],
            "description"  => $_POST["description"],
            // Added the IDs from the comboboxes
            "author_id"    => $_POST["author_id"],
            "category_id"  => $_POST["category_id"],
            "publisher_id" => $_POST["publisher_id"],
            "series_id"    => $_POST["series_id"],
        ]);

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