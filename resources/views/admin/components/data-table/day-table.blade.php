<table class="custom-table category-search-table">
    <thead>
        <tr>

            <th>{{ __("Category Name") }}</th>
            <th></th>
            <th>{{ __("Created Time") }}</th>
            <th></th>
            <th>{{ __("Status") }}</th>
            <th></th>
            <th>{{ __("Action") }}</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($allDays ?? [] as $item)
            <tr data-item="{{ $item->editData }}">
                <td>{{ $item->name }}</td>
                <td></td>
                <td>{{ $item->created_at->format('d-m-y h:i:s A') }}</td>
                <td></td>

                <td>
                    @include('admin.components.form.switcher',[
                        'name'          => 'day_status',
                        'value'         => $item->status,
                        'options'       => [__('Enable') => 1,__('Disable') => 0],
                        'onload'        => true,
                        'data_target'   => $item->id,
                        'permission'    => "admin.day.status.update",
                    ])
                </td>
                <td></td>

                <td>
                    @include('admin.components.link.edit-default',[
                        'href'          => "javascript:void(0)",
                        'class'         => "edit-modal-button",
                        'permission'    => "admin.day.update",
                    ])
                </td>
            </tr>
        @empty
            @include('admin.components.alerts.empty',['colspan' => 7])
        @endforelse
    </tbody>
</table>

@push("script")
    <script>
        $(document).ready(function(){
            // Switcher
            switcherAjax("{{ setRoute('admin.day.status.update') }}");
        })
    </script>
@endpush
