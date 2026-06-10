{{--
    Komponen notifikasi global berbasis Toastr.
    Cara pakai:
      1. Sertakan partial ini sebelum </body> pada setiap layout/halaman:
         @include('components.toastr')
      2. Flash dari controller akan otomatis tampil:
         return redirect()->back()->with('success', 'Berhasil!');
         return redirect()->back()->with('error', 'Gagal!');
         (mendukung: success, error, warning, info)
      3. Dari JavaScript (mis. setelah AJAX) panggil:
         notify('success', 'Pesan Anda');
--}}

{{-- Toastr CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

{{-- jQuery (dependency Toastr) --}}
@once
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@endonce
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<script>
    (function () {
        if (typeof toastr === 'undefined') {
            console.warn('Toastr belum termuat.');
            return;
        }

        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            preventDuplicates: true,
            positionClass: 'toast-top-right',
            timeOut: 4000,
            extendedTimeOut: 1500,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };

        // Helper global untuk dipanggil dari mana saja.
        window.notify = function (type, message, title) {
            if (typeof toastr === 'undefined' || !message) return;
            const fn = ['success', 'error', 'warning', 'info'].includes(type) ? type : 'info';
            toastr[fn](message, title || '');
        };

        // Tampilkan flash message dari session Laravel.
        @if (session('success'))
            notify('success', @json(session('success')));
        @endif
        @if (session('error'))
            notify('error', @json(session('error')));
        @endif
        @if (session('warning'))
            notify('warning', @json(session('warning')));
        @endif
        @if (session('info'))
            notify('info', @json(session('info')));
        @endif
        @if (session('status'))
            notify('info', @json(session('status')));
        @endif

        // Tampilkan error validasi (jika ada).
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                notify('error', @json($error));
            @endforeach
        @endif
    })();
</script>
