<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TentangKami extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'Tentang Website';
    protected static ?string $title = 'Tentang Kami';
    protected static string $view = 'filament.pages.tentang-kami';
}
