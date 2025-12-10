import { Title } from "@solidjs/meta";
import { DashboardLayout } from "~/components/Layout/DashboardLayout";
import { Alert } from "~/components/Portal/Alert";
import { Loader } from "~/components/Portal/Loader";
import { useAuth } from "~/lib/auth";
import { Show } from "solid-js";

export default function Dashboard() {
  const { user, loading } = useAuth();

  return (
    <>
      <Title>Dashboard - ServiGraf V2</Title>
      <Alert />
      <Loader />
      
      <Show when={!loading()} fallback={<div>Cargando...</div>}>
        <DashboardLayout>
          <div class="space-y-6">
            <h1 class="text-3xl font-bold">Bienvenido, {user()?.name}</h1>
            
            {/* Stats */}
            <div class="stats shadow w-full bg-base-100">
              <div class="stat">
                <div class="stat-figure text-primary">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="inline-block w-8 h-8 stroke-current"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </div>
                <div class="stat-title">Pedidos Activos</div>
                <div class="stat-value text-primary">0</div>
                <div class="stat-desc">Pendientes de procesar</div>
              </div>

              <div class="stat">
                <div class="stat-figure text-secondary">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="inline-block w-8 h-8 stroke-current"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    />
                  </svg>
                </div>
                <div class="stat-title">Clientes</div>
                <div class="stat-value text-secondary">0</div>
                <div class="stat-desc">Total registrados</div>
              </div>

              <div class="stat">
                <div class="stat-figure text-accent">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="inline-block w-8 h-8 stroke-current"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                    />
                  </svg>
                </div>
                <div class="stat-title">Ingresos del Mes</div>
                <div class="stat-value text-accent">$0</div>
                <div class="stat-desc">↗︎ 0%</div>
              </div>
            </div>

            {/* Recent activity */}
            <div class="card bg-base-100 shadow-xl">
              <div class="card-body">
                <h2 class="card-title">Actividad Reciente</h2>
                <p>No hay actividad reciente para mostrar.</p>
              </div>
            </div>
          </div>
        </DashboardLayout>
      </Show>
    </>
  );
}
