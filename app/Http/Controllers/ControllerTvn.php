<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
class ControllerTvn extends Controller
{
    public function getJsonData()
    {
        $jsonFilePath = storage_path('../storage/scraped_links.json'); // Adjust the path to your JSON file
        $jsonContent = file_get_contents($jsonFilePath);
        return response()->json(json_decode($jsonContent), 200);
    }
}
