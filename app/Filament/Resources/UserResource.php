<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
// use App\Filament\Resources\UserResource\RelationManagers; // Aktifkan jika perlu Relation Manager
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash; // Import Hash Facade

// --- Import yang diperlukan untuk fitur tambahan ---
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn; // Untuk menampilkan role (Admin/User)
use Filament\Forms\Components\Toggle;    // Untuk form edit/create is_admin
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;  // Untuk filter berdasarkan role
// --- End Import ---

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // Icon di navigasi

    protected static ?string $navigationGroup = 'Manajemen Pengguna'; // Grup di navigasi (opsional)

    protected static ?string $recordTitleAttribute = 'name'; // Atribut untuk judul record (misal di breadcrumbs)

    public static function form(Form $form): Form
    {
        // Definisikan form untuk Create dan Edit
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Pastikan email unik, abaikan record saat ini ketika edit
                Forms\Components\DateTimePicker::make('email_verified_at')
                     ->label('Email Terverifikasi Pada'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable() // Ikon mata show/hide password
                    ->required(fn (string $context): bool => $context === 'create') // Wajib hanya saat membuat user baru
                    ->dehydrated(fn ($state) => filled($state)) // Hanya simpan jika diisi (tidak kosongkan password saat edit jika tidak diubah)
                    ->maxLength(255),
                // --- Toggle untuk is_admin ---
                Toggle::make('is_admin')
                    ->label('Apakah Admin?')
                    ->required(), // Biasanya boolean tidak null
                    // ->helperText('Aktifkan jika pengguna ini adalah Administrator.'), // Teks bantuan (opsional)
                 // ---------------------------
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                // --- Kolom untuk menampilkan Role (Admin/User Biasa) ---
                BadgeColumn::make('is_admin')
                    ->label('Role')
                    ->sortable()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Admin' : 'User Biasa') // Teks di dalam badge
                    ->color(fn (bool $state): string => match ($state) { // Warna badge
                        true => 'success', // Hijau untuk Admin
                        false => 'warning',   // Kuning/Abu2 untuk User Biasa (sesuaikan warnanya)
                    }),
                // -------------------------------------------------------

                IconColumn::make('email_verified_at')
                    ->boolean() // Tampilkan ikon centang/silang
                    ->sortable()
                    ->label('Terverifikasi'),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i') // Format tanggal dan waktu
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true) // Bisa disembunyikan/ditampilkan user
                    ->label('Tanggal Daftar'),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true) // Sembunyikan default
                    ->label('Terakhir Update'),
            ])
            ->filters([
                TernaryFilter::make('email_verified_at')
                    ->label('Email Terverifikasi')
                    ->nullable(), // Filter berdasarkan sudah/belum/semua status verifikasi

                // --- Filter untuk Role ---
                SelectFilter::make('is_admin')
                    ->label('Role Pengguna')
                    ->options([
                        true => 'Admin', // Filter untuk nilai true
                        false => 'User Biasa', // Filter untuk nilai false
                    ]),
                // ------------------------
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Tombol Edit per baris
                Tables\Actions\DeleteAction::make(), // Tombol Hapus per baris
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Tombol Hapus untuk multiple select
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Definisikan Relation Manager di sini jika perlu
            // Contoh: RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // --- Catatan: Jika Anda sudah menggunakan Mutator (method password()) di Model User ---
    // --- maka method mutateFormDataBeforeCreate dan mutateFormDataBeforeSave ---
    // --- untuk hashing password TIDAK diperlukan lagi di Resource ini. ---
    // protected function mutateFormDataBeforeCreate(array $data): array { ... }
    // protected function mutateFormDataBeforeSave(array $data): array { ... }
}