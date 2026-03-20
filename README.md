# Database - Coredata Filament

Estructura de base de datos para sistema de gestión empresarial con Laravel Filament.

## 📁 Estructura

```
database/
├── migrations/          # Definición de tablas
├── seeders/            # Datos de prueba
└── factories/          # Fábricas para testing
```

## 🗄️ Tablas

### Core del Sistema
- `users` - Usuarios del sistema
- `roles` / `permissions` - Roles y permisos (Spatie)
- `cache`, `jobs` - Colas y caché de Laravel

### Datos Maestros
- `departamentos` - Departamentos de Colombia (DANE)
- `ciudades` - Ciudades de Colombia (DANE)
- `empresa` - Datos legales y fiscales de la empresa

### Terceros
- `clientes` - Clientes de la empresa
- `proveedores` - Proveedores de la empresa

### Auditoría
- `auditorias` - Registro de trazabilidad

## 🚀 Uso

### Migrar la base de datos
```bash
php artisan migrate
```

### Poblar con datos de prueba
```bash
php artisan db:seed
```

### Migrar y poblar desde cero
```bash
php artisan migrate:fresh --seed
```

## 📦 Seeders Disponibles

| Seeder | Descripción |
|--------|-------------|
| `RoleSeeder` | Crea roles y permisos granulares |
| `UserSeeder` | Usuario administrador + usuarios de prueba |
| `DepartamentosSeeder` | 32 departamentos de Colombia |
| `CiudadesSeeder` | Todos los municipios de Colombia |
| `EmpresaSeeder` | Datos de la empresa (id=1) |
| `ClientesSeeder` | Cliente de ejemplo |
| `ProveedoresSeeder` | Proveedor de ejemplo |

## 👤 Usuarios por Defecto

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | joseforozco@gmail.com | Digital2019** |
| Auxiliar | auxiliar@sigainv.test | password |
| Contador | contador@sigainv.test | password |
| Vendedor | vendedor@sigainv.test | password |
| Cliente | cliente@sigainv.test | password |

> ⚠️ **Importante:** Cambia las contraseñas en producción.

## 🏗️ Convenciones

- **Snake case** en nombres de columnas (`usuario_id`, no `usuarioId`)
- **FKs** con `foreignId()` y restricciones apropiadas
- **onDelete** configurado según necesidad de negocio:
  - `restrict` - No permitir eliminación si hay registros relacionados
  - `set null` - Limpiar FK al eliminar el padre
  - `cascade` - Eliminar en cascada

## 📝 Notas

- Los seeders son **idempotentes** - seguros para ejecutar múltiples veces
- `empresa` tiene un solo registro (id=1) - se gestiona como configuración
- `departamentos` y `ciudades` usan códigos DANE oficiales de Colombia

## 📄 Licencia

Privado - Uso interno
