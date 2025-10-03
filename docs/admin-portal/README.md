# Admin Portal Documentation

## Overview

The Admin Portal is the central control system for GarageIQ, providing complete oversight of all workshop accounts, resellers, subscription plans, and billing operations.

## Access

- **URL**: `http://localhost/admin/login`
- **Default Credentials**: `admin@garageiq.com` / `password`
- **Authentication Guard**: `admin`

## Dashboard

The admin dashboard provides a high-level overview of the entire system:

### Key Metrics Displayed

**Account Statistics:**
- Total Accounts created
- Total Users across all accounts
- Active Trials (currently in 14-day period)
- Expired Trials (not converted)
- Converted Trials (now paying customers)
- Accounts with Plans assigned
- Churned Accounts (cancelled subscriptions)

**Quick Actions:**
- Navigate to Accounts Management
- Navigate to Plans Management
- Navigate to Billing/Invoices
- Navigate to Resellers Management

## Accounts Management

**Route**: `/admin/accounts`

### Features

#### Account Listing
- Paginated table of all workshop accounts
- Sortable by: Company Name, Created Date
- Real-time status badges with color coding:
  - 🟢 **Trial** (lime) - Active trial period
  - 🟢 **Active** (green) - Paying customer
  - 🟠 **Trial Expired** (orange) - Trial ended without conversion
  - 🔴 **Churned** (red) - Was active but cancelled

#### Search & Filters
- **Search**: Company name or email
- **Status Filter**: Trial, Active, Trial Expired, Churned, or All
- **Plan Filter**: Filter by subscription plan or "No Plan"

#### Account Details View

**Route**: `/admin/accounts/{id}`

Shows comprehensive account information:

**Basic Information:**
- Company name and contact details
- Registration address
- Phone, email, website
- Account status and creation date

**Statistics:**
- Number of users
- Number of customers
- Number of vehicles tracked

**Plan & Trial Information:**
- Current subscription plan (if any)
- Trial status and dates
- Trial days remaining (for active trials)
- Subscription start date (for converted accounts)

**Users Table:**
- List of all users for this account
- Name, Email, Role
- Join date and status
- **Actions**: DVLA Lookup button (opens vehicle lookup in new tab)

## Resellers Management

**Route**: `/admin/resellers`

### Reseller Listing

**Features:**
- Complete list of all resellers
- Search by name, email, or company
- Filter by Active/Inactive status
- View account count per reseller
- View total commission earned

**Table Columns:**
- Reseller contact name and email
- Company name
- Number of accounts created
- Commission rate (%)
- Total commissions earned (£)
- Active/Inactive status
- Actions (View, Activate/Deactivate)

### Create New Reseller

**Route**: `/admin/resellers/create`

**Form Fields:**

*Contact Information:*
- Contact Name (required) - Main contact person
- Email Address (required) - Login email (must be unique)
- Phone Number (optional)

*Company Information:*
- Company Name (required)

*Commission Settings:*
- Commission Rate (required, 0-100%) - Percentage of subscription
- Active Status (checkbox) - Enable/disable account

**Process:**
1. Admin fills in reseller details
2. System generates secure temporary password
3. Reseller account created
4. Email notification sent (future: with login instructions)
5. Redirects to reseller detail page

### Reseller Details View

**Route**: `/admin/resellers/{id}`

**Left Panel - Reseller Information:**

*Contact Details:*
- Name, Email, Company
- Phone number
- Active/Inactive status
- Commission rate (large display)
- Member since date

*Performance Metrics:*
- Trials Created (total count)
- Trials Converted (to active)
- Conversion Rate (percentage)

**Right Panel - Financial & Account Data:**

*Commission Summary Cards:*
- **Total Earned**: All-time commission total
- **Paid Out**: Commissions already paid (green)
- **Pending**: Awaiting payment (orange)

*Customer Accounts Table:*
- All accounts created by this reseller
- Company name (clickable link to account details)
- Status badges (Trial, Active, Trial Expired, Churned)
- Plan information
- Number of users
- Creation date

*Commission Payments Table:*
- Individual commission records
- Account name (clickable link)
- Amount (£)
- Status (Paid/Pending/Cancelled)
- Date earned
- Date paid (if applicable)

**Actions:**
- Activate/Deactivate reseller
- Back to resellers list

## Plans Management

**Route**: `/admin/plans`

### Plan Cards

Plans displayed as cards showing:
- Plan name and description
- Monthly price (£)
- Resource limits:
  - Max Users
  - Max Customers  
  - Max Searches per month
- Active/Inactive status
- Number of accounts on plan

