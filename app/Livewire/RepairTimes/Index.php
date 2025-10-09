<?php

namespace App\Livewire\RepairTimes;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Services\HaynesPro;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class Index extends Component
{
    public Vehicle $vehicle;
    public $repairTimeTypes = [];
    public $selectedRepairTimeTypeIndex = null;
    public $selectedRepairTimeType = null;
    public $repairTimeNodes = [];
    public $expandedNodes = []; // Track which nodes are expanded and their subnodes
    public $loadingNodeId = null; // Track which node is currently being loaded
    public $isLoading = true;
    public $isLoadingNodes = false;
    public $error = null;
    
    // Quote basket
    public $quoteItems = [];
    public $labourRate = 75.00; // Default, will be overridden from settings
    public $vatRate = 20; // Default UK VAT rate
    public $showQuoteModal = false; // Modal visibility
    
    // Customer search
    public $showCustomerSearchModal = false;
    public $customerSearchTerm = '';
    public $searchResults = [];
    public $selectedCustomer = null;
    public $showConfirmCustomer = false;
    public $showCreateCustomer = false;
    
    // Customer creation fields
    public $newCustomerFirstName = '';
    public $newCustomerLastName = '';
    public $newCustomerOrganisation = '';
    public $newCustomerEmail = '';
    public $newCustomerPhone = '';
    
    // Pre-loaded customers linked to this vehicle
    public $linkedCustomers = [];

    public function mount(string $registration)
    {
        $this->vehicle = Vehicle::where('registration', $registration)->firstOrFail();
        
        // Load labour settings from account
        $account = auth()->user()->account;
        if ($account) {
            $this->labourRate = $account->hourly_labour_rate ?? $this->labourRate;
            $this->vatRate = $account->vat_registered ? 20 : 0;
        }
        
        // Load customers already linked to this vehicle
        $this->linkedCustomers = Customer::whereHas('vehicles', function ($query) {
            $query->where('vehicle_id', $this->vehicle->id);
        })
        ->where('account_id', auth()->user()->account_id)
        ->with('vehicles')
        ->get()
        ->toArray();
        
        $this->loadRepairTimeTypes();
    }
    
    public function updated($property)
    {
        // Automatically search when customerSearchTerm changes
        if ($property === 'customerSearchTerm') {
            $this->searchCustomers();
        }
    }

