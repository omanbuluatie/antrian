@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel Operator</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('operator.callNext') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="loket">Pilih Loket</label>
            <select name="loket_id" id="loket" class="form-control">
                @foreach($lokets as $loket)
                    <option value="{{ $loket->id }}">{{ $loket->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Panggil Nomor Selanjutnya</button>
    </form>
</div>
@endsection
