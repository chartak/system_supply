@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('product_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.products.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.product.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                                <thead>
                                <tr>
                                    <!-- <th>
                                        {{ trans('cruds.product.fields.id') }}
                                    </th> -->
                                    <th>
                                        {{ trans('cruds.product.fields.cpv') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.product.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.product.fields.unit_measurementid') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <!-- <td>
                                    </td> -->
                                    <!-- <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td> -->
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($unit_measurements as $key => $item)
                                                <option value="{{ $item->unit_of_measurement }}">{{ $item->unit_of_measurement }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $key => $product)
                                    <tr data-entry-id="{{ $product->id }}">
                                        <!-- <td>
                                            {{ $product->id ?? '' }}
                                        </td> -->
                                        <td>
                                            {{ $product->cpv ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->unit_measurementid->unit_of_measurement ?? '' }}
                                        </td>
                                        <td>
                                            @can('product_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.products.show', $product->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('product_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.products.edit', $product->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('product_delete')
                                                <form action="{{ route('frontend.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
            @can('product_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('frontend.products.massDestroy') }}",
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
                pageLength: 10,
            });
            let table = $('.datatable-Product:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })

        })

    </script>
@endsection