    public function loadRepairTimeTypes()
    {
        try {
            $this->isLoading = true;
            $this->error = null;

            $haynesPro = app(HaynesPro::class);
            
            // Determine which carTypeId to use
            $carTypeId = null;
            
            // Strategy 1: Use the vehicle's HaynesPro car_type_id if available
            if ($this->vehicle->car_type_id) {
                $carTypeId = $this->vehicle->car_type_id;
                Log::info('Using vehicle car_type_id for repair times', [
                    'car_type_id' => $carTypeId,
                    'registration' => $this->vehicle->registration
                ]);
            }
            // Strategy 2: Try TecDoc KType lookup
            elseif ($this->vehicle->tecdoc_ktype) {
                try {
                    $identificationData = $haynesPro->getIdentificationByTecdocKtype((int) $this->vehicle->tecdoc_ktype);
                    if (!empty($identificationData) && is_array($identificationData)) {
                        $carTypeId = $identificationData[0]['id'] ?? $identificationData['id'] ?? null;
                        Log::info('Using TecDoc KType for repair times', [
                            'tecdoc_ktype' => $this->vehicle->tecdoc_ktype,
                            'car_type_id' => $carTypeId,
                            'registration' => $this->vehicle->registration
                        ]);
                    }
                } catch (Exception $e) {
                    Log::warning('TecDoc lookup failed for repair times', [
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Fallback: Show error if no carTypeId available
            if (!$carTypeId) {
                $this->error = 'This vehicle does not have HaynesPro identification data. Please look up the vehicle first to access repair times.';
                $this->isLoading = false;
                return;
            }
            
            Log::info('Loading repair time types', [
                'carTypeId' => $carTypeId,
                'registration' => $this->vehicle->registration
            ]);
            
            // Get repair time types for this vehicle
            $response = $haynesPro->getRepairtimeTypesV2($carTypeId);
            
            Log::info('Repair Time Types API Response', [
                'carTypeId' => $carTypeId,
                'raw_response' => $response,
                'response_type' => gettype($response),
                'is_array' => is_array($response)
            ]);

            // Handle both single object and array responses
            if (!empty($response)) {
                // If it's a single object (associative array), wrap it in an array
                if (isset($response['repairtimeTypeId'])) {
                    $this->repairTimeTypes = [$response];
                } else {
                    $this->repairTimeTypes = $response;
                }
            } else {
                $this->repairTimeTypes = [];
            }

            Log::info('Processed Repair Time Types', [
                'types_count' => count($this->repairTimeTypes),
                'types' => $this->repairTimeTypes
            ]);
            
            $this->isLoading = false;
        } catch (Exception $e) {
            Log::error('Failed to load repair time types', [
                'error' => $e->getMessage(),
                'vehicle_registration' => $this->vehicle->registration,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->error = 'Unable to load repair time types: ' . $e->getMessage();
            $this->isLoading = false;
        }
    }

    public function selectRepairTimeType()
    {
        if ($this->selectedRepairTimeTypeIndex === null) {
            $this->error = 'Please select a vehicle type';
            return;
        }

        $index = (int) $this->selectedRepairTimeTypeIndex;
        
        if (!isset($this->repairTimeTypes[$index])) {
            $this->error = 'Invalid vehicle type selected';
            return;
        }

        $this->selectedRepairTimeType = $this->repairTimeTypes[$index];
        
        Log::info('User selected repair time type', [
            'index' => $index,
            'selected_type' => $this->selectedRepairTimeType
        ]);

        // Load repair time nodes for the selected type
        $this->loadRepairTimeNodes();
    }

    public function loadRepairTimeNodes()
    {
        try {
            $this->isLoadingNodes = true;
            $this->error = null;

            if (!$this->selectedRepairTimeType) {
                $this->error = 'No vehicle type selected';
                $this->isLoadingNodes = false;
                return;
            }

            $haynesPro = app(HaynesPro::class);
            
            $repairtimeTypeId = (int) $this->selectedRepairTimeType['repairtimeTypeId'];
            $typeCategory = $this->selectedRepairTimeType['typeCategory'] ?? 'CAR';
            $rootNodeId = $this->selectedRepairTimeType['rootNodeId'] ?? 'root';
            
            Log::info('Loading repair time nodes', [
                'repairtimeTypeId' => $repairtimeTypeId,
                'typeCategory' => $typeCategory,
                'rootNodeId' => $rootNodeId,
                'selected_type' => $this->selectedRepairTimeType
            ]);
            
            // Get repair time subnodes
            $response = $haynesPro->getRepairtimeSubnodesByGroupV4(
                $repairtimeTypeId,
                $typeCategory,
                $rootNodeId
            );
            
            Log::info('Repair Time Nodes API Response', [
                'repairtimeTypeId' => $repairtimeTypeId,
                'raw_response' => $response,
                'response_type' => gettype($response),
                'nodes_count' => is_array($response) ? count($response) : 0
            ]);

            $this->repairTimeNodes = is_array($response) ? $response : [];
            
            $this->isLoadingNodes = false;
        } catch (Exception $e) {
            Log::error('Failed to load repair time nodes', [
                'error' => $e->getMessage(),
                'selected_type' => $this->selectedRepairTimeType,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->error = 'Unable to load repair times: ' . $e->getMessage();
            $this->isLoadingNodes = false;
        }
    }

    public function toggleNode($nodeId)
    {
        // If node is already expanded, collapse it
        if (isset($this->expandedNodes[$nodeId])) {
            unset($this->expandedNodes[$nodeId]);
            Log::info('Collapsed node', ['nodeId' => $nodeId]);
            return;
        }

        // Otherwise, load and expand the node using getRepairtimeSubnodesByGroupV4
        $this->loadSubnodes($nodeId);
    }

    public function loadSubnodes($nodeId)
    {
        try {
            $this->loadingNodeId = $nodeId;
            $this->error = null;

            if (!$this->selectedRepairTimeType) {
                $this->error = 'No vehicle type selected';
                $this->loadingNodeId = null;
                return;
            }

            $haynesPro = app(HaynesPro::class);
            
            $repairtimeTypeId = (int) $this->selectedRepairTimeType['repairtimeTypeId'];
            $typeCategory = $this->selectedRepairTimeType['typeCategory'] ?? 'CAR';
            
            Log::info('Loading subnodes using getRepairtimeSubnodesByGroupV4', [
                'nodeId' => $nodeId,
                'repairtimeTypeId' => $repairtimeTypeId,
                'typeCategory' => $typeCategory
            ]);
            
            // Call getRepairtimeSubnodesByGroupV4 with repairtimeTypeId, typeCategory, and nodeId
            $response = $haynesPro->getRepairtimeSubnodesByGroupV4(
                $repairtimeTypeId,
                $typeCategory,
                $nodeId
            );
            
            Log::info('Subnodes API Response', [
                'nodeId' => $nodeId,
                'raw_response' => $response,
                'response_type' => gettype($response),
                'subnodes_count' => is_array($response) ? count($response) : 0
            ]);

            // Store the subnodes for this node
            $this->expandedNodes[$nodeId] = is_array($response) ? $response : [];
            
            $this->loadingNodeId = null;
        } catch (Exception $e) {
            Log::error('Failed to load subnodes', [
                'nodeId' => $nodeId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->error = 'Unable to load subnodes: ' . $e->getMessage();
            $this->loadingNodeId = null;
        }
    }

    public function addToQuote($itemId, $description, $timeValue, $awNumber = null)
    {
        // Check if item already exists in quote
        if (isset($this->quoteItems[$itemId])) {
            // Increase quantity
            $this->quoteItems[$itemId]['quantity']++;
            Log::info('Increased quote item quantity', ['itemId' => $itemId, 'quantity' => $this->quoteItems[$itemId]['quantity']]);
        } else {
            // Add new item
            $timeInHours = $timeValue / 100;
            $labourCost = $timeInHours * $this->labourRate;
            
            $this->quoteItems[$itemId] = [
                'id' => $itemId,
                'description' => $description,
                'awNumber' => $awNumber,
                'time' => $timeInHours,
                'quantity' => 1,
                'labourCost' => $labourCost,
            ];
            
            Log::info('Added item to quote', ['item' => $this->quoteItems[$itemId]]);
        }
        
        session()->flash('quote-success', 'Item added to quote');
    }
    
    public function removeFromQuote($itemId)
    {
        if (isset($this->quoteItems[$itemId])) {
            if ($this->quoteItems[$itemId]['quantity'] > 1) {
                $this->quoteItems[$itemId]['quantity']--;
            } else {
                unset($this->quoteItems[$itemId]);
            }
            Log::info('Removed item from quote', ['itemId' => $itemId]);
        }
    }
    
    public function clearQuote()
    {
        $this->quoteItems = [];
        Log::info('Cleared quote basket');
    }
    
    public function getQuoteTotalTimeProperty()
    {
        return array_sum(array_map(function($item) {
            return $item['time'] * $item['quantity'];
        }, $this->quoteItems));
    }
    
    public function getQuoteTotalLabourProperty()
    {
        return $this->quoteTotalTime * $this->labourRate;
    }
    
    public function getQuoteVatProperty()
    {
        return $this->quoteTotalLabour * ($this->vatRate / 100);
    }
    
    public function getQuoteTotalProperty()
    {
        return $this->quoteTotalLabour + $this->quoteVat;
    }
    
    // Customer Search and Quote Finalization
    public function openCustomerSearch()
    {
        if (count($this->quoteItems) === 0) {
            session()->flash('quote-error', 'Please add items to your quote first');
            return;
        }
        
        $this->showCustomerSearchModal = true;
        $this->customerSearchTerm = '';
        $this->searchResults = [];
        $this->selectedCustomer = null;
        $this->showConfirmCustomer = false;
        $this->showCreateCustomer = false;
        
        // Reset customer creation fields
        $this->newCustomerFirstName = '';
        $this->newCustomerLastName = '';
        $this->newCustomerOrganisation = '';
        $this->newCustomerEmail = '';
        $this->newCustomerPhone = '';
    }
    
    public function searchCustomers()
    {
        $this->searchResults = [];
        $this->selectedCustomer = null;
        $this->showConfirmCustomer = false;
        
        if (strlen($this->customerSearchTerm) < 2) {
            Log::info('Search term too short', ['term' => $this->customerSearchTerm]);
            return;
        }
        
        $search = $this->customerSearchTerm;
        $accountId = auth()->user()->account_id;
        
        Log::info('Searching customers', [
            'search' => $search,
            'account_id' => $accountId
        ]);
        
        // Search by name, email, organisation, or registration
        $this->searchResults = Customer::where('account_id', $accountId)
            ->where(function ($query) use ($search) {
                // Search individual fields (first one must be 'where', rest are 'orWhere')
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('organisation', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        // Search concatenated full name (e.g., "Rich Martell")
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                        // Search with last name first (e.g., "Martell Rich")
                        ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"]);
                })
                // Search vehicles
                ->orWhereHas('vehicles', function ($subQuery) use ($search) {
                    $subQuery->where('registration', 'like', "%{$search}%");
                });
            })
            ->with('vehicles')
            ->limit(10)
            ->get();
            
        Log::info('Customer search completed', [
            'search_term' => $search,
            'account_id' => $accountId,
            'results_count' => $this->searchResults->count(),
            'results' => $this->searchResults->map(function($c) {
                return $c->id . ': ' . $c->first_name . ' ' . $c->last_name;
            })->toArray()
        ]);
    }
    
    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = Customer::with('vehicles')->find($customerId);
        $this->showConfirmCustomer = true;
    }
    
    public function confirmCustomerAndProceed()
    {
        if (!$this->selectedCustomer) {
            return;
        }
        
        // Link vehicle to customer if not already linked
        $isLinked = $this->selectedCustomer->vehicles()
            ->where('vehicle_id', $this->vehicle->id)
            ->exists();
            
        if (!$isLinked) {
            Log::info('Linking vehicle to customer', [
                'customer_id' => $this->selectedCustomer->id,
                'vehicle_id' => $this->vehicle->id,
                'registration' => $this->vehicle->registration
            ]);
            
            $this->selectedCustomer->linkVehicle(
                $this->vehicle,
                'owner', // Default relationship type
                now()->format('Y-m-d'), // Owned from today
                null // No end date (current owner)
            );
            
            Log::info('Vehicle linked to customer successfully');
        } else {
            Log::info('Vehicle already linked to customer', [
                'customer_id' => $this->selectedCustomer->id,
                'vehicle_id' => $this->vehicle->id
            ]);
        }
        
        try {
            DB::beginTransaction();
            
            // Calculate totals
            $subtotal = array_sum(array_map(function($item) {
                return ($item['time'] * $this->labourRate * $item['quantity']);
            }, $this->quoteItems));
            
            $vatAmount = ($subtotal * $this->vatRate) / 100;
            $total = $subtotal + $vatAmount;
            
            // Create draft quote in database
            $quote = \App\Models\Quote::create([
                'account_id' => auth()->user()->account_id,
                'customer_id' => $this->selectedCustomer->id,
                'vehicle_id' => $this->vehicle->id,
                'status' => 'draft',
                'labour_rate' => $this->labourRate,
                'vat_rate' => $this->vatRate,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
                'total' => $total,
                'valid_until' => now()->addDays(30),
            ]);
            
            // Create quote items
            $sortOrder = 0;
            foreach ($this->quoteItems as $item) {
                \App\Models\QuoteItem::create([
                    'quote_id' => $quote->id,
                    'description' => $item['description'],
                    'time_hours' => $item['time'],
                    'labour_rate' => $this->labourRate,
                    'quantity' => $item['quantity'],
                    'line_total' => ($item['time'] * $this->labourRate * $item['quantity']),
                    'sort_order' => $sortOrder++,
                ]);
            }
            
            DB::commit();
            
            Log::info('Draft quote created', [
                'quote_id' => $quote->id,
                'items_count' => count($this->quoteItems)
            ]);
            
            // Redirect to quote edit page
            return redirect()->route('quotes.create', ['quote' => $quote->id]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create draft quote', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Failed to create quote: ' . $e->getMessage());
        }
    }
    
    public function createNewCustomer()
    {
        $this->showCreateCustomer = true;
        $this->searchResults = [];
        $this->customerSearchTerm = '';
    }
    
    public function backToSearch()
    {
        $this->showCreateCustomer = false;
        $this->showConfirmCustomer = false;
        $this->newCustomerFirstName = '';
        $this->newCustomerLastName = '';
        $this->newCustomerOrganisation = '';
        $this->newCustomerEmail = '';
        $this->newCustomerPhone = '';
    }
    
    public function saveNewCustomer()
    {
        try {
            $validated = $this->validate([
                'newCustomerFirstName' => 'required|string|max:80',
                'newCustomerLastName' => 'required|string|max:80',
                'newCustomerOrganisation' => 'nullable|string|max:191',
                'newCustomerEmail' => 'nullable|email|max:191',
                'newCustomerPhone' => 'nullable|string|max:30',
            ]);
            
            $accountId = auth()->user()->account_id;
            
            // Check for existing customer with same email
            if ($this->newCustomerEmail) {
                $existingCustomer = Customer::where('account_id', $accountId)
                    ->where('email', $this->newCustomerEmail)
                    ->first();
                    
                if ($existingCustomer) {
                    Log::info('Found existing customer with email', [
                        'customer_id' => $existingCustomer->id,
                        'email' => $this->newCustomerEmail
                    ]);
                    
                    // Automatically select the existing customer
                    $this->selectedCustomer = $existingCustomer->load('vehicles');
                    $this->showCreateCustomer = false;
                    $this->showConfirmCustomer = true;
                    
                    session()->flash('info', 'Customer with this email already exists. Using existing customer.');
                    return;
                }
            }
            
            Log::info('Creating new customer', [
                'first_name' => $this->newCustomerFirstName,
                'last_name' => $this->newCustomerLastName,
                'organisation' => $this->newCustomerOrganisation,
                'account_id' => $accountId,
            ]);
            
            $customer = Customer::create([
                'account_id' => $accountId,
                'first_name' => $this->newCustomerFirstName,
                'last_name' => $this->newCustomerLastName,
                'organisation' => $this->newCustomerOrganisation ?: null,
                'email' => $this->newCustomerEmail ?: null,
                'phone' => $this->newCustomerPhone ?: null,
                'source' => 'web',
            ]);
            
            Log::info('Customer created successfully', ['customer_id' => $customer->id]);
            
            // Automatically select the new customer and proceed
            $this->selectedCustomer = $customer->load('vehicles');
            $this->showCreateCustomer = false;
            $this->showConfirmCustomer = true;
            
            session()->flash('success', 'Customer created successfully');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Customer validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e; // Re-throw to show validation errors
            
        } catch (\Exception $e) {
            Log::error('Failed to create customer', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Check if it's a duplicate entry error
            if (str_contains($e->getMessage(), 'Duplicate entry') || str_contains($e->getMessage(), '1062')) {
                $this->addError('newCustomerEmail', 'A customer with this email already exists. Please search for them instead or use a different email.');
            } else {
                $this->addError('newCustomerFirstName', 'Failed to create customer. Please try again.');
            }
        }
    }

    public function render()
    {
        return view('livewire.repair-times.index')->layout('components.layouts.app', [
            'vehicle' => $this->vehicle,
            'vehicleImage' => null,
        ]);
    }
}
