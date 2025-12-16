@extends('layouts.employee_navbar')

@section('title', 'My Profile')

@section('content')
    @php
        $u = Auth::user();
        $e = $u->employee;
    @endphp
    <h1>Profile</h1>
    <div class="user" style="border: 2px solid">
        <h3>User Details</h3>
        <img src="{{ asset('images/kale.jpg') }}" width="200" height="200"
            style="border:2px none black; border-radius: 50%;">

        <form action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" id="fileInput" name="image" accept="image/*">
            <br><br>
            <img id="imagePreview" alt="Preview"  width="200" height="200"
            style="border:2px none black; border-radius: 50%;">
            <button type="submit">Upload Image</button>
        </form>
        <p>Username: {{ $u->name }}</p>
        <p>Email: {{ $u->email }}</p>
        <p>Role: {{ $u->role->role_name }}</p>
    </div>
    <br>
    @if ($u && $u->employee)
        <div class="employee" style="border: 2px solid">
            <h3>Employee Details</h3>
            <p>Name: {{ $e->first_name }} {{ $e->last_name }}</p>
            <p>Gender:{{ $e->gender }}</p>
            <p>Date of birth: {{ $e->date_of_birth->format('M d, Y') }}</p>
            <p>Join Date: {{ $e->date_of_joining->format('M d, Y') }} <b>That's like
                    {{ $e->date_of_joining->diffForHumans() }}</b></p>
            <h4>Contacts</h4>
            <p>Main: {{ $e->phone }}</p>
            <p>Secondary: {{ $e->secondary_phone }}</p>
            <p>Emergency: {{ $e->emergency_contact }}</p>
            <p>Current Status:
                @if ($e->employment_status == 'active')
                    <span style="color:green;"><strong>{{ $e->employment_status }}</strong></span>
                @endif
            </p>
        </div>
        
        <script>
                document.getElementById('fileInput').addEventListener('change',function(event){
                    const file = event.target.files[0];
                    if(file && file.type.match('image.*')){
                        const reader = new FileReader();

                        reader.onload = function (e){
                            const imagePreview=document.getElementById('imagePreview');
                            imagePreview.src = e.target.result;
                            imagePreview.style.display='block';
                        };
                        reader.readAsDataURL(file);
                    }
                    else{
                        document.getElementById('imagePreview').style.display='none';
                        document.getElementById('imagePreview').src='';
                    }
                });
        </script>
    @endif
@endsection
