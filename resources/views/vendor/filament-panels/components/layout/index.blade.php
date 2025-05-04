@php
    use Filament\Support\Enums\MaxWidth;

    $navigation = filament()->getNavigation();
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    <div {{-- Remove flex-row-reverse to make sidebar appear on the left --}} class="fi-layout flex min-h-screen w-full overflow-x-clip">
        {{-- Moved Sidebar to the beginning --}}
        @if (filament()->hasNavigation())
            {{-- Sidebar Wrapper with fixed width --}}
            <div class="fi-main-sidebar-ctn w-72 flex-shrink-0"> {{-- Added fixed width --}}
                {{-- Close overlay for mobile --}}
                <div x-cloak x-data="{}" x-on:click="$store.sidebar.close()" x-show="$store.sidebar.isOpen"
                    x-transition.opacity.300ms
                    class="fi-sidebar-close-overlay fixed inset-0 z-30 bg-gray-950/50 transition duration-500 dark:bg-gray-950/75 lg:hidden">
                </div>

                {{-- Remove Manually Added Logo Section --}}
                {{-- <div
                    class="h-16 flex items-center justify-center px-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <a href="{{ filament()->getHomeUrl() }}" class="inline-flex items-center gap-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Pak Jhon Logo" class="h-10 w-auto">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold leading-tight text-gray-800 dark:text-white">PAK JHON</span>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">JAGONYA AYAM BAKAR</span>
                        </div>
                    </a>
                </div> --}}
                {{-- End Remove Manually Added Logo Section --}}

                <x-filament-panels::sidebar :navigation="$navigation" class="fi-main-sidebar" />

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        setTimeout(() => {
                            let activeSidebarItem = document.querySelector(
                                '.fi-main-sidebar .fi-sidebar-item.fi-active',
                            )

                            if (
                                !activeSidebarItem ||
                                activeSidebarItem.offsetParent === null
                            ) {
                                activeSidebarItem = document.querySelector(
                                    '.fi-main-sidebar .fi-sidebar-group.fi-active',
                                )
                            }

                            if (
                                !activeSidebarItem ||
                                activeSidebarItem.offsetParent === null
                            ) {
                                return
                            }

                            const sidebarWrapper = document.querySelector(
                                '.fi-main-sidebar .fi-sidebar-nav',
                            )

                            if (!sidebarWrapper) {
                                return
                            }

                            sidebarWrapper.scrollTo(
                                0,
                                activeSidebarItem.offsetTop -
                                window.innerHeight / 2,
                            )
                        }, 10)
                    })
                </script>
            </div>
        @endif

        {{-- Main Content Area --}}
        <div {{-- Simplified classes, forcing margin for fixed sidebar --}} class="fi-main-ctn flex-1 flex flex-col h-full">
            @if (filament()->hasTopbar())
                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_BEFORE, scopes: $livewire->getRenderHookScopes()) }}

                <x-filament-panels::topbar :navigation="$navigation" />

                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_AFTER, scopes: $livewire->getRenderHookScopes()) }}
            @endif

            <main @class([
                'fi-main mx-auto h-full w-full px-4 md:px-6 lg:px-8',
                match (
                    ($maxContentWidth ??=
                        filament()->getMaxContentWidth() ?? MaxWidth::SevenExtraLarge)
                ) {
                    MaxWidth::ExtraSmall, 'xs' => 'max-w-xs',
                    MaxWidth::Small, 'sm' => 'max-w-sm',
                    MaxWidth::Medium, 'md' => 'max-w-md',
                    MaxWidth::Large, 'lg' => 'max-w-lg',
                    MaxWidth::ExtraLarge, 'xl' => 'max-w-xl',
                    MaxWidth::TwoExtraLarge, '2xl' => 'max-w-2xl',
                    MaxWidth::ThreeExtraLarge, '3xl' => 'max-w-3xl',
                    MaxWidth::FourExtraLarge, '4xl' => 'max-w-4xl',
                    MaxWidth::FiveExtraLarge, '5xl' => 'max-w-5xl',
                    MaxWidth::SixExtraLarge, '6xl' => 'max-w-6xl',
                    MaxWidth::SevenExtraLarge, '7xl' => 'max-w-7xl',
                    MaxWidth::Full, 'full' => 'max-w-full',
                    MaxWidth::MinContent, 'min' => 'max-w-min',
                    MaxWidth::MaxContent, 'max' => 'max-w-max',
                    MaxWidth::FitContent, 'fit' => 'max-w-fit',
                    MaxWidth::Prose, 'prose' => 'max-w-prose',
                    MaxWidth::ScreenSmall, 'screen-sm' => 'max-w-screen-sm',
                    MaxWidth::ScreenMedium, 'screen-md' => 'max-w-screen-md',
                    MaxWidth::ScreenLarge, 'screen-lg' => 'max-w-screen-lg',
                    MaxWidth::ScreenExtraLarge, 'screen-xl' => 'max-w-screen-xl',
                    MaxWidth::ScreenTwoExtraLarge, 'screen-2xl' => 'max-w-screen-2xl',
                    default => $maxContentWidth,
                },
            ])>
                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_START, scopes: $livewire->getRenderHookScopes()) }}

                {{ $slot }}

                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_END, scopes: $livewire->getRenderHookScopes()) }}
            </main>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $livewire->getRenderHookScopes()) }}
        </div>

    </div>
</x-filament-panels::layout.base>
