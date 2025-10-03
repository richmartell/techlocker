<?php

namespace App\Livewire\Admin\Plans;

use App\Models\Plan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Upsert extends Component
{
    public ?Plan $plan = null;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('nullable|string')]
    public $description = '';

    #[Rule('required|numeric|min:0')]
    public $price = '';

    #[Rule('nullable|integer|min:1')]
    public $max_users = '';

    #[Rule('nullable|integer|min:1')]
    public $max_customers = '';

    #[Rule('nullable|integer|min:1')]
    public $max_searches = '';

    #[Rule('boolean')]
    public $is_active = true;

    public function mount(?Plan $plan = null)
    {
        if ($plan->exists) {
            $this->plan = $plan;
            $this->name = $plan->name;
            $this->description = $plan->description;
            $this->price = $plan->price;
            $this->max_users = $plan->max_users;
            $this->max_customers = $plan->max_customers;
            $this->max_searches = $plan->max_searches;
            $this->is_active = $plan->is_active;
        }
    }

    public function save()
    {
        $validated = $this->validate();

        // Convert empty strings to null for nullable fields
        $validated['max_users'] = $validated['max_users'] ?: null;
        $validated['max_customers'] = $validated['max_customers'] ?: null;
        $validated['max_searches'] = $validated['max_searches'] ?: null;

        if ($this->plan) {
            $this->plan->update($validated);
            session()->flash('success', 'Plan updated successfully.');
        } else {
            Plan::create($validated);
            session()->flash('success', 'Plan created successfully.');
        }

        return redirect()->route('admin.plans.index');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.plans.upsert');
    }
}
