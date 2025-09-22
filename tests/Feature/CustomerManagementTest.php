<?php

use App\Models\Account;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vehicle;
use Livewire\Livewire;

beforeEach(function () {
    // Create a test account and user for testing multi-tenancy
    $this->account = Account::factory()->create();
    $this->user = User::factory()->create(['account_id' => $this->account->id]);
    $this->actingAs($this->user);
});

test('customers index page loads successfully', function () {
    $response = $this->get('/customers');
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('customers.index');
});

test('customers index shows only current account customers', function () {
    $otherAccount = Account::factory()->create();
    
    // Create customers in different accounts
    $myCustomer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'John',
        'last_name' => 'Smith',
    ]);
    
    $otherCustomer = Customer::factory()->create([
        'account_id' => $otherAccount->id,
        'first_name' => 'Jane',
        'last_name' => 'Doe',
    ]);
    
    Livewire::test('customers.index')
        ->assertSee('John Smith')
        ->assertDontSee('Jane Doe');
});

test('can search customers by name', function () {
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'John',
        'last_name' => 'Smith',
    ]);
    
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'Jane',
        'last_name' => 'Doe',
    ]);
    
    Livewire::test('customers.index')
        ->set('search', 'John')
        ->assertSee('John Smith')
        ->assertDontSee('Jane Doe');
});

test('can search customers by email', function () {
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'John',
        'email' => 'john@example.com',
    ]);
    
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'Jane',
        'email' => 'jane@example.com',
    ]);
    
    Livewire::test('customers.index')
        ->set('search', 'john@example')
        ->assertSee('john@example.com')
        ->assertDontSee('jane@example.com');
});

test('can filter customers by deleted status', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    $customer->delete();
    
    Livewire::test('customers.index')
        ->set('filter', 'all')
        ->assertSee($customer->full_name)
        ->set('filter', 'deleted')
        ->assertSee($customer->full_name)
        ->set('filter', 'active')
        ->assertDontSee($customer->full_name);
});

test('can sort customers by different fields', function () {
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'Alpha',
        'last_name' => 'Beta',
    ]);
    
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'Zeta',
        'last_name' => 'Alpha',
    ]);
    
    Livewire::test('customers.index')
        ->set('sortBy', 'first_name')
        ->set('sortDirection', 'asc')
        ->assertSeeInOrder(['Alpha Beta', 'Zeta Alpha']);
});

test('can create a new customer', function () {
    Livewire::test('customers.upsert')
        ->set('first_name', 'John')
        ->set('last_name', 'Smith')
        ->set('email', 'john@example.com')
        ->set('phone', '01234 567890')
        ->set('notes', 'Test customer')
        ->call('save')
        ->assertHasNoErrors();
    
    $customer = Customer::first();
    expect($customer->first_name)->toBe('John');
    expect($customer->last_name)->toBe('Smith');
    expect($customer->email)->toBe('john@example.com');
    expect($customer->account_id)->toBe($this->account->id);
});

test('customer creation validates required fields', function () {
    Livewire::test('customers.upsert')
        ->set('first_name', '')
        ->set('last_name', '')
        ->call('save')
        ->assertHasErrors(['first_name', 'last_name']);
});

test('customer email must be unique within account', function () {
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'email' => 'john@example.com',
    ]);
    
    Livewire::test('customers.upsert')
        ->set('first_name', 'Jane')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->call('save')
        ->assertHasErrors(['email']);
});

test('customer email can be same across different accounts', function () {
    $otherAccount = Account::factory()->create();
    
    Customer::factory()->create([
        'account_id' => $otherAccount->id,
        'email' => 'john@example.com',
    ]);
    
    Livewire::test('customers.upsert')
        ->set('first_name', 'John')
        ->set('last_name', 'Smith')
        ->set('email', 'john@example.com')
        ->call('save')
        ->assertHasNoErrors();
});

test('can edit existing customer', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    Livewire::test('customers.upsert', ['customer' => $customer])
        ->assertSet('first_name', $customer->first_name)
        ->set('first_name', 'Updated Name')
        ->call('save')
        ->assertHasNoErrors();
    
    expect($customer->fresh()->first_name)->toBe('Updated Name');
});

test('can add and remove tags from customer', function () {
    Livewire::test('customers.upsert')
        ->set('first_name', 'John')
        ->set('last_name', 'Smith')
        ->set('newTag', 'VIP')
        ->call('addTag')
        ->assertSet('tags', ['VIP'])
        ->set('newTag', 'Regular')
        ->call('addTag')
        ->assertSet('tags', ['VIP', 'Regular'])
        ->call('removeTag', 0)
        ->assertSet('tags', ['Regular']);
});

