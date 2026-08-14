# Recrivo — Demo / Testing Credentials

This file lists pre-seeded accounts for testing Recrivo without needing to register a new tenant. Please use these accounts rather than self-registering — see the **Note on Email** section below for why.

---

## Tenant Account — Northbridge Talent Partners

Use this account to explore a fully populated tenant: client companies, job postings, and candidates spread across the recruitment pipeline.

| Field | Value |
|---|---|
| Company Name | Northbridge Talent Partners |
| Login Email | `marcus.bennett@northbridgetalent.test` |
| Password | `NorthBridge@2026!` |
| Role | Admin |

**What to check as this user:**
- Client Companies list (multiple companies under this one tenant)
- Job Postings with rich-text descriptions
- Candidates with rich-text notes
- Applications board — drag a candidate card between pipeline stages to see live AJAX transitions
- Team page (Admin-only) — inviting a Recruiter / Hiring Manager

---

## Super Admin Account

Use this account to view the platform-wide oversight panel, separate from any single tenant.

| Field | Value |
|---|---|
| Login Email | `superadmin@recrivo.test` |
| Password | *(set separately — not included in this file for security; provided alongside submission if required)* |

**What to check as this user:**
- Platform dashboard with aggregate stats across all tenants
- Tenant list with live user/candidate counts
- Tenant detail view
- Suspend / activate toggle (try suspending Northbridge, confirm it blocks login, then reactivate)

---

## Note on Email (Important)

Recrivo's outgoing mail (password reset, email verification) is currently routed to a **private Mailtrap sandbox** for development testing — this inbox is not accessible to graders/testers.

This means:
- **Please don't self-register a new tenant** or trigger a password reset during testing — the resulting email won't be visible to you.
- Please use the seeded account(s) above to explore the app instead.
- If you'd like to see the registration → verification flow specifically, let me know and I can walk through it live or provide a screen recording.

---

## Known Limitations (by design, for this submission)

- Recruiter and Hiring Manager roles currently share the same permission set — differentiated permissions are planned but not yet implemented.
- Pipeline stage/status columns use `varchar`, not PHP backed enums — a deliberate scope decision for this submission.
- Password reset / verification **email bodies** are not yet branded (the in-app auth pages are).
