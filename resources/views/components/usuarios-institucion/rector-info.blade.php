@props(['rector'])

@if($rector)
    <div class="d-flex align-items-center justify-content-end gap-2 text-end">
        <i class="fa fa-user-tie text-custom-blue-light" aria-hidden="true"></i>
        <div class="lh-sm">
            <div class="small text-muted">Rector</div>
            <strong>{{ $rector->name }}</strong>
            <span class="small text-muted">| {{ $rector->email }}</span>
        </div>
    </div>
@endif
