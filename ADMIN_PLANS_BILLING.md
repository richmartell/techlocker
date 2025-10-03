# Admin Portal - Plans & Billing Documentation

## Overview

This document covers the Plans Management and Billing/Invoices sections added to the Admin Portal.

---

## Plans Management

### Overview
Manage subscription plans that accounts can be assigned to. Each plan defines limits for users, customers, and searches.

### Access
- **URL**: `/admin/plans`
- Navigate from Admin Dashboard or use the "Plans" link in the navigation

### Features

#### 1. Plans List (`/admin/plans`)
- View all plans in a card grid layout
- See plan details at a glance:
  - Plan name and description
  - Monthly price
  - Number of accounts using this plan
  - Active/Inactive status
  - Resource limits (users, customers, searches)
- **Actions**:
  - Edit plan details
  - Activate/Deactivate plans

#### 2. Create Plan (`/admin/plans/create`)
Create new subscription plans with:
- **Basic Information**:
  - Plan name (required)
  - Description (optional)
  - Monthly price in GBP (required)
- **Plan Limits**:
  - Maximum users (leave empty for unlimited)
  - Maximum customers (leave empty for unlimited)
  - Maximum searches per month (leave empty for unlimited)
- **Active Status**: Toggle if plan is available for new subscriptions

#### 3. Edit Plan (`/admin/plans/{id}/edit`)
Update existing plan details with the same form as create.

**Note**: Changing plan limits will not affect existing accounts immediately. You may want to implement enforcement logic in your application.

### Default Plans

Three plans are created by the seeder:

1. **Starter** - £24.99/month
   - 3 users
   - 50 customers
   - 100 searches/month

2. **Professional** - £64.99/month
   - 10 users
   - 200 customers
   - 500 searches/month

3. **Enterprise** - £124.99/month
   - Unlimited users
   - Unlimited customers
   - Unlimited searches

---

## Billing & Invoices

### Overview
Track and manage all invoices across all accounts in the system. Monitor revenue, pending payments, and overdue invoices.

### Access
- **URL**: `/admin/invoices`
- Navigate from Admin Dashboard or use the "Billing" link in the navigation

### Features

#### Dashboard Statistics
Three key metrics displayed at the top:

1. **Total Revenue**: Sum of all paid invoices
2. **Pending Revenue**: Sum of all pending invoices
3. **Overdue Invoices**: Count of pending invoices past their due date

#### Invoices List

**Display Information**:
- Invoice number (e.g., INV-001000)
- Account name (clickable link to account details)
- Associated plan
- Invoice amount
- Issue date
- Due date (with overdue indicator)
- Status badge (color-coded)
- Actions button

**Filtering**:
- Search by invoice number or account name
- Filter by status:
  - All Statuses
  - Pending
  - Paid
  - Failed
  - Refunded
  - Cancelled

**Pagination**: 20 invoices per page

#### Invoice Statuses

| Status | Description | Badge Color |
|--------|-------------|-------------|
| Draft | Invoice created but not sent | Zinc |
| Pending | Invoice sent, awaiting payment | Yellow |
| Paid | Payment received | Green |
| Failed | Payment attempt failed | Red |
| Refunded | Payment was refunded | Zinc |
| Cancelled | Invoice cancelled | Zinc |

---

## Database Schema

### Invoices Table

