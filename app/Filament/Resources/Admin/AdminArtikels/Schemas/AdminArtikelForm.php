<?php

namespace App\Filament\Resources\Admin\AdminArtikels\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class AdminArtikelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_artikel_id')
                    ->label('Kategori Artikel')
                    ->relationship('kategoriArtikel', 'title') 
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('gambar')
                    ->disk('public_folder')
                    ->directory(function ($record, $get) {
                        // Ambil singkatan dan slug agar "PT SM" jadi "pt_sm"
                        $singkatan = Str::slug($record?->singkatan ?? $get('singkatan') ?? 'default', '_');
                        
                        if ($record?->id) {
                            return "media/company-internal/{$singkatan}/logo/{$record->id}";
                        }
                        
                        return "media/company-internal/{$singkatan}/logo/temp";
                    })
                    ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                        $ext = $file->getClientOriginalExtension();
                        $datetime = now()->format('Ymd_His');
                        $id = $record?->id ?? 'new';
                        return "logo_{$datetime}_{$id}.{$ext}";
                    })
                    // === TAMBAHKAN INI UNTUK MENGHENTIKAN LOOP ===
                    // 1. Matikan pratinjau sementara untuk memastikan masalah di level URL/Path
                    ->previewable(false) 
                    
                    // 2. Cegah error jika file fisik hilang (Trik untuk menimpa method yang hilang sebelumnya)
                    ->extraAttributes(['data-on-error' => 'this.style.display="none"']) 
                    // ============================================

                    ->visibility('public')
                    ->preserveFilenames(false)
                    ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public_folder')->delete($file)),

                RichEditor::make('description')
                    ->label('Isi Artikel')
                    ->helperText('Tulis rumus dengan LaTeX, contoh: $\frac{3}{8}$ atau $X > Y$. Lihat hasilnya di pratinjau bawah.')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'orderedList',
                        'bulletList',
                        'h2',
                        'h3',
                        'blockquote',
                        'codeBlock',
                        'redo',
                        'undo',
                    ])
                    ->live(onBlur: true)
                    ->columnSpanFull()
                    ->required(),

                Placeholder::make('preview_latex')
                    ->label('Pratinjau Rumus (LaTeX)')
                    ->columnSpanFull()
                    ->content(fn (Get $get): HtmlString => new HtmlString(
                        '<div class="mathjax-preview" style="line-height:1.8; padding:12px; border:1px solid #e5e7eb; border-radius:8px; background:#fff;">'
                        . ($get('description') ?: '<span style="color:#9ca3af;">Mulai menulis untuk melihat pratinjau rumus…</span>')
                        . '</div>'
                    )),
            ]);
    }
}
