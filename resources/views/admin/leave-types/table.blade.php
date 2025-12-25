<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Days/Year</th>
                    <th scope="col" width="120" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($leave_types as $leave_type)
                    <tr>
                        <td>
                            <div class="fw-medium">{{ $leave_type->name }}</div>
                        </td>
                        <td>
                                    <span class="table-badge badge-opacity-info">
                                        {{ $leave_type->max_days_per_year }} days
                                    </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('leave-types.edit', $leave_type->id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Leave Type">Edit</a>
                                <form action="{{ route('leave-types.destroy', $leave_type->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this leave type?')" title="Delete Leave Type">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No leave types found</h5>
                                <p class="text-muted mb-4">Get started by adding your first leave type</p>
                                <a href="{{ route('leave-types.create') }}" class="btn btn-primary">Add First Leave Type</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
