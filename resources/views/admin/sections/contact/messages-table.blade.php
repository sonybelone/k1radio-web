<table class="custom-table messages-table">
    <thead>
        <tr>
            <th>{{ __("Name") }}</th>
            <th>{{ __("Email") }}</th>
            <th>{{ __("Reply") }}</th>
            <th>{{ __("Created at") }}</th>
            <th>{{ __("Action") }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($messages ?? [] as $item)
            <tr data-item="{{ $item->editData }}">
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>
                    @if ($item->reply == 0)
                    <span class="badge badge--danger">{{ __("Not Replied") }}</span>
                    @else
                    <span class="badge badge--success">{{ __("Replied") }}</span>
                    @endif
                </td>
                <td>{{ $item->created_at}}</td>
                <td>
                    @include('admin.components.link.info-default',[
                        'href'          => "#message-details",
                        'class'         => "edit-modal-button",
                        'permission'    => "admin.contact.details",
                    ])
                    @include('admin.components.link.reply-default',[
                        'href'          => "#message-reply",
                        'class'         => "reply-modal-button",
                        'permission'    => "admin.contact.reply",
                    ])
                     @include('admin.components.link.delete-default',[
                        'class'         => "delete-modal-button",
                        'permission'    => "admin.contact.delete",
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

    </script>
@endpush
