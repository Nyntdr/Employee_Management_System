<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Department Name</th>
                    <th scope="col">Total Employees</th>
                    <th scope="col">Manager</th>
                    <th scope="col" width="150" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($departments as $d)
                    <tr>
                        <td>
                            <div class="fw-medium">{{ $d->name }}</div>
                        </td>
                        <td> {{$d->employees_count}}</td>
                        <td>
                            @if($d->manager_id)
                                <span class="table-badge badge-opacity-info">
                                            {{ $d->manager->first_name }} {{ $d->manager->last_name }}
                                        </span>
                            @else
                                <span class="table-badge badge-opacity-secondary">
                                            Not Assigned
                                        </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('departments.edit', $d->department_id) }}"
                                   class="btn table-btn-sm btn-outline-primary" title="Edit Department">Edit</a>
                                <form action="{{ route('departments.destroy', $d->department_id) }}" method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn table-btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete {{ $d->name }}?')"
                                            title="Delete Department">Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No departments found</h5>
                                <p class="text-muted mb-4">Get started by adding a new department</p>
                                <a href="{{ route('departments.create') }}" class="btn btn-midnight">
                                    Add First Department
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($departments->hasPages())
            <div class="pagination-wrapper">
                <div class="d-flex justify-content-center">
                    {{ $departments->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
