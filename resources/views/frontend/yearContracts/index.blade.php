@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('year_contract_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.year-contracts.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.yearContract.title_singular') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.yearContract.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-YearContract">
                                <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.yearContract.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.yearContract.fields.customerid') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.yearContract.fields.supplierid') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.yearContract.fields.start_date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.yearContract.fields.end_date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.yearContract.fields.contract_doc') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.yearContract.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($user_infos as $key => $item)
                                                <option value="{{ $item->company }}">{{ $item->company }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($user_infos as $key => $item)
                                                <option value="{{ $item->company }}">{{ $item->company }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($yearContracts as $key => $yearContract)
                                    <tr data-entry-id="{{ $yearContract->id }}">
                                        <td>
                                            {{ $yearContract->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $yearContract->customerid->company ?? '' }}
                                        </td>
                                        <td>
                                            {{ $yearContract->supplierid->company ?? '' }}
                                        </td>
                                        <td>
                                            {{ $yearContract->start_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $yearContract->end_date ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($yearContract->contract_doc as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $yearContract->status ?? '' }}
                                        </td>
                                        <td>
                                            @can('year_contract_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.year-contracts.show', $yearContract->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('year_contract_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.year-contracts.edit', $yearContract->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('year_contract_delete')
                                                <form action="{{ route('frontend.year-contracts.destroy', $yearContract->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
            @can('year_contract_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('frontend.year-contracts.massDestroy') }}",
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
            let table = $('.datatable-YearContract:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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