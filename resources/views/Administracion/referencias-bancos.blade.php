@extends('layouts.app')

@section('desktop-content')
  <x-path
    :items="[ ['text' => 'Libro Diario', 'current' => false, 'href' => route('libro')], ['text' => 'Referencias y Bancos', 'current' => true, 'href' => '#'] ]" />

  <x-blue-board title='Referencias'
    :foot="[ ['text'=>'Nueva', 'href'=>'#modalReferencia', 'id'=>'newReferencia', 'tipo'=>'modal'] ]">
    <table id="tableReferencias" class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Detalle</th>
          <th scope="col" class="w-2">Crud</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($referencias as $item)
          <tr>
            <td scope="col">{{ $item->referencia }}</td>
            <td scope="col">{{ $item->descripcion }}</td>
            <td scope="col">
              <x-crud routeEdit="#modalReferencia" :modalEdit="$item" />
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </x-blue-board>

  <x-blue-board title='Bancos' :foot="[ ['text'=>'Nuevo', 'href'=>'#modalBanco', 'id'=>'newBanco', 'tipo'=>'modal'] ]">
    <table id="tableBancos" class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">No. de Cuenta</th>
          <th scope="col" class="w-2">Crud</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bancos as $item)
          <tr>
            <td scope="col">{{ $item->banco }}</td>
            <td scope="col">{{ $item->cuenta }}</td>
            <td scope="col">
              <x-crud routeEdit="#modalBanco" :modalEdit="$item" />
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </x-blue-board>
@endsection

@section('modals')
  <!-- Modal Referencia -->
  <div class="modal fade" id="modalReferencia" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Referencia</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('referencia.store') }}" method="POST" id="referencia-action">
          @csrf
          @method('POST')
          <div class="modal-body">
            <div class="form-group">
              <label for="referencia">Referencia</label>
              <input type="text" class="form-control referencia-referencia" name="referencia" id="referencia">
            </div>
            <div class="form-group">
              <label for="descripcion">Detalle</label>
              <input type="text" class="form-control referencia-descripcion" name="descripcion" id="descripcion">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary referencia-send">Crear</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Banco -->
  <div class="modal fade" id="modalBanco" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Banco</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('banco.store') }}" method="POST" id="banco-action">
          @csrf
          @method('POST')
          <div class="modal-body">
            <div class="form-group">
              <label for="banco">Banco</label>
              <input type="text" class="form-control banco-banco" name="banco" id="banco">
            </div>
            <div class="form-group">
              <label for="cuenta">Cuenta</label>
              <input type="number" class="form-control banco-cuenta" name="cuenta" id="cuenta">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary banco-send">Crear</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    const referenciaStore = `{{ route('referencia.store') }}`;
    const referenciaUpdate = `{{ route('referencia.update', 0) }}`;
    const bancoStore = `{{ route('banco.store') }}`;
    const bancoUpdate = `{{ route('banco.update', 0) }}`;

    $("#modalReferencia").on('show.bs.modal', event => {
      let data = $(event.relatedTarget).data('modaldata');
      let modal = $(event.target);

      let action = data ? referenciaUpdate.replace('/0', `/${data.id}`) : referenciaStore;
      modal.find('#referencia-action').attr('action', action);
      modal.find('.referencia-referencia').val(data ? data.referencia : '');
      modal.find('.referencia-descripcion').val(data ? data.descripcion : '');
      modal.find('.referencia-send').html(data ? 'Modificar' : 'Crear');
      modal.find("input[name='_method']").val(data ? 'PUT' : 'POST');
    });

    $("#modalBanco").on('show.bs.modal', event => {
      let data = $(event.relatedTarget).data('modaldata');
      let modal = $(event.target);

      let action = data ? bancoUpdate.replace("/0", "/" + data.id) : bancoStore;
      modal.find('#banco-action').attr('action', action);
      modal.find('.banco-banco').val(data ? data.banco : '');
      modal.find('.banco-cuenta').val(data ? data.cuenta : '');
      modal.find('.banco-send').html(data ? 'Modificar' : 'Crear');
      modal.find("input[name='_method']").val(data ? 'PUT' : 'POST');
    });
  </script>
@endsection
