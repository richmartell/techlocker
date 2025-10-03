# Reseller Portal Documentation

## Overview

The Reseller Portal enables partners to create trial accounts, manage their customer portfolio, and track commission earnings from converted subscriptions.

## Access

- **URL**: `http://localhost/reseller/login`
- **Default Credentials**: `reseller@garageiq.com` / `password`
- **Authentication Guard**: `reseller`

## Dashboard

The reseller dashboard provides an at-a-glance view of business performance:

### Performance Metrics

**Trial Statistics:**
- **Trials Created**: Total number of trial accounts created
- **Trials Converted**: Number that became paying customers
- **Conversion Rate**: Percentage of trials that converted

**Commission Summary:**
- **Total Earned**: All-time commission total
- **Total Paid**: Commissions already received
- **Pending**: Awaiting payment

**Visual Indicators:**
- Large, easy-to-read numbers
- Color-coded cards
- Percentage calculations

### Quick Actions
- **Create Trial** (primary button) - Start a new customer trial
- **View Customers** - Access customer list
- **View Commissions** - See payment history

## Create Trial Account

**Route**: `/reseller/customers/create`

### Purpose
Enable resellers to quickly set up new 14-day trials for prospective customers.

### Form Fields

**Business Information:**
- **Business Name** (required) - Customer's company name
  - Example: "ABC Motors Ltd"
  
**Contact Information:**
- **Contact Name** (required) - Main contact person
  - Example: "John Smith"
  - Used for: Account ownership, first admin user
  
- **Email Address** (required) - Primary contact email
  - Example: "contact@business.com"
  - Validation: Must be unique (not already in use)
  - Used for: Login credentials, notifications
  
- **Phone Number** (optional) - Contact telephone
  - Example: "07700 900000"

### Trial Benefits Displayed
- ✅ 14 days free trial period
- ✅ Full access to all features
- ✅ No credit card required
- ✅ Commission earned on conversion

### Process Flow

1. **Reseller Fills Form**
   - Enters customer business and contact details
   - Validates email uniqueness

2. **System Creates Account**
   - New account record created
   - Linked to reseller (`reseller_id`)
   - Trial dates set (start: now, end: +14 days)
   - Status: `trial`
   - Active: `true`

3. **System Creates User**
   - Primary admin user for account
   - Uses contact name and email
   - Temporary password generated
   - Role: `admin`
   - Status: `active`

4. **Success Redirect**
   - Flash message: "Trial account created successfully!"
   - Redirect to customer list
   - New trial appears with "Trial" status

### Validation Rules
- Business name: Required, max 255 characters
- Contact name: Required, max 255 characters
- Email: Required, valid email format, unique in users table
- Phone: Optional, max 20 characters

## Customer Management

**Route**: `/reseller/customers`

### Customer Listing

**Features:**
- Paginated table of all customers created by this reseller
- Search by company name or email
- Real-time status updates

**Table Columns:**
- **Company Name**: Customer business name
- **Email**: Primary contact email
- **Users**: Number of users in account (badge)
- **Plan**: Current subscription plan (or "No plan" for trials)
- **Status**: Account status with color-coded badge and trial countdown
- **Created**: Account creation date

**Status Display:**
- 🟢 **Trial** (lime) - "X days left" countdown
- 🟢 **Active** (green) - Paying customer
- 🟠 **Trial Expired** (orange) - Not converted
- 🔴 **Churned** (red) - Was active, now cancelled

**Actions:**
- **Create Trial** button (top right) - Add new customer
- **Search** - Filter by company name or email

### Customer Lifecycle Visibility

Resellers can see:
- Which trials are active (and days remaining)
- Which trials converted to paying customers
- Which trials expired without converting
- Which customers cancelled (churned)

This helps resellers:
- Follow up on expiring trials
- Celebrate conversions
- Learn from unsuccessful trials

## Commission Tracking

**Route**: `/reseller/commissions`

### Commission Summary Cards

**Total Earned:**
- All-time commission total
- Includes paid + pending

**Pending Payments:**
- Commissions awaiting payment
- Highlighted in orange

### Commission Records Table

**Table Columns:**
- **Account**: Customer company name (linked)
- **Amount**: Commission amount in £
- **Status**: Paid/Pending/Cancelled (color-coded badge)
- **Earned**: Date commission was calculated
- **Paid**: Date payment was made (if applicable)

**Status Badges:**
- 🟢 **Paid** (green) - Payment completed
- 🟡 **Pending** (yellow) - Awaiting payment
- 🔴 **Cancelled** (red) - Voided/refunded

