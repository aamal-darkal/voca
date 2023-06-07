<div class="canvas offcanvas-lg offcanvas-start rounded-4" tabindex="-1" id="offcanvasResponsive"
    aria-labelledby="offcanvasResponsiveLabel">
    <div class="offcanvas-header">
        <a type="button" class="text-dark" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive"
            aria-label="Close"><i class="fa-solid fa-circle-arrow-left fa-2x"></i></a>
    </div>
    <div class="w-100 text-center pt-2 menu-title h5">Dashboard</div>
    <hr class="my-2 border-light">
    <div class="offcanvas-body">
        <div class="side-menu btn-group-vertical w-100" role="group" aria-label="Vertical button group">
            <a class="btn border" href="/"><i class="fas fa-home"></i> Home</a>
            <a class="btn border" href="{{ route('languages.index') }}"><i class="fas fa-language"></i> Languages</a>
            <a class="btn border" href="{{ route('participants.index') }}"><i class="fas fa-user-friends"></i> Participants</a>
            <a class="btn border" href="{{ route('domains.index') }}"><i class="fas fa-section"></i> Domains</a>
            <a class="btn border" href="{{ route('phrases.index') }}"><i class="fas fa-quote-left"></i> <i class="fas fa-quote-right"></i> phrases</a>
            <a class="btn border" href="{{ route('home.saveProfile') }}"><i class="fas fa-quote-left"></i> <i class="fas fa-user"></i> profile</a>
        </div>
    </div>
</div>
`