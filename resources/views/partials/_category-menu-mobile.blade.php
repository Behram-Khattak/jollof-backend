<div class="logo-wrapper shopping-categories hidden-md hidden-lg" style="background: #FAFAFA;">
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoriesNavbar">
                <i class="fa fa-bars"></i> &nbsp;<span style="font-size: 15px;">CATEGORIES</span>
            </button>
            <div class="collapse navbar-collapse" id="categoriesNavbar">
                <ul class="navbar-nav ml-auto">
                    @foreach ($categories as $category)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">
                            {{ $category->name }}
                        </a>
                        <div class="dropdown-menu">
                            <div class="row">
                                @foreach ($category->childrenCategories as $subcategory)
                                <div class="col-sm-4 col-6 mt-10">
                                    <div>
                                        <p>
                                            <a href="{{ route('fashion.category.index', $subcategory->slug) }}">
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
                    </li>
                    @if($loop->iteration == 8)
                    @break
                    @endif
                    @endforeach
                    <li>
                        <a class="text-danger font-weight-bolder" href="{{ route('fashion.store.avenue') }}" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i> Fashion Avenue
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
