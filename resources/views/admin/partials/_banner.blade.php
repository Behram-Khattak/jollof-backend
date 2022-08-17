@if (empty($banner))
<div id="demo" class="carousel slide" data-ride="carousel">

    <div class="carousel-inner">

        <div class="carousel-item active">
            <a href="#"><img class="d-block w-100" src="/images/background.png"></a>
        </div>

    </div>
</div>

@else

    @if ($slot == "slider")

    <div id="demo" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ul class="carousel-indicators">
            @for ($i = 0; $i < count($banner->getMedia()); $i++)
            <li data-target="#demo" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
            @endfor

        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">

            @foreach($banner->getMedia() as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <a href="{{ $slide->getCustomProperty('link') }}"><img class="d-block w-100" src="{{ $slide->getUrl() }}"></a>
            </div>

            @endforeach

        </div>

        <a class="carousel-control-prev" href="#demo" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#demo" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    @endif


    @if ($slot == "ad_slot_1")

    <div id="demo" class="carousel slide mt-20" data-ride="carousel">

        <!-- The slideshow -->
        <div class="carousel-inner">

            @foreach($banner->getMedia() as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <a href="{{ $slide->getCustomProperty('link') }}" target="_blank"><img class="d-block w-100" src="{{ $slide->getUrl() }}"></a>
            </div>

            @endforeach

        </div>
    </div>

    @endif


    @if ($slot == "ad_slot_2")

    <div id="demo" class="carousel slide mt-20" data-ride="carousel">

        <!-- The slideshow -->
        <div class="carousel-inner">

            @foreach($banner->getMedia() as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <a href="{{ $slide->getCustomProperty('link') }}" target="_blank"><img class="d-block w-100" src="{{ $slide->getUrl() }}"></a>
            </div>

            @endforeach

        </div>
    </div>

    @endif

@endif
