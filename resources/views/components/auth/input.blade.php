{{-- ============================================================
     Component: auth.input
     Props:
       - label       : string  — field label text
       - type        : string  — input type (default: 'text')
       - id          : string  — input id + label for
       - name        : string  — input name
       - placeholder : string  — placeholder text
       - icon        : string  — 'email' | 'lock' | null
       - required    : bool    — marks field as required
       - forgotLink  : string  — optional URL shown as "Mot de passe oublié ?"
     ============================================================ --}}
@props([
    'label',
    'type'       => 'text',
    'id',
    'name',
    'placeholder' => '',
    'icon'        => null,
    'required'    => false,
    'forgotLink'  => null,
])

<div class="form-group">
    <div class="form-group__header">
        <label class="form-group__label" for="{{ $id }}">{{ $label }}</label>
        <!-- @if($forgotLink)
            <a href="{{ $forgotLink }}" class="form-group__forgot">Mot de passe oublié&nbsp;?</a>
        @endif -->
    </div>

    <div class="input-wrapper">
        {{-- Left icon --}}
        @if($icon === 'email')
            <span class="input-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
            </span>
        @elseif($icon === 'lock')
            <span class="input-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </span>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >

        {{-- Password toggle button --}}
        @if($type === 'password')
            <button
                type="button"
                class="password-toggle"
                aria-label="Afficher/masquer le mot de passe"
                onclick="
                    const inp = this.previousElementSibling;
                    const isText = inp.type === 'text';
                    inp.type = isText ? 'password' : 'text';
                    this.querySelector('.icon-eye').style.display     = isText ? 'block' : 'none';
                    this.querySelector('.icon-eye-off').style.display = isText ? 'none'  : 'block';
                "
            >
                {{-- Eye open --}}
                <svg class="icon-eye" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                {{-- Eye off (hidden by default) --}}
                <svg class="icon-eye-off" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                </svg>
            </button>
        @endif
    </div>
</div>
