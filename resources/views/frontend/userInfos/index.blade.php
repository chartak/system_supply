@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('user_info_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.user-infos.create') }}">
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
                            <table class=" table table-bordered table-striped table-hover datatable datatable-UserInfo">
                                <thead>
                                <tr>
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
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($users as $key => $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\UserInfo::TYPE_SELECT as $key => $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userInfos as $key => $userInfo)
                                    <tr data-entry-id="{{ $userInfo->id }}">
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
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.user-infos.show', $userInfo->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('user_info_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.user-infos.edit', $userInfo->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('user_info_delete')
                                                <form action="{{ route('frontend.user-infos.destroy', $userInfo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
            @can('user_info_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('frontend.user-infos.massDestroy') }}",
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
            let table = $('.datatable-UserInfo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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