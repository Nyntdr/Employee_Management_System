@if($employees->count() > 0)
    <div class="employee-grid">
        @foreach($employees as $employee)
            <div class="employee-card">
                <div class="employee-card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="employee-profile-img-container me-3">
                            @if($employee->user->profile_picture)
                                <img src="{{ asset('storage/'.$employee->user->profile_picture) }}" class="employee-profile-img" width="60" height="60" alt="{{ $employee->first_name }}">
                            @else
                                <img src="{{ asset('images/icon.jpg') }}" class="employee-profile-img" width="60" height="60" alt="{{ $employee->first_name }}">
                            @endif
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="employee-card-title mb-1 text-truncate">{{ $employee->first_name.' '.$employee->last_name }}</h5>
                            <p class="employee-card-subtitle mb-2 text-muted">@<strong>{{ $employee->user->name }}</strong></p>
                            <div class="mt-1 d-flex flex-wrap gap-1">
                                <span class="employee-badge employee-badge-info">{{ $employee->user->role->role_name }}</span>
                                <span class="employee-badge employee-badge-secondary">{{ ucwords($employee->gender) }}</span>
                                <span class="employee-badge employee-badge-primary">{{ ucwords($employee->department->name) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="employee-info-section">
                        <h6 class="employee-section-title">Contact Information</h6>
                        <p class="employee-detail"><strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}</p>
                        <p class="employee-detail"><strong>Email:</strong> {{ $employee->user->email }}</p>
                        <p class="employee-detail"><strong>Secondary:</strong> {{ $employee->secondary_phone ?? 'N/A' }}</p>
                        <p class="employee-detail"><strong>Emergency:</strong> {{ $employee->emergency_contact ?? 'N/A' }}</p>
                    </div>

                    <div class="employee-info-section">
                        <h6 class="employee-section-title">Employment Details</h6>
                        @php
                            $latestContract = $employee->contracts()->latest()->first();
                        @endphp
                        <p class="employee-detail"><strong>Position:</strong> {{ $latestContract ? ucwords(str_replace('_',' ',$latestContract->job_title->value)) : 'N/A' }}</p>
                        <p class="employee-detail"><strong>Base Salary:</strong> {{$latestContract ? 'NPR ' . number_format($latestContract->salary, 2) : 'N/A'}}</p>
                        <p class="employee-detail"><strong>Status:</strong>
                            @if($latestContract)
                                @php
                                    $status = $latestContract->contract_status->value ?? (string) $latestContract->contract_status;
                                    $statusBadgeClass = match(strtolower($status)) {
                                        'active' => 'employee-badge-success',
                                        'renewed' => 'employee-badge-success',
                                        'expired' => 'employee-badge-warning',
                                        'terminated' => 'employee-badge-danger',
                                        default => 'employee-badge-secondary'
                                    };
                                @endphp
                                <span class="employee-badge {{ $statusBadgeClass }}">{{ ucfirst($status) }}</span>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <div class="employee-info-section">
                        <h6 class="employee-section-title">Personal Details</h6>
                        <p class="employee-detail"><strong>DOB:</strong> {{ $employee->date_of_birth->format('F j, Y') }}</p>
                        <p class="employee-detail"><strong>DOJ:</strong> {{ $employee->date_of_joining->format('F j, Y') }}</p>
                    </div>

                    <div class="employee-mt-auto employee-btn-container">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('employees.edit', $employee->employee_id) }}" class="btn employee-action-btn employee-action-btn-sm btn-outline-primary" title="Edit Employee">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->employee_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn employee-action-btn employee-action-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete {{ $employee->first_name }} {{ $employee->last_name }}?')" title="Delete Employee">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($employees->hasPages())
        <div class="pagination-wrapper">
            <div class="d-flex justify-content-center mt-4">
                {{ $employees->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
@else
    <div class="employee-empty-state">
        <h5>No employees found</h5>
        <p>Get started by adding your first employee</p>
        <a href="{{ route('employees.create') }}" class="btn btn-midnight">
            Add First Employee
        </a>
    </div>
@endif
