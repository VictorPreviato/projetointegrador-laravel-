@foreach ([
    'success_doacao', 'success_perdido', 'success_config',
    'success_depoi', 'success_exdepoi', 'success_feed',
    'success_delpost', 'success_contato', 'success_attpost',
    'succes_deluser'
] as $key)
    @if(session($key))
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: @json(session($key)),
            confirmButtonText: 'Ok',
            confirmButtonColor: '#31403E',
            timer: 4000,
            timerProgressBar: true
        });
        </script>
    @endif
@endforeach
