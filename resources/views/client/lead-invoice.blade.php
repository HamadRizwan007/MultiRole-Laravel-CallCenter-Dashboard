<x-dashboard-layout>
    <x-slot name="pageTitle">Lead Invoice</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client.leads', $client) }}">Client Leads</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Generate Invoice</a></li>
    </x-slot>
    <div class="Lead-invoice">
        <div class="download-btn text-right mr-3">
            <button type="button" class="btn btn-success download-invoice">Download invoice</button>
        </div>
        <div id="generateId">
            <table class="table table-borderless" style="margin-bottom: 1in">
                <tr>
                    <td class="align-bottom">
                        <h2>GIGA BITE PVT LTD</h2>
                        <span>Your Insurance Leads Provider</span>
                    </td>
                    <td>
                        <img src="{{ asset('/img/logo.png') }}" width="120px" height="120px" alt="logo">
                    </td>
                    <td class="text-right align-bottom">
                        <h2 class="display-4 font-weight-bold">INVOICE</h2>
                    </td>
                </tr>
            </table>
            <div class="d-flex justify-content-between mt-3">
                <div>
                    <h5>Tel: 917-720-3759</h5>
                    <h5>Email: <a href="mailto:info@gigabitesoft.com">info@gigabitesoft.com</a></h5>
                    <h5>Web: <a href="https://gigabitesoft.com">https://gigabitesoft.com</a></h5>
                </div>
                <div class="text-right">
                    <h5>INVOICE # {{ $invoice['invoice_number'] }}</h5>
                    <h5>DUE DATE: {{ date('d-M-Y', strtotime($invoice['due_date'])) }}</h5>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div>
                    <h4><b>To:</b></h4>
                    <h5>{{ $client['name'] }}</h5>
                    <h5>{{ $client['agency'] }}</h5>
                    <h5>{{ implode(' , ', $invoice['state']) }}</h5>
                </div>
                <div class="text-right">
                    <h4><b>ACH Details:</b></h4>
                    <h5>ABDUL REHMAN SIDDIQUE RANA (CEO GBS) </h5>
                    <h5><b>Routing number</b> 084009519</h5>
                    <h5><b>Account number</b> 9600001939606001</h5>
                    <h5><b>Account typer</b> Checking</h5>
                    <h5><b>Address</b> 19 W 24th Street<br>
                        New York NY 10010<br>
                        United States</h5>
                </div>
            </div>
            <div class="mt-5">
                <h4><b>INSURANCE LEADS PROJECT:</b></h4>
                <h5>{{ ucwords($invoice['lead_request']) }}</h5>
            </div>
            <div class="mt-5">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">DESCRIPTION</th>
                            <th scope="col">UNIT PRICE</th>
                            <th scope="col">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">{{ $invoice['billable_leads'] }}</th>
                            <td>Billable Leads</td>
                            <td>$ {{ $invoice['unit_price'] }}</td>
                            <td>$ {{ $invoice['total_invoice'] }}</td>
                        </tr>

                    </tbody>
                    <tfoot class="footer">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Total</td>
                            <th>$ {{ $invoice['total_invoice'] }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div style="margin-top: 100px;">
                <h5>We are always at your service. </h5>
            </div>
            <div class="text-center mt-5">
                <h2>THANK YOU FOR YOUR BUSINESS!</h2>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('.download-invoice').click(function(){
                var element = document.getElementById('generateId');

                var opt =
                {
                  margin:       [0.1, 0.25],
                  filename:     '{{$invoice['invoice_number']}} - {{$client->name}}.pdf',
                  image:        { type: 'jpeg', quality: 0.98 },
                  html2canvas:  { scale: 2 },
                  jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
                };

                // New Promise-based usage:
                html2pdf().set(opt).from(element).save();
            });
			//more custom settings
        </script>
    </x-slot>
</x-dashboard-layout>
