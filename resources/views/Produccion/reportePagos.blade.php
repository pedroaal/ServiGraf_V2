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
      'text' => 'Reporte de pagos',
      'current' => true,
      'href' => '#',
    ]
  ]"
></x-path>

<x-filters :clientes="$clientes" cob=0 />

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
        <th scope="col">Creacion</th>
        <th scope="col">Pago</th>
        <th scope="col">Detalle</th>
        <th scope="col">Cobro</th>
        <th scope="col">Total $</th>
        <th scope="col">Abonos $</th>
        <th scope="col">Saldo $</th>
        <th scope="col" class="crudCol"></th>
        <th scope="col" class="crudCol">Crud</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6" class="text-right">Total $</td>
        <td id="clmtotal"></td>
        <td id="clmabonos"></td>
        <td id="clmsaldo"></td>
        <td colspan="2"></td>
      </tr>
    </tfoot>
  </table>
</x-blueBoard>
@endsection

@section('scripts')
<script>
  $('#cliente').select2();

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
      "url": "{{route('reporte.pagos.ajax')}}",
      "method": 'get',
      "data": {
        "fechaini": function() { return $('#inicio').val() },
        "fechafin": function() { return $('#fin').val() },
        "cliente": function() { return $('#cliente').val() },
        // "cobro": function() { return $('#cobro').val() }
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
      {"name":"creacion", "data": "fecha_entrada"},
      {"name":"pago", "data": "fecha_cobro"},
      {"name":"detalle", "data": "detalle"},
      {"name":"cobro", "data": "usuario_cobro"},
      {"name":"total", "data": "total_pedido"},
      {"name":"abonos", "data": "abono"},
      {"name":"saldo", "data": "saldo"},
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
      var aboTotal = api.column('abonos:name', {search: 'applied'}).data().sum();
      var salTotal = api.column('saldo:name', {search: 'applied'}).data().sum();

      // Update footer
      $("#clmtotal").html(totTotal.toFixed(2));
      $("#clmabonos").html(aboTotal.toFixed(2));
      $("#clmsaldo").html(salTotal.toFixed(2));
    }
  });

  // $('#refresh').on('click', function(){
  //   table.ajax.reload(null, false);
  // });

  $('.refresh').on('change', function(){
    table.ajax.reload(null, false);
  });
</script>
@endsection