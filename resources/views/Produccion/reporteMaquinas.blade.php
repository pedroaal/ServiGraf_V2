@extends('layouts.app')

@section('links')
@endsection

@section('desktop-content')
<x-path
  :items="[
    [
      'text' => 'Pedidos',
      'current' => false,
      'href' => route('pedidos'),
    ],
    [
      'text' => 'Reporte de maquinas',
      'current' => true,
      'href' => '#',
    ]
  ]"
></x-path>

<x-filters :clientes="[]" cli=false />

<x-blueBoard
  title='Reporte'
  :foot="[
    ['text'=>'fas fa-print', 'href'=>'imprimir(\'tabla\')', 'id'=>'print', 'tipo'=>'button'],
  ]"
>
  <table id="table" class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">No.</th>
        <th scope="col">Cliente</th>
        <th scope="col">Detalle</th>
        @foreach ($servicios as $servicio)
        <th scope="col">{{$servicio->servicio}}</th>
        @endforeach
        <th scope="col">Total $</th>
        <th scope="col" class="crudCol"></th>
        <th scope="col" class="crudCol">Crud</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" class="text-right">Total $</td>
        @foreach ($servicios as $servicio)
        <th scope="col" id="{{'serv'.$servicio->id}}"></th>
        @endforeach
        <td id="clmtotal"></td>
        <td colspan="2"></td>
      </tr>
    </tfoot>
  </table>
</x-blueBoard>
@endsection

@section('scripts')
<script>
  let servicios = @json($servicios);
  $('#cliente').select2();

  // console.log(areas.length);
  var table = $('#table').DataTable({
    "paging":   true,
    "ordering": true,
    "info":     false,
    "responsive": true,
    "buttons": [{
      extend: 'print',
      text: 'Imprimir Reporte',
      autoPrint: false
    }],
    "ajax": {
      "url": "{{route('reporte.maquinas.ajax')}}",
      "method": 'get',
      "dataSrc": '',
      "data": {
        "fechaini": function() { return $('#inicio').val() },
        "fechafin": function() { return $('#fin').val() },
        "cobro": function() { return $('#cobro').val() }
      },
      // "success": function(data){
      //   console.log(data);
      // },
      "error": function(reason) {
        alert('Ha ocurrido un error al cargar los datos!');
        console.log('error -> ');
        console.log(reason);
      }
    },
    "columns": [
      {"name":"numero", "data": "numero"},
      {"name":"cliente", "data": "cliente_nom"},
      {"name":"detalle", "data": "detalle"},
      @foreach($servicios as $servicio)
      {"name":"{{'serv'.$servicio->id}}", "data":"servicios", "defaultContent": "", "render":function(data, type, full, meta){
        let servicio = data.find(record => record.servicio_id === '{{ $servicio->id }}');
        return servicio ? servicio.totalServicio : '';
      }},
      @endforeach
      {"name":"total", "data": "total_pedido"},
      {"name":"estado", "data": "estado", "sortable": "false",
        "render": function ( data, type, full, meta ) {
          var rspt;
          if(data == '1') rspt = "<em class='fa fa-times'></em>";
          else if(data == '2') rspt = "<em class='fa fa-check'></em>";
          else if(data == '3') rspt = "<em class='fas fa-trash'></em>";
          else if(data == '4') rspt = "<em class='fas fa-exchange-alt'></em>";
          else rspt = "<em class='fa fa-ban'></em>";
          return rspt;
        },
      },
      {"name":"crud", "data":"id", "sortable": "false",
        "render": function ( data, type, full, meta ) {
          return "<a class='fa fa-edit' href='/pedido/modificar/"+data+"'></a> <a class='fa fa-eye' href='#' onClick='openOt("+data+")'></a>"
        }
      }
    ],
    "columnDefs": [
      { "responsivePriority": 1, "targets": [0, 1, -2, -3] }
    ],
    "footerCallback": function(row, data, start, end, display) {
      var api = this.api(), data;
      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
        return typeof i === 'string' ?
        i.replace(/[\$,]/g, '')*1 :
        typeof i === 'number' ?
        i : 0;
      };

      // Total over this page
      var totTotal = api.column('total:name', {search: 'applied'}).data().sum();
      // Update footer
      $("#clmtotal").html(totTotal.toFixed(2));

      @foreach($servicios as $servicio)
      let {{"dataserv".$servicio->id}} = api.column('{{"serv".$servicio->id}}:name', {search: 'applied'}).cache('search');
      let {{"totserv".$servicio->id}} = {{'dataserv'.$servicio->id}}.length ? {{'dataserv'.$servicio->id}}.sum() : 0;
      $("#{{'serv'.$servicio->id}}").html({{'totserv'.$servicio->id}}.toFixed(2));
      @endforeach
    }
  });

  $('.refresh').on('change', function(){
    table.ajax.reload(null, false);
  });
</script>
@endsection