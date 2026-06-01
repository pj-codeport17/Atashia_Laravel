<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11000">
    @if (session('toast'))
        @php $toast = session('toast'); @endphp
        <div class="toast align-items-center text-bg-{{ $toast['type'] ?? 'primary' }} border-0 show" role="alert" data-bs-autohide="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    @if (($toast['type'] ?? '') === 'success')
                        <i class="bi bi-check-circle me-1"></i>
                    @elseif (($toast['type'] ?? '') === 'danger')
                        <i class="bi bi-exclamation-circle me-1"></i>
                    @else
                        <i class="bi bi-info-circle me-1"></i>
                    @endif
                    {{ $toast['message'] }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    {{ $errors->first() }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
</div>

@if (session('toast') || (isset($errors) && $errors->any()))
<script>
    document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el).show());
</script>
@endif
