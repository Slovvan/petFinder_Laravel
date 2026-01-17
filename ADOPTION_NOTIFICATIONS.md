# Sistema de Notificaciones - Documentación

## Flujo de Adopción

### 1. Usuario ve anuncio y envía solicitud
- URL: `GET /animals/{id}` (animals.show)
- Vista: `resources/views/animals/show.blade.php`
- Formulario: textarea para mensaje de adopción
- Validación: mínimo 10, máximo 1000 caracteres
- Ruta de envío: `POST /animals/{animal}/adopt` (adopt.store)

### 2. Controlador procesa la solicitud
- **Controlador**: `App\Http\Controllers\AdoptionController::store()`
- **Pasos**:
  1. Valida que no sea el propietario del animal
  2. Valida el mensaje (min:10, max:1000)
  3. Crea un registro en `AdoptRequest` con:
     - `animal_id`: ID del animal
     - `user_id`: ID del solicitante (auth()->id())
     - `message`: Mensaje de solicitud
     - `read_at`: NULL (sin leer)
  4. Dispara notificación `AdoptionRequestReceived` al propietario del animal
  5. Redirige con mensaje de éxito

### 3. Notificación en base de datos
- **Clase**: `App\Notifications\AdoptionRequestReceived`
- **Canal**: `database` (almacenada en tabla `notifications`)
- **Datos**: animal_name, requester_name, message, animal_url
- **Receptores**: El propietario del animal (`$animal->user`)

### 4. Propietario ve notificación
- **URL**: `GET /notificaciones` (notifications.index)
- **Controlador**: `App\Http\Controllers\AnimalController::notifications()`
- **Vista**: `resources/views/animals/notifications.blade.php`
- **Muestra**:
  - Lista de solicitudes recibidas
  - Nombre del animal solicitado
  - Nombre del solicitante
  - Mensaje de solicitud
  - Estado (Nueva/Leída)
  - Timestamp de la solicitud
  - Botones: "Ver Animal", "Marcar como Leída"

### 5. Marcar notificación como leída
- **Ruta**: `PATCH /notificaciones/{id}/leida` (notifications.mark-read)
- **Controlador**: `App\Http\Controllers\AdoptionController::markAsRead()`
- **Acción**: Actualiza `read_at` con timestamp actual
- **Interfaz**: Badge rojo desaparece de "Solicitudes" en navegación

## Modelos

### AdoptRequest
```php
Model: App\Models\AdoptRequest
Tabla: adopt_requests

Campos:
- id
- animal_id (FK → animals)
- user_id (FK → users - el solicitante)
- message: string
- read_at: timestamp (nullable)
- created_at, updated_at

Relaciones:
- animal(): belongsTo(Animal)
- user(): belongsTo(User) // El solicitante
```

### Animal (Actualizado)
```php
// Relación nueva:
public function adoptRequests()
{
    return $this->hasMany(AdoptRequest::class);
}
```

### User (Actualizado)
```php
// Relaciones:
- notifications(): hasMany(Notification)
- animals(): hasMany(Animal)
- adoptRequests(): hasMany(AdoptRequest) // Solicitudes enviadas
```

## Rutas

```
POST   /animals/{animal}/adopt          → adopt.store         (crear solicitud)
GET    /notificaciones                  → notifications.index (ver notificaciones)
PATCH  /notificaciones/{id}/leida       → notifications.mark-read (marcar leída)
```

## Navegación

### Navbar (Usuarios autenticados)
- "📬 Solicitudes" con badge rojo mostrando cantidad de sin leer
- Enlace a `/notificaciones`

### Dashboard (Mis Anuncios)
- Botón "📬 Solicitudes" con contador rojo
- Enlace a `/notificaciones`

## Validación

### Formulario de Solicitud
```
message:
  - required
  - string
  - min:10
  - max:1000

Errores personalizados:
  - message.required: "El mensaje es requerido."
  - message.min: "El mensaje debe tener al menos 10 caracteres."
  - message.max: "El mensaje no puede exceder 1000 caracteres."
```

## Autorizaciones

1. **No puedes solicitar tu propio animal**
   - Validación en AdoptionController::store()
   - Redirige con error: "No puedes enviar una solicitud para tu propio anuncio."

2. **Solo ves tus propias notificaciones**
   - Filtrado en AnimalController::notifications()
   - auth()->user()->notifications()

3. **Solo puedes marcar como leída tus propias notificaciones**
   - Auth middleware en ruta
   - Búsqueda dentro de auth()->user()->notifications()

## Estados de Notificación

### Nueva (Unread)
- Badge amarillo: "Nueva"
- Botón: "Marcar como Leída"
- Contador rojo en navegación incluye esta notificación

### Leída (Read)
- Badge azul: "Leída"
- Botón: No aparece (notificación ya procesada)
- No aparece en contador rojo

## Vistas

### animals/show.blade.php
- Si usuario autenticado Y no es propietario:
  - Muestra formulario de adopción
  - Textarea para mensaje
  - Botón "Enviar Solicitud"
- Si usuario es propietario:
  - Muestra info: "Este es tu anuncio. [Editar]"
- Si usuario no autenticado:
  - Muestra: "[Inicia sesión] para enviar una solicitud de adopción"

### animals/notifications.blade.php
- Lista de todas las solicitudes recibidas
- Paginación: 10 por página
- Tarjetas con:
  - Nombre del animal (enlace)
  - Nombre del solicitante
  - Mensaje en cuadro destacado
  - Badge de estado
  - Botones de acción
  - Timestamp relativo (ej: "hace 2 horas")

### layouts/app.blade.php
- Navbar actualizada con "📬 Solicitudes"
- Contador rojo con cantidad de sin leer
- Solo visible para usuarios autenticados

### animals/my-animals-blade.blade.php
- Botón "📬 Solicitudes" con contador
- Botón "+ Publicar" para crear nuevo anuncio
- Tabla de anuncios del usuario

## Ejemplos de Uso

### Enviar solicitud de adopción
1. Usuario A ve animal publicado por Usuario B
2. Usuario A completa formulario: "Me encantaría adoptar a Max, tengo experiencia con perros y una casa con patio grande."
3. Click en "Enviar Solicitud"
4. Notificación llega a Usuario B en base de datos
5. Usuario B ve badge rojo con "1" en navegación

### Ver notificaciones
1. Usuario B click en "📬 Solicitudes"
2. URL: `/notificaciones`
3. Ve: "Max solicitado por Usuario A: Me encantaría..."
4. Puede ver detalles del animal o marcar como leída

### Marcar como leída
1. Click en "Marcar como Leída"
2. PATCH /notificaciones/{id}/leida
3. Notificación cambia a "Leída"
4. Badge rojo en navegación se actualiza
5. Redirecciona con "Notificación marcada como leída."

## Próximos Pasos (TODO)

1. **Responder solicitudes** (aceptar/rechazar)
   - Nuevo estado en AdoptRequest: 'pending', 'accepted', 'rejected'
   - Vista de detalle de solicitud
   - Botones de aceptar/rechazar
   - Notificación de respuesta al solicitante

2. **Filtrar notificaciones**
   - Por estado (nuevas, leídas, antiguas)
   - Por animal
   - Búsqueda por solicitante

3. **Historial de solicitudes**
   - Ver todas las solicitudes (aceptadas, rechazadas, pendientes)
   - Por animal

4. **Notificaciones por email**
   - Enviar también por correo al propietario
   - Resumen diario de solicitudes

5. **Chat con solicitante**
   - Comunicación directa en la plataforma
   - Historial de conversación
