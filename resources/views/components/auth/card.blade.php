{{-- ============================================================
     Component: auth.card
     Wraps the white login/form card on the right side of the page.
     ============================================================ --}}
<div class="auth-card-wrapper" {{ $attributes }}>
    <div class="auth-card">
        {{ $slot }}
    </div>
</div>
