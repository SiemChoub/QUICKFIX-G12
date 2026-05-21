# QUICKFIX-G12

A service booking platform connecting customers with professional fixers (service providers). Multi-role: **Admin**, **Customer**, **Fixer**.

---

## Repository Layout

```
QUICKFIX-G12/
├── backend/    # Laravel 10 API
└── frontend/   # Vue 3 + TypeScript SPA
```

---

## Backend — Laravel 10

**Path:** [backend/](backend/)

### Stack
- **Framework:** Laravel 10 (PHP)
- **Auth:** Laravel Sanctum (token-based)
- **Authorization:** Spatie laravel-permission (roles/permissions)
- **Payments:** Stripe PHP SDK
- **DB:** MySQL (`quickfix` database)

### Configuration
Local env in [backend/.env](backend/.env):
- DB: MySQL @ `127.0.0.1:3306`, database `quickfix`, user `root`
- Mail: MailHog @ `mailhog:1025`
- Cache/Queue/Session: file/sync/file (local dev defaults)

### Domain Models
Located in [backend/app/Models/](backend/app/Models/):

| Entity | Purpose |
|---|---|
| `User` | Base auth model |
| `Frontuser` | Customer profile extension |
| `Fixer` | Service provider profile (career, location, phone) |
| `Service` | Offered services (price, category, promotions) |
| `Booking` | Links customer ↔ fixer |
| `Bookin_immediately` | ASAP same-day bookings |
| `Bookin_deadline` | Scheduled future bookings |
| `FixingProgress` | Job lifecycle (accepted → in-progress → completed) |
| `Chat` | Customer ↔ fixer messaging |
| `Payment` | Stripe transaction records |
| `Feedback` | Reviews/ratings |
| `Promotion`, `Notification` | Supporting entities |

### API Surface
~40 endpoints in [backend/routes/api.php](backend/routes/api.php), protected by `auth:sanctum`. Covers:
- Auth (login, signup, OAuth)
- Services & categories
- Booking lifecycle (create → accept → progress → complete)
- Chat
- Fixer registry
- Payments (Stripe)
- Notifications & feedback

### Controllers
[backend/app/Http/Controllers/](backend/app/Http/Controllers/)

---

## Frontend — Vue 3 + TypeScript

**Path:** [frontend/](frontend/)

### Stack
- **Framework:** Vue 3, TypeScript
- **Build:** Vite
- **State:** Pinia
- **Router:** Vue Router
- **UI:** Element Plus + Syncfusion
- **Calendar:** FullCalendar
- **Realtime:** Socket.io-client
- **Payments:** Stripe.js
- **Auth:** Google OAuth
- **Maps:** Google Maps + Mapbox
- **Forms:** vee-validate

### Entry Point
[frontend/src/main.ts](frontend/src/main.ts) bootstraps Pinia, Router, Element Plus, Axios, vee-validate.

### Routing
[frontend/src/router/index.ts](frontend/src/router/index.ts) defines three role-based view trees:

| Role | Path prefix | Views |
|---|---|---|
| **Admin** | `/admin/*` | Dashboard, user management |
| **Customer** | `/`, `/book`, `/profile`, `/messanger` | Home, booking, profile, chat |
| **Fixer** | `/HomeFixer/*`, `/fixer` | Job acceptance, progress tracking |

### Source Structure
```
frontend/src/
├── main.ts            # bootstrap
├── router/            # route definitions
├── stores/            # Pinia (auth-store, post-list, service-list)
├── views/             # Admin, Web, Fixer view trees
├── Components/        # LoginForm, SignUpForm, BookingForm, Messenger, Map, etc.
└── assets/
```

---

## Notable Architecture Decisions

1. **Dual booking model** — `Bookin_immediately` (ASAP) vs `Bookin_deadline` (scheduled) dispatched via `booking_type_id` on `Booking`.
2. **Real-time chat** — Socket.io between customer ↔ fixer.
3. **Role-segregated UI** — Admin, Customer, and Fixer have separate view trees rather than conditional rendering.
4. **Sanctum over JWT** — token-based auth without a custom implementation.
5. **Spatie permissions** — RBAC backbone for admin features.

---

## Local Development

### Backend
```bash
cd backend
composer install
cp ".env copy.example" .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend
```bash
cd frontend
npm install        # or bun install (bun.lockb present)
npm run dev
```

---

## Screenshots
- [backend/admin-login.png](backend/admin-login.png)
- [backend/admin-dashboard.png](backend/admin-dashboard.png)
