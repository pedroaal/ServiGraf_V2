import { Portal as SolidPortal } from "solid-js/web";
import { JSX, ParentComponent } from "solid-js";

/**
 * Portal component for rendering children in a portal
 * Used for alerts, modals, and loaders to maintain proper render order
 */
export const Portal: ParentComponent<{
  mount?: Node;
}> = (props) => {
  return (
    <SolidPortal mount={props.mount || document.getElementById("portal-root")!}>
      {props.children}
    </SolidPortal>
  );
};
