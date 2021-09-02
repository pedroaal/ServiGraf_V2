@php
  $proveedores = App\Models\Produccion\Proveedor::where('empresa_id', Auth::user()->empresa_id)->get();
  $materiales = App\Models\Produccion\Material::where('empresa_id', Auth::user()->empresa_id)->orderBy('categoria_id')->with('categoria')->get();
  // $procesos = App\Models\Produccion\Proceso::where('empresa_id', Auth::user()->empresa_id)->orderBy('area_id')->with('area')->get();
  $tintas = App\Models\Produccion\Tinta::where('empresa_id', Auth::user()->empresa_id)->get();

  $oldTintasTiro = old('tinta_tiro') ?? $pedido->tintas_id->where('lado', 1)->pluck('tinta_id')->toArray();
  $oldTintasRetiro = old('tinta_retiro') ?? $pedido->tintas_id->where('lado', 0)->pluck('tinta_id')->toArray();
@endphp

<section id="descripcion">
  <div class="form-row">
    <div class="form-group col-12 col-md-6">
      <div class="form-group">
        <label for="descripcion"><b>Descripcion del trabajo</b></label>
        <textarea class="form-control form-control-sm" name="detalle" id="descripcion" rows="1">{{ old('detalle', $pedido->detalle) }}</textarea>
      </div>
    </div>
    <div class="form-group col-8 col-md-4">
      <label for="papel">Papel</label>
      <textarea class="form-control form-control-sm" name="papel" id="papel" rows="1">{{ old('papel', $pedido->papel) }}</textarea>
    </div>
    <div class="form-group col-4 col-md-2">
      <label for="cantidad">Cantidad</label>
      <input type="number" name="cantidad" id="cantidad" class="form-control form-control-sm" min="0" value="{{ old('cantidad', $pedido->cantidad) ?? '0' }}">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-6 col-md-3 order-1">
      <label for="corte">Corte Final</label>
      <div class="form-row" id="corte">
        <div class="col-6">
          <input type="number" name="corte_ancho" id="corte_ancho" class="form-control form-control-sm fixFloat"  value="{{ old('corte_ancho', $pedido->corte_ancho) ?? '0.00' }}"  min="0" step="0.01" aria-describedby="help_corte_ancho">
          <small id="help_corte_ancho" class="text-muted">Ancho</small>
        </div>
        <div class="col-6">
          <input type="number" name="corte_alto" id="corte_alto" class="form-control form-control-sm fixFloat" value="{{ old('corte_alto', $pedido->corte_alto) ?? '0.00' }}" min="0" step="0.01" aria-describedby="help_corte_alto">
          <small id="help_corte_alto" class="text-muted">Alto</small>
        </div>
      </div>
    </div>
    <div class="form-group col-12 col-md-5 order-3 order-md-2">
      <label for="tintas">Tintas</label>
      <div class="form-row" id="tintas">
        <div class="col-6">
          <select name="tinta_tiro[]" id="tinta_tiro" class="form-control form-control-sm d-print-none" aria-describedby="help_tintas_tiro" multiple>
            @foreach ($tintas as $tinta)
            <option value="{{ $tinta->id }}" {{ in_array($tinta->id, $oldTintasTiro) ? 'selected' : '' }}>{{ $tinta->color }}</option>
            @endforeach
          </select>
          <small id="help_tintas_tiro" class="text-muted">Tiro</small>
        </div>
        <div class="col-6">
          <select name="tinta_retiro[]" id="tinta_retiro" class="form-control form-control-sm" aria-describedby="help_tintas_retiro" multiple>
            @foreach ($tintas as $tinta)
            <option value="{{ $tinta->id }}" {{ in_array($tinta->id, $oldTintasRetiro) ? 'selected' : '' }}>{{ $tinta->color }}</option>
            @endforeach
          </select>
          <small id="help_tintas_retiro" class="text-muted">Retiro</small>
        </div>
      </div>
    </div>
    <div class="form-group col-6 col-md-4 order-2 order-md-3">
      <label for="numerado">Numerado</label>
      <div class="form-row" id="numerado">
        <div class="col-6">
          <input type="number" name="numerado_inicio" id="numerado_inicio" class="form-control form-control-sm" value="{{ old('numerado_inicio', $pedido->numerado_inicio) ?? '0' }}" min="0" aria-describedby="help_numerado_inicio">
          <small id="help_numerado_inicio" class="text-muted">Inicial</small>
        </div>
        <div class="col-6">
          <input type="number" name="numerado_fin" id="numerado_fin" class="form-control form-control-sm" value="{{ old('numerado_fin', $pedido->numerado_fin) ?? '0' }}" min="0" aria-describedby="help_numerado_fin">
          <small id="help_numreado_fin" class="text-muted">Final</small>
        </div>
      </div>
    </div>
  </div>
