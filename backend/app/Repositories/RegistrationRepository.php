<?php

namespace App\Repositories;

use App\Models\Registration;
use Illuminate\Support\Str;

class RegistrationRepository
{
    public function getAll()
    {
        return Registration::all();
    }

    public function create(array $data)
    {
        $data['code'] = Str::uuid();

        return Registration::create($data);
    }

    public function getById($id)
    {
        return Registration::find($id);
    }

    public function update($id, array $data)
    {
        return Registration::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Registration::where('id', $id)->delete();
    }
}
