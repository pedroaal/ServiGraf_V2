@extends('layouts.app')

@section('desktop-content')
  <x-path
    :items="[ ['text' => 'Libro Diario', 'current' => false, 'href' => route('libro')], ['text' => 'Entrada', 'current' => true, 'href' => '#'] ]" />

  <x-blue-board :title=$text
    :foot="[ ['text'=>$action, 'href'=>'#', 'id'=>'formSubmit', 'tipo'=>'link'], ['text' => 'Nueva', 'href' => route('entrada.create'), 'id' => 'new', 'tipo' => 'link', 'condition' => $entrada->id ?? 0] ]">
    <form action="{{ $path }}" method="POST" id="form">
      @csrf
      @method($method)
      <div class="form-row">
        <div class="form-group col-6 col-md-3">
          <label for="fecha">Fecha</label>
          <input type="date" class="form-control form-control-sm" name="fecha" id="fecha"
            value="{{ old('fecha', $entrada->fecha) ?? date('Y-m-d') }}">
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="usuario_id">Usuario</label>
          <select class="form-control form-control-sm" name="usuario_id" id="usuario_id">
            @foreach ($usuarios as $item)
              <option value="{{ $item->cedula }}"
                {{ old('usuario_id', $entrada->usuario_id ?? auth()->id()) == $item->cedula ? 'selected' : '' }}>
                {{ $item->usuario }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="libro_id">Libro</label>
          <select class="form-control form-control-sm" name="libro_id" id="libro_id">
          </select>
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="tipo">Tipo de transacción</label>
          <select class="form-control form-control-sm" name="tipo" id="tipo">
            @foreach (config('factura.tipo') as $key => $val)
              <option value="{{ $key }}" {{ old('tipo', $entrada->tipo) == $key ? 'selected' : '' }}>
                {{ $val }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="libro_ref_id">Referencia</label>
          <select class="form-control form-control-sm" name="libro_ref_id" id="libro_ref_id"
            aria-placeholder="Selecciona una...">
            @foreach ($referencias as $item)
              <option value="{{ $item->id }}"
                {{ old('libro_ref_id', $entrada->libro_ref_id) == $item->id ? 'selected' : '' }}>
                {{ $item->referencia }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="beneficiario">Beneficiario</label>
          <input type="text" class="form-control form-control-sm" name="beneficiario" id="beneficiario"
            value="{{ old('beneficiario', $entrada->beneficiario) }}">
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="ci">C.I.</label>
          <input type="number" min="0" class="form-control form-control-sm" name="ci" id="ci"
            value="{{ old('ci', $entrada->ci) }}">
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="detalle">Detalle</label>
          <textarea class="form-control form-control-sm" name="detalle" id="detalle"
            rows="3">{{ old('detalle', $entrada->detalle) }}</textarea>
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="banco_id">Banco</label>
          <select class="form-control form-control-sm" name="banco_id" id="banco_id">
            <option value="">Selecciona</option>
            @foreach ($bancos as $item)
              <option value="{{ $item->id }}"
                {{ old('banco_id', $entrada->banco_id) == $item->id ? 'selected' : '' }}>{{ $item->banco }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="cuenta">Cuenta Bancaria</label>
          <input type="number" min="0" class="form-control form-control-sm" name="cuenta" id="cuenta"
            value="{{ old('cuenta', $entrada->cuenta) }}">
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="cheque">Cheque No.</label>
          <input type="number" min="0" class="form-control form-control-sm" name="cheque" id="cheque"
            value="{{ old('cheque', $entrada->cheque) }}">
        </div>
        <div class="form-group col-6 col-md-3">
          <label for="valor">Valor</label>
          <input type="number" min="0" step="0.0001" class="form-control form-control-sm fixFloat" name="valor" id="valor"
            value="{{ old('valor', $entrada->tipo ? $entrada->ingreso : $entrada->egreso) }}">
        </div>
      </div>
    </form>
  </x-blue-board>
@endsection

@section('scripts')
  <script>
    const route = `{{ route('libro.api.libros') }}`;

    function getLibros() {
      axios.post(route, {
        usuario: $('#usuario_id').val(),
      }).then(res => {
        let data = res.data
        let content;
        $.each(data, (index, value) => {
          content += `<option value='${value.id}'>${value.libro}</option>`;
        });
        $('#libro_id').empty().append(content);
      }).catch(error => {
        swal('Oops!', 'No hemos podido cargar los libros', 'error');
        console.log(error);
      });
    }

    $(() => getLibros());

    $('#usuario').change(() => getLibros());
  </script>
@endsection
