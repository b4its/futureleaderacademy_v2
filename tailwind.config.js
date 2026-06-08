import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        // Tambahkan baris di bawah ini jika Anda punya komponen Livewire kustom
        './app/Livewire/**/*.php',
        './resources/views/livewire/**/*.blade.php',
    ],
}