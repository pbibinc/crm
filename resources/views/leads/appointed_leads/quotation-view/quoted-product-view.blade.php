<table id="forQuoteLead" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>Company Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groupedProducts as $company => $groupedProduct)
            @php
                $displayCompany = false;
                foreach ($groupedProduct as $product) {
                    if ($product['product']->status == 1) {
                        $displayCompany = true;
                        break;
                    }
                }
            @endphp
            @if ($displayCompany)
                <tr style="background-color: #f0f0f0;">
                    <td><strong><b>{{ $company }}</b></strong></td>
                    <td><strong><b>Product</b></strong></td>
                    <td><strong><b>Telemarketer</b></strong></td>
                    <td><strong><b>Status</b></strong></td>
                    {{-- <td><strong><b>Action</b></strong></td> --}}
                </tr>
                @foreach ($groupedProduct as $product)
                    @if ($product['product']->status == 1)
                        <tr>
                            <td></td>
                            <td>
                                <a href="lead-profile-view/{{ $product['product']->id }}" id="viewButton" name="viewButton"
                                    class="viewButton" id="{{ $product['product']->id }}">
                                    {{ $product['product']->product }}</a>
                            </td>
                            <td>{{ $product['telemarketer'] }}</td>
                            <td>
                                @if ($product['product']->status == 1)
                                    <span class="badge bg-success">Quoted</span>
                                @else
                                    <span class="badge bg-warning">Quoting</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach
    </tbody>
</table>
