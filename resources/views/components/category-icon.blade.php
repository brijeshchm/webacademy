@props([
    'key' => '',
    'class' => 'h-6 w-6',
])
@php
    // Mirror artifacts/corporate-academy/src/components/IconMap.tsx getCategoryIcon().
    $k = strtolower((string) $key);
    $icon = match ($k) {
        'data', 'database' => 'database',
        'cloud' => 'cloud',
        'code' => 'code',
        'shield', 'security' => 'shield',
        'agile' => 'book-open',
        'workday', 'enterprise' => 'building',
        'chart' => 'bar-chart',
        'server' => 'server',
        'briefcase' => 'briefcase',
        'design', 'layout' => 'layout-grid',
        'ai', 'machine-learning' => 'monitor-play',
        'servicenow' => 'layers',
        'salesforce' => 'circle-dot',
        'dynamics' => 'cpu',
        'oracle' => 'users',
        default => 'book-open',
    };
    $attrs = 'class="' . e($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';
@endphp
@switch($icon)
    @case('database')
        <svg {!! $attrs !!}><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5V19A9 3 0 0 0 21 19V5"></path><path d="M3 12A9 3 0 0 0 21 12"></path></svg>
        @break
    @case('cloud')
        <svg {!! $attrs !!}><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path></svg>
        @break
    @case('code')
        <svg {!! $attrs !!}><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
        @break
    @case('shield')
        <svg {!! $attrs !!}><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>
        @break
    @case('building')
        <svg {!! $attrs !!}><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path><path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path></svg>
        @break
    @case('bar-chart')
        <svg {!! $attrs !!}><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
        @break
    @case('server')
        <svg {!! $attrs !!}><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
        @break
    @case('briefcase')
        <svg {!! $attrs !!}><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
        @break
    @case('layout-grid')
        <svg {!! $attrs !!}><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        @break
    @case('monitor-play')
        <svg {!! $attrs !!}><path d="m10 7 5 3-5 3Z"></path><rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path></svg>
        @break
    @case('layers')
        <svg {!! $attrs !!}><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
        @break
    @case('circle-dot')
        <svg {!! $attrs !!}><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="1"></circle></svg>
        @break
    @case('cpu')
        <svg {!! $attrs !!}><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="9" y="9" width="6" height="6"></rect><path d="M15 2v2"></path><path d="M15 20v2"></path><path d="M2 15h2"></path><path d="M2 9h2"></path><path d="M20 15h2"></path><path d="M20 9h2"></path><path d="M9 2v2"></path><path d="M9 20v2"></path></svg>
        @break
    @case('users')
        <svg {!! $attrs !!}><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        @break
    @default
        <svg {!! $attrs !!}><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path></svg>
@endswitch
