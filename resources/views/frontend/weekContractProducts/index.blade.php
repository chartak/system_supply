@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('week_contract_product_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.week-contract-products.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.weekContractProduct.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.weekContractProduct.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-WeekContractProduct">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.week_contract') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.quantity') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.year_con_prod') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.type') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($weekContractProducts as $key => $weekContractProduct)
                                    <tr data-entry-id="{{ $weekContractProduct->id }}">
                                        <td>
                                            {{ $weekContractProduct->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $weekContractProduct->week_contract->start_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $weekContractProduct->quantity ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($weekContractProduct->year_con_prods as $key => $item)
                                                <span>{{ $item->quantity }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ App\Models\WeekContractProduct::TYPE_SELECT[$weekContractProduct->type] ?? '' }}
                                        </td>
                                        <td>
                                            @can('week_contract_product_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.week-contract-products.show', $weekContractProduct->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('week_contract_product_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.week-contract-products.edit', $weekContractProduct->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('week_contract_product_delete')
                                                <form action="{{ route('frontend.week-contract-products.destroy', $weekContractProduct->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('week_contract_product_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.week-contract-products.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-WeekContractProduct:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection