# G-Track Modules Documentation

This directory contains detailed documentation for each G-Track module.

## Available Modules

### MVP Modules (In Development)

1. **[Drivers](drivers/)** - Driver management with documents and status tracking
   - Status: 🚧 In Development
   - Priority: #1

2. **Vehicles & Trailers** - Fleet management
   - Status: 📅 Planned (after Drivers)
   - Priority: #2

### Existing Modules (Migration from OLD version)

3. **Customers** - Customer and carrier management
   - Status: 🔒 Coming Soon (needs v2 migration)
   - Current: 90% complete in OLD version

4. **Orders** - Transport order management
   - Status: 🔒 Coming Soon (needs v2 migration)
   - Current: 85% complete in OLD version

5. **Invoices** - Billing and invoicing
   - Status: 🔒 Coming Soon (needs v2 migration)
   - Current: 20% complete in OLD version

## Documentation Structure

Each module should have:

```
modules/<module-name>/
├── README.md           # Overview and status
├── API.md             # API endpoints specification
├── DATABASE.md        # Database schema and models
├── BUSINESS_LOGIC.md  # Business rules and workflows
├── RBAC.md           # Roles and permissions
└── VALIDATION.md     # Validation rules
```

## Current Development

**Active Module:** Drivers

See [full project documentation](https://docs.g-track.eu) for architecture and design decisions.
