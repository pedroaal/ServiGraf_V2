# Implementation Guide - SolidStart Migration

This guide provides step-by-step instructions for completing the migration from Laravel to SolidStart.

## Quick Reference

- **Framework**: SolidJS with SolidStart
- **Backend**: Appwrite (BaaS)
- **UI**: DaisyUI + Tailwind CSS
- **Language**: TypeScript

## Table of Contents

1. [Setting Up Development Environment](#setting-up-development-environment)
2. [Appwrite Configuration](#appwrite-configuration)
3. [Creating New Features](#creating-new-features)
4. [Working with Data](#working-with-data)
5. [Common Patterns](#common-patterns)
6. [Migration Checklist](#migration-checklist)

---

## Setting Up Development Environment

### 1. Prerequisites

```bash
# Check versions
node --version  # Should be v20+
npm --version   # Should be v10+
```

### 2. Install Dependencies

```bash
npm install
```

### 3. Configure Environment

```bash
cp .env.example .env
# Edit .env with your Appwrite credentials
```

### 4. Run Development Server

```bash
npm run dev
```

Visit http://localhost:3000

---

## Appwrite Configuration

### 1. Create Appwrite Project

1. Go to https://cloud.appwrite.io
2. Create new project
3. Note your Project ID

### 2. Setup Authentication

1. Navigate to **Auth** section
2. Enable **Email/Password** provider
3. Add your domain to **Platforms** → **Web**

### 3. Create Database

1. Go to **Databases**
2. Create new database
3. Note your Database ID

### 4. Create Collections

Use the `APPWRITE_SCHEMA.md` file as reference. For each collection:

1. Click **Create Collection**
2. Set collection name (e.g., `pedidos`, `clientes`)
3. Add attributes based on schema
4. Configure permissions:
   - **Read**: `role:authenticated`
   - **Write**: Based on user role

Example for `pedidos` collection:

```javascript
// Attributes
- codigo: string, required, unique
- cliente_id: string, required
- empresa_id: string, required
- fecha_pedido: datetime
- fecha_entrega: datetime
- descripcion: string
- total: float
- status: string
```

### 5. Update Environment Variables

```bash
VITE_APPWRITE_ENDPOINT=https://cloud.appwrite.io/v1
VITE_APPWRITE_PROJECT_ID=your_project_id
VITE_APPWRITE_DATABASE_ID=your_database_id
```

---

## Creating New Features

### 1. Create a New Route

File-based routing: `src/routes/[path].tsx`

```typescript
// src/routes/dashboard/my-feature.tsx
import { Title } from "@solidjs/meta";
import { DashboardLayout } from "~/components/Layout/DashboardLayout";
import { Alert } from "~/components/Portal/Alert";
import { Loader } from "~/components/Portal/Loader";

export default function MyFeature() {
  return (
    <>
      <Title>My Feature - ServiGraf V2</Title>
      <Alert />
      <Loader />

      <DashboardLayout>
        <div class="space-y-6">
          <h1 class="text-3xl font-bold">My Feature</h1>
          {/* Your content */}
        </div>
      </DashboardLayout>
    </>
  );
}
```

### 2. Create a New Component

```typescript
// src/components/MyComponent.tsx
import { Component } from "solid-js";

interface MyComponentProps {
  title: string;
}

export const MyComponent: Component<MyComponentProps> = (props) => {
  return (
    <div class="card bg-base-100 shadow-xl">
      <div class="card-body">
        <h2 class="card-title">{props.title}</h2>
        <p>Content goes here</p>
      </div>
    </div>
  );
};
```

### 3. Add to Navigation

Edit `src/components/Layout/DashboardLayout.tsx`:

```typescript
<li>
  <A href="/dashboard/my-feature">My Feature</A>
</li>
```

---

## Working with Data

### 1. List Documents

```typescript
import { createSignal, onMount } from "solid-js";
import { databases } from "~/lib/appwrite";

function MyComponent() {
  const [data, setData] = createSignal([]);
  const [loading, setLoading] = createSignal(true);

  onMount(async () => {
    try {
      const response = await databases.listDocuments(
        import.meta.env.VITE_APPWRITE_DATABASE_ID,
        'collection_id'
      );
      setData(response.documents);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  });

  return (
    <Show when={!loading()} fallback={<div>Loading...</div>}>
      <For each={data()}>
        {(item) => <div>{item.name}</div>}
      </For>
    </Show>
  );
}
```

### 2. Create Document

```typescript
import { databases } from "~/lib/appwrite";
import { showAlert, showLoader, hideLoader } from "~/components/Portal";

async function createItem(data: any) {
  showLoader("Creating...");
  
  try {
    await databases.createDocument(
      import.meta.env.VITE_APPWRITE_DATABASE_ID,
      'collection_id',
      'unique()', // Auto-generate ID
      data
    );
    
    showAlert({
      type: 'success',
      message: 'Item created successfully!'
    });
  } catch (error) {
    showAlert({
      type: 'error',
      message: error.message
    });
  } finally {
    hideLoader();
  }
}
```

### 3. Update Document

```typescript
async function updateItem(id: string, data: any) {
  try {
    await databases.updateDocument(
      import.meta.env.VITE_APPWRITE_DATABASE_ID,
      'collection_id',
      id,
      data
    );
    
    showAlert({
      type: 'success',
      message: 'Item updated successfully!'
    });
  } catch (error) {
    showAlert({
      type: 'error',
      message: error.message
    });
  }
}
```

### 4. Delete Document

```typescript
import { ConfirmModal } from "~/components/Portal/Modal";

function MyComponent() {
  const [deleteConfirm, setDeleteConfirm] = createSignal(false);
  const [itemToDelete, setItemToDelete] = createSignal<string | null>(null);

  const handleDelete = async () => {
    if (!itemToDelete()) return;
    
    try {
      await databases.deleteDocument(
        import.meta.env.VITE_APPWRITE_DATABASE_ID,
        'collection_id',
        itemToDelete()!
      );
      
      showAlert({
        type: 'success',
        message: 'Item deleted successfully!'
      });
      
      // Refresh data
    } catch (error) {
      showAlert({
        type: 'error',
        message: error.message
      });
    } finally {
      setDeleteConfirm(false);
      setItemToDelete(null);
    }
  };

  return (
    <>
      <button
        onClick={() => {
          setItemToDelete('item_id');
          setDeleteConfirm(true);
        }}
        class="btn btn-error"
      >
        Delete
      </button>

      <ConfirmModal
        open={deleteConfirm()}
        title="Confirmar Eliminación"
        message="¿Está seguro de que desea eliminar este elemento?"
        onConfirm={handleDelete}
        onCancel={() => setDeleteConfirm(false)}
        confirmText="Eliminar"
        cancelText="Cancelar"
      />
    </>
  );
}
```

### 5. Using createResource (Recommended)

```typescript
import { createResource, For, Show } from "solid-js";
import { databases } from "~/lib/appwrite";

function MyComponent() {
  const [data, { refetch }] = createResource(async () => {
    const response = await databases.listDocuments(
      import.meta.env.VITE_APPWRITE_DATABASE_ID,
      'collection_id'
    );
    return response.documents;
  });

  return (
    <Show when={!data.loading} fallback={<div>Loading...</div>}>
      <For each={data()}>
        {(item) => <div>{item.name}</div>}
      </For>
      <button onClick={() => refetch()}>Refresh</button>
    </Show>
  );
}
```

---

## Common Patterns

### 1. Form Handling

```typescript
import { createSignal } from "solid-js";

function MyForm() {
  const [formData, setFormData] = createSignal({
    name: "",
    email: "",
  });

  const handleSubmit = async (e: Event) => {
    e.preventDefault();
    
    // Validate
    if (!formData().name || !formData().email) {
      showAlert({ type: 'error', message: 'All fields are required' });
      return;
    }

    // Submit
    showLoader("Saving...");
    try {
      await databases.createDocument(
        import.meta.env.VITE_APPWRITE_DATABASE_ID,
        'collection_id',
        'unique()',
        formData()
      );
      
      showAlert({ type: 'success', message: 'Saved!' });
      
      // Reset form
      setFormData({ name: "", email: "" });
    } catch (error) {
      showAlert({ type: 'error', message: error.message });
    } finally {
      hideLoader();
    }
  };

  return (
    <form onSubmit={handleSubmit} class="space-y-4">
      <div class="form-control">
        <label class="label">
          <span class="label-text">Name</span>
        </label>
        <input
          type="text"
          class="input input-bordered"
          value={formData().name}
          onInput={(e) =>
            setFormData({ ...formData(), name: e.currentTarget.value })
          }
        />
      </div>

      <div class="form-control">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <input
          type="email"
          class="input input-bordered"
          value={formData().email}
          onInput={(e) =>
            setFormData({ ...formData(), email: e.currentTarget.value })
          }
        />
      </div>

      <button type="submit" class="btn btn-primary">
        Submit
      </button>
    </form>
  );
}
```

### 2. Search and Filter

```typescript
import { createSignal, createMemo } from "solid-js";

function MyList() {
  const [items, setItems] = createSignal([]);
  const [searchTerm, setSearchTerm] = createSignal("");

  const filteredItems = createMemo(() => {
    const term = searchTerm().toLowerCase();
    return items().filter((item) =>
      item.name.toLowerCase().includes(term)
    );
  });

  return (
    <>
      <input
        type="text"
        class="input input-bordered"
        placeholder="Search..."
        value={searchTerm()}
        onInput={(e) => setSearchTerm(e.currentTarget.value)}
      />

      <For each={filteredItems()}>
        {(item) => <div>{item.name}</div>}
      </For>
    </>
  );
}
```

### 3. Pagination

```typescript
import { createSignal } from "solid-js";

function PaginatedList() {
  const [page, setPage] = createSignal(1);
  const [limit] = createSignal(25);

  const [data] = createResource(
    () => ({ page: page(), limit: limit() }),
    async ({ page, limit }) => {
      const response = await databases.listDocuments(
        import.meta.env.VITE_APPWRITE_DATABASE_ID,
        'collection_id',
        [
          Query.limit(limit),
          Query.offset((page - 1) * limit),
        ]
      );
      return response;
    }
  );

  return (
    <>
      <For each={data()?.documents}>
        {(item) => <div>{item.name}</div>}
      </For>

      <div class="join">
        <button
          class="join-item btn"
          disabled={page() === 1}
          onClick={() => setPage(page() - 1)}
        >
          Previous
        </button>
        <button class="join-item btn">Page {page()}</button>
        <button
          class="join-item btn"
          onClick={() => setPage(page() + 1)}
        >
          Next
        </button>
      </div>
    </>
  );
}
```

---

## Migration Checklist

### Phase 1: Core Infrastructure ✅
- [x] SolidStart setup
- [x] Appwrite integration
- [x] Portal components
- [x] Authentication
- [x] Dashboard layout

### Phase 2: Data Layer
- [ ] Create all Appwrite collections
- [ ] Set up collection permissions
- [ ] Create indexes
- [ ] Write migration scripts
- [ ] Test data import

### Phase 3: Components
- [ ] Form components
- [ ] Table components
- [ ] File upload
- [ ] Charts
- [ ] Reports

### Phase 4: Producción Module
- [ ] Pedidos CRUD
- [ ] Procesos CRUD
- [ ] Materiales CRUD
- [ ] Areas and Maquinas
- [ ] Reports

### Phase 5: CRM/Ventas Module
- [ ] Clientes CRUD
- [ ] Contactos CRUD
- [ ] Actividades CRUD
- [ ] Comments system

### Phase 6: RRHH Module
- [ ] Nómina management
- [ ] Employee records
- [ ] Attendance tracking
- [ ] Documents

### Phase 7: Sistema/Admin
- [ ] User management
- [ ] Roles and permissions
- [ ] System settings
- [ ] Notifications

### Phase 8: Additional Features
- [ ] Email notifications
- [ ] File storage
- [ ] Analytics
- [ ] PDF generation
- [ ] Export functionality

---

## Tips and Best Practices

1. **Use Portals**: Always render alerts, modals, and loaders in portals
2. **Type Safety**: Define interfaces for your data structures
3. **Error Handling**: Always wrap Appwrite calls in try-catch
4. **Loading States**: Show loaders for async operations
5. **Validation**: Validate forms before submission
6. **Responsive**: Use DaisyUI responsive classes
7. **Permissions**: Test with different user roles
8. **Performance**: Use createMemo for expensive computations
9. **Lazy Loading**: Use lazy() for code splitting
10. **Testing**: Test critical paths manually

---

## Troubleshooting

### Issue: "Cannot find module"
**Solution**: Check your tsconfig.json paths and imports

### Issue: Appwrite connection error
**Solution**: Verify .env variables and Appwrite project settings

### Issue: Build fails
**Solution**: Run `npm install` and check for dependency conflicts

### Issue: Portal components not rendering
**Solution**: Ensure portal-root div exists in entry-server.tsx

---

## Resources

- [SolidJS Docs](https://www.solidjs.com/docs)
- [SolidStart Docs](https://start.solidjs.com/)
- [Appwrite Docs](https://appwrite.io/docs)
- [DaisyUI Components](https://daisyui.com/components/)
- [Tailwind CSS](https://tailwindcss.com/docs)

## Need Help?

1. Check existing documentation
2. Review example implementations in codebase
3. Consult community forums
4. Review Laravel code for business logic
