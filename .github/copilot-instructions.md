# PetFinder Architecture Guide

## Snapshot
- Laravel 12 app with Blade views for animals (see resources/views/animals/*). Inertia + React scaffolding exists (resources/js/pages/*) but animals currently render via Blade, not Inertia.
- Service/Repository pattern for Animals: controllers should delegate to services → repositories; avoid raw model access in controllers.
- Auth via Laravel Fortify; routes grouped by auth/guest in routes/web.php. User owns many animals; 2FA enabled.
- Search via Laravel Scout on Animal model (name/species/city/description). Filtering and pagination layered in repository.
- Adoption request workflow: Users submit adoption requests via form → AdoptRequest model stores data → Database notification sent to animal owner → Owner sees notifications on dashboard.

## Components
- Models: 
  - Animal: fillable (name, species, status, city, description, user_id, latitude, longitude), Scout indexed, belongsTo(User), hasMany(AdoptRequest)
  - User: Fortify/2FA, hasMany(Animal), hasMany(AdoptRequest as requester), receives notifications
  - AdoptRequest: fillable (animal_id, user_id, message, read_at), belongsTo(Animal), belongsTo(User)
  - Profile: hasOne relationship to User
- Repository: AnimalRepository handles `searchAnimals`, `archiveOldAnimals`. Scout query wraps `Animal::search($term)->query(...)`; filters inside query callback.
- Services: AnimalService::storeAnimal(), ::archiveExpiredPosts(), ::searchAnimals(), ::listUserAnimals(), ::filterLocatedAnimals()
- Controllers: AnimalController (index, show, create, store, edit, update, destroy, myAnimals, notifications), AdoptionController (store adoption request, markAsRead)
- Notifications: AdoptionRequestReceived - database channel, sends to animal owner when adoption request created

## Data & Flows
- Listing: AnimalController@index → AnimalRepository::searchAnimals with filters (search/species/status/city), paginates 12
- User animals: myAnimals() → auth()->user()->animals()->latest()
- Adoption request: POST /animals/{animal}/adopt → AdoptionController@store → creates AdoptRequest → dispatches AdoptionRequestReceived notification
- Notifications dashboard: GET /notificaciones → shows auth()->user()->notifications() paginated, displays animal name/requester/message
- Mark as read: PATCH /notificaciones/{id}/leida → updates read_at timestamp
- Auto-archive: archiveOldAnimals marks >30-day non-Archived animals as Archived (needs scheduled command)

## Frontend
- Blade views: animals/index (search form + Leaflet map), show (detail + adoption form), create (form to post), edit (form to edit), my-animals-blade (user dashboard with notification counter), notifications (adoption request list)
- Navigation: PETFINDER logo, links to explore/my-posts/notifications/profile
- Adoption form: textarea for message, only visible when not animal owner
- Notification badge: red counter on "Solicitudes" link shows unread count

## Routes
- GET / → animals.index (search + map)
- POST /register → register (user registration)
- POST /login → login (authentication)
- GET /mis-animales → animals.mine (user's posts with notification counter)
- GET /animals/create → animals.create (new post form)
- POST /animals → animals.store (save new animal)
- GET /animals/{id} → animals.show (detail + adoption form if auth and not owner)
- POST /animals/{animal}/adopt → adopt.store (create adoption request, send notification)
- GET /animals/{id}/edit → animals.edit (edit form)
- PUT /animals/{id} → animals.update
- DELETE /animals/{id} → animals.destroy
- GET /notificaciones → notifications.index (adoption requests received)
- PATCH /notificaciones/{id}/leida → notifications.mark-read
- GET /profile/edit → profile.edit
- PATCH /profile → profile.update
- DELETE /profile → profile.destroy

## Workflows
- Dev servers: `php artisan serve` (app), `npm run dev` (Vite/HMR).
- Quality: `npm run lint`, `npm run format`, `php artisan pint`.
- DB: `php artisan migrate`, `php artisan db:seed`, `php artisan tinker` for queries.
- Tests: `php artisan test`; TS types: `npm run types`.
- New user: register → create profile → post animals → receive adoption requests → dashboard shows notifications

## Conventions / Gotchas
- Always route filters through Request::only([...]) before passing to repository.
- When combining Scout search with filters, put filter logic inside `.query(fn($builder) => ...)` to avoid losing Scout builder.
- Controllers delegate to services (AnimalService), not direct repository/model access.
- Database notifications stored in notifications table; read_at nullable (NULL = unread).
- Adoption form only visible when auth and user doesn't own animal.
- Animal owner can edit/delete own posts from my-animals-blade view.
- Status values in DB: 'Lost', 'In Adoption' (English), UI displays Spanish labels (Perdido, En Adopción).

## TODOs
- Wire scheduler/command to call AnimalService::archiveExpiredPosts (30-day old animal archival).
- Build geolocation picker for animal posting (Leaflet map click → set lat/lng).
- Implement AdoptionService response workflow (accept/reject adoption requests).
- Add ProfilePolicy/authorization for profile edits.
- Add adoption request responses (mark as accepted/rejected by animal owner).

