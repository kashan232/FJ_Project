@include('admin_panel.include.header_include')

<div class="main-wrapper">
    @include('admin_panel.include.navbar_include')
    @include('admin_panel.include.admin_sidebar_include')

    <div class="page-wrapper">
        <div class="content">
            <div class="card p-4 shadow-lg">
                <div class="card-body">
                    <h3 class="card-title text-center fw-bold mb-4 text-primary">DATE WISE RECOVERY REPORT</h3>

                    <form id="ledgerSearchForm">
                        @csrf
                        <div class="row g-3">
                            @if(Auth::check() && Auth::user()->usertype === 'admin')
                            <div class="col-md-4">
                                <label for="type" class="form-label">Select Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="all">All</option>
                                    <option value="distributor">Distributor</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                            @elseif(Auth::check() && Auth::user()->usertype === 'distributor')
                            <div class="col-md-4">
                                <label for="type" class="form-label">Select Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                            @endif

                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" id="searchLedger" class="btn btn-primary btn-lg px-5">
                                Search
                            </button>
                        </div>
                    </form>

                    <div class="title mt-4">DATE WISE RECOVERY REPORT</div>
                    <table id="recoveryTable">
                        <thead>
                            <tr>
                                <th>Voc #</th>
                                <th>Date</th>
                                <th>Party Name</th>
                                <th>Area</th>
                                <th>Remarks</th>
                                <th>Rec Amt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">No Data Available</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@include('admin_panel.include.footer_include')

<style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
    }

    .title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>

<script>
    document.getElementById("searchLedger").addEventListener("click", function() {
        let type = document.getElementById("type").value;
        let startDate = document.getElementById("start_date").value;
        let endDate = document.getElementById("end_date").value;
        let csrfToken = document.querySelector('input[name="_token"]').value;

        fetch("{{ route('get-recovery-report') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    type: type,
                    start_date: startDate,
                    end_date: endDate
                })
            })
            .then(response => response.json())
            .then(data => {
                let tableBody = document.querySelector("#recoveryTable tbody");
                tableBody.innerHTML = "";
                let totalAmount = 0;

                if (data.length > 0) {
                    data.forEach((item, index) => {
                        let formattedDate = new Date(item.date).toLocaleDateString("en-GB");
                        let amount = parseFloat(item.amount_paid.replace(/,/g, '')); // Correct comma issue
                        totalAmount += amount;

                        let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${formattedDate}</td>
                        <td>${item.party_name}</td>
                        <td>${item.area}</td>
                        <td>${item.remarks}</td>
                        <td>${item.amount_paid}</td>
                    </tr>`;
                        tableBody.innerHTML += row;
                    });



                    // Fixed: show accurate total recovery
                    tableBody.innerHTML += `
                <tr>
                    <td colspan="5" class="text-end fw-bold">Total Recovery:</td>
                    <td class="fw-bold">${totalAmount.toLocaleString()}</td>
                </tr>`;
                    // Corrected: count all rows as customers if each row is a customer
                    tableBody.innerHTML += `
                <tr>
                    <td colspan="5" class="text-end fw-bold">Total Customers:</td>
                    <td class="fw-bold">${data.length}</td>
                </tr>`;
                } else {
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center">No Data Available</td></tr>`;
                }
            })
            .catch(error => console.error("Error:", error));
    });
</script>