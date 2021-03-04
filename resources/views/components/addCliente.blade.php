<div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Crear Cliente</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form method="POST" action="{{ route('cliente.store') }}" role="form" id="clientForm">
            @csrf
            @include('Ventas.contacto')
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary submitbtn" data-form="#clientForm">Guardar</button>
      </div>
    </div>
  </div>
</div>