# DVLA Vehicle Enquiry API Integration

## Overview

The DVLA (Driver and Vehicle Licensing Agency) Vehicle Enquiry Service provides access to UK vehicle registration data. GarageIQ integrates this API to offer real-time vehicle lookups.

## Configuration

### Environment Variables

```env
DVLA_API_KEY=your_api_key_here
```

### Service Configuration

Located in `config/services.php`:

```php
'dvla' => [
    'api_key' => env('DVLA_API_KEY'),
    'endpoint' => env('DVLA_API_ENDPOINT', 'https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles'),
],
```

## Service Class

**Location**: `app/Services/DVLA.php`

### Methods

#### `getVehicleDetails(string $registrationNumber): array`

Retrieves complete vehicle information from DVLA database.

**Parameters:**
- `$registrationNumber` - UK vehicle registration (e.g., "AB12CDE")

**Returns:** Array of vehicle data

**Throws:** `Exception` on API failure

## API Endpoint

**URL**: `https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles`

**Method**: POST

**Headers:**
```
x-api-key: {your_api_key}
Content-Type: application/json
```

**Request Body:**
```json
{
  "registrationNumber": "AB12CDE"
}
```

## Response Format

### Successful Response

```json
{
  "registrationNumber": "AB12CDE",
  "taxStatus": "Taxed",
  "taxDueDate": "2025-03-01",
  "artEndDate": "2025-03-01",
  "motStatus": "Valid",
  "motExpiryDate": "2025-07-15",
  "make": "VOLKSWAGEN",
  "model": "GOLF",
  "colour": "SILVER",
  "fuelType": "DIESEL",
  "yearOfManufacture": 2019,
  "engineCapacity": 1968,
  "co2Emissions": 112,
  "euroStatus": "EURO 6",
  "markedForExport": false,
  "realDrivingEmissions": "1",
  "typeApproval": "M1",
  "dateOfLastV5CIssued": "2019-06-15",
  "wheelplan": "2 AXLE RIGID BODY",
  "revenueWeight": 1980
}
```

### Error Responses

**404 Not Found:**
```json
{
  "errors": [{
    "code": "ENQ_404",
    "title": "Vehicle not found",
    "detail": "No vehicle found with registration AB12CDE"
  }]
}
```

**400 Bad Request:**
```json
{
  "errors": [{
    "code": "ENQ_400",
    "title": "Bad Request",
    "detail": "Invalid registration number format"
  }]
}
```

**403 Forbidden:**
```json
{
  "errors": [{
    "code": "ENQ_403",
    "title": "Forbidden",
    "detail": "Invalid API key"
  }]
}
```

## Data Fields

| Field | Type | Description |
|-------|------|-------------|
| `registrationNumber` | String | Vehicle registration mark |
| `taxStatus` | String | Current tax status (Taxed, SORN, Untaxed) |
| `taxDueDate` | String | Date tax is due (YYYY-MM-DD) |
| `motStatus` | String | MOT status (Valid, Not valid, No details) |
| `motExpiryDate` | String | MOT expiry date (YYYY-MM-DD) |
| `make` | String | Vehicle manufacturer |
| `model` | String | Vehicle model |
| `colour` | String | Primary color |
| `fuelType` | String | Fuel type (PETROL, DIESEL, ELECTRIC, etc.) |
| `yearOfManufacture` | Integer | Year manufactured |
| `engineCapacity` | Integer | Engine size in cc |
| `co2Emissions` | Integer | CO2 emissions in g/km |
| `euroStatus` | String | Euro emissions standard |
| `markedForExport` | Boolean | Export marker flag |
| `typeApproval` | String | Vehicle type approval category |
| `wheelplan` | String | Axle/wheel configuration |
| `revenueWeight` | Integer | Weight in kg |

## Usage in Application

### DVLA Lookup Page

**Route**: `/dvla-lookup`
**Component**: `App\Livewire\Vehicles\DvlaLookup`

**Features:**
- Enter registration number
- Real-time API lookup
- Display all DVLA fields
- Show MOT history (if available)
- Error handling and validation

### Admin Portal Integration

**Location**: Admin Portal → Accounts → View Account → Users

**Features:**
- "DVLA Lookup" button for each user
- Opens in new tab/window
- Quick vehicle verification
- Useful for account support

