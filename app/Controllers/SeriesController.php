namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Series\SeriesView;
use App\Views\Series\SeriesFormView;

class SeriesController
{
    private ApiRequest $api;

    public function __construct()
    {
        $this->api = new ApiRequest();
    }

    public function index(): string
    {
        $series = $this->api->get("/series");
        return (new SeriesView($series))->render();
    }

    public function create(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->post("/series", [
                "title" => $_POST["title"],
                "description" => $_POST["description"] ?? null
            ]);

            header("Location: /series");
            exit;
        }

        return (new SeriesFormView())->render();
    }

    public function edit(?int $id): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->put("/series/$id", [
                "name" => $_POST["name"],
            ]);

            header("Location: /series");
            exit;
        }

        $seriesItem = $this->api->get("/series/$id");
        return (new SeriesFormView($seriesItem))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/series/$id");
        header("Location: /series");
        exit;
    }
}