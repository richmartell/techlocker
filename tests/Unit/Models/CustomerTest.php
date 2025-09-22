<?php

use App\Models\Account;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;

beforeEach(function () {
    // Create a test account and user for testing multi-tenancy
    $this->account = Account::factory()->create();
    $this->user = User::factory()->create(['account_id' => $this->account->id]);
    $this->actingAs($this->user);
});

test('customer belongs to an account', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    expect($customer->account)->toBeInstanceOf(Account::class);
    expect($customer->account->id)->toBe($this->account->id);
});

test('customer has full name accessor', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'first_name' => 'John',
        'last_name' => 'Smith',
    ]);
    
    expect($customer->full_name)->toBe('John Smith');
});

test('customer phone number gets normalized to e164 format', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'phone' => '01234 567890',
    ]);
    
    expect($customer->phone_e164)->toMatch('/^\+44/');
});

test('customer formatted phone returns readable format', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'phone' => '01234567890',
    ]);
    
    expect($customer->formatted_phone)->toContain('01234');
});

test('customer can have multiple vehicles with different relationships', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    $vehicle1 = Vehicle::factory()->create(['account_id' => $this->account->id]);
    $vehicle2 = Vehicle::factory()->create(['account_id' => $this->account->id]);
    
    $customer->linkVehicle($vehicle1, 'owner', '2023-01-01');
    $customer->linkVehicle($vehicle2, 'driver', '2023-06-01');
    
    expect($customer->vehicles)->toHaveCount(2);
    expect($customer->vehiclesByRelationship('owner'))->toHaveCount(1);
    expect($customer->vehiclesByRelationship('driver'))->toHaveCount(1);
});

test('customer current vehicles only includes active relationships', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    $vehicle1 = Vehicle::factory()->create(['account_id' => $this->account->id]);
    $vehicle2 = Vehicle::factory()->create(['account_id' => $this->account->id]);
    
    // Link both vehicles
    $customer->linkVehicle($vehicle1, 'owner', '2023-01-01');
    $customer->linkVehicle($vehicle2, 'owner', '2023-06-01');
    
    // End ownership of one vehicle
    $customer->endVehicleOwnership($vehicle1, '2023-12-01');
    
    expect($customer->currentVehicles)->toHaveCount(1);
    expect($customer->currentVehicles->first()->id)->toBe($vehicle2->id);
});

test('customer can own same vehicle multiple times with history', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    $vehicle = Vehicle::factory()->create(['account_id' => $this->account->id]);
    
    // First ownership period
    $customer->linkVehicle($vehicle, 'owner', '2023-01-01', '2023-06-01');
    
    // Second ownership period
    $customer->linkVehicle($vehicle, 'owner', '2023-12-01');
    
    expect($customer->vehicles)->toHaveCount(2);
    expect($customer->currentVehicles)->toHaveCount(1);
});

test('customer search scope finds by first name', function () {
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
    
    $results = Customer::search('John')->get();
    
    expect($results)->toHaveCount(1);
    expect($results->first()->first_name)->toBe('John');
});

test('customer search scope finds by last name', function () {
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
    
    $results = Customer::search('Smith')->get();
    
    expect($results)->toHaveCount(1);
    expect($results->first()->last_name)->toBe('Smith');
});

test('customer search scope finds by email', function () {
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'email' => 'john@example.com',
    ]);
    
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'email' => 'jane@example.com',
    ]);
    
    $results = Customer::search('john@example')->get();
    
    expect($results)->toHaveCount(1);
    expect($results->first()->email)->toBe('john@example.com');
});

test('customer search scope finds by phone', function () {
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'phone' => '01234 567890',
    ]);
    
    Customer::factory()->create([
        'account_id' => $this->account->id,
        'phone' => '09876 543210',
    ]);
    
    $results = Customer::search('01234')->get();
    
    expect($results)->toHaveCount(1);
});

test('customer soft delete works correctly', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    $customer->delete();
    
    expect($customer->trashed())->toBeTrue();
    expect(Customer::withoutTrashed()->count())->toBe(0);
    expect(Customer::withTrashed()->count())->toBe(1);
});

test('customer can be restored after soft delete', function () {
    $customer = Customer::factory()->create(['account_id' => $this->account->id]);
    
    $customer->delete();
    $customer->restore();
    
    expect($customer->trashed())->toBeFalse();
    expect(Customer::count())->toBe(1);
});

test('customer can add and remove tags', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'tags' => ['VIP'],
    ]);
    
    $customer->addTag('Regular');
    expect($customer->tags)->toContain('VIP');
    expect($customer->tags)->toContain('Regular');
    
    $customer->removeTag('VIP');
    expect($customer->tags)->not->toContain('VIP');
    expect($customer->tags)->toContain('Regular');
});

test('customer last contact can be updated', function () {
    $customer = Customer::factory()->create([
        'account_id' => $this->account->id,
        'last_contact_at' => null,
    ]);
    
    $now = Carbon::now();
    $customer->updateLastContact($now);
    
    expect($customer->last_contact_at->toDateTimeString())->toBe($now->toDateTimeString());
});

test('customer validation rules include account scope for email uniqueness', function () {
    $rules = Customer::validationRules();
    
    expect($rules['email'])->toContain('account_id,' . $this->account->id);
});

test('customer automatically gets account_id when created by authenticated user', function () {
    $customer = Customer::factory()->make(['account_id' => null]);
    $customer->save();
    
    expect($customer->account_id)->toBe($this->account->id);
});

test('customer global scope filters by current user account', function () {
    $otherAccount = Account::factory()->create();
    
    // Create customers in different accounts
    Customer::factory()->create(['account_id' => $this->account->id]);
    Customer::factory()->create(['account_id' => $otherAccount->id]);
    
    // Should only see customers from current user's account
    expect(Customer::count())->toBe(1);
});
