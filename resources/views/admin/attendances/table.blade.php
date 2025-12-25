<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col" width="60">S/N</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Clock In</th>
                    <th scope="col">Clock Out</th>
                    <th scope="col">Total Hours</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="120" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($attendances as $attendance)
                    @php
                        $totalHours = 'N/A';
                        if ($attendance->clock_in && $attendance->clock_out) {
                            $start = Carbon\Carbon::parse($attendance->clock_in);
                            $end = Carbon\Carbon::parse($attendance->clock_out);
                            $diff = $start->diff($end);
                            if ($diff->h > 0 || $diff->i > 0) {
                                $totalHours = sprintf('%dh %02dm', $diff->h, $diff->i);
                            } else {
                                $totalHours = '0h 00m';
                            }
                        }
                    @endphp
                    <tr>
                        <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-medium">{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</div>
                            <div class="text-muted small">{{ $attendance->employee->department->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $attendance->date->format('Y-m-d') }}</span>
                            <div class="text-muted small">{{ $attendance->date->format('D') }}</div>
                        </td>
                        <td>
                            @if($attendance->clock_in)
                                <span class="table-badge badge-opacity-success">
                                            {{ $attendance->clock_in->format('H:i') }}
                                        </span>
                            @else
                                <span class="table-badge badge-opacity-secondary">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->clock_out)
                                <span class="table-badge badge-opacity-info">
                                            {{ $attendance->clock_out->format('H:i') }}
                                        </span>
                            @else
                                <span class="table-badge badge-opacity-secondary">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->clock_in && $attendance->clock_out)
                                <span class="fw-bold text-primary">{{$totalHours }}</span>
                            @else
                                <span class="table-badge badge-opacity-secondary">N/A</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $status = $attendance->status->value ?? (string) $attendance->status;
                                $badgeClass = match(strtolower($status)) {
                                    'present' => 'badge-opacity-success',
                                    'absent' => 'badge-opacity-danger',
                                    'late' => 'badge-opacity-warning',
                                    'half_day' => 'badge-opacity-info',
                                    'on_leave' => 'badge-opacity-secondary',
                                    default => 'badge-opacity-secondary'
                                };
                            @endphp
                            <span class="table-badge {{ $badgeClass }}">{{ ucwords(str_replace('_', ' ', $status)) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('attendances.edit', $attendance->attendance_id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Attendance">Edit</a>
                                <form action="{{ route('attendances.destroy', $attendance->attendance_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this attendance record?')" title="Delete Attendance">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No attendance records found</h5>
                                <p class="text-muted mb-4">Get started by adding attendance records</p>
                                <a href="{{ route('attendances.create') }}" class="btn btn-primary">Add First Attendance</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