</section>

<hr style="border-width: 3px;">

<section id="material">
  <table id="table-materiales" class="table table-sm table-responsive">
    <thead>
      <tr>
        <th scope="col" class="crudCol"><i id="addMaterial" class="fas fa-plus"></i></th>
        <th scope="col" style="width: 30%; min-width:150px"><b>Solicitud de material</b></th>
        <th scope="col" class="text-center">Cantidad</th>
        <th scope="col" colspan="2" class="text-center">Corte</th>
        <th scope="col" class="text-center">Tamaños</th>
        <th scope="col" style="width: 20%; min-width:150px"><i data-toggle="modal" data-target="#modalProveedor" class="fas fa-plus"></i> Proveedor</th>
        <th scope="col" class="text-center">Factura</th>
        <th scope="col" class="text-center" style="width:10%">Total</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <tr class="font-weight-bold">
        <td colspan="2"><a class="text-muted d-print-none" href="http://www.pplanos.com/" target="_blank">Corte de papel</a></td>
        <td colspan="4" class="text-right"></td>
        <td colspan="2" class="text-right"><a id="printable" data-target="material" class="d-print-none"><i class="fas fa-print pr-2"></i></a>  Total material $</td>
        <td class="text-center"><input type="number" name="total_material" id="totalMaterial" value="{{ old('total_material', $pedido->total_material) ?? '0.00'}}" class="form-control form-control-sm text-center" readonly></td>
      </tr>
    </tfoot>
  </table>
</section>

<hr style="border-width: 3px;">
<section id="procesos">
  <table id="table-procesos" class="table table-sm table-responsive-sm">
    <thead>
      <tr>
        <th scope="col" class="crudCol"><i id="addProceso" class="fas fa-plus"></i></th>
        <th scope="col" style="width: 50%; min-width:200px"><b>Procesos</b></th>
        <th scope="col" class="text-center">T</th>
        <th scope="col" class="text-center">R</th>
        <th scope="col" class="text-center">Mill</th>
        <th scope="col" class="text-center">V/U</th>
        <th scope="col" class="text-center">Total</th>
        <th scope="col" class="crudCol"><i class="fas fa-check" id="checkall"></i></th>
      </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <tr class="font-weight-bold">
        <td colspan="4" rowspan="3" class="align-bottom">
          <div class="d-none d-print-flex text-center mh-100 justify-content-center">
            <div class="border-top w-50">{{ session('userInfo.nomina') }}</div>
          </div>
        </td>
        <td colspan="2" class="text-right">Total Pedido $</td>
        <td class="text-center"><input type="number" id="totalProcesos" name="total_pedido" value="{{ old('total_pedido', $pedido->total_pedido) ?? '0.00'}}" class="form-control form-control-sm text-center" readonly></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2" class="text-right">Abonos $</td>
        <td class="text-center"><input type="number" id="totalAbonos" name="abono" value="{{ old('abono', $pedido->abono) ?? '0.00'}}" class="form-control form-control-sm text-center" readonly></td>
        <td><i data-toggle="modal" data-target="#modalAbonos" class="fas fa-eye"></i></td>
      </tr>
      <tr>
        <td colspan="2" class="text-right">Saldo $</td>
        <td class="text-center"><input type="number" id="totalSaldo" name="saldo" value="{{ old('saldo', $pedido->saldo) ?? '0.00'}}" class="form-control form-control-sm text-center" readonly></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</section>


@section('modals2')
<x-addProveedor />

<!-- Modal Abonos -->
<div class="modal fade" id="modalAbonos" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Abonos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="{{route('abonos', isset($pedido->id))}}" method="POST" role="form">
        @csrf
        <table id="table-abonos" class="table table-sm table-responsive">
          <thead>
            <tr>
              <td scope="col" class="crudCol"><i id="addAbono" class="fas fa-plus"></i></td>
              <td scope="col">Fecha</td>
              <td scope="col">Usuario</td>
              <td scope="col">Forma de pago</td>
              <td scope="col" style="width:15%">Valor $</td>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr class="font-weight-bold">
              <td colspan="4" class="text-right">Total $</td>
              <td class="text-center"><input id="abonos" class="form-control form-control-sm text-center" type="number" readonly name="totalAbonos" value="{{old('totalAbonos', $pedido->abono) ?? '0.00'}}"></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" @if ($method != 'PUT') disabled @endif>Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
@php
  //
  // $opts_ = '<option disabled selected>Selecciona uno...</option>';
  // foreach (config('') ?? [] as $key => $value) {
  //   $opts_ .= "<option value='$key'>$value</option>";
  // }
  // $old_ = $pedido->;
  // if($cnt = count(old('') ?? [])) {
  //   for($i = 0; $i <optgroup $cnt; $i++){
  //     $model = new \stdClass;
  //     $model-> = old('')[$i];
  //     $old_[] = $model;
  //   }
  // }

  // SOLICITUD MATERIAL
  $opts_mats = "<option disabled selected>Selecciona uno...</option>";
  if($materiales){
    $first_mat = $materiales->first();
    $group =  $first_mat->categoria_id;
    $cat = $first_mat->categoria->categoria;
    $opts_mats .= "<optgroup label='$cat'>";
    foreach($materiales as $mat){
      if($group != $mat->categoria_id){
        $group = $mat->categoria_id;
        $opts_mats .= "</optgroup>";
        $cat = $mat->categoria->categoria;
        $opts_mats .= "<optgroup label='$cat'>";
      }
      $opts_mats .= "<option value='$mat->id'>$mat->descripcion</option>";
    }
  }

  $opts_provs = '<option disabled selected>Selecciona uno...</option>';
  foreach($proveedores as $prov){
    $opts_provs .= "<option value='$prov->id'>$prov->proveedor / $prov->telefono</option>";
  }

  $old_material = $pedido->material_id;
  if($cnt = count(old('material_id') ?? [])) {
    for($i = 0; $i < $cnt; $i++){
      $model = new \stdClass;
      $model->material_id = old('material_id')[$i];
      $model->cantidad = old('material_cantidad')[$i];
      $model->corte_alto = old('material_corte_alt')[$i];
      $model->corte_ancho = old('material_corte_anc')[$i];
      $model->tamanos = old('material_tamanios')[$i];
      $model->proveedor_id = old('material_proveedor')[$i];
      $model->factura = old('material_factura')[$i];
      $model->total = old('material_total')[$i];
      $old_material[] = $model;
    }
  }

  // PROCESOS
  $old_procesos = $pedido->procesos_id;
  if($cnt = count(old('proceso_id') ?? [])) {
    for($i = 0; $i < $cnt; $i++){
      $model = new \stdClass;
      $model->proceso_id = old('proceso_id')[$i];
      $model->tiro = old('proceso_tiro')[$i];
      $model->retiro = old('proceso_retiro')[$i];
      $model->millares = old('proceso_millar')[$i];
      $model->valor_unitario = old('proceso_valor')[$i];
      $model->total = old('proceso_total')[$i];
      $model->status = old('proceso_terminado')[$i];
      $old_procesos[] = $model;
    }
  }

  // ABONOS
  $opts_pagos = '<option disabled selected>Selecciona uno...</option>';
  foreach (config('pedido.formas_pago') ?? [] as $key => $value) {
    $opts_pagos .= "<option value='$key'>$value</option>";
  }

  $old_abonos = $pedido->abonos;
  if($cnt = count(old('abono_fecha_val') ?? [])) {
    for($i = 0; $i < $cnt; $i++){
      $model = new \stdClass;
      $model->fecha = old('abono_fecha_val')[$i];
      $model->usuario_id = old('abono_usuario_val')[$i];
      $model->forma_pago = old('abono_pago_val')[$i];
      $model->valor = old('abono_valor_val')[$i];
      $old_abonos[] = $model;
    }
  }
@endphp
@endsection

