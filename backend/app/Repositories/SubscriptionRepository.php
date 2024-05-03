<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    public function getAll()
    {
        return Subscription::with(['registration'])->get();
    }

    public function getByRegistrationId($id) {
        return Subscription::with(['registration'])->where('registration_id', $id)->get();
    }

    public function create(array $data)
    {
        return Subscription::create($data);
    }

    public function getById($id)
    {
        return Subscription::with(['registration'])->find($id);
    }

    public function update($id, array $data)
    {
        return Subscription::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Subscription::where('id', $id)->delete();
    }
}