```php
Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique();
    $table->foreignId('account_id')->constrained()->cascadeOnDelete();
    $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();
    $table->decimal('amount', 10, 2);
    $table->enum('status', ['draft', 'pending', 'paid', 'failed', 'refunded', 'cancelled'])->default('pending');
    $table->date('issue_date');
    $table->date('due_date');
    $table->date('paid_at')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

### Relationships

**Invoice Model**:
- `belongsTo(Account::class)` - The account being billed
- `belongsTo(Plan::class)` - The plan being billed for

**Account Model** (updated):
- `hasMany(Invoice::class)` - All invoices for this account

**Plan Model** (no changes needed):
- Already has `hasMany(Account::class)`

---

## Models

### Invoice Model
Location: `app/Models/Invoice.php`

**Key Methods**:
- `isOverdue()`: Check if invoice is pending and past due date
- `getStatusColorAttribute()`: Get the badge color for the status

**Casts**:
- `amount`: decimal:2
- `issue_date`: date
- `due_date`: date
- `paid_at`: date

### Plan Model (Updated)
Location: `app/Models/Plan.php`

**Relationships**:
- `accounts()`: Get all accounts on this plan

---

## Livewire Components

### Plans Management

1. **Admin\Plans\Index**
   - Location: `app/Livewire/Admin/Plans/Index.php`
   - Lists all plans with account counts
   - Toggle plan active status

2. **Admin\Plans\Upsert**
   - Location: `app/Livewire/Admin/Plans/Upsert.php`
   - Create and edit plans
   - Form validation
   - Handles unlimited limits (null values)

### Invoices Management

1. **Admin\Invoices\Index**
   - Location: `app/Livewire/Admin/Invoices/Index.php`
   - Lists all invoices with filtering
   - Calculates revenue statistics
   - Pagination support

---

## Routes

### Plans Routes
```php
Route::get('/admin/plans', Index::class)->name('admin.plans.index');
Route::get('/admin/plans/create', Upsert::class)->name('admin.plans.create');
Route::get('/admin/plans/{plan}/edit', Upsert::class)->name('admin.plans.edit');
```

### Invoices Routes
```php
Route::get('/admin/invoices', Index::class)->name('admin.invoices.index');
```

---

## Navigation Updates

The admin navigation has been updated to include:
- **Plans** link (Desktop & Mobile)
- **Billing** link (Desktop & Mobile)

Both desktop navbar and mobile sidebar now show:
1. Dashboard
2. Accounts
3. Plans
4. Billing

---

## Sample Data

### Plan Seeder

Three default plans are created with prices in GBP:
- **Starter**: £24.99/mo
- **Professional**: £64.99/mo
- **Enterprise**: £124.99/mo

### Invoice Seeder

To generate sample invoice data for testing:

```bash
sail artisan db:seed --class=InvoiceSeeder
```

This creates:
- 3-5 invoices per account (for first 5 accounts)
- Random statuses (paid, pending, failed, refunded)
- Realistic dates (1-6 months ago)
- Invoice numbers in format: INV-001000, INV-001001, etc.
- All amounts in British pounds (£)

---

## Usage Examples

### Creating a New Plan

1. Navigate to `/admin/plans`
2. Click "Create Plan"
3. Fill in:
   - Name: "Premium"
   - Description: "For large workshops"
   - Price: 164.99 (in GBP)
   - Max Users: 25
   - Max Customers: 500
   - Max Searches: 2000
   - Check "Plan is active"
4. Click "Create Plan"

### Editing an Existing Plan

1. Go to `/admin/plans`
2. Click "Edit" on any plan card
3. Update desired fields
4. Click "Update Plan"

### Viewing Billing Information

1. Navigate to `/admin/invoices`
2. See total revenue, pending revenue, and overdue count
3. Use filters to narrow down invoices
4. Click on account name to see account details

### Filtering Invoices

1. On `/admin/invoices`:
2. Enter search term in search box (invoice # or account name)
3. Select status from dropdown
4. Results update automatically

---

## Future Enhancements

Potential additions to consider:

### Plans
- [ ] Plan usage analytics
- [ ] Automated plan enforcement (block actions when limits exceeded)
- [ ] Plan upgrade/downgrade workflows
- [ ] Plan feature flags (enable/disable specific features per plan)
- [ ] Plan comparison view
- [ ] Historical plan changes tracking

### Invoices
- [ ] Invoice detail page with line items
- [ ] Generate PDF invoices
- [ ] Email invoices to accounts
- [ ] Payment gateway integration (Stripe, PayPal)
- [ ] Automated recurring billing
- [ ] Payment reminders for pending/overdue invoices
- [ ] Bulk invoice operations
- [ ] Invoice notes and comments
- [ ] Credit notes/adjustments
- [ ] Payment history per account
- [ ] Revenue reports and charts
- [ ] Export invoices to CSV/Excel

### Billing Dashboard
- [ ] Revenue trends chart
- [ ] MRR (Monthly Recurring Revenue) tracking
- [ ] Churn rate calculation
- [ ] Payment success rate
- [ ] Average revenue per account

---

## Testing Checklist

### Plans Management
- [ ] Create a new plan
- [ ] Edit an existing plan
- [ ] Toggle plan active/inactive status
- [ ] Verify unlimited limits work (leave fields empty)
- [ ] Check validation errors display correctly
- [ ] Verify account count displays correctly

### Invoices & Billing
- [ ] View all invoices
- [ ] Search for specific invoice
- [ ] Filter by status
- [ ] Verify statistics are accurate
- [ ] Check overdue indicator shows correctly
- [ ] Click account link navigates to account details
- [ ] Verify pagination works

### Navigation
- [ ] Plans link works in desktop nav
- [ ] Billing link works in desktop nav
- [ ] Plans link works in mobile nav
- [ ] Billing link works in mobile nav
- [ ] Active state highlights correctly

---

## API Integration (Future)

If you need to integrate with a billing service like Stripe:

1. **Plans**: Sync with Stripe Products/Prices
2. **Invoices**: Import from Stripe Invoices
3. **Webhooks**: Handle payment events automatically
4. **Subscriptions**: Link accounts to Stripe subscriptions

---

## Troubleshooting

### No plans showing up
Run the seeder: `sail artisan db:seed --class=PlanSeeder`

### No invoices showing up
1. Make sure accounts exist
2. Make sure plans exist
3. Run: `sail artisan db:seed --class=InvoiceSeeder`

### Plan limits not enforced
The current implementation only displays limits. You need to add enforcement logic in your application where users perform actions (creating users, customers, searches).

### Revenue statistics showing 0
Make sure you have invoices with "paid" status. Run the invoice seeder or manually update some invoice statuses to "paid".

---

## Security Notes

1. **Admin Only**: Only authenticated admins can access plans and billing
2. **No Account Access**: Accounts cannot see or access billing information yet
3. **Plan Changes**: Changing plan limits doesn't automatically enforce them
4. **Invoice Creation**: Currently manual - implement automated billing for production

---

## Support

For issues or questions about Plans and Billing features:
- Check the main `ADMIN_PORTAL.md` documentation
- Review the Livewire component code
- Check the Laravel logs: `storage/logs/laravel.log`

---

## Summary

You now have a complete Plans and Billing management system in your admin portal:

✅ Create, edit, and manage subscription plans
✅ View and filter all invoices
✅ Track revenue and overdue payments
✅ Beautiful Flux UI implementation
✅ Responsive design
✅ Full navigation integration
✅ Sample data seeder for testing

The system is ready to be extended with payment gateway integration, automated billing, and more advanced features as needed.

