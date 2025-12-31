<div class="card table-card">
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col" width="60">S/N</th>
                <th scope="col">Event Details</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Status</th>
                <th scope="col">Announcer</th>
            </tr>
            </thead>
            <tbody>
            @forelse($events as $e)
                <tr>
                    <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-medium mb-1">{{ $e->title }}</div>
                        <div class="text-muted small" style="max-width: 300px; line-height: 1.4;">
                            {{ Str::limit($e->description, 120) }}
                        </div>
                    </td>
                    <td>
                        <span class="fw-medium">{{ $e->event_date->format('M d, Y') }}</span>
                    </td>
                    <td>
                        <div class="text-muted-small">
                            {{ $e->start_time->format('h:i A') }}
                        </div>
                        <div class="text-muted-small">
                            {{ $e->end_time->format('h:i A') }}
                        </div>
                    </td>
                    <td>
                        @if(now()->greaterThan($e->event_date))
                            <span class="table-badge badge-opacity-success">
                                            Completed
                                        </span>
                        @elseif(now()->diffInDays($e->event_date) <= 3)
                            <span class="table-badge badge-opacity-warning">
                                            Upcoming Soon
                                        </span>
                        @else
                            <span class="table-badge badge-opacity-info">
                                            Upcoming
                                        </span>
                        @endif
                    </td>
                    <td>
                                    <span class="table-badge badge-opacity-primary">
                                        {{ $e->creator->name }}
                                    </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="py-4">
                            <h5 class="text-muted">No events found</h5>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
        <div class="pagination-wrapper">
            <div class="d-flex justify-content-center">
                {{ $events->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
</div>
