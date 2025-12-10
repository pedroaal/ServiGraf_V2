import { Title } from "@solidjs/meta";
import { DashboardLayout } from "~/components/Layout/DashboardLayout";
import { Alert } from "~/components/Portal/Alert";
import { Loader } from "~/components/Portal/Loader";
import { createSignal, For } from "solid-js";
import { Modal } from "~/components/Portal/Modal";

interface Pedido {
  id: string;
  codigo: string;
  cliente: string;
  fecha_pedido: string;
  fecha_entrega: string;
  total: number;
  status: string;
}

export default function Pedidos() {
  const [pedidos, setPedidos] = createSignal<Pedido[]>([
    // Example data - in real app this would come from Appwrite
  ]);
  const [modalOpen, setModalOpen] = createSignal(false);

  const statusClass = (status: string) => {
    switch (status) {
      case "pending":
        return "badge badge-warning";
      case "processing":
        return "badge badge-info";
      case "completed":
        return "badge badge-success";
      case "cancelled":
        return "badge badge-error";
      default:
        return "badge";
    }
  };

  return (
    <>
      <Title>Pedidos - ServiGraf V2</Title>
      <Alert />
      <Loader />

      <DashboardLayout>
        <div class="space-y-6">
          <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Gestión de Pedidos</h1>
            <button
              class="btn btn-primary"
              onClick={() => setModalOpen(true)}
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4"
                />
              </svg>
              Nuevo Pedido
            </button>
          </div>

          {/* Stats */}
          <div class="stats stats-vertical lg:stats-horizontal shadow w-full bg-base-100">
            <div class="stat">
              <div class="stat-title">Pedidos Pendientes</div>
              <div class="stat-value text-warning">0</div>
            </div>
            <div class="stat">
              <div class="stat-title">En Proceso</div>
              <div class="stat-value text-info">0</div>
            </div>
            <div class="stat">
              <div class="stat-title">Completados</div>
              <div class="stat-value text-success">0</div>
            </div>
            <div class="stat">
              <div class="stat-title">Total del Mes</div>
              <div class="stat-value text-primary">$0</div>
            </div>
          </div>

          {/* Table */}
          <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
              <h2 class="card-title">Lista de Pedidos</h2>

              <div class="overflow-x-auto">
                <table class="table table-zebra">
                  <thead>
                    <tr>
                      <th>Código</th>
                      <th>Cliente</th>
                      <th>Fecha Pedido</th>
                      <th>Fecha Entrega</th>
                      <th>Total</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <For
                      each={pedidos()}
                      fallback={
                        <tr>
                          <td colspan="7" class="text-center py-8">
                            No hay pedidos registrados. Haz clic en "Nuevo Pedido" para crear uno.
                          </td>
                        </tr>
                      }
                    >
                      {(pedido) => (
                        <tr>
                          <td>{pedido.codigo}</td>
                          <td>{pedido.cliente}</td>
                          <td>{pedido.fecha_pedido}</td>
                          <td>{pedido.fecha_entrega}</td>
                          <td>${pedido.total.toFixed(2)}</td>
                          <td>
                            <span class={statusClass(pedido.status)}>
                              {pedido.status}
                            </span>
                          </td>
                          <td>
                            <div class="join">
                              <button class="btn btn-sm join-item">
                                Ver
                              </button>
                              <button class="btn btn-sm join-item">
                                Editar
                              </button>
                              <button class="btn btn-sm btn-error join-item">
                                Eliminar
                              </button>
                            </div>
                          </td>
                        </tr>
                      )}
                    </For>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        {/* New Order Modal */}
        <Modal
          open={modalOpen()}
          onClose={() => setModalOpen(false)}
          title="Nuevo Pedido"
        >
          <form class="space-y-4">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Cliente</span>
              </label>
              <select class="select select-bordered">
                <option disabled selected>
                  Seleccionar cliente
                </option>
                <option>Cliente 1</option>
                <option>Cliente 2</option>
              </select>
            </div>

            <div class="form-control">
              <label class="label">
                <span class="label-text">Descripción</span>
              </label>
              <textarea
                class="textarea textarea-bordered"
                placeholder="Descripción del pedido"
              />
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Fecha Pedido</span>
                </label>
                <input type="date" class="input input-bordered" />
              </div>

              <div class="form-control">
                <label class="label">
                  <span class="label-text">Fecha Entrega</span>
                </label>
                <input type="date" class="input input-bordered" />
              </div>
            </div>

            <div class="form-control">
              <label class="label">
                <span class="label-text">Cantidad</span>
              </label>
              <input
                type="number"
                class="input input-bordered"
                placeholder="0"
              />
            </div>

            <div class="modal-action">
              <button
                type="button"
                class="btn"
                onClick={() => setModalOpen(false)}
              >
                Cancelar
              </button>
              <button type="submit" class="btn btn-primary">
                Guardar
              </button>
            </div>
          </form>
        </Modal>
      </DashboardLayout>
    </>
  );
}
