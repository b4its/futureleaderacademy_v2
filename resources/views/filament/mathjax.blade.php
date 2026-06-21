{{-- Memuat MathJax di panel Filament agar konten ber-LaTeX (mis. pratinjau --}}
{{-- artikel & infolist) ter-render. Re-typeset otomatis setelah update Livewire. --}}
<script>
    window.MathJax = window.MathJax || {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']],
            displayMath: [['$$', '$$'], ['\\[', '\\]']],
            processEscapes: true,
            processEnvironments: true
        },
        options: {
            skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code']
        }
    };
</script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
<script>
    (function () {
        let timer, observer;

        function typeset() {
            if (!(window.MathJax && window.MathJax.typesetPromise)) {
                setTimeout(typeset, 300);
                return;
            }
            // Putuskan observer selama proses agar tidak memicu dirinya sendiri.
            if (observer) observer.disconnect();
            window.MathJax.typesetPromise().catch(function () {}).finally(startObserving);
        }

        function schedule() {
            clearTimeout(timer);
            timer = setTimeout(typeset, 350);
        }

        function startObserving() {
            if (observer) observer.disconnect();
            observer = new MutationObserver(schedule);
            observer.observe(document.body, { childList: true, subtree: true });
        }

        function init() {
            startObserving();
            schedule();
        }

        if (document.readyState !== 'loading') init();
        else document.addEventListener('DOMContentLoaded', init);

        // Livewire SPA navigation (Filament) mengganti isi body.
        document.addEventListener('livewire:navigated', init);
    })();
</script>
