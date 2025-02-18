<div class="m-3">
    @can('user_info_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.user-infos.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.userInfo.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.userInfo.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-useridUserInfos">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.userid') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.company_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.bank_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.bank_account_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.userInfo.fields.tax_code') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userInfos as $key => $userInfo)
                        <tr data-entry-id="{{ $userInfo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $userInfo->id ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->userid->name ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->company ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->company_email ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->phone ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->address ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->bank_name ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->bank_account_number ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\UserInfo::TYPE_SELECT[$userInfo->type] ?? '' }}
                            </td>
                            <td>
                                {{ $userInfo->tax_code ?? '' }}
                            </td>
                            <td>
                                @can('user_info_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.user-infos.show', $userInfo->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_info_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.user-infos.edit', $userInfo->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_info_delete')
                                    <form action="{{ route('admin.user-infos.destroy', $userInfo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
            @can('user_info_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.user-infos.massDestroy') }}",
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
            let table = $('.datatable-useridUserInfos:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection