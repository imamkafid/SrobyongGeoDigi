@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <div class="mb-3 text-center">
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="role" id="admin" value="admin" autocomplete="off">
                        <label class="btn btn-outline-primary" for="admin">Admin</label>

                        <input type="radio" class="btn-check" name="role" id="warga" value="warga" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="warga">Warga</label>
                    </div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" id="roleInput" value="warga">
                    
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" required>
                    </div>

                    <div class="mb-3" id="passwordField" style="display: none;">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('roleInput').value = this.value;
        document.getElementById('passwordField').style.display = 
            this.value === 'admin' ? 'block' : 'none';
    });
});
</script>
@endpush
@endsection