import { createSignal, Show, JSX, ParentComponent } from "solid-js";
import { Portal } from "./Portal";

export interface ModalProps {
  title?: string;
  open: boolean;
  onClose: () => void;
  children: JSX.Element;
}

/**
 * Modal component that renders in a Portal
 */
export const Modal: ParentComponent<ModalProps> = (props) => {
  return (
    <Show when={props.open}>
      <Portal>
        <div class="modal modal-open">
          <div class="modal-box relative max-w-5xl">
            <button
              class="btn btn-sm btn-circle absolute right-2 top-2"
              onClick={props.onClose}
            >
              ✕
            </button>
            {props.title && <h3 class="font-bold text-lg mb-4">{props.title}</h3>}
            <div class="py-4">{props.children}</div>
          </div>
          <div class="modal-backdrop" onClick={props.onClose} />
        </div>
      </Portal>
    </Show>
  );
};

/**
 * Confirmation Modal
 */
export interface ConfirmModalProps {
  title?: string;
  message: string;
  open: boolean;
  onConfirm: () => void;
  onCancel: () => void;
  confirmText?: string;
  cancelText?: string;
}

export const ConfirmModal: ParentComponent<ConfirmModalProps> = (props) => {
  return (
    <Modal
      title={props.title || "Confirmar"}
      open={props.open}
      onClose={props.onCancel}
    >
      <p class="py-4">{props.message}</p>
      <div class="modal-action">
        <button class="btn" onClick={props.onCancel}>
          {props.cancelText || "Cancelar"}
        </button>
        <button class="btn btn-primary" onClick={props.onConfirm}>
          {props.confirmText || "Confirmar"}
        </button>
      </div>
    </Modal>
  );
};
