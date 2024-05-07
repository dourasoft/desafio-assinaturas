<?php

namespace App\Console\Commands;

use App\Jobs\GenerateInvoices as JobGenerateInvoices;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateInvoices extends Command
{
    protected $signature = 'command:generate-invoices';
    protected $description = 'Command description';
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        parent::__construct();
        $this->subscriptionService = $subscriptionService;
    }

    public function handle()
    {
        $subscriptionsToInvoice = $this->subscriptionService->getToGenerateInvoices();

        foreach ($subscriptionsToInvoice as $subscription) {
            $dueDate = Carbon::now()->addDays(10)->toDateString();

            $data = [
                "registration_id" => $subscription->registration_id,
                "subscription_id" => $subscription->id,
                "description" => $subscription->description,
                "due_date" => $dueDate,
                "value" => $subscription->value
            ];
            JobGenerateInvoices::dispatch($data);
        }

        $this->info('Processing invoices.');
    }
}
