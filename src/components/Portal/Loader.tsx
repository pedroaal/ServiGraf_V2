import { createSignal, Show } from "solid-js";
import { Portal } from "./Portal";

const [loading, setLoading] = createSignal(false);
const [loadingMessage, setLoadingMessage] = createSignal<string | null>(null);

/**
 * Show loading indicator
 */
export function showLoader(message?: string) {
  setLoadingMessage(message || null);
  setLoading(true);
}

/**
 * Hide loading indicator
 */
export function hideLoader() {
  setLoading(false);
  setLoadingMessage(null);
}

/**
 * Loader component that renders in a Portal
 */
export function Loader() {
  return (
    <Show when={loading()}>
      <Portal>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
          <div class="bg-base-100 p-8 rounded-lg shadow-xl flex flex-col items-center gap-4">
            <span class="loading loading-spinner loading-lg"></span>
            <Show when={loadingMessage()}>
              <p class="text-lg">{loadingMessage()}</p>
            </Show>
          </div>
        </div>
      </Portal>
    </Show>
  );
}
