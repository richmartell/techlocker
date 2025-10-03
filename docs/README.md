# GarageIQ Documentation

Welcome to the GarageIQ documentation. This garage management system provides comprehensive tools for automotive workshops, including customer management, vehicle diagnostics, technical information, and multi-portal access for administrators and resellers.

## 📚 Documentation Structure

### Core Application
- [Application Overview](overview.md) - System architecture and key features
- [Getting Started](getting-started.md) - Installation and setup guide
- [Technical Architecture](architecture.md) - System design and technology stack

### User Portals
- [Admin Portal](admin-portal/README.md) - Complete administrative interface documentation
- [Reseller Portal](reseller-portal/README.md) - Reseller management and commission tracking
- [User Portal](user-portal/README.md) - Main workshop user interface

### API Integrations
- [Haynes Pro API](api/haynes-pro-api.md) - Complete Haynes Pro integration documentation
- [DVLA API](api/dvla-api.md) - UK vehicle registration lookups
- [MOT History API](api/mot-api.md) - MOT test history integration
- [AI Diagnostics](api/diagnostics-ai.md) - OpenAI-powered diagnostic assistance

### Features
- [Customer Management](features/customer-management.md) - Customer and vehicle tracking
- [Vehicle Diagnostics](features/diagnostics.md) - AI-powered diagnostics and troubleshooting
- [Technical Information](features/technical-info.md) - Haynes Pro data integration
- [Job Management](features/jobs.md) - Workshop job tracking and scheduling
- [Billing & Invoicing](features/billing.md) - Invoice management and tracking

## 🚀 Quick Start

```bash
# Clone repository
git clone <repository-url>

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Start development server
./vendor/bin/sail up -d
npm run dev
```

## 🔑 Key Features

### Multi-Portal Architecture
- **Admin Portal** - Full system control, account management, reseller oversight
- **Reseller Portal** - Customer trial management, commission tracking
- **User Portal** - Workshop operations, diagnostics, customer management

### Vehicle Intelligence
- **DVLA Integration** - Real-time UK vehicle data lookups
- **MOT History** - Complete MOT test history with advisories
- **Haynes Pro** - Comprehensive technical data, maintenance schedules, diagnostics
- **AI Diagnostics** - GPT-4 powered diagnostic assistance

### Business Management
- **Multi-tenant Architecture** - Account-based isolation
- **Subscription Plans** - Tiered pricing with feature limits
- **Trial Management** - 14-day trial system with conversion tracking
- **Commission System** - Automated reseller commission calculation

## 📖 Portal Access

### Admin Portal
- **URL**: `/admin/login`
- **Default Credentials**: `admin@garageiq.com` / `password`
- **Features**: Account management, reseller oversight, billing, plans

### Reseller Portal
- **URL**: `/reseller/login`
- **Default Credentials**: `reseller@garageiq.com` / `password`
- **Features**: Create trials, customer management, commission tracking

### User Portal
- **URL**: `/login`
- **Features**: Customer management, diagnostics, technical information, jobs

## 🛠 Technology Stack

- **Framework**: Laravel 11.x with Livewire 3
- **UI**: Flux UI components, Tailwind CSS
- **Database**: MySQL/MariaDB
- **Authentication**: Multi-guard (web, admin, reseller)
- **APIs**: Haynes Pro, DVLA, MOT History, OpenAI
- **Development**: Laravel Sail (Docker)

## 📊 System Status

### Current Version: 1.0.0

**Implemented Features:**
- ✅ Multi-portal authentication system
- ✅ Admin portal with full account management
- ✅ Reseller portal with trial and commission management
- ✅ Customer and vehicle management
- ✅ DVLA and MOT integration
- ✅ Haynes Pro technical data integration
- ✅ AI-powered diagnostics
- ✅ Subscription plans and billing
- ✅ Invoice management
- ✅ Multi-tenant architecture

**In Development:**
- 🔄 Email notifications for trials and invoices
- 🔄 Payment gateway integration
- 🔄 Advanced reporting and analytics
- 🔄 Mobile application

## 🔗 Related Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Flux UI Documentation](https://fluxui.dev)
- [Haynes Pro API](https://developer.haynes.com)

## 📞 Support

For technical support or questions:
- Review the relevant documentation section
- Check the API documentation for integration issues
- Review Laravel logs: `storage/logs/laravel.log`
- Run diagnostics: `php artisan dvla:test`, `php artisan haynes:test`

## 📝 License

Proprietary - All rights reserved
