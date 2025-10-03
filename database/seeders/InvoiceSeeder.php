<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = Account::all();
        $plans = Plan::all();

        if ($accounts->isEmpty() || $plans->isEmpty()) {
            $this->command->warn('No accounts or plans found. Please run AccountSeeder and PlanSeeder first.');
            return;
        }

        $statuses = ['paid', 'pending', 'failed', 'refunded'];
        $invoiceNumber = 1000;

        foreach ($accounts->take(5) as $account) {
            // Create 3-5 invoices per account
            $invoiceCount = rand(3, 5);
            
            for ($i = 0; $i < $invoiceCount; $i++) {
                $issueDate = now()->subMonths(rand(1, 6));
                $dueDate = $issueDate->copy()->addDays(30);
                $status = $statuses[array_rand($statuses)];
                $plan = $plans->random();

                Invoice::create([
                    'invoice_number' => 'INV-' . str_pad($invoiceNumber++, 6, '0', STR_PAD_LEFT),
                    'account_id' => $account->id,
                    'plan_id' => $plan->id,
                    'amount' => $plan->price,
                    'status' => $status,
                    'issue_date' => $issueDate,
                    'due_date' => $dueDate,
                    'paid_at' => $status === 'paid' ? $dueDate->copy()->subDays(rand(1, 10)) : null,
                    'notes' => $status === 'failed' ? 'Payment failed - card declined' : null,
                ]);
            }
        }

        $this->command->info('Sample invoices created successfully!');
    }
}
