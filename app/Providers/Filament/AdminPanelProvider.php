<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
<<<<<<< HEAD
use Illuminate\Contracts\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckAdminRole;
=======
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
<<<<<<< HEAD
                // 'primary' => Color::Amber, // Keep the color from config/filament.php
            ])
            ->brandLogo(fn(): View => view('filament.custom-brand'))
            ->brandLogoHeight('3rem') // Adjust height for the combined element if needed
=======
                'primary' => Color::Amber,
            ])
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
<<<<<<< HEAD
                CheckAdminRole::class,
=======
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            ]);
    }
}
