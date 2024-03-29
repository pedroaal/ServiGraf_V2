<div class="m-2 m-md-3 {$class}">
  <div style="background-color: rgba(59,89,152,.8)" class="text-white rounded-top p-2 d-print-none">
    {{ $title }}
  </div>
  <div class="p-2 p-md-3 m-0 border-left border-right">{{ $slot }}</div>
  <div class="bg-gray rounded-bottom p-2 d-print-none">
    <div class="d-flex">
      <div class="flex-grow-1 d-flex">
        @foreach ($foot as $item)
          @if (($item['condition'] ?? 1) && $item['tipo'] == 'link')
            <div class="mr-2 mr-md-3">
              <a id="{{ $item['id'] }}" href="{{ $item['href'] }}" class="text-blue-8">{{ $item['text'] }} <i
                  class="fas fa-arrow-alt-circle-right fa-md"></i></a>
            </div>
          @elseif ($item['tipo'] == 'modal')
            <div class="mr-2 mr-md-3">
              <a id="{{ $item['id'] }}" href="{{ $item['href'] }}" class="text-blue-8"
                data-toggle="modal">{{ $item['text'] }} <i class="fas fa-arrow-alt-circle-right fa-md"></i></a>
            </div>
          @endif
        @endforeach
      </div>
      <div class="ml-2 ml-md-3">
        @foreach ($foot as $item)
          @if (($item['condition'] ?? 1) && $item['tipo'] == 'button')
            <div class="mr-2 mr-md-3">
              <a onclick="{{ $item['href'] }}" class="{{ $item['text'] }}" id="{{ $item['id'] }}"
                {{ $item['print-target'] ? "data-target={$item['print-target']}" : '' }}></a>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
