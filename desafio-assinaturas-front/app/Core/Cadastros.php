<?php

class Cadastros
{
    private $client;
    private $session;

    public function __construct()
    {
        $this->client = new HttpClient();
        $this->session = new Session();
    }

    public function index()
    {
        $data = $this->client->get("/cadastros/index");
        return $data;
    }

    public function show($id)
    {
        $data = $this->client->get("/cadastros/show/{$id}");
        return $data;
    }

    public function store($data)
    {
        $data = $this->client->post("/cadastros/store", $data);
        return $data;
    }

    public function update($data)
    {
        $id = $data['id'];
        $data = $this->client->put("/cadastros/update/{$id}", $data);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->client->delete("/cadastros/destroy/{$id}");
        return $data;
    } 
}
