@props(['rector'])

@if($rector)
    <div class="d-inline-flex align-items-center gap-3 rounded-xl border border-custom-blue-light bg-white px-3 py-2 shadow-sm">
        <div class="d-flex align-items-center justify-content-center rounded-circle bg-custom-gray-light text-custom-blue-light" style="width: 36px; height: 36px;">
            <i class="fa fa-user-tie" aria-hidden="true"></i>
        </div>
        <div class="lh-sm">
            <div class="small fw-semibold text-uppercase text-custom-blue-light" style="letter-spacing: .04em;">Rector</div>
            <div class="fw-semibold text-custom-primary">{{ $rector->name }}</div>
            <div class="small text-muted">{{ $rector->email }}</div>
        </div>
    </div>
@endif