**Filters:**
- **All Commissions** - Show everything
- **Paid** - Only completed payments
- **Pending** - Only awaiting payment
- **Cancelled** - Only voided records

### Commission Calculation

**How It Works:**
1. Customer converts from trial to active subscription
2. System calculates: `Plan Price × Commission Rate`
   - Example: £79.99 × 10% = £7.99
3. Commission record created with status: `pending`
4. Each month, recurring commission generated
5. Admin marks commissions as `paid`
6. Total updates reflect payment

**Example Scenario:**

```
Reseller: 10% commission rate
Customer: Converts to Professional plan (£79.99/mo)

Month 1: £7.99 (pending → paid)
Month 2: £7.99 (pending)
Month 3: £7.99 (pending)
...continues while customer active
```

**When Commission Stops:**
- Customer cancels subscription (status: `churned`)
- No new commission records generated
- Pending commissions still valid

## Reseller Profile

Located in top-right dropdown:
- Reseller name
- Company name
- Email address
- **Logout** button

## Navigation

**Top Navigation:**
- Dashboard (home icon)
- Customers (customers icon)
- Commissions (currency icon)

**Mobile Navigation:**
- Collapsible sidebar
- Same navigation items
- Touch-friendly design

## Permissions & Restrictions

### What Resellers CAN Do
- ✅ Create new trial accounts
- ✅ View all their customer accounts
- ✅ See customer status and plan information
- ✅ Track trial conversions
- ✅ Monitor commission earnings
- ✅ Filter and search customers
- ✅ View commission payment history

### What Resellers CANNOT Do
- ❌ Change customer account status
- ❌ Modify subscription plans
- ❌ Access customer user accounts
- ❌ Change pricing or limits
- ❌ View other resellers' customers
- ❌ Mark commissions as paid
- ❌ Delete or suspend accounts

This ensures:
- Data integrity
- Clear separation of responsibilities
- Admin maintains full control
- Resellers focus on sales

## Business Operations

### Trial Follow-Up Strategy

**Active Trials (1-7 days left):**
- High priority for conversion outreach
- Demonstrate value proposition
- Address any concerns
- Highlight features being used

**Expiring Soon (< 3 days):**
- Urgent follow-up required
- Offer onboarding assistance
- Answer subscription questions
- Provide conversion incentives

**Expired Trials:**
- Post-trial follow-up
- Understand why didn't convert
- Offer special pricing (admin approval)
- Keep door open for future

### Conversion Optimization

**Track Metrics:**
- Conversion rate by source
- Time to conversion (days in trial)
- Most popular plans chosen
- Common objections/blockers

**Best Practices:**
- Quick response to new trial sign-ups
- Regular check-ins during trial
- Proactive support and training
- Clear value demonstration

## Commission Payment Process

### For Resellers

1. **Monitor Pending Balance**
   - Check Commissions page regularly
   - Track upcoming payments

2. **Payment Schedule** (set by admin)
   - Typical: Monthly or quarterly
   - Threshold: Minimum payout amount

3. **Receive Payment**
   - Via bank transfer (typical)
   - Commission status changes to `paid`
   - Payment date recorded

4. **Record Keeping**
   - Download payment history (future)
   - Invoice generation (future)
   - Tax documentation (future)

## Technical Details

### Authentication
- Guard: `reseller`
- Provider: `resellers` table
- Session-based authentication
- Remember-me functionality

### Data Scoping
All queries automatically filtered by:
```php
->where('reseller_id', auth('reseller')->id())
```

This ensures resellers only see their own data.

### API Access
Resellers do NOT have direct access to:
- DVLA lookups
- Haynes Pro data
- System administration
- Other resellers' data

## Mobile Experience

The reseller portal is fully responsive:
- Touch-friendly buttons
- Simplified layouts on mobile
- Essential actions prioritized
- Easy-to-read tables
- Quick access to key metrics

Designed for:
- On-the-go commission checks
- Quick trial creation
- Customer status verification
- Performance monitoring

## Success Metrics

Track your performance:
- **Conversion Rate**: Target > 30%
- **Average Trial Duration**: Monitor usage patterns
- **Monthly Commissions**: Track earnings growth
- **Active Customers**: Maintain healthy portfolio

## Support

### Getting Help
- Review this documentation
- Contact admin for:
  - Commission disputes
  - Account issues
  - Permission requests
  - Technical problems

### Best Practices
- Create quality trials (real prospects)
- Follow up during trial period
- Provide value-add support
- Maintain professional relationships
- Track and optimize conversion rate

## Related Documentation

- [Overview](../overview.md) - System architecture
- [Admin Portal](../admin-portal/README.md) - Admin perspective
- [User Portal](../user-portal/README.md) - End-user features
