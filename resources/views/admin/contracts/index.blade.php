@extends('layouts.navbars')
@section('title','All Contracts')
@section('content')

<h1>Contract List</h1>
<a href="{{ route('contracts.create') }}">Add Contract</a> <br><br>

<table border="1">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Employee Name</th>
            <th>Contract Type</th>
            <th>Title</th>
            <th>Start Date</th> 
            <th>End Date</th>  
            <th>Probation Period</th> 
            <th>Working Hours</th>  
            <th>Salary</th>  
            <th>Status</th> 
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($contracts as $contract)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $contract->employee->first_name.' '.$contract->employee->last_name }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $contract->contract_type->value)) }}</td> 
                <td>{{ ucwords(str_replace('_', ' ', $contract->job_title->value)) }}</td>
                <td>{{ $contract->start_date->format('F j, Y') }}</td>
                <td>{{ $contract->end_date->format('F j, Y') }}</td>
                <td>{{ $contract->probation_period }}</td>
                <td>{{ $contract->working_hours }}</td>
                <td>{{ $contract->salary }}</td>
                <td>{{ $contract->contract_status }}</td>
                <td>
                    <a href="{{ route('contracts.edit',$contract->contract_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('contracts.destroy',$contract->contract_id )}}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this contract?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11" style="text-align:center;">No contracts found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection