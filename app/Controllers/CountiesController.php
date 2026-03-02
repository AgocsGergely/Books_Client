<?php

namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Counties\IndexView;
use App\Views\Counties\CreateView;
use App\Views\Counties\EditView;

class CountiesController
{
    private ApiRequest $api;

    public function __construct()
    {
        $this->api = new ApiRequest();
    }

    public function index(): string { 
        $needle = $_GET["needle"] ?? null; 
        $endpoint = "/counties";
        if ($needle) { 
            $endpoint = "/counties?needle=" . urlencode($needle); 
        }
        $counties = $this->api->get($endpoint); 
        
        return (new IndexView($counties))->render(); 
    }

    public function create(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->post("/counties", [
                "name" => $_POST["name"]
            ]);

            header("Location: /counties");
            exit;
        }

        return (new CreateView())->render();
    }

    public function edit(?int $id): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->put("/counties/$id", [
                "name" => $_POST["name"]
            ]);

            header("Location: /counties");
            exit;
        }

        $county = $this->api->get("/counties/$id");
        return (new EditView($county))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/counties/$id");

        header("Location: /counties");
        exit;
    }
}
