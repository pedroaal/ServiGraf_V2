# Appwrite Database Schema

This document describes the database collections needed in Appwrite to replace the Laravel MySQL/PostgreSQL database.

## Setup Instructions

1. Create a new database in your Appwrite project
2. For each collection below, create the collection with the specified attributes
3. Configure appropriate indexes for frequently queried fields
4. Set up collection-level and document-level permissions

## Collections Reference

### Core System Collections

#### 1. tipo_empresa (Company Types)
- **Collection ID**: `tipo_empresa`
- **Attributes**:
  - `nombre` (string, required) - Type name
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 2. empresas (Companies)
- **Collection ID**: `empresas`
- **Attributes**:
  - `nombre` (string, required) - Company name
  - `tipo_empresa_id` (string, required) - Reference to tipo_empresa
  - `status` (boolean, required) - Active/Inactive
  - `created_at` (datetime)
  - `updated_at` (datetime)
  - `deleted_at` (datetime, nullable)

#### 3. perfiles (User Profiles/Roles)
- **Collection ID**: `perfiles`
- **Attributes**:
  - `nombre` (string, required) - Profile name
  - `descripcion` (string)
  - `empresa_id` (string, required) - Reference to empresas
  - `status` (boolean)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 4. modulos (System Modules)
- **Collection ID**: `modulos`
- **Attributes**:
  - `nombre` (string, required)
  - `parent_id` (string, nullable) - For nested modules
  - `ruta` (string) - Route path
  - `icono` (string) - Icon name
  - `orden` (integer) - Display order
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 5. modulo_perfil (Module-Profile Relations)
- **Collection ID**: `modulo_perfil`
- **Attributes**:
  - `modulo_id` (string, required)
  - `perfil_id` (string, required)
  - `ver` (boolean) - View permission
  - `crear` (boolean) - Create permission
  - `editar` (boolean) - Edit permission
  - `eliminar` (boolean) - Delete permission
  - `created_at` (datetime)

### User Management

#### 6. nomina (Employee Records)
- **Collection ID**: `nomina`
- **Attributes**:
  - `cedula` (string, unique, required) - ID number
  - `nombres` (string, required)
  - `apellidos` (string, required)
  - `empresa_id` (string, required)
  - `area_id` (string)
  - `cargo` (string)
  - `email` (email)
  - `telefono` (string)
  - `direccion` (string)
  - `fecha_ingreso` (datetime)
  - `salario` (float)
  - `status` (boolean)
  - `created_at` (datetime)
  - `updated_at` (datetime)
  - `deleted_at` (datetime, nullable)

#### 7. usuarios (System Users)
- **Collection ID**: `usuarios`
- **Note**: This will be supplemented by Appwrite's built-in Auth system
- **Attributes** (for additional user data):
  - `user_id` (string, required) - Reference to Appwrite Auth user
  - `cedula` (string, unique) - Reference to nomina
  - `empresa_id` (string, required)
  - `usuario` (string, unique) - Username
  - `perfil_id` (string, required)
  - `status` (boolean)
  - `reservarot` (boolean)
  - `libro` (boolean)
  - `utilidad` (boolean)
  - `is_superadmin` (boolean)
  - `created_at` (datetime)
  - `updated_at` (datetime)

### Producción Module

#### 8. areas (Production Areas)
- **Collection ID**: `areas`
- **Attributes**:
  - `nombre` (string, required)
  - `descripcion` (string)
  - `empresa_id` (string, required)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 9. maquinas (Machines)
- **Collection ID**: `maquinas`
- **Attributes**:
  - `nombre` (string, required)
  - `area_id` (string, required)
  - `descripcion` (string)
  - `status` (boolean)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 10. categorias (Material Categories)
- **Collection ID**: `categorias`
- **Attributes**:
  - `nombre` (string, required)
  - `descripcion` (string)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 11. proveedores (Suppliers)
- **Collection ID**: `proveedores`
- **Attributes**:
  - `nombre` (string, required)
  - `ruc` (string)
  - `direccion` (string)
  - `telefono` (string)
  - `email` (email)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 12. materiales (Materials)
- **Collection ID**: `materiales`
- **Attributes**:
  - `nombre` (string, required)
  - `categoria_id` (string, required)
  - `proveedor_id` (string)
  - `unidad` (string) - Unit of measure
  - `precio` (float)
  - `stock` (integer)
  - `stock_minimo` (integer)
  - `descripcion` (string)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 13. procesos (Production Processes)
- **Collection ID**: `procesos`
- **Attributes**:
  - `nombre` (string, required)
  - `area_id` (string, required)
  - `descripcion` (string)
  - `tiempo_estimado` (integer) - In minutes
  - `costo` (float)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 14. pedidos (Orders)
- **Collection ID**: `pedidos`
- **Attributes**:
  - `codigo` (string, unique, required)
  - `cliente_id` (string, required)
  - `empresa_id` (string, required)
  - `usuario_id` (string, required)
  - `fecha_pedido` (datetime)
  - `fecha_entrega` (datetime)
  - `descripcion` (string)
  - `cantidad` (integer)
  - `precio_unitario` (float)
  - `subtotal` (float)
  - `iva` (float)
  - `total` (float)
  - `status` (string) - pending, processing, completed, cancelled
  - `observaciones` (string)
  - `created_at` (datetime)
  - `updated_at` (datetime)
  - `deleted_at` (datetime, nullable)

#### 15. pedido_proceso (Order-Process Relations)
- **Collection ID**: `pedido_proceso`
- **Attributes**:
  - `pedido_id` (string, required)
  - `proceso_id` (string, required)
  - `maquina_id` (string)
  - `usuario_id` (string) - Assigned user
  - `fecha_inicio` (datetime)
  - `fecha_fin` (datetime)
  - `status` (string)
  - `observaciones` (string)
  - `created_at` (datetime)
  - `updated_at` (datetime)

### Ventas/CRM Module

#### 16. clientes (Clients)
- **Collection ID**: `clientes`
- **Attributes**:
  - `nombre` (string, required)
  - `ruc` (string)
  - `email` (email)
  - `telefono` (string)
  - `direccion` (string)
  - `tipo` (string) - individual, empresa
  - `empresa_id` (string, required)
  - `status` (boolean)
  - `created_at` (datetime)
  - `updated_at` (datetime)
  - `deleted_at` (datetime, nullable)

#### 17. contactos (Contacts)
- **Collection ID**: `contactos`
- **Attributes**:
  - `nombre` (string, required)
  - `apellido` (string)
  - `email` (email, required)
  - `telefono` (string)
  - `cargo` (string)
  - `cliente_id` (string)
  - `empresa_id` (string, required)
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 18. actividades (Activities)
- **Collection ID**: `actividades`
- **Attributes**:
  - `titulo` (string, required)
  - `descripcion` (string)
  - `tipo` (string) - call, meeting, email, task
  - `fecha` (datetime)
  - `contacto_id` (string)
  - `cliente_id` (string)
  - `usuario_id` (string, required)
  - `status` (string) - pending, completed
  - `created_at` (datetime)
  - `updated_at` (datetime)

#### 19. comentarios (Comments)
- **Collection ID**: `comentarios`
- **Attributes**:
  - `comentario` (string, required)
  - `actividad_id` (string)
  - `contacto_id` (string)
  - `usuario_id` (string, required)
  - `created_at` (datetime)
  - `updated_at` (datetime)

### Additional Collections

#### 20. notificaciones (Notifications)
- **Collection ID**: `notificaciones`
- **Attributes**:
  - `titulo` (string, required)
  - `mensaje` (string, required)
  - `tipo` (string) - info, warning, success, error
  - `usuario_id` (string, required)
  - `leida` (boolean, default: false)
  - `url` (string) - Link to relevant resource
  - `created_at` (datetime)

## Indexes

For optimal performance, create indexes on:

1. **empresas**: `tipo_empresa_id`, `status`
2. **usuarios**: `cedula`, `usuario`, `empresa_id`, `perfil_id`, `status`
3. **pedidos**: `codigo`, `cliente_id`, `empresa_id`, `usuario_id`, `status`, `fecha_pedido`
4. **clientes**: `ruc`, `email`, `empresa_id`, `status`
5. **contactos**: `email`, `cliente_id`, `empresa_id`
6. **actividades**: `usuario_id`, `cliente_id`, `contacto_id`, `fecha`, `status`
7. **materiales**: `categoria_id`, `proveedor_id`
8. **procesos**: `area_id`

## Permissions

### Recommended Permission Structure

1. **Public collections**: None
2. **Authenticated users**: 
   - Read: Own company data
   - Write: Based on role (perfil_id)
3. **Admin users** (is_superadmin):
   - Full access to all collections

### Role-Based Permissions

Configure permissions using Appwrite's role system:
- `role:all` - Any authenticated user
- `role:admin` - Admin users
- `role:empresa_{id}` - Users from specific company
- `role:perfil_{id}` - Users with specific profile/role

## Migration from Laravel

To migrate data from Laravel to Appwrite:

1. Export data from Laravel database (MySQL/PostgreSQL)
2. Transform data to match Appwrite document structure
3. Use Appwrite API or SDK to import data
4. Verify relationships and data integrity

### Migration Script Example

```javascript
import { databases } from './src/lib/appwrite';

async function migrateData() {
  // Example: Migrate empresas
  const empresas = await fetchFromLaravel('empresas');
  
  for (const empresa of empresas) {
    await databases.createDocument(
      'database_id',
      'empresas',
      'unique()',
      {
        nombre: empresa.nombre,
        tipo_empresa_id: empresa.tipo_empresa_id,
        status: empresa.status,
        created_at: empresa.created_at,
        updated_at: empresa.updated_at
      }
    );
  }
}
```

## Notes

- Appwrite uses document IDs instead of auto-increment integers
- Soft deletes can be handled with a `deleted_at` attribute
- Foreign key constraints are logical (not enforced by database)
- Use Appwrite Functions for complex business logic
- Consider using Appwrite's built-in features (Auth, Storage, Functions)
