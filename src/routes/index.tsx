import { Title } from "@solidjs/meta";
import { Alert } from "~/components/Portal/Alert";
import { Loader } from "~/components/Portal/Loader";

export default function Home() {
  return (
    <main class="min-h-screen">
      <Title>ServiGraf V2 - ERP System</Title>
      
      {/* Portal components for alerts and loaders */}
      <Alert />
      <Loader />
      
      <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
          <div class="max-w-md">
            <h1 class="text-5xl font-bold">ServiGraf V2</h1>
            <p class="py-6">
              Sistema ERP migrado de Laravel + Bootstrap a SolidStart + Appwrite + DaisyUI
            </p>
            <div class="space-x-4">
              <a href="/login" class="btn btn-primary">Iniciar Sesión</a>
              <a href="/register" class="btn btn-secondary">Registrarse</a>
            </div>
          </div>
        </div>
      </div>
    </main>
  );
}