**Actions per Plan:**
- Edit plan details
- Activate/Deactivate plan

### Create/Edit Plan

**Route**: `/admin/plans/create` or `/admin/plans/{id}/edit`

**Form Fields:**
- Plan Name (required)
- Description (optional)
- Monthly Price (£, required)
- Max Users (required, integer)
- Max Customers (required, integer)
- Max Searches (required, integer per month)
- Active Status (checkbox)

**Default Plans:**
- **Starter**: £29.99/mo - 2 users, 50 customers, 100 searches
- **Professional**: £79.99/mo - 5 users, 200 customers, 500 searches
- **Enterprise**: £149.99/mo - 15 users, unlimited customers/searches

## Invoices & Billing

**Route**: `/admin/invoices`

### Dashboard Metrics

**Summary Cards:**
- Total Revenue (all invoices)
- Pending Revenue (unpaid invoices)
- Overdue Count (past due date)

### Invoice Listing

**Table Columns:**
- Invoice Number (auto-generated)
- Account name (clickable link)
- Plan name
- Amount (£)
- Status badge (Paid/Pending/Cancelled/Overdue)
- Issue Date
- Due Date
- Paid Date (if paid)

**Filters:**
- Search by invoice number or account
- Filter by status: All, Paid, Pending, Overdue, Cancelled

**Color Coding:**
- 🟢 Paid (green)
- 🟡 Pending (yellow)
- 🔴 Overdue (red)
- ⚫ Cancelled (gray)

## Administrative Actions

### Account Management Actions
- **View Account Details**: Full account information and statistics
- **Access User List**: See all users with DVLA lookup access
- **Monitor Trial Status**: Track trial periods and expirations
- **Change Account Status**: Mark as active, churned, etc. (manual override)

### Reseller Management Actions
- **Create Resellers**: Set up new reseller accounts
- **View Performance**: Track conversion rates and earnings
- **Manage Commission Rates**: Adjust commission percentages
- **Activate/Deactivate**: Enable or disable reseller access
- **Monitor Customer Portfolio**: See all accounts per reseller

### Plan Management Actions
- **Create Plans**: Define new subscription tiers
- **Edit Pricing**: Update monthly rates
- **Adjust Limits**: Change resource quotas
- **Enable/Disable**: Make plans available or unavailable
- **View Usage**: See which accounts use each plan

### Financial Management
- **View All Invoices**: Complete billing history
- **Track Payments**: Monitor paid vs pending
- **Identify Overdue**: Flag late payments
- **Export Data**: Generate financial reports (future)

## Navigation

**Top Navigation Bar:**
- Dashboard (home icon)
- Accounts (building icon)
- Resellers (user-group icon)
- Plans (rectangle-stack icon)
- Billing (banknotes icon)

**Mobile Sidebar:**
- Same navigation items
- Collapsible menu
- Touch-friendly

**Profile Dropdown:**
- Admin name and email
- "Admin" role badge
- Logout button

## Permissions & Security

### Admin Capabilities
- ✅ Full read access to all accounts
- ✅ Full read/write access to resellers
- ✅ Full control over plans and pricing
- ✅ View all invoices and billing data
- ✅ Access DVLA and MOT lookups
- ✅ Change account statuses manually
- ✅ Create and manage admin users (future)

### Security Features
- Separate authentication guard (`admin`)
- Session-based authentication
- CSRF protection on all forms
- Rate limiting on login attempts
- Activity logging (future)

## Data Management

### Account Lifecycle
1. **Created**: By reseller or admin
2. **Trial**: 14-day period active
3. **Trial Expired**: Not converted
4. **Active**: Paying subscription
5. **Churned**: Cancelled subscription

### Status Changes
- Admins can manually change account status
- Automatic trial expiration after 14 days
- Resellers cannot change status (read-only)

## Best Practices

### Account Management
- Review trial conversions regularly
- Monitor churned accounts for follow-up
- Ensure appropriate plans assigned
- Verify reseller account associations

### Reseller Oversight
- Track conversion rates
- Review commission calculations
- Monitor active vs inactive resellers
- Ensure timely commission payments

### Plan Administration
- Keep plan limits realistic
- Price competitively
- Review usage patterns
- Adjust limits based on demand

### Financial Management
- Monitor overdue invoices
- Track revenue trends
- Reconcile commission payments
- Generate regular financial reports

## Related Documentation

- [Overview](../overview.md) - System architecture
- [Reseller Portal](../reseller-portal/README.md) - Reseller perspective
- [API Documentation](../api/) - External integrations
