# GarageIQ - Application Overview

## 🎯 Purpose

GarageIQ is a comprehensive garage management system designed for automotive workshops in the UK. It combines customer relationship management, vehicle diagnostics, technical information access, and business intelligence into a single, powerful platform.

## 🏗 System Architecture

### Multi-Portal Design

GarageIQ implements a **three-portal architecture** to serve different user types:

```
┌─────────────────────────────────────────────────────────────┐
│                        GarageIQ Platform                     │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │    Admin     │  │   Reseller   │  │     User     │      │
│  │    Portal    │  │    Portal    │  │    Portal    │      │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤      │
│  │ • Accounts   │  │ • Trials     │  │ • Customers  │      │
│  │ • Resellers  │  │ • Customers  │  │ • Vehicles   │      │
│  │ • Plans      │  │ • Commission │  │ • Diagnostics│      │
│  │ • Billing    │  │ • Payments   │  │ • Jobs       │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                     Core Services Layer                      │
├─────────────────────────────────────────────────────────────┤
│  • Multi-tenant Data Isolation                              │
│  • Authentication & Authorization                           │
│  • Subscription & Trial Management                          │
│  • Commission Calculation Engine                            │
├─────────────────────────────────────────────────────────────┤
│                   External API Integrations                  │
├─────────────────────────────────────────────────────────────┤
│  • Haynes Pro (Technical Data & Diagnostics)                │
│  • DVLA (Vehicle Registration Lookups)                      │
│  • MOT History (Test Results & History)                     │
│  • OpenAI GPT-4 (AI-Powered Diagnostics)                    │
└─────────────────────────────────────────────────────────────┘
```

## 👥 User Roles

### 1. System Administrators
**Access**: Admin Portal (`/admin/login`)

**Responsibilities:**
- Manage all workshop accounts
- Configure subscription plans and pricing
- Oversee reseller network
- Monitor billing and invoices
- View system-wide analytics
- Manage DVLA and technical data lookups

**Key Features:**
- Account lifecycle management (create, suspend, upgrade/downgrade)
- Reseller performance tracking and commission oversight
- Plan configuration (users, customers, searches limits)
- Invoice management and financial reporting
- Direct DVLA vehicle lookups with MOT history

### 2. Resellers
**Access**: Reseller Portal (`/reseller/login`)

**Responsibilities:**
- Create trial accounts for prospective customers
- Manage their customer portfolio
- Track trial conversions
- Monitor commission earnings

**Key Features:**
- 14-day trial creation (no credit card required)
- Customer account dashboard
- Commission tracking (earned, paid, pending)
- Performance metrics (conversion rates)
- Read-only access to customer accounts

**Business Model:**
- Earn commission on customer conversions
- Recurring monthly commission on active subscriptions
- Commission stops when customer churns

### 3. Workshop Users
**Access**: User Portal (`/login`)

**Responsibilities:**
- Manage customer relationships
- Track vehicle history
- Diagnose vehicle issues
- Access technical information
- Schedule and manage jobs

**Key Features:**
- Customer and vehicle database
- AI-powered diagnostics with DTC code lookup
- Haynes Pro technical data integration
- Service history tracking
- Job management and scheduling

## 🔐 Authentication & Security

### Multi-Guard Authentication

```php
Guards:
├── web (Workshop Users)
│   └── Provider: users table
├── admin (System Administrators)
│   └── Provider: admins table
└── reseller (Resellers)
    └── Provider: resellers table
```

**Security Features:**
- Separate authentication guards for each portal
- Role-based access control (RBAC)
- Multi-tenant data isolation (account_id scoping)
- Rate limiting on login attempts
- Session management with remember-me functionality
- Password reset flows for each guard

## 💼 Business Model

### Subscription Tiers

| Plan | Price (GBP) | Max Users | Max Customers | Max Searches |
|------|-------------|-----------|---------------|--------------|
| **Starter** | £29.99/mo | 2 | 50 | 100/mo |
| **Professional** | £79.99/mo | 5 | 200 | 500/mo |
| **Enterprise** | £149.99/mo | 15 | Unlimited | Unlimited |

### Trial System
- **Duration**: 14 days
- **Full Access**: All features available during trial
- **No Payment Required**: No credit card needed to start
- **Reseller Created**: Trials are created by resellers
- **Automatic Tracking**: Trial status automatically updated

### Account Statuses

```
┌──────────┐     14-day trial      ┌───────────────┐
│  Trial   │ ───────────────────> │ Trial Expired │
└────┬─────┘                       └───────────────┘
     │
     │ Convert (Subscribe)
     │
     ▼
┌──────────┐     Cancel/Non-payment     ┌─────────┐
│  Active  │ ─────────────────────────> │ Churned │
└──────────┘                             └─────────┘
```

### Commission Structure
- Resellers earn **percentage-based commission** on customer subscriptions
- Commission calculated monthly based on active subscriptions
- Default rate: 10% (configurable per reseller)
- Commission stops when customer churns
- Payment tracking: Earned → Pending → Paid

## 🔌 API Integrations

### 1. Haynes Pro API
**Purpose**: Technical automotive data

