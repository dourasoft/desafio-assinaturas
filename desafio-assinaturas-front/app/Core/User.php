<?php

class User
{
    private $client;
    private $session;

    public function __construct()
    {
        $this->client = new HttpClient();
        $this->session = new Session();
    }

    public function login($data)
    {
        $user = $this->client->post("/login", $data);

        if ($this->session->has('token') || $user['status'] != 200) {
            $this->session->destroy();
            return $user;
        }

        //register in session user's data
        $this->session->set('token', $user['response']->token);
        $this->session->set('id', $user['response']->user->id);
        $this->session->set('name', $user['response']->user->name);
        $this->session->set('email', $user['response']->user->email);

        //return status
        $response['status'] = $user['status'];

        return $response;
    }

    public function logout()
    {
        $user = $this->client->post("/logout");

        $this->session->destroy();

        return $user;
    }
}
