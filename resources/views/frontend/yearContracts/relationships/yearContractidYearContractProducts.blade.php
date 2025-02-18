<div class="m-3">
    @can('year_contract_product_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.year-contract-products.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.yearContractProduct.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.yearContractProduct.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-yearContractidYearContractProducts">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.year_contractid') }}
                        </th>
                        <th>
                            {{ trans('cruds.yearContract.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.productid') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.cpv') }}
                        </th>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($yearContractProducts as $key => $yearContractProduct)
                        <tr data-entry-id="{{ $yearContractProduct->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $yearContractProduct->id ?? '' }}
                            </td>
                            <td>
                                {{ $yearContractProduct->year_contractid->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $yearContractProduct->year_contractid->status ?? '' }}
                            </td>
                            <td>
                                {{ $yearContractProduct->productid->name ?? '' }}
                            </td>
                            <td>
                                {{ $yearContractProduct->productid->cpv ?? '' }}
                            </td>
                            <td>
                                {{ $yearContractProduct->quantity ?? '' }}
                            </td>
                            <td>
                                {{ $yearContractProduct->price ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\YearContractProduct::TYPE_SELECT[$yearContractProduct->type] ?? '' }}
                            </td>
                            <td>
                                @can('year_contract_product_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.year-contract-products.show', $yearContractProduct->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('year_contract_product_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.year-contract-products.edit', $yearContractProduct->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('year_contract_product_delete')
                                    <form action="{{ route('admin.year-contract-products.destroy', $yearContractProduct->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('year_contract_product_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.year-contract-products.massDestroy') }}",
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
            let table = $('.datatable-yearContractidYearContractProducts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection