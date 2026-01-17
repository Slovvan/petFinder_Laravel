# 📬 Notificaciones de Adopción - Guía Rápida

## ¿Qué se implementó?

Sistema completo de notificaciones en base de datos que alerta a los propietarios de animales cuando reciben solicitudes de adopción.

## Flujo en 3 pasos

### 1️⃣ Usuario ve animal
- Navega a `/animals/{id}`
- Si no es el propietario, ve formulario para enviar solicitud

### 2️⃣ Usuario envía solicitud
- Escribe mensaje (mín. 10, máx. 1000 caracteres)
- Click en "Enviar Solicitud"
- POST a `/animals/{animal}/adopt`

### 3️⃣ Propietario recibe notificación
- Badge rojo aparece en "📬 Solicitudes" 
- Navega a `/notificaciones`
- Ve lista de solicitudes recibidas
- Puede ver detalles o marcar como leída

## Componentes Implementados

### Modelos
- ✅ `AdoptRequest` - Almacena solicitudes (animal_id, user_id, message, read_at)
- ✅ `Notification` - Tabla nativa de Laravel para notificaciones

### Controladores
- ✅ `AdoptionController@store` - Crea solicitud y notifica
- ✅ `AdoptionController@markAsRead` - Marca notificación como leída
- ✅ `AnimalController@notifications` - Lista notificaciones del usuario

### Vistas
- ✅ `animals/show.blade.php` - Formulario de adopción
- ✅ `animals/notifications.blade.php` - Dashboard de notificaciones
- ✅ `layouts/app.blade.php` - Navbar con badge "Solicitudes"

### Rutas
```php
POST   /animals/{animal}/adopt        → crear solicitud
GET    /notificaciones                → ver todas mis solicitudes  
PATCH  /notificaciones/{id}/leida    → marcar como leída
```

## Características

✅ **Notificaciones en tiempo real**
- Almacenadas en base de datos
- Se actualizan automáticamente

✅ **Badge con contador**
- Número de solicitudes sin leer
- En navbar y en "Mis Anuncios"

✅ **Estados**
- Nueva (amarillo): Recién recibida
- Leída (azul): Usuario ya vio

✅ **Seguridad**
- No puedes solicitar tu propio animal
- Solo ves tus notificaciones
- Validación de mensaje

✅ **Interfaz responsiva**
- Diseño mobile-friendly
- Transiciones suaves
- Feedback visual claro

## Ejemplos de Uso

### Crear solicitud
```html
<form action="{{ route('adopt.store', $animal) }}" method="POST">
    @csrf
    <textarea name="message" required>...</textarea>
    <button type="submit">Enviar</button>
</form>
```

### Ver notificaciones
```php
auth()->user()->notifications()->paginate(10);
```

### Marcar como leída
```html
<form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
    @csrf @method('PATCH')
    <button type="submit">Marcar como Leída</button>
</form>
```

## Validaciones

| Campo | Requisitos | Error |
|-------|-----------|-------|
| message | required, 10-1000 chars | "El mensaje debe tener al menos 10 caracteres." |
| propietario | ≠ usuario actual | "No puedes enviar solicitud para tu propio anuncio." |

## Base de datos

### Tabla: notifications
```sql
Campos: id, notifiable_type, notifiable_id, type, data (JSON), read_at, created_at
Nota: Creada automáticamente por Laravel
```

### Tabla: adopt_requests
```sql
Campos: id, animal_id, user_id, message, read_at, created_at, updated_at
Foreign Keys: animal_id → animals(id), user_id → users(id)
Nota: Ya existe en migrations
```

## Archivos Creados/Modificados

| Archivo | Tipo | Cambio |
|---------|------|--------|
| AdoptionController.php | Controlador | Nuevo archivo |
| AdoptionRequestReceived.php | Notificación | Actualizado |
| AdoptRequest.php | Modelo | Relaciones + fillable |
| web.php | Rutas | +3 rutas nuevas |
| AnimalController.php | Controlador | +método notifications() |
| show.blade.php | Vista | Formulario de adopción |
| notifications.blade.php | Vista | Nueva lista de notificaciones |
| app.blade.php | Vista | Badge "Solicitudes" |
| my-animals-blade.blade.php | Vista | Botón "Solicitudes" |

## Próximos Pasos (Opcionales)

- [ ] Aceptar/Rechazar solicitud
- [ ] Enviar email de notificación
- [ ] Chat entre solicitante y propietario
- [ ] Historial de solicitudes
- [ ] Filtros en dashboard de notificaciones

## Troubleshooting

**P: No veo el badge rojo**
R: Asegúrate de estar logueado y recibir solicitudes. El contador muestra solo sin leer.

**P: El formulario no aparece**
R: Verifica que no seas el propietario del animal. El formulario solo aparece para otros usuarios.

**P: Las notificaciones no se guardan**
R: Verifica que la tabla `notifications` exista en BD. Ejecuta `php artisan migrate`.

**P: No puedo marcar como leída**
R: Verifica estar logueado y que la notificación sea tuya (auth()->user()->notifications()).

## Support

Para más detalles, ver:
- 📖 `ADOPTION_NOTIFICATIONS.md` - Documentación técnica completa
- 📋 `NOTIFICATIONS_IMPLEMENTATION.md` - Resumen de cambios
- 🏗️ `.github/copilot-instructions.md` - Arquitectura general

---

**¡Sistema listo para usar!** Comienza a recibir solicitudes de adopción 🐾
