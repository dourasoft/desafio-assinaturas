<?php

namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository
{
    public function getAll()
    {
        return Subscription::with(['registration'])->get();
    }

    public function getByRegistrationId($id)
    {
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

    public function getToGenerateInvoices()
    {
        return DB::select("
        SELECT 
            s.*,
            i.due_date AS last_due_date,
            TO_DATE(EXTRACT(YEAR FROM CURRENT_DATE)::text || '-' || EXTRACT(MONTH FROM CURRENT_DATE)::text || '-' || s.due_day::text, 'YYYY-MM-DD') + INTERVAL '10 days' AS next_due_date
        FROM 
            subscriptions s
        LEFT JOIN LATERAL (
            SELECT i.due_date
            FROM invoices i
            WHERE i.subscription_id = s.id
            ORDER BY i.due_date DESC
            LIMIT 1
        ) i ON TRUE
        WHERE
            s.is_active = true
            AND s.due_day IS NOT NULL
            AND (i.due_date < CURRENT_DATE OR i.due_date IS NULL)
            AND (i.due_date != (TO_DATE(EXTRACT(YEAR FROM CURRENT_DATE)::text || '-' || EXTRACT(MONTH FROM CURRENT_DATE)::text || '-' || s.due_day::text, 'YYYY-MM-DD') + INTERVAL '10 days') OR i.due_date IS NULL)
            AND (TO_DATE(EXTRACT(YEAR FROM CURRENT_DATE)::text || '-' || EXTRACT(MONTH FROM CURRENT_DATE)::text || '-' || s.due_day::text, 'YYYY-MM-DD') + INTERVAL '10 days') BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL '10 days'
            AND (DATE_TRUNC('month', i.due_date) != DATE_TRUNC('month', TO_DATE(EXTRACT(YEAR FROM CURRENT_DATE)::text || '-' || EXTRACT(MONTH FROM CURRENT_DATE)::text || '-' || s.due_day::text, 'YYYY-MM-DD') + INTERVAL '10 days') OR i.due_date IS NULL)
        ORDER BY s.id DESC;
    ");
    
    }
}
