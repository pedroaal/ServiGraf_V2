import { createSignal, createEffect, JSX } from "solid-js";
import { account } from "~/lib/appwrite";
import { useNavigate } from "@solidjs/router";
import { showAlert } from "~/components/Portal";

export function useAuth() {
  const [user, setUser] = createSignal<any>(null);
  const [loading, setLoading] = createSignal(true);
  const navigate = useNavigate();

  // Check if user is logged in
  createEffect(async () => {
    try {
      const currentUser = await account.get();
      setUser(currentUser);
    } catch (error) {
      setUser(null);
    } finally {
      setLoading(false);
    }
  });

  const login = async (email: string, password: string) => {
    try {
      await account.createEmailPasswordSession(email, password);
      const currentUser = await account.get();
      setUser(currentUser);
      showAlert({ type: "success", message: "Inicio de sesión exitoso" });
      navigate("/dashboard");
      return true;
    } catch (error: any) {
      showAlert({ type: "error", message: error.message || "Error al iniciar sesión" });
      return false;
    }
  };

  const register = async (email: string, password: string, name: string) => {
    try {
      await account.create("unique()", email, password, name);
      await login(email, password);
      return true;
    } catch (error: any) {
      showAlert({ type: "error", message: error.message || "Error al registrarse" });
      return false;
    }
  };

  const logout = async () => {
    try {
      await account.deleteSession("current");
      setUser(null);
      showAlert({ type: "success", message: "Sesión cerrada" });
      navigate("/");
    } catch (error: any) {
      showAlert({ type: "error", message: error.message || "Error al cerrar sesión" });
    }
  };

  return {
    user,
    loading,
    login,
    register,
    logout,
  };
}
