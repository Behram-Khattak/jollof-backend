@include('admin.partials._header.base-mobile')

<!-- begin:: Root -->
<div class="kt-grid kt-grid--hor kt-grid--root">

	<!-- begin:: Page -->
	<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        @include('admin.partials._aside.base')

		<!-- begin:: Wrapper -->
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            @include('admin.partials._header.base')

			<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                @yield('content')

			</div>

            @include('admin.partials._footer.base')

		</div>

		<!-- end:: Wrapper -->
	</div>

	<!-- end:: Page -->
</div>

<!-- end:: Root -->

@include('admin.partials._scrolltop')
