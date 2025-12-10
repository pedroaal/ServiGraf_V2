import { Title } from "@solidjs/meta";
import { createSignal } from "solid-js";
import { Alert } from "~/components/Portal/Alert";
import { Loader } from "~/components/Portal/Loader";
import { useAuth } from "~/lib/auth";
import { A } from "@solidjs/router";

export default function Register() {
  const [name, setName] = createSignal("");
  const [email, setEmail] = createSignal("");
  const [password, setPassword] = createSignal("");
  const [confirmPassword, setConfirmPassword] = createSignal("");
  const { register } = useAuth();

  const handleSubmit = async (e: Event) => {
    e.preventDefault();
    
    if (password() !== confirmPassword()) {
      alert("Las contraseñas no coinciden");
      return;
    }
    
    await register(email(), password(), name());
  };

  return (
    <main class="min-h-screen bg-base-200">
      <Title>Registrarse - ServiGraf V2</Title>
      <Alert />
      <Loader />
      
      <div class="hero min-h-screen">
        <div class="hero-content flex-col lg:flex-row-reverse">
          <div class="text-center lg:text-left">
            <h1 class="text-5xl font-bold">Registrarse</h1>
            <p class="py-6">
              Crea tu cuenta en el sistema ERP ServiGraf V2
            </p>
          </div>
          <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
            <form class="card-body" onSubmit={handleSubmit}>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Nombre</span>
                </label>
                <input
                  type="text"
                  placeholder="Tu nombre"
                  class="input input-bordered"
                  value={name()}
                  onInput={(e) => setName(e.currentTarget.value)}
                  required
                />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Email</span>
                </label>
                <input
                  type="email"
                  placeholder="email@ejemplo.com"
                  class="input input-bordered"
                  value={email()}
                  onInput={(e) => setEmail(e.currentTarget.value)}
                  required
                />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Contraseña</span>
                </label>
                <input
                  type="password"
                  placeholder="contraseña"
                  class="input input-bordered"
                  value={password()}
                  onInput={(e) => setPassword(e.currentTarget.value)}
                  required
                />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Confirmar Contraseña</span>
                </label>
                <input
                  type="password"
                  placeholder="confirmar contraseña"
                  class="input input-bordered"
                  value={confirmPassword()}
                  onInput={(e) => setConfirmPassword(e.currentTarget.value)}
                  required
                />
              </div>
              <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">
                  Registrarse
                </button>
              </div>
              <div class="divider">O</div>
              <div class="text-center">
                <A href="/login" class="link link-primary">
                  ¿Ya tienes cuenta? Inicia sesión
                </A>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  );
}