test('can soft delete customer', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    Livewire::test('customers.index')
        ->call('confirmDelete', $customer->id)
        ->assertSet('showDeleteModal', true)
        ->call('delete')
        ->assertSet('showDeleteModal', false);
    
    expect($customer->fresh()->trashed())->toBeTrue();
});

test('can restore soft deleted customer', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    $customer->delete();
    
    Livewire::test('customers.index')
        ->call('restore', $customer->id);
    
    expect($customer->fresh()->trashed())->toBeFalse();
});

test('customer show page loads successfully', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    $response = $this->get("/customers/{$customer->id}");
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('customers.show');
});

test('customer show page displays customer information', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'John',
        'last_name' => 'Smith',
        'email' => 'john@example.com',
    ]);
    
    Livewire::test('customers.show', ['customer' => $customer])
        ->assertSee('John Smith')
        ->assertSee('john@example.com');
});

test('can link vehicle to customer', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    $vehicle = Vehicle::factory()->create([
        'account_id' => $this->account->id,
        'registration' => 'AB12 CDE',
    ]);
    
    Livewire::test('customers.show', ['customer' => $customer])
        ->set('vehicleRegistration', 'AB12 CDE')
        ->set('vehicleRelationship', 'owner')
        ->set('ownedFrom', '2023-01-01')
        ->call('linkVehicle')
        ->assertHasNoErrors();
    
    expect($customer->currentVehicles)->toHaveCount(1);
    expect($customer->currentVehicles->first()->registration)->toBe('AB12 CDE');
});

test('can create new vehicle when linking if not exists', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    Livewire::test('customers.show', ['customer' => $customer])
        ->set('vehicleRegistration', 'NEW123')
        ->set('vehicleRelationship', 'owner')
        ->call('linkVehicle')
        ->assertHasNoErrors();
    
    $vehicle = Vehicle::where('registration', 'NEW123')->first();
    expect($vehicle)->not->toBeNull();
    expect($vehicle->account_id)->toBe($this->account->id);
    expect($customer->currentVehicles)->toHaveCount(1);
});

test('can unlink vehicle from customer', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    $vehicle = Vehicle::factory()->create(['account_id' => $this->account->id]);
    
    $customer->linkVehicle($vehicle, 'owner', '2023-01-01');
    
    Livewire::test('customers.show', ['customer' => $customer])
        ->call('confirmUnlinkVehicle', $vehicle->id)
        ->assertSet('showUnlinkConfirmModal', true)
        ->call('unlinkVehicle')
        ->assertSet('showUnlinkConfirmModal', false);
    
    expect($customer->fresh()->currentVehicles)->toHaveCount(0);
});

test('can update customer notes with autosave', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'notes' => 'Original notes',
    ]);
    
    Livewire::test('customers.show', ['customer' => $customer])
        ->set('notes', 'Updated notes')
        ->assertSet('notesChanged', true)
        ->call('updateNotes')
        ->assertSet('notesChanged', false);
    
    expect($customer->fresh()->notes)->toBe('Updated notes');
});

test('can update last contact timestamp', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'last_contact_at' => null,
    ]);
    
    Livewire::test('customers.show', ['customer' => $customer])
        ->call('updateLastContact');
    
    expect($customer->fresh()->last_contact_at)->not->toBeNull();
});

test('customer show page has different tabs', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    Livewire::test('customers.show', ['customer' => $customer])
        ->assertSet('activeTab', 'profile')
        ->call('setActiveTab', 'vehicles')
        ->assertSet('activeTab', 'vehicles')
        ->call('setActiveTab', 'timeline')
        ->assertSet('activeTab', 'timeline');
});

test('cannot access other account customers', function () {
    $otherAccount = Account::factory()->create();
    $otherCustomer = Customer::factory()->create(['account_id' => $otherAccount->id]);
    
    $response = $this->get("/customers/{$otherCustomer->id}");
    
    $response->assertStatus(404);
});

test('customer policies enforce account ownership', function () {
    $otherAccount = Account::factory()->create();
    $otherCustomer = Customer::factory()->create(['account_id' => $otherAccount->id]);
    
    expect($this->user->can('view', $otherCustomer))->toBeFalse();
    expect($this->user->can('update', $otherCustomer))->toBeFalse();
    expect($this->user->can('delete', $otherCustomer))->toBeFalse();
});
