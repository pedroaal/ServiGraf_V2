import { createSignal, Show, JSX } from "solid-js";
import { Portal } from "./Portal";

export type AlertType = "success" | "error" | "warning" | "info";

export interface AlertConfig {
  type: AlertType;
  message: string;
  duration?: number;
}

const [currentAlert, setCurrentAlert] = createSignal<AlertConfig | null>(null);

/**
 * Show an alert notification
 */
export function showAlert(config: AlertConfig) {
  setCurrentAlert(config);
  
  // Auto-dismiss after duration
  const duration = config.duration || 5000;
  setTimeout(() => {
    setCurrentAlert(null);
  }, duration);
}

/**
 * Dismiss the current alert
 */
export function dismissAlert() {
  setCurrentAlert(null);
}

/**
 * Alert component that renders in a Portal
 */
export function Alert() {
  const alertClass = () => {
    const alert = currentAlert();
    if (!alert) return "";
    
    const baseClass = "alert shadow-lg";
    switch (alert.type) {
      case "success":
        return `${baseClass} alert-success`;
      case "error":
        return `${baseClass} alert-error`;
      case "warning":
        return `${baseClass} alert-warning`;
      case "info":
        return `${baseClass} alert-info`;
      default:
        return baseClass;
    }
  };

  return (
    <Show when={currentAlert()}>
      <Portal>
        <div class="fixed top-4 right-4 z-50 w-96 max-w-full">
          <div class={alertClass()}>
            <div class="flex items-center justify-between w-full">
              <span>{currentAlert()?.message}</span>
              <button
                class="btn btn-sm btn-ghost"
                onClick={dismissAlert}
              >
                ✕
              </button>
            </div>
          </div>
        </div>
      </Portal>
    </Show>
  );
}
