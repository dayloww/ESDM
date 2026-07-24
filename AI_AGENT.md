# AI_AGENT.md

# AI Coding Agent Instructions

## Project Information

Project Name:
ESDM SATU DATA WILAYAH IV

Framework:
Laravel 13

Language:
PHP 8.3+

Database:
MySQL

Frontend:
Blade + Bootstrap 5

Purpose:
Develop an internal web application for Cabang Dinas Wilayah IV Dinas ESDM Provinsi Sulawesi Utara.

---

## Project Scope

Current development only focuses on the **Admin Panel**.

The system is intended for internal use to store, manage, update, and organize ESDM data.

Advanced features such as GIS, QR Code, GPS, public complaints, notifications, mobile applications, and third-party integrations will be developed in future versions.

---

## Reference Documents

Before generating any code, always read:

1. README.md
2. DESIGN.md
3. DATABASE.md
4. TASKS.md

Follow these documents as the primary project reference.

---

## Development Rules

- Follow Laravel Best Practices.
- Use MVC Architecture.
- Use Eloquent ORM.
- Use Resource Controllers.
- Use Form Request Validation.
- Use Laravel Migration.
- Use Laravel Storage for uploaded files.
- Use Bootstrap 5 for the user interface.
- Use DataTables for tables.
- Use Chart.js for charts.
- Use SweetAlert2 for notifications.

---

## Coding Standards

- Follow PSR-12 Coding Standard.
- Write clean and readable code.
- Avoid duplicate code.
- Use reusable components whenever possible.
- Keep controllers concise and move business logic to appropriate classes when necessary.

---

## Database Rules

- Follow DATABASE.md.
- Use foreign keys where appropriate.
- Use timestamps.
- Use soft deletes where appropriate.
- Do not create unnecessary tables.
- Do not rename tables or fields without updating the documentation.

---

## User Interface Rules

The application must include:

- Responsive layout
- Top navigation bar
- Left sidebar
- Content area
- Footer

Every CRUD page should have:

- Search
- Filter
- Pagination
- Validation
- Success/Error messages

---

## Current Development Order

Develop modules in this order:

1. Authentication
2. Dashboard
3. Data Wilayah
4. Data Usaha ESDM
5. Data Mineral dan Pertambangan
6. Data Energi dan Ketenagalistrikan
7. Pengawasan
8. Potensi PAD
9. Laporan
10. User Management

Complete one module before moving to the next.

---

## Restrictions

Do NOT implement:

- Mobile App
- QR Code
- GPS Tracking
- Public Complaint Portal
- Notifications
- Public API
- Third-party integrations

These features will be implemented in future phases.

---

## Documentation

Whenever a feature changes:

- Update DATABASE.md if the database structure changes.
- Update DESIGN.md if the interface changes.
- Update TASKS.md if the development roadmap changes.

---

## Important Notes

Do not assume business rules.

If any requirement is unclear, leave a TODO comment or request clarification instead of making assumptions.

The application should prioritize maintainability, readability, scalability, and future development.