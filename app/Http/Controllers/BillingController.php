<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    /**
     * Show the billing page
     */
    public function index()
    {
        $account = auth()->user()->account;
        $account->load(['plan', 'reseller']);

        // Check if account has a reseller
        $hasReseller = !is_null($account->reseller_id) && $account->reseller;

        if ($hasReseller) {
            // Account is managed by a reseller
            return view('billing.index', [
                'account' => $account,
                'hasReseller' => true,
                'reseller' => $account->reseller,
                'plan' => $account->plan,
            ]);
        }

        // Account manages their own billing
        // Check if they have a Stripe subscription
        $subscription = $account->subscriptions()->active()->first();
        $hasActiveSubscription = !is_null($subscription);

        return view('billing.index', [
            'account' => $account,
            'hasReseller' => false,
            'plan' => $account->plan,
            'subscription' => $subscription,
            'hasActiveSubscription' => $hasActiveSubscription,
        ]);
    }

    /**
     * Redirect to Stripe Customer Portal
     */
    public function portal(Request $request)
    {
        $account = auth()->user()->account;

        // Only allow if account doesn't have a reseller
        if ($account->reseller_id) {
            return redirect()->route('billing.index')
                ->with('error', 'Your billing is managed by your reseller. Please contact them for billing changes.');
        }

        try {
            return $account->redirectToBillingPortal(
                route('billing.index')
            );
        } catch (\Exception $e) {
            Log::error('Stripe portal redirect failed', [
                'account_id' => $account->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('billing.index')
                ->with('error', 'Unable to access billing portal. Please try again or contact support.');
        }
    }

    /**
     * Create a checkout session for a new subscription
     */
    public function checkout(Request $request)
    {
        $account = auth()->user()->account;

        // Only allow if account doesn't have a reseller
        if ($account->reseller_id) {
            return redirect()->route('billing.index')
                ->with('error', 'Your billing is managed by your reseller. Please contact them for plan changes.');
        }

        $priceId = $request->input('price_id');

        if (!$priceId) {
            return redirect()->route('billing.index')
                ->with('error', 'Please select a plan.');
        }

        try {
            return $account->newSubscription('default', $priceId)
                ->checkout([
                    'success_url' => route('billing.success'),
                    'cancel_url' => route('billing.index'),
                ]);
        } catch (\Exception $e) {
            Log::error('Stripe checkout failed', [
                'account_id' => $account->id,
                'price_id' => $priceId,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('billing.index')
                ->with('error', 'Unable to start checkout. Please try again or contact support.');
        }
    }

    /**
     * Handle successful subscription
     */
    public function success()
    {
        return redirect()->route('billing.index')
            ->with('success', 'Your subscription has been activated successfully!');
    }
}

