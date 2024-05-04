<?php

class Faturas
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
        $data = $this->client->get("/faturas/index");
        return $data;
    }

    public function show($id)
    {
        $data = $this->client->get("/faturas/show/{$id}");
        return $data;
    }

    public function store($data)
    {
        $data = $this->client->post("/faturas/store", $data);
        return $data;
    }

    public function update($data)
    {
        $id = $data['id'];
        $data = $this->client->put("/faturas/update/{$id}", $data);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->client->delete("/faturas/destroy/{$id}");
        return $data;
    } 
}
