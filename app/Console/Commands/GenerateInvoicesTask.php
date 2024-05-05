<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Eloquent\Builder;

class GenerateInvoicesTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate invoices for subscriptions that expire in 10 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Subscription::with('register')->whereDate('due_date', now()->addDays(10))
            ->whereDoesntHave('invoice')
            ->get();
        dd($subscriptions);
        foreach ($subscriptions as $subscription) {
            $invoice = new Invoice();
            $invoice->subscription_id = $subscription->id;
            $invoice->register_id = $subscription->register_id;
            $invoice->description = 'Invoice for ' . $subscription->description;
            $invoice->due_date = $subscription->due_date;
            $invoice->value = $subscription->value;
            $invoice->save();
        }
        $this->info('Invoices generated successfully.');
    }
}
