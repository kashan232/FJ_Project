@include('admin_panel.include.header_include')
<div class="main-wrapper">
    @include('admin_panel.include.navbar_include')
    @include('admin_panel.include.admin_sidebar_include')

    <div class="page-wrapper">
        <div class="content">

            {{-- Top Receipt Header with Logo and Company Info --}}
            <div class="row mb-4 align-items-center pt-2 pb-2 border-bottom border-3 border-dark">
                <div class="col-md-4 d-flex align-items-center">
                    <img src="{{ url('small-logo.png') }}" alt="Logo" style="max-width: 120px;">
                    <h4 class="fw-bold ms-3" style="font-size: 16px;">FJL LUBRICANTS</h4>
                </div>
                <div class="col-md-4 text-center">
                    <h5 class="fw-bold mb-1">FJLUBRICANTS</h5>
                    <p class="mb-0">6-B Block-E, Latifabad No. 08, Hyderabad</p>
                    <p class="mb-0">Phone: 0314-4021603 / 0334-2611233</p>
                </div>
                <div class="col-md-4 text-end">
                    <h4 class="fw-bold">MACKSOL</h4>
                </div>
            </div>
            <div class="card shadow-lg mt-4 p-4 border-0 rounded-4">
                <div class="text-center mb-4">
                    <h5 class="text-success fw-bold">Distributor Payment Receipt</h5>
                    <p class="text-muted mb-0">Below are the payment details</p>
                    <hr>
                </div>

                <table class="table table-striped align-middle">
                    <tbody>
                        <tr>
                            <th>Distributor Name</th>
                            <td>{{ $distributor->Customer ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $date }}</td>
                        </tr>
                        <tr>
                            <th>Amount Paid</th>
                            <td><span class="badge bg-success fs-6">PKR {{ number_format($amount) }}</span></td>
                        </tr>
                        <tr>
                            <th>Updated Closing Balance</th>
                            <td><span class="badge bg-danger fs-6">PKR {{ number_format($closing_balance) }}</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center mt-5">
                    <a href="{{ route('Distributor-payments') }}" class="btn btn-outline-primary px-4 me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Payment
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-print me-1"></i> Print Receipt
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@include('admin_panel.include.footer_include')
