{{-- Página de aletas utilizando SweetAlert2 --}}
@if (session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Pronto!', "{{ session('success') }}", 'success');
        });
    </script>

@elseif (session()->has('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire('Erro!', "{{ session('error') }}", 'error');
    });
</script>

@elseif ($errors->any())
    @php
        $mensagem = implode('<br>', $errors->all());
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Error!', "{!! $mensagem !!}", 'error');
        });
    </script>
@endif
