<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmplyeeController extends Controller
{
    private $path;
    private $client;

    public function __construct()
    {

        $this->client = new Client(['base_uri' => 'http://lamarr.srv.tecalis.com/pruebaNivel.php']);
        $this->path = "/pruebaNivel.php?employee=";
    }

    public function index()
    {
        return view('index');
    }

    public function find(Request $request, string $id)
    {
        $path = "/pruebaNivel.php?employee=".$id;

        $response = $this->client->request('get', $path);

        $response = json_decode($response->getBody()->getContents(), true);

        return response()->json($response, Response::HTTP_OK);


    }

    public function save(Request $request)
    {
        $file_name = "employee.txt";
        $pathFile =storage_path(). '\\' . $file_name;
        $fichero = fopen($pathFile, "w");
        $data = $request->all();
        
        if (isset($data['data'] )) {

            foreach($data['data'] as $employee) {
                fwrite($fichero, $employee . "\n");
            }

            fclose($fichero);

            $headers = [
                'Content-Type' => 'text/plain',
                'Content-Disposition' => 'attachment; filename="{$file_name}"',
                'Content-Description'=> 'File Transfer',
                'Content-Transfer-Encoding'=> 'binary'
            ];


            return response()->download(
                $pathFile,
                $file_name,
                $headers,
                'attachment'
            );
        }

        return response()->json('not found', Response::HTTP_NOT_FOUND);



    }
}
