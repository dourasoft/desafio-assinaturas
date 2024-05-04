<?php

class Assinaturas
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
        $data = $this->client->get("/assinaturas/index");
        return $data;
    }

    public function show($id)
    {
        $data = $this->client->get("/assinaturas/show/{$id}");
        return $data;
    }

    public function store($data)
    {
        $data = $this->client->post("/assinaturas/store", $data);
        return $data;
    }

    public function update($data)
    {
        $id = $data['id'];
        $data = $this->client->put("/assinaturas/update/{$id}", $data);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->client->delete("/assinaturas/destroy/{$id}");
        return $data;
    }     
}
