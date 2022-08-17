<form class="kt-form" action="{{ route('merchant.report.filter') }}" method="POST">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @csrf

    <div class="form-group row">
        <div class="col-md-3">
            <label>Business:</label>
            <select name="business" class="form-control select2" id="kt_select2_1">
                <option value="" selected>Select Business</option>
                @forelse ($businesses as $biz)

                <option value="{{ $biz->id }}">{{ $biz->name }}</option>

                @empty
                <option value="">No Business Available</option>
                @endforelse
            </select>
            <span class="form-text text-muted">Select Business</span>
        </div>
        <div class="col-md-3">
            <label>Report</label>
            <select name="report" class="form-control">
                <option value="" selected>Select Report</option>
                @forelse ($reports as $report)

                <option value="{{ $report }}">{{ $report }}</option>

                @empty
                <option value="">No Business Available</option>
                @endforelse
            </select>
            <span class="form-text text-muted">Select report type</span>
        </div>
        <div class="col-md-3">
            <label>Duration of Report</label>
            <input class="form-control daterange" type="text" value="" name="duration">
            <span class="form-text text-muted">Select date range for report</span>
        </div>

        <div class="col-md-3">
            <label>Payment Status</label>
            <select name="payment" class="form-control select2" id="kt_select2_1">
                <option value="all" selected>All</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <button type="submit" class="btn btn-primary btn-lg">Generate Report</button>
    </div>

</form>

@push('scripts')

<script>
    jQuery(document).ready(function() {
        $('#kt_select2_1').select2({
            placeholder: "Select a Business"
        });

    });
</script>

@endpush
