@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Edit Jabatan</h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jabatan.update', $jabatan) }}" method="POST">
            @method('PUT')
            @include('jabatan._form')
        </form>
    </div>
@endsection
