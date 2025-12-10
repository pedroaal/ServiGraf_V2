# ServiGraf V2 - ERP System

**🚀 Migrated from Laravel + Bootstrap to SolidStart + Appwrite + DaisyUI**

Sistema ERP moderno construido con tecnologías web de última generación.

## 🆕 New Technology Stack

- **Frontend**: [SolidJS](https://solidjs.com) + [SolidStart](https://start.solidjs.com)
- **Backend**: [Appwrite](https://appwrite.io) (Backend as a Service)
- **UI Framework**: [DaisyUI](https://daisyui.com) + [Tailwind CSS](https://tailwindcss.com)
- **Language**: TypeScript
- **Build Tool**: Vite

## 📋 Table of Contents

- [Quick Start](#quick-start)
- [Migration Guide](#migration-guide)
- [Features](#features)
- [Project Structure](#project-structure)
- [Development](#development)

## 🚀 Quick Start

### Prerequisites

- Node.js 20+ and npm
- Appwrite account (free at [cloud.appwrite.io](https://cloud.appwrite.io))

### Installation

1. **Install dependencies**:
   ```bash
   npm install
   ```

2. **Configure environment**:
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` and add your Appwrite credentials:
   ```
   VITE_APPWRITE_ENDPOINT=https://cloud.appwrite.io/v1
   VITE_APPWRITE_PROJECT_ID=your_project_id
   VITE_APPWRITE_DATABASE_ID=your_database_id
   ```

3. **Run development server**:
   ```bash
   npm run dev
   ```
   
   Open [http://localhost:3000](http://localhost:3000)

4. **Build for production**:
   ```bash
   npm run build
   npm start
   ```

## 📖 Migration Guide

For detailed migration information, see:
- **[MIGRATION.md](./MIGRATION.md)** - Complete migration guide and documentation
- **[APPWRITE_SCHEMA.md](./APPWRITE_SCHEMA.md)** - Database schema for Appwrite

### Key Changes

| Old Stack | New Stack |
|-----------|-----------|
| Laravel (PHP) | SolidStart (TypeScript) |
| Bootstrap | DaisyUI + Tailwind CSS |
| MySQL/PostgreSQL | Appwrite Database |
| Blade Templates | JSX/TSX Components |
| jQuery | SolidJS Reactivity |

## ✨ Features

### Implemented ✅

- ✅ SolidStart application with TypeScript
- ✅ Appwrite integration for backend
- ✅ DaisyUI component library
- ✅ Portal-based alerts, modals, and loaders
- ✅ Authentication system (login/register)
- ✅ Dashboard with responsive sidebar
- ✅ File-based routing

### Modules (To Be Implemented)

- 🚧 **Producción**: Pedidos, Procesos, Materiales, Reportes
- 🚧 **CRM/Ventas**: Clientes, Contactos, Actividades
- 🚧 **RRHH**: Nómina, Asistencia, Documentos
- 🚧 **Sistema**: Usuarios, Perfiles, Módulos, Permisos

## 📁 Project Structure

```
ServiGraf_V2/
├── src/
│   ├── routes/              # File-based routing
│   │   ├── index.tsx       # Home page
│   │   ├── login.tsx       # Login
│   │   ├── register.tsx    # Register
│   │   └── dashboard/      # Protected routes
│   ├── components/
│   │   ├── Portal/         # Alerts, Modals, Loaders
│   │   ├── Layout/         # Layout components
│   │   └── UI/             # Reusable UI components
│   ├── lib/
│   │   ├── appwrite.ts     # Appwrite config
│   │   └── auth.ts         # Auth utilities
│   └── styles/
│       └── app.css         # Global styles
├── public/                  # Static assets
├── app.config.ts           # SolidStart config
├── tailwind.config.ts      # Tailwind config
└── tsconfig.json           # TypeScript config
```

## 🛠 Development

### Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm start` - Start production server

### Key Concepts

#### Portal Components

All overlays (alerts, modals, loaders) use SolidJS Portals:

```typescript
import { showAlert } from '~/components/Portal';

showAlert({ 
  type: 'success', 
  message: 'Operation completed!' 
});
```

#### Authentication

```typescript
import { useAuth } from '~/lib/auth';

function MyComponent() {
  const { user, login, logout } = useAuth();
  // Use auth methods
}
```

#### Data Fetching with Appwrite

```typescript
import { databases } from '~/lib/appwrite';

const response = await databases.listDocuments(
  'database_id',
  'collection_id'
);
```

## 📚 Documentation

- **Original Laravel docs**: See sections below for legacy documentation
- **New stack docs**: See [MIGRATION.md](./MIGRATION.md)
- **Database schema**: See [APPWRITE_SCHEMA.md](./APPWRITE_SCHEMA.md)

---

## 📝 Legacy Laravel Documentation
=============

En esta seccion se encuentran las acciones que se pueden realizar dentro del sistema.

## Landing
- Paginas estaticas con informacion y galeria de la empresa
- Página de contacto

## Desktop
- Revision de resumen empresarial (BI y KPIs) para el admin
- Revision de pedidos, clientes por usuario

## Usuario
- Registro
- Login
- Estatus activo o inactivo
- Gestion de perfil

## Perfiles
- Gestion de perfiles
- Gestion de modulos y acciones por perfil

## Facturacion
- Creacion de facturas
- Gestion de caja chica (ingresos / egresos)

## RRHH
- Gestion de nomino (IESS Ecuador)
- Gestion de asistencia

## Produccion
- Gestion de pedidos
- Creacion de pedidos
- Reportes: pedidos, pagos, procesos
- Gestion de procesos
- Gestion de materiales

## CRM
- Gestion de contactos / clientes
- Gestion de tareas
- Creacion de tareas por contacto

## Sistema
- Gestion del sistema
- Gestion de facturacion
- Gestion de claves encriptadas

### Notificaciones
- Notificaciones en DDBB
- Se envia una notificacion a un usuario

Roadmap
=======

El proyecto sigue la arquitectura mvc de laravel.
La arquitectura del proyecto es modular, cada feature tiene una subcarpeta dentro de la estructura mvc de laravel.
Ejm. Organizaciones
```
app > Http > controllers > modulo > controller
app > Http > requests > modulo > controller
app > models > modulo > model
resources > views > modulo > view
```

El proyecto usa scss y postcss, para editar el css se debe cambiar los archivos de:
```
css propietario
resources > sass > styles.scss

sbadmin4 theme + general
resources > sass > app.scss

landing page theme
resources > sass > landing.scss
```

El proyecto genera los archivos js, ademas usa jq, para editar el js en:
```
general
resources > js > app.js

plugins init
resources > js > helpers.js

landing
resources > js > landing.js
```

Para mas informacion de css y js revisar:
```
webpack.mix.js
```
