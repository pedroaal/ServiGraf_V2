# ServiGraf V2 - Migration Guide

## Overview

This project has been migrated from **Laravel + Bootstrap** to **SolidStart + Appwrite + DaisyUI**.

## New Technology Stack

- **Frontend Framework**: [SolidJS](https://www.solidjs.com/) with [SolidStart](https://start.solidjs.com/)
- **Backend/Database**: [Appwrite](https://appwrite.io/) (BaaS - Backend as a Service)
- **UI Framework**: [DaisyUI](https://daisyui.com/) (Tailwind CSS component library)
- **Build Tool**: Vite
- **Language**: TypeScript

## Project Structure

```
src/
├── routes/              # File-based routing (SolidStart)
│   ├── index.tsx       # Home page
│   ├── login.tsx       # Login page
│   ├── register.tsx    # Registration page
│   └── dashboard/      # Protected dashboard routes
├── components/          # Reusable components
│   ├── Portal/         # Portal components (alerts, modals, loaders)
│   ├── Layout/         # Layout components
│   └── UI/             # UI components
├── lib/                # Utilities and services
│   ├── appwrite.ts     # Appwrite client configuration
│   └── auth.ts         # Authentication hooks
└── styles/             # Global styles
    └── app.css         # Main stylesheet (Tailwind)
```

## Getting Started

### Prerequisites

- Node.js 20+ and npm
- Appwrite instance (cloud or self-hosted)

### Installation

1. **Install dependencies**:
   ```bash
   npm install
   ```

2. **Configure Appwrite**:
   
   Copy `.env.example` to `.env` and update with your Appwrite credentials:
   ```bash
   cp .env.example .env
   ```
   
   Update the following variables:
   ```
   VITE_APPWRITE_ENDPOINT=https://cloud.appwrite.io/v1
   VITE_APPWRITE_PROJECT_ID=your_project_id
   VITE_APPWRITE_DATABASE_ID=your_database_id
   ```

3. **Run development server**:
   ```bash
   npm run dev
   ```
   
   The app will be available at `http://localhost:3000`

4. **Build for production**:
   ```bash
   npm run build
   npm start
   ```

## Appwrite Setup

### 1. Create an Appwrite Project

1. Sign up at [Appwrite Cloud](https://cloud.appwrite.io/) or deploy your own instance
2. Create a new project
3. Note your Project ID

### 2. Configure Authentication

1. Go to **Auth** → **Settings**
2. Enable Email/Password authentication
3. Configure your app's domains under **Platforms**

### 3. Create Database Schema

Based on the Laravel migrations, you'll need to create the following collections:

#### Core Collections:
- **empresas** (companies)
- **users** (usuarios)
- **perfiles** (profiles/roles)
- **modulos** (modules)

#### Producción Module:
- **pedidos** (orders)
- **procesos** (processes)
- **materiales** (materials)
- **areas** (areas)
- **maquinas** (machines)
- **proveedores** (suppliers)
- **categorias** (categories)
- **tintas** (inks)

#### Ventas/CRM Module:
- **clientes** (clients)
- **contactos** (contacts)
- **actividades** (activities)
- **comentarios** (comments)

#### RRHH Module:
- **nomina** (payroll)
- **nomina_familia** (family info)
- **nomina_educ** (education info)
- **nomina_documentos** (documents)
- **asistencia** (attendance)

For each collection, define appropriate attributes based on the Laravel migrations in `database/migrations/`.

### 4. Set Collection Permissions

Configure read/write permissions for each collection based on user roles.

## Key Features Implemented

### ✅ Portal Components

All alerts, modals, and loaders use **SolidJS Portals** for proper render order:

```typescript
import { showAlert, showLoader, hideLoader } from '~/components/Portal';

// Show alert
showAlert({ 
  type: 'success', 
  message: 'Operation completed!' 
});

// Show loader
showLoader('Processing...');
// ... do work ...
hideLoader();
```

### ✅ Authentication

Authentication is handled through Appwrite with React-like hooks:

```typescript
import { useAuth } from '~/lib/auth';

function MyComponent() {
  const { user, login, logout, register } = useAuth();
  
  // Use authentication methods
}
```

### ✅ Routing

File-based routing with SolidStart:
- `/` - Home page
- `/login` - Login page
- `/register` - Registration page
- `/dashboard` - Protected dashboard
- `/dashboard/produccion/*` - Production module
- `/dashboard/ventas/*` - Sales/CRM module
- `/dashboard/rrhh/*` - HR module
- `/dashboard/sistema/*` - System admin module

### ✅ UI Components

DaisyUI components are used throughout:
- Cards, buttons, forms
- Modals (in Portal)
- Alerts (in Portal)
- Loaders (in Portal)
- Tables, stats, badges
- Responsive navigation

## Migration Status

### Completed ✅
- [x] Project setup and configuration
- [x] TypeScript and build tools
- [x] DaisyUI + Tailwind CSS
- [x] Appwrite SDK integration
- [x] Portal components (alerts, modals, loaders)
- [x] Authentication system
- [x] Basic routing structure
- [x] Dashboard layout with sidebar
- [x] Home, login, and register pages

### To Be Implemented 🚧

#### Phase 1: Core Features
- [ ] Protected route middleware
- [ ] User profile management
- [ ] Role-based access control
- [ ] Error boundaries

#### Phase 2: Producción Module
- [ ] Pedidos (Orders) CRUD
- [ ] Procesos (Processes) management
- [ ] Materiales (Materials) inventory
- [ ] Reports (pedidos, pagos, maquinas)
- [ ] Forms (imprenta forms)

#### Phase 3: CRM/Ventas Module
- [ ] Clientes (Clients) management
- [ ] Contactos (Contacts) management
- [ ] Actividades (Activities) tracking
- [ ] Comentarios (Comments) system

#### Phase 4: RRHH Module
- [ ] Nómina (Payroll) management
- [ ] Employee records
- [ ] Asistencia (Attendance) tracking
- [ ] Documents management

#### Phase 5: Sistema/Admin
- [ ] User management
- [ ] Profile/Role management
- [ ] Module permissions
- [ ] System settings
- [ ] Notifications system

#### Phase 6: Additional Features
- [ ] Email notifications
- [ ] File uploads (Storage)
- [ ] Charts and analytics (Chart.js replacement)
- [ ] PDF generation
- [ ] Export functionality (CSV, Excel)
- [ ] Advanced search and filters
- [ ] Responsive tables (DataTables replacement)

## Differences from Laravel Version

### Architecture Changes

| Laravel | SolidStart + Appwrite |
|---------|----------------------|
| Server-side rendering | SSR/CSR hybrid |
| Blade templates | JSX/TSX components |
| PHP backend | Appwrite (BaaS) |
| MySQL/PostgreSQL | Appwrite Database |
| Laravel Auth | Appwrite Auth |
| Bootstrap | DaisyUI/Tailwind |
| jQuery | Vanilla JS/SolidJS |

### Benefits

1. **Performance**: SolidJS is extremely fast with fine-grained reactivity
2. **Developer Experience**: TypeScript, hot reload, modern tooling
3. **Scalability**: Appwrite handles backend infrastructure
4. **Maintenance**: Simpler codebase, no server management
5. **Modern UI**: DaisyUI provides beautiful, accessible components

### Trade-offs

1. **Backend Control**: Less control over backend logic (can be mitigated with Appwrite Functions)
2. **Learning Curve**: New stack requires learning SolidJS, Appwrite, and Tailwind
3. **Migration Effort**: Significant initial migration work

## Development Guidelines

### Component Structure

```typescript
import { Component, createSignal } from "solid-js";

export const MyComponent: Component = () => {
  const [state, setState] = createSignal(0);
  
  return (
    <div class="card bg-base-100 shadow-xl">
      <div class="card-body">
        <h2 class="card-title">My Component</h2>
        <p>Count: {state()}</p>
        <button 
          class="btn btn-primary"
          onClick={() => setState(state() + 1)}
        >
          Increment
        </button>
      </div>
    </div>
  );
};
```

### Using Portals

Always use Portal components for overlays:

```typescript
import { Modal, showAlert } from "~/components/Portal";

function MyPage() {
  const [modalOpen, setModalOpen] = createSignal(false);
  
  return (
    <>
      <button onClick={() => setModalOpen(true)}>
        Open Modal
      </button>
      
      <Modal 
        open={modalOpen()} 
        onClose={() => setModalOpen(false)}
        title="My Modal"
      >
        <p>Modal content</p>
      </Modal>
    </>
  );
}
```

### Data Fetching

```typescript
import { createResource } from "solid-js";
import { databases } from "~/lib/appwrite";

function MyComponent() {
  const [data] = createResource(async () => {
    const response = await databases.listDocuments(
      'database_id',
      'collection_id'
    );
    return response.documents;
  });
  
  return (
    <Show when={!data.loading} fallback={<div>Loading...</div>}>
      {/* Render data */}
    </Show>
  );
}
```

## Resources

- [SolidJS Documentation](https://www.solidjs.com/docs/latest)
- [SolidStart Documentation](https://start.solidjs.com/)
- [Appwrite Documentation](https://appwrite.io/docs)
- [DaisyUI Components](https://daisyui.com/components/)
- [Tailwind CSS](https://tailwindcss.com/docs)

## Support

For issues or questions:
1. Check the documentation links above
2. Review the existing Laravel codebase for business logic reference
3. Consult the Appwrite and SolidJS communities

## License

Same as original project (MIT)
