<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0"><?php echo $title;?></h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            @if (Auth::check() && Auth::user()->is_admin == true)
                <a href="{{ route('index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Tableau de bord
                </a>
            @else
                <a href="{{ route('transList') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Tableau de bord
                </a>
            @endif
        </li>
        <li>-</li>
        <li class="fw-medium"><?php echo $subTitle;?></li>
    </ul>
</div>