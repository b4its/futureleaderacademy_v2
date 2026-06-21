<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PengajarPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('pengajar')
            ->path('pengajar')
            ->brandName('Pengajar Panel')
            ->login()
            ->globalSearch(false)
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->renderHook(
                'panels::auth.login.form.after',
                fn () => view('filament.hooks.halaman-utama-button'),
            )
            ->renderHook(
                'panels::body.end',
                fn () => view('filament.mathjax'),
            )
            ->userMenuItems([
                MenuItem::make()
                    ->label('Pembelajaran Pengajar')
                    ->icon('heroicon-o-academic-cap')
                    ->url('/pembelajaran/pengajar'),
            ])
            ->discoverResources(in: app_path('Filament/Resources/Pengajar'), for: 'App\Filament\Resources\Pengajar')
            ->discoverPages(in: app_path('Filament/Pages/Pengajar'), for: 'App\Filament\Pages\Pengajar')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets/Pengajar'), for: 'App\Filament\Widgets\Pengajar')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\EnsureIsPengajar::class,
            ]);
    }
}
