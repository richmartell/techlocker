# MOT History API Integration

## Overview

The MOT History API provides access to the complete MOT test history for UK vehicles. This API is provided by the DVSA (Driver and Vehicle Standards Agency) and integrates with GarageIQ's vehicle lookup functionality.

## Configuration

### Environment Variables

```env
MOT_API_KEY=your_mot_api_key_here
```

### Service Configuration

Located in `config/services.php`:

```php
'mot' => [
    'api_key' => env('MOT_API_KEY'),
],
```

## Service Class

**Location**: `app/Services/MOT.php`

### Methods

#### `getMOTHistory(string $registrationNumber): array`

Retrieves complete MOT test history for a vehicle.

**Parameters:**
- `$registrationNumber` - UK vehicle registration

**Returns:** Array of MOT test records (or error array if not found)

**Graceful Degradation:** Returns error array instead of throwing exceptions

## API Endpoint

**URL**: `https://beta.check-mot.service.gov.uk/trade/vehicles/mot-tests`

**Method**: GET

**Headers:**
```
x-api-key: {your_api_key}
Accept: application/json+v6
```

**Query Parameters:**
```
registration={REGISTRATION_NUMBER}
```

## Response Format

### Successful Response

Array of MOT test records, newest first:

```json
[
  {
    "motTestNumber": "123456789",
    "completedDate": "2024-07-15 10:23:45",
    "testResult": "PASSED",
    "expiryDate": "2025-07-14",
    "odometerValue": "45678",
    "odometerUnit": "mi",
    "odometerResultType": "READ",
    "rfrAndComments": [
      {
        "text": "Nearside Front Tyre worn close to legal limit (5.2.3 (e))",
        "type": "ADVISORY",
        "dangerous": false
      }
    ]
  },
  {
    "motTestNumber": "987654321",
    "completedDate": "2023-07-20 14:15:30",
    "testResult": "FAILED",
    "expiryDate": null,
    "odometerValue": "32145",
    "odometerUnit": "mi",
    "rfrAndComments": [
      {
        "text": "Nearside Front Brake disc excessively pitted (1.1.14 (a) (ii))",
        "type": "FAIL",
        "dangerous": false
      },
      {
        "text": "Offside Front Suspension component ball joint excessively worn (5.3.4 (a) (i))",
        "type": "FAIL",
        "dangerous": true
      }
    ]
  }
]
```

### Error Responses

**404 Not Found:**
```json
{
  "error": "Vehicle not found",
  "message": "No MOT history found for this registration."
}
```

**API Not Configured:**
```json
{
  "error": "MOT API not configured",
  "message": "MOT history is not available at this time."
}
```

## MOT Test Record Fields

| Field | Type | Description |
|-------|------|-------------|
| `motTestNumber` | String | Unique test certificate number |
| `completedDate` | String | Test completion date/time |
| `testResult` | String | PASSED or FAILED |
| `expiryDate` | String | Certificate expiry date (YYYY-MM-DD) |
| `odometerValue` | String | Mileage at test |
| `odometerUnit` | String | mi (miles) or km |
| `odometerResultType` | String | READ or NOT_READABLE |
| `rfrAndComments` | Array | Reasons for rejection and advisories |

## RFR and Comments Fields

| Field | Type | Description |
|-------|------|-------------|
| `text` | String | Issue description |
| `type` | String | FAIL, ADVISORY, USER_ENTERED, MINOR |
| `dangerous` | Boolean | If failure is dangerous defect |

### Comment Types

- **FAIL**: Reasons for test failure
- **ADVISORY**: Items that need attention but passed
- **MINOR**: Minor defects recorded
- **USER_ENTERED**: Additional notes from tester

## Usage in Application

### DVLA Lookup Integration

The MOT History API is integrated into the DVLA Lookup page:

**Route**: `/dvla-lookup`

**Features:**
1. Enter vehicle registration
2. Fetch DVLA data (make, model, etc.)
3. Automatically fetch MOT history
4. Display side-by-side

**Benefits:**
- Complete vehicle information in one place
- Historical maintenance records
- Advisory items for proactive service

### Display Format

**MOT History Card:**
- Chronological list of all tests
- Color-coded test results:
  - 🟢 PASSED (green badge)
  - 🔴 FAILED (red badge)
- Key information per test:
  - Test date and expiry
  - Mileage reading
  - Test certificate number
  
**Issues & Advisories:**
- Color-coded by severity:
  - 🔴 FAIL (red) - Test failures
  - 🟡 ADVISORY (yellow) - Items needing attention
  - 🔵 MINOR (blue) - Minor defects
- Full text descriptions
- Reference codes for further research

## Example Usage

### In Livewire Component

```php
public function lookup()
{
    // Get DVLA data
    $this->vehicleData = app(DVLA::class)
        ->getVehicleDetails($registration);
    
    // Get MOT history
    $motService = app(MOT::class);
    $motData = $motService->getMOTHistory($registration);
    
    if (!isset($motData['error'])) {
        $this->motHistory = $motData;
    }
}
```

### Handling No MOT Data

```php
@if($motHistory)
    {{-- Display MOT history --}}
@elseif($vehicleData)
    <p>MOT history not available. Vehicle may be:</p>
    <ul>
        <li>New (no MOT due yet)</li>
        <li>Exempt from MOT</li>
        <li>Not in MOT database</li>
    </ul>
@endif
```

