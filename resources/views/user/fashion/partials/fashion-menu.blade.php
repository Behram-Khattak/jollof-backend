<div class="collapse show navbar-collapse categories-desktop"
     id="navbar-collapse-x">
    <ul class="nav navbar-nav navbar-right">
        @foreach ($categories as $category)
            <div class="btn-group dropright mt-3">
                <a class="dropdown-toggle" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    {{ $category->name }}
                </a>
                <div class="dropdown-menu {{ $category->slug }}">
                    <div class="row">
                        @foreach ($category->childrenCategories as $subcategory)
                            <div class="col-md-4 col-lg-4 mt-10">
                                <div>
                                    <p>
                                        <a href="{{ route('fashion.category.index', $subcategory->slug) }}">
                                            <strong>{{ $subcategory->name }}</strong>
                                        </a>
                                    </p>
                                    @foreach ($subcategory->categories as $subcategoryVariant)
                                        <a class="dropdown-item"
                                           href="{{ route('fashion.category.index', $subcategoryVariant->slug) }}"
                                        >
                                            {{ $subcategoryVariant->name }}
                                        </a>

                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </ul>
</div>
