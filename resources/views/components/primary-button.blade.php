<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary bg-sand border-0']) }}>
    {{ $slot }}
</button>
