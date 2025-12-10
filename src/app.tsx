// @refresh reload
import { Router } from "@solidjs/router";
import { FileRoutes } from "@solidjs/start/router";
import { Suspense } from "solid-js";
import "./styles/app.css";

export default function App() {
  return (
    <Router
      root={(props) => (
        <>
          <Suspense>{props.children}</Suspense>
          {/* Portal mount point for alerts, modals, and loaders */}
          <div id="portal-root" />
        </>
      )}
    >
      <FileRoutes />
    </Router>
  );
}