@section('after.after.scripts')
<script>
  $('#tinta_tiro').select2({
    maximumSelectionLength: 4,
  });

  $('#tinta_retiro').select2({
    maximumSelectionLength: 4,
  });

  //SOLICITUD DE MATERIALES
  var index_material = 0;
  const opts_mats = `@json($opts_mats)`;
  const opts_provs = `@json($opts_provs)`;
  const old_material = JSON.parse(`@json($old_material)`);
  const add_material = (material_id=null, material_cantidad=null, material_corte_alt=0.00, material_corte_anc=0.00, material_tamanios=null, material_proveedor=null, material_factura=null, material_total=0.00) => {
    let table = $('#table-materiales > tbody');

    let button = $('<i />', {'type': 'button', 'class':'fas fa-times removeRow', 'name': 'remove', 'id':`material-${index_material}`});

    let material = $('<select />', {'class': 'form-control form-control-sm select2Class', 'name' : 'material_id[]', 'id': `material_id_${index_material}`}).append(opts_mats);
    if(material_id) material.val(material_id);

    let cantidad = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center', 'value': material_cantidad, 'name':'material_cantidad[]', 'id': `material_cantidad_${index_material}`, 'min': '0', 'onchange': `sumarMaterial();`});

    let corte_alt = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center fixFloat', 'value': material_corte_alt, 'name':'material_corte_alt[]', 'id': `material_corte_alt_${index_material}`, 'min': '0', 'step':'0.01'});

    let corte_anc = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center fixFloat', 'value': material_corte_anc, 'name':'material_corte_anc[]', 'id': `material_corte_anc_${index_material}`, 'min': '0', 'step':'0.01'});

    let tamanios = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center', 'value': material_tamanios, 'name':'material_tamanios[]', 'id': `material_tamanios_${index_material}`, 'min': '0'});

    let proveedor = $('<select />', {'class': 'form-control form-control-sm select2Class', 'name' : 'material_proveedor[]', 'id': `material_proveedor_${index_material}`}).append(opts_provs);
    if(material_proveedor) proveedor.val(material_proveedor);

    let factura = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center', 'value': material_factura, 'name':'material_factura[]', 'id': `material_factura_${index_material}`, 'min': '0'});

    let total = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-right fixFloat', 'value': material_total, 'name':'material_total[]', 'id': `material_total_${index_material}`, 'min': '0', 'step':'0.01', 'onchange':'sumarMaterial();'});

    newRow(table, [button, material, cantidad, corte_alt, corte_anc, tamanios, proveedor, factura, total], `row-material-${index_material}`);
    $('.select2Class').select2();
    index_material++;
  };
  $('#addMaterial').click(() => add_material());
  if(old_material != []){
    old_material.map(item => {
      add_material(item.material_id, item.cantidad, item.corte_alto, item.corte_ancho, item.tamanos, item.proveedor_id, item.factura, item.total);
    });
  }

  //sumar total pedidos
  function sumarMaterial(){
    let total = 0.00;
    $('input[name="material_total[]"]').each(function(){
      total += parseFloat($(this).val());
    });
    $('#totalMaterial').val(parseFloat(total).toFixed(2));
  }


  //PROCESOS
  var index_procesos = 0;
  const proc_opts = `<x-procesos-area id='procesos' name='proceso_id[]' :old='$pedido->proceso_id' />`;
  const old_procesos = JSON.parse(`@json($old_procesos)`);
  const add_proceso = (proceso_id=null, proceso_tiro=1, proceso_retiro=0, proceso_millar=1, proceso_valor=0.00, proceso_total=0.00, proceso_terminado=0) => {
    let table = $('#table-procesos > tbody');

    let button = $('<i />', {'type': 'button', 'class':'fas fa-times removeRow', 'name': 'remove', 'id':`proceso-${index_procesos}`});

    // let proceso = $('<select />', {'name' : 'proceso[id][]', 'id': 'proceso-'+i, 'class': 'form-control form-control-sm select2Class'}).append(proc_opts);
    let proceso = proc_opts.replace("procesos", `proceso-${index_procesos}`);
    // if(proceso_id) proceso.val(proceso_id);

    let tiro = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center', 'value': proceso_tiro, 'name':'proceso_tiro[]', 'id': `tiro-${index_procesos}`, 'min': '0', 'onchange':`sumar(${index_procesos});`});

    let retiro = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center', 'value': proceso_retiro, 'name':'proceso_retiro[]', 'id': `retiro-${index_procesos}`, 'min': '0', 'onchange':`sumar(${index_procesos});`});

    let millar = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center', 'value': proceso_millar, 'name':'proceso_millar[]', 'id': `mill-${index_procesos}`, 'min': '0', 'onchange':`sumar(${index_procesos});`});

    let valor = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center fixFloat', 'value': proceso_valor, 'step': '0.01', 'name':'proceso_valor[]', 'id': `valor-${index_procesos}`, 'min': '0', 'onchange':`sumar(${index_procesos});`});

    let total = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-center fixFloat', 'value': proceso_total, 'step': '0.01', 'name':'proceso_total[]', 'id': `total_proceso-${index_procesos}`, 'min': '0', 'onchange':`sumar(${index_procesos});`, 'readonly': 'readonly'});

    let terminado = $('<input />', {'type': 'hidden', 'value': proceso_terminado, 'name':'proceso_terminado[]'});

    let clicker = $('<input />', {'type': 'checkbox', 'name':'clicker[]', 'onClick': 'this.previousSibling.value=1-this.previousSibling.value'}).prop('checked', proceso_terminado);

    newRow(table, [button, proceso, tiro, retiro, millar, valor, total, terminado], `row-proceso-${index_procesos}`);
    $('.select2Class').select2();
    index_procesos++;
  };
  $('#addProceso').click(() => add_proceso());
  if(old_procesos != []){
    old_procesos.map(item => {
      add_proceso(item.proceso_id, item.tiro, item.retiro, item.millares, item.valor_unitario, item.total, item.status);
    });
  }

  //funcion para sumar el total
  function sumar(num){
    let tiro = $('#tiro-'+String(num)).val();
    let retiro = $('#retiro-'+String(num)).val();
    let millares = $('#mill-'+String(num)).val();
    let valor = $('#valor-'+String(num)).val();
    let sum = ((parseFloat(tiro) + parseFloat(retiro)) * parseFloat(millares)) * parseFloat(valor);
    $('#total_proceso-'+String(num)).val(parseFloat(sum).toFixed(2));
    sumarProcesos();
  }

  // sumar total procesos
  function sumarProcesos(){
    let total = 0.00;
    $('input[name="proceso_total[]"]').each(function(){
      total += parseFloat($(this).val());
    });
    $('#totalProcesos').val(parseFloat(total).toFixed(2));
    sumarSaldo();
  }


  //ABONOS
  var index_abono = 0;
  const method = '{{ $method }}';
  const opts_pagos = `@json($opts_pagos)`;
  const old_abonos = JSON.parse(`@json($old_abonos)`);
  const add_abono = (abono_fecha_val=null, abono_usuario_val=null, abono_pago_val=null, abono_valor_val=0.00) => {
    let table = $('#table-abonos > tbody');

    let button = $('<i />', {'type': 'button', 'class':'fas fa-times removeRow', 'name': 'remove', 'id':`abono-${index_abono}`});

    let fecha = $('<input />', {'type': 'date', 'class': 'form-control form-control-sm text-right', 'value': abono_fecha_val, 'name':'abono_fecha[]', 'id': `abono_fecha_${index_abono}`});

    let usuario = $('<select />', {'class': 'form-control form-control-sm text-center', 'name' : 'abono_usuario[]', 'id': `abono_usuario_${index_abono}`});

    let pago = $('<select />', {'class': 'form-control form-control-sm text-right', 'name':'abono_pago[]', 'id': `abono_pago_${index_abono}`}).append(opts_pagos);
    if(abono_pago_val) pago.val(abono_pago_val);

    let valor = $('<input />', {'type': 'number', 'class': 'form-control form-control-sm text-right fixFloat', 'value': abono_valor_val, 'name':'abono_valor[]', 'id': `abono_valor_${index_abono}`, 'min': '0', 'step': '0.01', 'onchange':'sumarAbonos();'});

    newRow(table, [button, fecha, usuario, pago, valor], `row-abono-${index_abono}`);
    index_abono++;
  };
  $('#addAbono').click(() => {
    if(method == 'POST'){
      swal('Oops!', 'Primero debes crear el pedido.', 'error');
      return;
    }
    add_abono();
  })
  if(old_abonos != []){
    old_abonos.map(item => {
      add_abono(item.fecha, item.usuario_id, item.forma_pago, item.valor);
    });
  }

  //sumar total pedidos
  function sumarAbonos(){
    let total = 0.00;
    $('input[name="abono_valor[]"]').each(function(){
      total += parseFloat($(this).val());
    });
    $('#totalAbonos').val(parseFloat(total).toFixed(2));
    $('#abonos').val(parseFloat(total).toFixed(2));
    sumarSaldo();
  }

  //funcion para sumar saldo
  function sumarSaldo(){
    let total = $('#totalProcesos').val();
    let abono = $('#totalAbonos').val();
    $('#totalSaldo').val(parseFloat(total-abono).toFixed(2));
  }


  //funcion para check todos los checkbox
  $('#checkall').on('click', function () {
    if ($('input[name="clicker[]"]:checked').length == $('input[name="clicker[]"]').length){
      $('input[name="clicker[]"]').each(function(){
        $(this).prop('checked', false);
      });
      $('input[name="proceso_terminado[]"]').each(function(){
        $(this).val('0');
      });
    } else {
      $('input[name="clicker[]"]').each(function(){
        $(this).prop('checked', true);
      });
      $('input[name="proceso_terminado[]"]').each(function(){
        $(this).val('1');
      });
    }
  });

  $("#printable").on("click", event => {
    let target = "#" + $("#printable").data("target");
    $(".select2Class").select2("destroy");
    $(target).print();
    $(".select2Class").select2();
  });
</script>
@endsection
