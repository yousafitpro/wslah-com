<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 col-xl-6">
                <h4 class="card-title">{{ __('system.instagram_story.menu') }}</h4>
                <div class="page-title-box pb-0 d-sm-flex">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('environment/instagram-story') }}">{{ __('system.instagram_story.menu') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('system.dashboard.recent_stories_history') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{ __('system.dashboard.recent_stories_history') }}</h4>
        <button id="delete-selected" class="btn btn-danger btn-sm ml-auto">
            Delete Selected
        </button>
    </div>
    <!-- end card header -->

    <div class="card-body px-0 pb-0 pt-2">
        <div class="table-responsive px-3" data-simplebar style="height: 425px;">
            <table class="table align-middle table-nowrap">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>Thumbnail</th>
                        <th>ID</th>
                        <th class="text-end">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stories as $story)
                        <?php $payload = json_decode($story->payload, true); ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="story-checkbox" value="{{ $story->id }}">
                            </td>
                            <td style="width: 50px;">
                                <a href="{{ isset($payload['thumbnail_url']) ? $payload['thumbnail_url'] : $payload['media_url'] }}" target="_blank">
                                    <img data-src="{{ isset($payload['thumbnail_url']) ? $payload['thumbnail_url'] : $payload['media_url'] }}" alt=""
                                        class="avatar-md rounded-circle me-2 lazyload">
                                </a>
                            </td>
                            <td>
                                <h5 class="font-size-15"><a class="text-dark">{{ $payload['id'] }}</a></h5>
                                <span class="text-muted">{{ $payload['media_type'] }}</span>
                            </td>
                            <td class="text-end">
                                <span class="text-muted">{{ \Carbon\Carbon::parse($payload['timestamp'])->diffForHumans() }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- end card body -->
</div>
<!-- end card -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Select all checkboxes
        $('#select-all').on('change', function () {
            $('.story-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Delete selected stories
        $('#delete-selected').on('click', function () {
            let selectedIds = [];
            $('.story-checkbox:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('No stories selected');
                return;
            }

            if (confirm('Are you sure you want to delete the selected stories?')) {
                $.ajax({
                    url: "{{ url('instagram/delete-multiple') }}",
                    type: "POST",
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert(response.message || 'Stories deleted successfully');
                        location.reload(); // Reload the page to update the table
                    },
                    error: function (xhr) {
                        alert('An error occurred while deleting stories');
                    }
                });
            }
        });
    });
</script>
