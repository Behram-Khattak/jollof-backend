<div class="container-fluid hidden-sm" style="padding-left: 0; padding-right: 0;">
    <div class="row">
        <div class="col-lg-3">
            <nav class="navbar navbar-default" role="navigation" id="fashion-navbar">
                <div class="navbar-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div>
                                <h5><a class="navbar-brand" href="#top">CATEGORIES</a></h5>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="text-right">
                                <button type="button" class="navbar-toggler x collapsed" data-toggle="collapse" data-target="#navbar-collapse-x">
                                    <i class="fa fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse navbar-collapse categories-desktop show" id="navbar-collapse-x" style="height:300px;">
                    <ul class="nav navbar-nav navbar-right">
                        @foreach ($categories as $category)
                        <div class="btn-group dropright mt-2">
                            <a class="dropdown-toggle" href="{{ route('fashion.category.show', [$category->slug,1]) }}" data-toggle=" dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $category->name }}
                            </a>
                            <div class="dropdown-menu {{ $category->slug }}">
                                <div class="row">
                                    @foreach ($category->childrenCategories as $subcategory)
                                    <div class="col-md-4 col-lg-4 mt-10">
                                        <div>
                                            <!-- {{ route('fashion.category.index', $subcategory->slug) }} -->
                                            <p>
                                                <a href="#">
                                                    <strong>{{ $subcategory->name }}</strong>
                                                </a>
                                            </p>
                                            @foreach ($subcategory->categories as $subcategoryVariant)
                                            <a class="dropdown-item" href="{{ route('fashion.category.show', [$subcategory->slug, $subcategoryVariant->slug]) }}">
                                                {{ $subcategoryVariant->name }}
                                            </a>

                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if($loop->iteration == 8)
                        @break
                        @endif
                        @endforeach
                        <a href="{{ route('fashion.layaway.index') }}" class="mt-2">
                            <strong>Layaway Products</strong>
                        </a>
                        <div class="btn-group dropright mt-1">
                            <a class="text-danger font-weight-bolder" href="{{ route('fashion.store.avenue') }}" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i> Fashion Avenue
                            </a>
                        </div>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-lg-9 pd-7">
            <div>
                <div id="fashion-search" style="margin-bottom: 10px;">
                    @include('user.fashion.partials.fashion-search')
                </div>

                @if(request()->routeIs('fashion.index') || request()->routeIs('fashion.category.show') || request()->routeIs('fashion.store.avenue') || request()->routeIs('fashion.store.search') || request()->routeIs('fashion.search') || request()->routeIs('fashion.all_products') || request()->routeIs('fashion.layaway.index') || request()->routeIs('fashion.search.filter')|| request()->routeIs('myaccount'))
                {{ show_banner('fashion', 'slider') }}
                @else

                <div class="movie-div" style="background:linear-gradient(rgba(44, 51, 58, 0.8), rgba(44, 51, 58, 0.8)), url({{ ($business->getMedia(App\Enums\MediaCollectionNames::BANNER)->isEmpty()) ? 'images/vendor-one.png' : $business->getMedia(App\Enums\MediaCollectionNames::BANNER)[0]->getFullUrl() }}); background-size: contain; background-repeat: no-repeat;">
                    <div class="store-wrapper">
                        <div class="container">
                            <p>Store</p>
                            <h2>{{ (request()->routeIs('fashion.store.show')) ? $business->name : $product->owner->name  }}</h2>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>
</div>
