<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ session('succcess') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif