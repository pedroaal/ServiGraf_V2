@extends('layouts.app')

@section('links')
@endsection

@section('desktop-content')
<x-path
  :items="[
    [
      'text' => 'Procesos',
      'current' => true,
      'href' => route('procesos'),
    ]
  ]"
/>

<x-blueBoard
  title='Áreas'
  :foot="[
    ['text'=>'Nueva', 'href'=>'#modalArea', 'id'=>'newArea', 'tipo'=> 'modal'],
  ]"
>
  <div class="row">
    @foreach ($areas as $item)
    <div class="col-6 col-md-2">
    <a class="fas fa-edit modArea" href="#modalArea" data-toggle="modal" data-route="{{ route('area.update', $item->id) }}" data-area="{{ $item->area }}" data-orden="{{ $item->orden }}"></a>
      &nbsp;&nbsp;{{ $item->area }}
    </div>
    @endforeach
  </div>
</x-blueBoard>

<x-blueBoard
  title='Servicios'
  :foot="[
    ['text'=>'Nuevo', 'href'=>route('servicio.create'), 'id'=>'nuevo', 'tipo'=> 'link'],
  ]"
>
  <table id="tableServ" class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">Area</th>
        <th scope="col">Servicio</th>
        <th scope="col">Meta $</th>
        <th scope="col">T xM</th>
        <th scope="col">T xO</th>
        <th scope="col">Tipo</th>
        <th scope="col" class="crudCol">Seguimiento</th>
        <th scope="col" class="crudCol">Crud</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($servicios as $item)
      <tr>
        <td>{{ $item->area->area }}</td>
        <td>{{ $item->servicio }}</td>
        <td>{{ $item->meta }}</td>
        <td>{{ $item->tmaquina ?? '' }}</td>
        <td>{{ $item->toperador ?? '' }}</td>
        <td>{{ $item->tipo ? 'Interno' : 'Externo' }}</td>
        <td><i class="{{ $item->seguimiento ? 'fas fa-check' : 'fas fa-times' }}"></i></td>
        <td><a class='fa fa-edit' href='{{route('servicio.edit', $item->id)}}'></a> <a class='fa fa-eye' id="{{ $item->id }}"></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table> 
</x-blueBoard>

<x-blueBoard
  title='Subservicios'
  :foot="[
    ['text'=>'Nuevo', 'href'=>route('subservicio.create'), 'id'=>'nuevo', 'tipo'=> 'link'],
  ]"
>
  <table id="tableSubs" class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">Servicio</th>
        <th scope="col">Subservicio</th>
        <th scope="col">T xM</th>
        <th scope="col">T xO</th>
        <th scope="col">Tipo</th>
        <th scope="col" class="crudCol">Crud</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($subservicios as $item)
      <tr>
        <td>{{ $item->servicio->servicio }}</td>
        <td>{{ $item->subservicio }}</td>
        <td>{{ $item->tmaquina ?? '' }}</td>
        <td>{{ $item->toperador ?? '' }}</td>
        <td>{{ $item->tipo ? 'Interno' : 'Externo' }}</td>
        <td><a class='fa fa-edit' href='{{route('subservicio.edit', $item->id)}}'></a> <a class='fa fa-eye' id="{{ $item->id }}"></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table> 
</x-blueBoard>


<!-- Modal AREAS -->
<div id="modalArea" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('area.store') }}" method="post" class="modal-path">
              @csrf
              @method('POST')
              <div class="modal-body">
                <div class="form-group">
                  <label for="area">Área</label>
                  <input type="text" name="area" id="area" class="form-control modal-area">
                </div>
                <div class="form-group">
                  <label for="orden">Orden</label>
                  <input type="number" name="orden" id="orden" class="form-control modal-orden">
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#tableServ').DataTable({
      "paging":   true,
      "ordering": true,
      "info":     false,
      "responsive": true,
    });
    $('#tableSubs').DataTable({
      "paging":   true,
      "ordering": true,
      "info":     false,
      "responsive": true,
    });
  });

  // AREAS
  $('#newArea').on('click', function (event) {
    var modal = $('#modalArea');
    modal.find('.modal-title').html('Nueva Área');
    modal.find('.modal-area').val('');
    modal.find('.modal-orden').val('');
    modal.find('.modal-path').attr('action', '{{ route("area.store") }}');
    modal.find('input[name="_method"]').val('POST');
  });

  $('.modArea').on('click', function (event) {
    var button = $(this);
    var modal = $('#modalArea');
    modal.find('.modal-title').html('Modificar Área');
    modal.find('.modal-area').val(button.data('area'));
    modal.find('.modal-orden').val(button.data('orden'));
    modal.find('.modal-path').attr('action', button.data('route'));
    modal.find('input[name="_method"]').val('PUT');
  });
</script>
@endsection