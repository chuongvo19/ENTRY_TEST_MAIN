<div>
    @if (session('success'))
        <div class="alert-success">
            <h4>{{ session('success') }}</h4>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-danger">
            <h4>{{ session('error') }}</h4>
        </div>
    @endif
</div>