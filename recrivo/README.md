# Recrivo — Multi-Tenant Applicant Tracking System / Recruitment CRM

Recrivo is a multi-tenant Applicant Tracking System (ATS) / Recruitment CRM built with Laravel 13. It allows recruitment agencies to sign up as isolated tenants, manage their client companies, post jobs, track candidates through a hiring pipeline, and manage their internal team — all within a fully tenant-isolated environment, with a platform-level Super Admin panel for oversight.

Built as a final project for a Laravel course at Webskitter Academy.

---

## Tech Stack

- **Backend:** Laravel 13 (PHP 8.3+), MySQL, Eloquent ORM
- **Auth:** Hand-rolled authentication (deliberately built without Fortify/Breeze to deepen framework understanding) + Laravel Sanctum for the API layer
- **Frontend:** Blade (anonymous components), Tailwind CSS v4 + Vite, Alpine.js (CDN), Quill.js (CDN — WYSIWYG editor)
- **Icons/Fonts:** Heroicons (outline), Inter (Google Fonts)
- **Mail:** Laravel `Password` broker + `MustVerifyEmail`, tested via Mailtrap Email Sandbox

---

## Core Features

### Multi-Tenancy
- Each agency self-registers and gets its own isolated **tenant** workspace, becoming its own Admin.
- Tenant isolation enforced via manual `abort_if` checks across controllers.
- A dedicated **"Recrivo Platform"** tenant houses the Super Admin account, avoiding a nullable `tenant_id` and schema ripple effects.

### Roles & Access
- Single role per user via foreign key: **Admin**, **Recruiter**, **Hiring Manager**.
- Admins invite their own team members (Recruiters / Hiring Managers) from inside the app — no public registration for internal roles.
- Role escalation is guarded (`abort_unless`) on the team invite flow.

### Recruitment Workflow
- **Client Companies** — businesses the tenant/agency recruits for (not the tenant's own org profile). One tenant can have many client companies.
- **Job Postings** — belong to a client company, rich-text description via Quill.js.
- **Candidates** — with rich-text notes, tracked per application.
- **Applications & Pipeline** — forward-only, one-step-at-a-time pipeline:
  `applied → screening → interview → offer → hired`
  - `on_hold` and `rejected` reachable from any active stage
  - `on_hold` resumes to its exact previous stage
  - `hired` and `rejected` are terminal states
  - Enforced server-side via `PipelineStageService`, with live drag/AJAX transitions in the UI (Alpine.js + fetch)

### Audit Logging
- Polymorphic audit trail (`Auditable` trait) applied to Candidates, Applications, and Job Postings — tracks changes over time.

### Super Admin Panel
- Platform-wide dashboard with aggregate stats across all tenants.
- Tenant list with live user/candidate counts.
- Tenant detail view.
- Reversible **suspend/activate** toggle (suspended tenants are blocked at login with a clear message).
- Permanent tenant delete with confirmation.
- Visually distinct dark charcoal + coral-accent UI, separate from the tenant-facing theme.

### API Layer
- Sanctum-authenticated REST API for Candidates and Applications.
- Full CRUD, tenant-scoped, tested end-to-end including cross-tenant 403 checks, composite-unique validation, pipeline stage transition guards, and file-upload via `_method=PUT` spoofing.

---

## Local Setup

```bash
# 1. Clone and enter the project
git clone <repo-url>
cd recrivo

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env, then migrate + seed
php artisan migrate --seed

# 5. Build frontend assets
npm run build
# (or `npm run dev` for local development with hot reload)

# 6. Serve the app
php artisan serve
```

### Default Accounts (from seeders)
| Role | Email | Notes |
|---|---|---|
| Super Admin | `superadmin@recrivo.test` | Lives in the dedicated "Recrivo Platform" tenant |

Additional tenant/agency accounts and demo data (candidates, job postings, applications across all pipeline stages) are seeded manually through the UI across two tenants to demonstrate multi-tenant isolation — see the demo walkthrough below.

---

## Demo Walkthrough (for grading)

1. Log in as **Skyline Talent Partners** — a fully populated tenant with multiple client companies, job postings, and candidates spread across every pipeline stage.
2. Browse candidates, job postings, and drag an application through pipeline stages to see live AJAX transitions + audit logging in action.
3. Log out, log in as **Bramblewood Staffing** — a minimal second tenant — to confirm complete data isolation between tenants.
4. Log in as **Super Admin** (`superadmin@recrivo.test`) to view the platform dashboard, confirm both tenants appear with correct counts, and test the suspend/activate toggle.

---

## Notable Engineering Decisions

- **Hand-rolled auth & RBAC** instead of Fortify/Breeze — chosen deliberately to build a deeper understanding of Laravel's authentication internals.
- **`tenants` table** (not `agencies`) — reserved "companies" naming for client companies (Phase 2 consideration).
- **`job_postings` table** (not `jobs`) — avoids collision with Laravel's built-in queue jobs table.
- **Single role via FK**, not a roles pivot table — deliberate simplicity trade-off appropriate for the current scope.
- **Super Admin as its own tenant** rather than a nullable `tenant_id` — avoids schema-wide nullability ripple effects.

## Known Trade-offs / Deferred Scope

The following were consciously deferred to protect the submission deadline, and are earmarked for a later refactor pass:
- Global query scope for tenant isolation (currently handled via explicit controller-level checks).
- Backed PHP enums for stage/status columns (currently `varchar`).
- Distinct permission sets for Recruiter vs Hiring Manager roles (currently share the same non-Admin capabilities).
- Branded email templates for password reset / verification mail (in-app auth pages are branded; email bodies are not yet).

---

## License

Academic project — Webskitter Academy Laravel course final submission.
