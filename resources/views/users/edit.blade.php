@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-slate-900">Edit User</h2>
            <p class="text-sm text-slate-600 mt-1">Perbarui informasi pengguna</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="p-8">
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 mb-1">Terdapat kesalahan:</h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach($errors->all() as $err)
                                        <li>• {{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('users._form')
                </form>
            </div>
        </div>
    </div>

@endsection
