# Backend Changelog

All notable changes to the G-Track backend will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Added
- Initial Laravel 11 setup with PostgreSQL configuration
- Documentation synchronization workflow
- Development notes and setup guide

---

## [0.1.0] - 2025-10-25

### Added
- **Framework**: Laravel 11.46.1 with PHP 8.2+
- **Database**: PostgreSQL 16 configured as default
- **API**: RESTful API with `/api/v0` prefix
- **Health Check**: `/api/v0/health` endpoint
- **Testing**: Pest testing framework
- **Authentication**: Laravel Sanctum for API tokens (prepared for Auth0)
- **Documentation**: 
  - DEV_NOTES.md with setup instructions
  - CHANGELOG.md for tracking changes
  - README.md with project overview
- **CI/CD**:
  - gtrack-ci-v2 workflow for builds and tests
  - gtrack-policy-v2 workflow for branch and PR validation
  - notify-docs-sync workflow for automatic documentation sync
- **Project Structure**:
  - Standard Laravel 11 directory structure
  - PostgreSQL migrations (users, cache, jobs)
  - API routes with versioning

### Infrastructure
- Deployment configured for Laravel Cloud
- Database: Serverless Postgres 16 on Laravel Cloud
- Frontend deployment: Vercel
- Documentation: GitHub Pages (MkDocs Material)

### Next Steps
- Drivers module database schema and models
- Frontend setup (Angular 20 + Material UI)
- Auth0 integration with RBAC
- File storage integration (Hetzner FTP → AWS S3)

---

## Legend

- `Added` - New features
- `Changed` - Changes in existing functionality
- `Deprecated` - Soon-to-be removed features
- `Removed` - Removed features
- `Fixed` - Bug fixes
- `Security` - Vulnerability fixes
- `Infrastructure` - Deployment, CI/CD, environment changes