## Testing

### Artisan Command

Test the DVLA API connection:

```bash
# Use default test registration
php artisan dvla:test

# Specific registration
php artisan dvla:test AB12CDE

# With custom API key
php artisan dvla:test AB12CDE --key=your-api-key-here
```

**Output:**
- API key validation
- Request/response timing
- Complete vehicle data
- Full JSON response
- Error messages (if any)

### Test Registrations

DVLA provides test registrations for API testing:
- `AB12CDE` - Standard test vehicle
- Contact DVLA for additional test data

## Rate Limiting

**DVLA API Limits:**
- **Free Tier**: Limited requests per month
- **Paid Tier**: Higher limits available
- **Rate**: Varies by subscription

**Application Rate Limiting:**
- Laravel rate limiting on routes
- 60 requests per minute per user
- Prevents API quota exhaustion

## Error Handling

### Application-Level Errors

```php
try {
    $vehicleData = $dvlaService->getVehicleDetails($registration);
} catch (\Exception $e) {
    // Log error
    Log::error('DVLA API Error', [
        'registration' => $registration,
        'error' => $e->getMessage()
    ]);
    
    // Display user-friendly message
    $this->error = 'Unable to retrieve vehicle information';
}
```

### Common Errors

**Invalid Registration:**
- User enters malformed registration
- Solution: Client-side validation, format hints

**Vehicle Not Found:**
- Registration doesn't exist in DVLA database
- Solution: Clear message, suggest verification

**API Key Issues:**
- Invalid, expired, or missing API key
- Solution: Check environment configuration

**Rate Limit Exceeded:**
- Too many requests
- Solution: Implement request throttling

## API Key Management

### Obtaining an API Key

1. Visit: https://developer-portal.driver-vehicle-licensing.api.gov.uk
2. Create account
3. Register application
4. Obtain API key
5. Add to `.env` file

### Key Suspension Prevention

**DVLA Policy:**
- Keys unused for 30+ days may be suspended
- Requires activity to remain active

**Prevention:**
Run regular test:
```bash
php artisan dvla:test
```

Set up scheduled task (optional):
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Keep DVLA API key active
    $schedule->command('dvla:test')->monthly();
}
```

## Logging

All DVLA API interactions are logged:

```php
Log::info('DVLA API: Starting vehicle lookup', [
    'registration' => $registrationNumber,
]);

Log::info('DVLA API: Successfully retrieved vehicle details', [
    'registration' => $registrationNumber,
    'make' => $data['make'],
    'model' => $data['model'],
]);

Log::error('DVLA API: Request failed', [
    'registration' => $registrationNumber,
    'status' => $response->status(),
]);
```

**Log Location**: `storage/logs/laravel.log`

## Best Practices

### Caching

Consider caching DVLA responses:
```php
Cache::remember("dvla_vehicle_{$registration}", now()->addDays(7), function () use ($registration) {
    return $dvlaService->getVehicleDetails($registration);
});
```

### Input Sanitization

Always clean registration input:
```php
$cleanReg = strtoupper(str_replace(' ', '', $registration));
```

### User Feedback

Provide clear loading states:
- Show spinner during lookup
- Display progress messages
- Handle timeouts gracefully

## Related APIs

- [MOT History API](mot-api.md) - Complementary vehicle test data
- [Haynes Pro VRM API](haynes-pro-api.md#vrm-lookup) - Alternative vehicle identification

## Support

### DVLA Support
- Developer Portal: https://developer-portal.driver-vehicle-licensing.api.gov.uk
- Email: VESAPISupport@dvla.gov.uk
- Documentation: Available in developer portal

### Troubleshooting

**Issue**: "API key not configured"
- **Solution**: Add `DVLA_API_KEY` to `.env`

**Issue**: "Vehicle not found"
- **Solution**: Verify registration is valid UK format

**Issue**: "Request failed with status 403"
- **Solution**: Check API key is valid and active

**Issue**: "Rate limit exceeded"
- **Solution**: Implement request throttling, upgrade API tier

## Security

### API Key Protection
- Never commit API keys to version control
- Use environment variables only
- Rotate keys periodically
- Monitor usage for anomalies

### Data Privacy
- DVLA data is public information
- No personal owner data included
- GDPR compliant (public records)
- Log access for audit purposes
