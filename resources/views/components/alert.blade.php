{{-- Menampilkan pesan dari controller: ->with('status', '...') atau ->with('error', '...') --}}
@if (session('status'))
    <div class="alert alert-success" role="status">{{ session('status') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
@endif
