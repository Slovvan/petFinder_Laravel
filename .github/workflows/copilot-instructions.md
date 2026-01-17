# PetFinder Laravel + React Codebase Guide

## Architecture Overview

**PetFinder** is a Laravel 12 + React/Inertia full-stack application for discovering and managing lost/found animals with geolocation support. The architecture follows:

- **Backend**: Laravel 12 with Service/Repository pattern, Laravel Scout for search
- **Frontend**: React 19 + TypeScript + Tailwind CSS with Inertia.js for server-driven rendering
- **Auth**: Laravel Fortify with two-factor authentication support
- **Database**: Uses Eloquent ORM with location-based querying (latitude/longitude)

## Key Components & Data Flow

### Models (Single Responsibility)
- `User`: Authenticatable with Fortify 2FA; owns animals via relation
- `Animal`: Core entity (name, species, status, city, lat/lng); indexed with Scout for full-text search
- `AdoptRequest`: (TODO - implement request handling for adoptions)
- `Profil`: (user profile extension - currently minimal)

### Service Layer Pattern
Located in `app/Services/`, services encapsulate business logic:
- `AnimalService::storeAnimal()` → creates animal owned by auth user
- `AnimalService::archiveExpiredPosts()` → calls repository to auto-archive 30+ day old animals
- `AdoptionService` → (TODO - implement adoption request workflow)
- Services inject repositories; **never query models directly from controllers**

### Repository Pattern
`AnimalRepository` handles all Animal queries:
- `searchAnimals(filters)` → complex filtering (Scout full-text + filters)
- `archiveOldAnimals()` → batch update with date checking
- Uses **Scout for full-text search** on name/species/city/description
- **Important**: Search gracefully chains with `->query()` when using Scout

### Controllers
- Keep minimal; delegate to services/repositories
- `AnimalController::index()` → public listing with filters
- `AnimalController::myAnimals()` → authenticated user's animals
- Receive filters via `Request::only()` to prevent injection

## Development Workflows

### Build & Development
```bash
# Terminal 1: PHP/Laravel server
php artisan serve                # Runs on http://localhost:8000

# Terminal 2: Node/Vite dev server
npm run dev                      # Hot-reloads React components

# Code quality
npm run lint                     # ESLint + fix
npm run format                   # Prettier
php artisan pint                 # PHP formatting (Laravel's tool)
```

### Database & Seeding
```bash
php artisan migrate              # Run pending migrations
php artisan db:seed              # Run seeders
php artisan tinker              # Interactive shell for testing queries
```

### Testing
```bash
php artisan test                 # PHPUnit (tests/ directory)
npm run types                    # TypeScript check (no emit)
```

## Critical Patterns & Conventions

### 1. Query Building with Scout
When implementing search across Animal, **always use the repository pattern**:
```php
// ✗ Wrong: Direct model query with Scout
Animal::search($term)->get();

// ✓ Correct: Through repository
$this->repository->searchAnimals(['search' => $term, 'species' => $species]);
```
**Scout requires chaining `.query()` callback** when combining full-text + structured filters.

### 2. Authentication & Authorization
- All protected routes use `auth` middleware in `routes/web.php`
- User ownership validated: `auth()->user()->animals()` relationship
- **TODO**: Implement ProfilePolicy for profile editing authorization

### 3. Filtering & Pagination
Animals endpoint supports simultaneous filters:
- `search` (full-text via Scout)
- `species` (exact match)
- `status` (exact match: "Lost", "Found", "Archived")
- `city` (LIKE wildcard)
All return paginated results (12 per page).

### 4. Auto-Archiving Posts
Cron/scheduler not visible—but archiving logic exists:
- Animals 30+ days old auto-marked as "Archived"
- Call `AnimalService::archiveExpiredPosts()` from a scheduled command (TODO: implement)

## Frontend Structure (React/TypeScript)

- `resources/js/pages/` → Page components (Inertia-rendered server routes)
- `resources/js/components/` → Reusable React components
- `resources/js/layouts/` → Page layouts (header, nav, footer)
- `resources/js/hooks/` → Custom React hooks
- `resources/js/types/` → TypeScript type definitions (models mirror backend)
- `resources/js/lib/` → Utilities (API helpers, formatters)

## External Dependencies
- **Laravel Scout**: Full-text search abstraction (driver TBD in config)
- **Laravel Fortify**: Authentication & 2FA
- **Inertia.js**: Server-driven React rendering (replaces traditional views)
- **Tailwind CSS + Vite plugins**: Styling & optimization

## File Organization Key Paths
- Controllers: `app/Http/Controllers/`
- Models: `app/Models/`
- Services: `app/Services/` (business logic)
- Repositories: `app/Repositories/` (data access)
- Routes: `routes/web.php` (all routes defined here)
- Migrations: `database/migrations/` (schema changes)
- React Pages: `resources/js/pages/`
- Config: `config/` (app.php, auth.php, scout.php)

## Common Tasks for AI

### Adding a Feature
1. **Model**: Define in `app/Models/`; set `$fillable` for mass assignment
2. **Migration**: Create in `database/migrations/`; run `php artisan migrate`
3. **Repository**: Add query methods to handle filtering/searching
4. **Service**: Wrap business logic (validation, relationships)
5. **Controller**: Inject service; keep thin
6. **Route**: Add to `routes/web.php` with middleware
7. **Frontend**: Create React page in `resources/js/pages/`, type definitions in `types/`

### Debugging
- `php artisan tinker` → query models interactively
- Laravel logs: `storage/logs/`
- Browser console for React/TypeScript errors
- Check Vite build output for HMR issues

### Geolocation Features
Animals table has `latitude` / `longitude` columns. Map features (TODO) should:
- Query animals with `whereNotNull('latitude')` before mapping
- Use `AnimalController::indexMap()` as reference
- Frontend can use Leaflet or Mapbox (not yet chosen)

## Known TODOs & Incomplete Features
- `AdoptRequest` model needs relationship setup and workflow implementation
- `AdoptionService` incomplete (adoption request handling)
- `ProfilService` minimal (profile image processing exists in Jobs but incomplete)
- Map integration (`indexMap()` exists but frontend not connected)
- Geolocation front-end components (picker, display)
- Cron/scheduler for auto-archiving (service exists, needs Job/Command)