## Vehicle MOT Exemptions

Some vehicles are exempt from MOT:

### Age Exemptions
- Vehicles over 40 years old (historic vehicles)
- First registered before 1960 (no MOT required)

### Type Exemptions
- Goods vehicles over 3,000kg
- Agricultural vehicles
- Electric goods vehicles
- Vehicles with trade licenses

**Application Behavior:**
- Gracefully handles "no MOT history" scenarios
- Displays helpful message
- Doesn't treat as error

## Rate Limiting

**MOT API Limits:**
- **Free Tier**: Limited requests per day
- **Trade API**: Higher limits for businesses
- Consult DVSA documentation for current limits

**Application Protection:**
- Laravel rate limiting on routes
- Graceful error handling
- Caching strategy (future enhancement)

## Error Handling

### Service-Level Handling

```php
try {
    $response = Http::withHeaders([...])->get(...);
    
    if ($response->successful()) {
        return $response->json();
    }
    
    if ($response->status() === 404) {
        return [
            'error' => 'Vehicle not found',
            'message' => 'No MOT history found'
        ];
    }
} catch (Exception $e) {
    Log::error('MOT API Error', [
        'registration' => $registration,
        'error' => $e->getMessage()
    ]);
    
    return [
        'error' => 'API Error',
        'message' => $e->getMessage()
    ];
}
```

### Application-Level Handling

- **Missing API Key**: Warning logged, returns error array
- **Network Errors**: Logged and handled gracefully
- **Invalid Registration**: Returns "not found" message
- **Rate Limit**: Logged for monitoring

## Data Insights

### MOT History Analysis

From MOT history, you can identify:

**Service History Patterns:**
- Regular testing (annual MOT)
- Mileage progression
- Maintenance quality

**Common Issues:**
- Recurring failures
- Advisory items becoming failures
- Dangerous defects

**Vehicle Condition:**
- Test pass/fail ratio
- Types of failures
- Mileage consistency

**Customer Service Opportunities:**
- Address advisory items before next MOT
- Proactive brake/tyre service
- Service scheduling based on mileage

## API Access

### Obtaining an API Key

1. Visit: https://documentation.history.mot.api.gov.uk
2. Register for trade API access
3. Receive API key
4. Add to `.env` file

### API Documentation

Full official documentation:
- https://documentation.history.mot.api.gov.uk/mot-history-api/latest/overview/

## Best Practices

### Caching

MOT history doesn't change frequently:

```php
// Cache for 1 day
Cache::remember("mot_history_{$registration}", now()->addDay(), function () use ($registration) {
    return app(MOT::class)->getMOTHistory($registration);
});
```

### Display Strategy

**Most Recent Test First:**
- Sort by completedDate DESC
- Highlight latest expiry date
- Show mileage progression

**Advisory Tracking:**
- Highlight recurring advisories
- Track items becoming failures
- Service planning opportunities

### Error Messages

Be helpful when data isn't available:
```
"MOT history not available. This could mean:
- The vehicle is new and hasn't had its first MOT
- The vehicle is exempt from MOT testing  
- The MOT API is temporarily unavailable"
```

## Integration with Other Systems

### With DVLA Data

Combine for complete picture:
```
DVLA Data:          MOT Data:
- Make/Model        - Test History
- Tax Status        - Mileage Progression
- Current MOT       - Failure Reasons
                    - Advisory Items
```

### With Haynes Pro

Use MOT failures to:
- Look up repair procedures
- Find component specifications
- Access diagnostic information
- Get service schedules

### With Customer Records

Link MOT data to:
- Service history
- Upcoming service needs
- Customer communication
- Proactive maintenance

## Logging

MOT API interactions are logged:

```php
Log::info('MOT API: Starting MOT history lookup', [
    'registration' => $registrationNumber
]);

Log::info('MOT API: Successfully retrieved MOT history', [
    'registration' => $registrationNumber,
    'tests_count' => count($data)
]);
```

**Log Location**: `storage/logs/laravel.log`

## Troubleshooting

### Common Issues

**Issue**: "MOT history not available"
- **Cause**: Vehicle exempt or new
- **Solution**: Display informative message

**Issue**: "API Error" returned
- **Cause**: Network timeout, API down
- **Solution**: Retry logic, user notification

**Issue**: Empty array returned
- **Cause**: Vehicle never had MOT
- **Solution**: Check if vehicle is < 3 years old

## Security & Privacy

### Public Information
- MOT history is public data
- No personal information included
- Vehicle keeper details NOT available
- Safe to display to users

### GDPR Compliance
- No personal data processing
- Public records only
- Audit logging for transparency

## Testing

### Test with Known Vehicles

Use DVLA test registration:
```bash
php artisan dvla:test AB12CDE
```

This will also attempt MOT lookup.

### Manual Testing

1. Access `/dvla-lookup`
2. Enter registration: `AB12CDE`
3. Verify both DVLA and MOT data displayed
4. Check error handling with invalid registration

## Related Documentation

- [DVLA API](dvla-api.md) - Vehicle registration lookups
- [Haynes Pro API](haynes-pro-api.md) - Technical repair data
- [Application Overview](../overview.md) - System architecture
