<?php

namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository
{
    public function getAll()
    {
        return Invoice::all();
    }

    public function create(array $data)
    {
        return Invoice::create($data);
    }

    public function getById($id)
    {
        return Invoice::find($id);
    }

    public function getBySubscriptionId($id) {
        return Invoice::where('subscription_id', $id)->get();
    }

    public function update($id, array $data)
    {
        return Invoice::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Invoice::where('id', $id)->delete();
    }
}
