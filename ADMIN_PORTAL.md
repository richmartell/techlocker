# Admin Portal Documentation

## Overview

The Admin Portal is a separate administration area for managing accounts, users, plans, and trials across the entire GarageIQ system.

## Access

### Admin Login
- **URL**: `/admin/login`
- **Default Credentials**:
  - Email: `admin@garageiq.com`
  - Password: `password`

**⚠️ IMPORTANT**: Change the default password immediately after first login by updating it in the database.

### Authentication
- Admin authentication is completely separate from regular user authentication
- Admins use a separate guard (`admin`) and session
- Admins cannot access regular user areas and vice versa

## Features

### 1. Dashboard (`/admin/dashboard`)
High-level statistics about the system:
- Total number of accounts
- Total number of users across all accounts
- Active trials count
- Expired trials count
- Converted trials count
- Accounts with assigned plans

### 2. Accounts Management (`/admin/accounts`)

#### Accounts List
- View all accounts in the system
- Pagination (20 accounts per page)
- Search by company name or email
- Filter by:
  - Trial Status (Active, Expired, Converted, No Trial)
  - Plan (Starter, Professional, Enterprise, No Plan)
- Sort by company name or creation date

#### Account Details (`/admin/accounts/{id}`)
View detailed information about a specific account:
- Company information (name, email, phone, address)
- Statistics (users, customers, vehicles)
- Plan information
- Trial information (start date, end date, days remaining, status)
- List of all users associated with the account

### 3. Plans System

Three default plans are created:
1. **Starter** ($29.99/month)
   - 3 users
   - 50 customers
   - 100 searches

2. **Professional** ($79.99/month)
   - 10 users
   - 200 customers
   - 500 searches

3. **Enterprise** ($149.99/month)
   - Unlimited users
   - Unlimited customers
   - Unlimited searches

### 4. Trials System

Each account can have a 14-day trial with three statuses:
- **Active**: Trial is currently active and hasn't expired
- **Expired**: Trial period has ended
- **Converted**: Trial was converted to a paid subscription

## Database Schema

### New Tables

#### `admins`
- `id`
- `name`
- `email` (unique)
- `password` (hashed)
- `is_active`
- `email_verified_at`
- `remember_token`
- `created_at`, `updated_at`

#### `plans`
- `id`
- `name`
- `description`
- `price` (decimal)
- `max_users` (nullable for unlimited)
- `max_customers` (nullable for unlimited)
- `max_searches` (nullable for unlimited)
- `is_active`
- `created_at`, `updated_at`

### Updated Tables

#### `accounts`
Added fields:
- `plan_id` (foreign key to plans)
- `trial_started_at`
- `trial_ends_at` (already existed)
- `trial_status` (enum: active, expired, converted)
- `subscribed_at`

## Models

### Admin Model
Location: `app/Models/Admin.php`
- Extends `Authenticatable`
- Uses `HasFactory`, `Notifiable` traits
- Password is automatically hashed

### Plan Model
Location: `app/Models/Plan.php`
- Relationship: `hasMany(Account::class)`

### Account Model (Updated)
Location: `app/Models/Account.php`
- New relationship: `belongsTo(Plan::class)`
- Helper methods:
  - `isOnTrial()`: Check if account is currently on an active trial
  - `hasExpiredTrial()`: Check if trial has expired
  - `trialDaysRemaining()`: Get number of days left in trial

## Routes

### Admin Routes File
Location: `routes/admin.php`

- `GET /admin/login` - Admin login page
- `POST /admin/logout` - Admin logout
- `GET /admin/dashboard` - Admin dashboard (requires auth)
- `GET /admin/accounts` - Accounts list (requires auth)
- `GET /admin/accounts/{id}` - Account details (requires auth)

## Livewire Components

1. **Admin\Auth\Login** - Admin login form
2. **Admin\Dashboard** - Dashboard with statistics
3. **Admin\Accounts\Index** - Accounts list with filtering/pagination
4. **Admin\Accounts\Show** - Account details page

## Middleware

**AdminAuthenticate** (`app/Http/Middleware/AdminAuthenticate.php`)
- Checks if admin is logged in using `admin` guard
- Checks if admin account is active
- Redirects to login if not authenticated

## Layouts

### Admin Layout
Location: `resources/views/components/layouts/admin.blade.php`
- Navigation with Dashboard and Accounts links
- Admin profile dropdown
- Logout functionality
- Uses Flux UI components

### Guest Layout
Location: `resources/views/components/layouts/guest.blade.php`
- Minimal layout for login page
- No navigation

## Security Notes

1. **Change Default Password**: The default admin password (`password`) should be changed immediately
2. **Admin Access**: Only system administrators should have access to the admin portal
3. **Separate Authentication**: Admin and user sessions are completely separate
4. **Active Status**: Inactive admin accounts cannot log in

## Future Enhancements

Potential additions to consider:
- Plan creation/editing interface
- Trial management (start trial, extend trial, convert to paid)
- Account creation/editing
- User impersonation
- Activity logs
- Email notifications for trial expiration
- Billing integration
- Reports and analytics
- Plan limits enforcement

## Seeders

### PlanSeeder
Location: `database/seeders/PlanSeeder.php`
- Creates 3 default plans
- Can be run multiple times (uses `firstOrCreate`)

### AdminSeeder
Location: `database/seeders/AdminSeeder.php`
- Creates default admin user
- Can be run multiple times (uses `firstOrCreate`)

To run seeders:
```bash
sail artisan db:seed --class=PlanSeeder
sail artisan db:seed --class=AdminSeeder
```

## Testing

To test the admin portal:
1. Navigate to `/admin/login`
2. Login with default credentials
3. Explore the dashboard
4. View accounts list
5. Click on an account to see details
6. Test filtering and sorting
7. Logout

## Support

For issues or questions about the admin portal, please contact the development team.

