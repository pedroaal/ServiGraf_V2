@extends('layouts.app')

@section('desktop-content')
  <x-path :items="[ ['text' => 'Contactos', 'current' => true, 'href' => '#'] ]" />

  <x-blue-board title='Contactos'
    :foot="[ ['text' => 'Nuevo', 'href' => '#modalContacto', 'id' => 'nuevo', 'tipo' => 'modal'] ]">
    <table id="table" class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Organización</th>
          <th scope="col">Nombre</th>
          <th scope="col">Telf.</th>
          <th scope="col">Dirección</th>
          <th scope="col">Email</th>
          <th scope="col" class="w-2">Crud</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contactos as $item)
          <tr>
            <td>{{ $item->empresa->nombre }}</td>
            <td>{{ $item->full_name }}</td>
            <td>{{ $item->movil }}</td>
            <td>{{ $item->direccion }}</td>
            <td>{{ $item->email }}</td>
            <td>
              <x-crud :routeSee="route('contacto.show', $item->id)" routeEdit="#modalContacto" :modalEdit="$item"
                :routeDelete="route('contacto.delete', $item->id)" :textDelete="$item->full_name" />
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
      </tfoot>
    </table>
  </x-blue-board>
@endsection

@section('modals')
  <x-add-contacto />
@endsection

@section('scripts')
  <script>
    $('#table').DataTable({
      "info": false,
      "paging": true,
      "ordering": true,
      "responsive": true,
    });

    const routeStore = `{{ route('contacto.store') }}`;
    const routeEdit = `{{ route('contacto.update', 0) }}`;

    $('#modalContacto').on('show.bs.modal', event => {
      let data = $(event.relatedTarget).data('modaldata');
      let modal = $(event.target);

      let path = data ? routeEdit.replace('/0', `/${data.id}`) : routeStore;
      modal.find('#contactoForm').attr('action', path);
      modal.find("input[name='_method']").val(data ? 'PUT' : 'POST');
      modal.find(".submitbtn").html(data ? 'Modificar' : 'Crear');

      modal.find('#empresa').val(data ? data.empresa.nombre : '');
      modal.find('#ruc').val(data ? data.empresa.ruc : '');
      modal.find('#ruc').prop('readonly', data ? true : false);

      modal.find('#actividad').val(data ? data.actividad : '');
      modal.find('#titulo').val(data ? data.titulo : '');
      modal.find('#nombre').val(data ? data.nombre : '');
      modal.find('#apellido').val(data ? data.apellido : '');
      modal.find('#cargo').val(data ? data.cargo : '');
      modal.find('#direccion').val(data ? data.direccion : '');
      modal.find('#sector').val(data ? data.sector : '');
      modal.find('#email').val(data ? data.email : '');
      modal.find('#telefono').val(data ? data.telefono : '');
      modal.find('#extencion').val(data ? data.extencion : '');
      modal.find('#celular').val(data ? data.celular : '');
      modal.find('#web').val(data ? data.web : '');

      let seguimiento = false;
      if (data?.cliente?.seguimiento == '1') seguimiento = true;
      modal.find('#isCliente').prop('checked', data?.cliente ? true : false);
      modal.find('#tipo_contribuyente').val(data?.cliente?.tipo_contribuyente ?? 1);
      modal.find('#seguimiento').prop('checked', seguimiento);
    });
  </script>
@endsection