**Capabilities:**
- Vehicle identification by VRM (registration number)
- Complete technical specifications
- Maintenance schedules and service intervals
- Diagnostic Trouble Code (DTC) information
- Component locations and diagrams
- Lubricant specifications
- Adjustment data (tyre pressures, wheel alignment, etc.)
- Service procedures

**Usage in App:**
- Vehicle lookup and identification
- Technical information display
- AI diagnostics context enrichment
- Maintenance recommendations

### 2. DVLA Vehicle Enquiry API
**Purpose**: UK vehicle registration data

**Data Retrieved:**
- Registration number
- Make, Model, Color
- Year of manufacture
- Engine capacity
- Fuel type
- CO2 emissions
- Tax status and due date
- MOT status and expiry date

**Usage in App:**
- Admin portal vehicle lookups
- Quick vehicle verification
- Customer vehicle onboarding

### 3. MOT History API
**Purpose**: UK MOT test history

**Data Retrieved:**
- Complete test history
- Pass/Fail results
- Test dates and expiry dates
- Mileage at each test
- Failure reasons and advisories
- Dangerous defects
- Test certificate numbers

**Usage in App:**
- Vehicle history reports
- Maintenance planning
- Customer advisory services

### 4. OpenAI GPT-4 API
**Purpose**: AI-powered diagnostics

**Capabilities:**
- Interpret diagnostic trouble codes (DTCs)
- Suggest probable causes
- Recommend diagnostic procedures
- Context-aware responses using Haynes data
- Natural language interaction

**Usage in App:**
- Diagnostics AI assistant
- Interactive troubleshooting
- Technical question answering

## 📊 Data Model

### Core Entities

```
Accounts (Multi-tenant root)
├── Users (Workshop staff)
├── Customers (Vehicle owners)
│   └── Vehicles (Customer vehicles)
│       └── Jobs (Service jobs)
├── Plan (Subscription tier)
├── Reseller (Account creator)
└── Invoices (Billing records)

Resellers
├── Accounts (Created trials/customers)
└── Commissions (Earnings records)

Plans
├── Accounts (Subscribed accounts)
└── Invoices (Billing history)
```

### Multi-Tenancy
- All user-generated data scoped by `account_id`
- Query scopes automatically filter by authenticated user's account
- Ensures complete data isolation between workshops

## 🎨 User Interface

### Technology
- **Framework**: Livewire 3 (full-stack framework)
- **Components**: Flux UI (modern component library)
- **Styling**: Tailwind CSS
- **Interactivity**: Alpine.js (embedded in Livewire)

### Design Principles
- **Responsive**: Mobile-first design
- **Dark Mode**: Full dark mode support
- **Accessibility**: WCAG 2.1 AA compliance
- **Consistency**: Shared component library across portals
- **Performance**: SPA-like experience with minimal page loads

## 📈 System Metrics

### Performance Targets
- Page load: < 1s
- API response: < 500ms
- Database queries: Optimized with eager loading
- Real-time updates: Livewire polling where needed

### Scalability
- Multi-tenant architecture supports unlimited accounts
- API rate limiting to prevent abuse
- Database indexing on key foreign keys
- Caching strategy for expensive API calls

## 🔄 Workflow Examples

### New Customer Trial Flow
1. Reseller creates trial via Reseller Portal
2. System creates Account with 14-day trial
3. System creates primary User for account
4. Email sent to customer with login details
5. Trial countdown begins
6. After 14 days: Trial auto-expires or converts
7. If converted: Reseller earns commission
8. If expired: Account marked as trial_expired

### Vehicle Diagnostic Flow
1. User enters DTC code (e.g., P0300)
2. System queries Haynes Pro for DTC information
3. System sends context to OpenAI GPT-4
4. AI provides diagnostic guidance
5. User accesses related Haynes technical data
6. User creates job for repairs

### DVLA Lookup Flow
1. Admin/User clicks "DVLA Lookup" 
2. Enters vehicle registration
3. System queries DVLA API
4. System queries MOT History API
5. Displays comprehensive vehicle data
6. Shows complete MOT history with advisories
7. Data can be used for customer records

## 🚀 Future Roadmap

### Planned Features
- Payment gateway integration (Stripe)
- Email notification system
- Advanced reporting and analytics
- Mobile companion app
- Automated invoice generation
- Customer self-service portal
- SMS notifications for service reminders
- Inventory management
- Parts ordering integration

### Technical Improvements
- API response caching layer
- Background job processing (queues)
- Enhanced search functionality
- Data export capabilities
- Webhook integrations
- Multi-language support

## 📝 Development Notes

### Key Laravel Features Used
- Multi-guard authentication
- Livewire full-stack framework
- Eloquent ORM with relationships
- Database migrations and seeders
- Service providers for API clients
- Middleware for authorization
- Policy-based authorization
- Model accessors and mutators

### Best Practices Implemented
- Repository pattern for external APIs
- Service layer for business logic
- Resource limits enforcement
- Comprehensive error logging
- API key management via environment
- Database transaction safety
- CSRF protection
- XSS prevention
