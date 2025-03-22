<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #000;
        }
        .invoice-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .invoice-details {
            margin-top: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            break-inside: avoid; /* Prevents breaking table content */
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            white-space: nowrap; /* Prevents text from wrapping */
        }
        .total-section {
            margin-top: 20px;
            font-weight: bold;
        }
        .bank-details, .tax-details {
            margin-top: 20px;
            border: 1px solid black;
            padding: 10px;
        }
        .signature {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
   
    <div class="invoice-header">
    <h2>INVOICE</h2>
    
    <img src="{{ storage_path('app/public/uploads/GIL_LOGO.png')}}" alt="Company Logo">

    
    
</div>

    <div class="invoice-details">
        <p><strong>Invoice No:</strong> {{$invoice_number}}</p>
        <p><strong>Invoice To:</strong> {{$clientName}}, {{$clientAddress}}</p>
        <p><strong>Date:</strong> {{$receivedDate}}</p>
    </div>

    @if(isset($services['diamond']) && is_array($services['diamond']))
        <h3>Diamond Services</h3>
        <table class="invoice-table">
            <tr>
                <th>Sr No.</th>
                <th>Dia. Caratage</th>
                <th>Services</th>
                <th>Rates</th>
                <th>Qty</th>
                <th>Carat</th>
                <th>Amount</th>
            </tr>
            @foreach ($services['diamond'] as $index => $diamond)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $diamond['range'] }}</td>
                    <td>{{ $diamond['service'] }}</td>
                    <td>{{ $diamond['rate'] }} {{ $diamond['extension'] }}</td>
                    <td>{{ $diamond['quantity'] }}</td>
                    <td>{{ $diamond['grwt'] }}</td>
                    <td>{{ number_format($diamond['amount'], 2) }}</td>
                </tr>
            @endforeach
            
            
            <tfoot>
    <tr>
        <td colspan="6" style="text-align: right;"><strong>Total Amount:</strong></td>
        <td><strong>{{ number_format($services['diamond_jobs_service_total_amount'], 2) }}</strong></td>
    </tr>
</tfoot>

        </table>


    @endif

  
                

    @if(isset($services['gemstone']) && is_array($services['gemstone']))
        <h3>Gemstone Services</h3>
        <table class="invoice-table">
            <tr>
            <th>Sr No.</th>
                <th>Range</th>
                <th>Service</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Carat</th>
                <th>Amount</th>
            </tr>
            @foreach ($services['gemstone'] as $index => $gemstone)
                <tr>
                <td>{{ $index + 1 }}</td>
                    <td>{{ $gemstone['range'] }}</td>
                    <td>{{ $gemstone['service'] }}</td>
                    <td>{{ $gemstone['rate'] }} {{ $gemstone['extension'] }}</td>
                    <td>{{ $gemstone['quantity'] }}</td>
                    <td>{{ $gemstone['grwt'] }}</td>
                    <td>{{ number_format($gemstone['amount'], 2) }}</td>
                </tr>
            @endforeach

            <tfoot>
    <tr>
        <td colspan="6" style="text-align: right;"><strong>Total Amount:</strong></td>
        <td><strong>{{ number_format($services['gemstone_jobs_service_total_amount'], 2) }}</strong></td>
    </tr>
</tfoot>



        </table>

    @endif

    @if(isset($services['diamondcard']) && is_array($services['diamondcard']))
        <h3>Diamond Card Services</h3>
        <table class="invoice-table">
            <tr>
            <th>Sr No.</th>
                <th>Range</th>
                <th>Service</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Carat</th>
                <th>Amount</th>
            </tr>
            @foreach ($services['diamondcard'] as $index => $diamondcard)
                <tr>
                <td>{{ $index + 1 }}</td>
                    <td>{{ $diamondcard['range'] }}</td>
                    <td>{{ $diamondcard['service'] }}</td>
                    <td>{{ $diamondcard['rate'] }} {{ $diamondcard['extension'] }}</td>
                    <td>{{ $diamondcard['quantity'] }}</td>
                    <td>{{ $diamondcard['grwt'] }}</td>
                    <td>{{ number_format($diamondcard['amount'], 2) }}</td>
                </tr>
            @endforeach

             
            <tfoot>
    <tr>
        <td colspan="6" style="text-align: right;"><strong>Total Amount:</strong></td>
        <td><strong>{{ number_format($services['diamonds_jobs_service_total_amount'], 2) }}</strong></td>
    </tr>
</tfoot>
        </table>
    @endif


    @if(isset($services['gemjewellerycard']) && is_array($services['gemjewellerycard']))
        <h3>Gem Jewellery Card Services</h3>
        <table class="invoice-table">
            <tr>
            <th>Sr No.</th>
                <th>Range</th>
                <th>Service</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Carat</th>
                <th>Amount</th>
            </tr>
            @foreach ($services['gemjewellerycard'] as $index => $diamondcard)
                <tr>
                <td>{{ $index + 1 }}</td>
                    <td>{{ $diamondcard['range'] }}</td>
                    <td>{{ $diamondcard['service'] }}</td>
                    <td>{{ $diamondcard['rate'] }} {{ $diamondcard['extension'] }}</td>
                    <td>{{ $diamondcard['quantity'] }}</td>
                    <td>{{ $diamondcard['grwt'] }}</td>
                    <td>{{ number_format($diamondcard['amount'], 2) }}</td>
                </tr>
            @endforeach

            <tfoot>
    <tr>
        <td colspan="6" style="text-align: right;"><strong>Total Amount:</strong></td>
        <td><strong>{{ number_format($services['gem_jewellery_card_jobs_total'], 2) }}</strong></td>
    </tr>
</tfoot>
        </table>
    @endif


    @if(isset($services['uncutjewellery']) && is_array($services['uncutjewellery']))
        <h3>Un Cut Jewellery Card Services</h3>
        <table class="invoice-table">
            <tr>
            <th>Sr No.</th>
                <th>Range</th>
                <th>Service</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Carat</th>
                <th>Amount</th>
            </tr>
            @foreach ($services['uncutjewellery'] as $index => $diamondcard)
                <tr>
                <td>{{ $index + 1 }}</td>
                    <td>{{ $diamondcard['range'] }}</td>
                    <td>{{ $diamondcard['service'] }}</td>
                    <td>{{ $diamondcard['rate'] }} {{ $diamondcard['extension'] }}</td>
                    <td>{{ $diamondcard['quantity'] }}</td>
                    <td>{{ $diamondcard['grwt'] }}</td>
                    <td>{{ number_format($diamondcard['amount'], 2) }}</td>
                </tr>
            @endforeach

            <tfoot>
    <tr>
        <td colspan="6" style="text-align: right;"><strong>Total Amount:</strong></td>
        <td><strong>{{ number_format($services['uncut_jewellery_card_total'], 2) }}</strong></td>
    </tr>
</tfoot>

        </table>
    @endif



    @if(isset($services['extrachargesdata']) && is_array($services['extrachargesdata']))
        <h3>Extra Charges</h3>
        <table class="invoice-table">
            <tr>
            <th>Sr No.</th>
                <th>Service Name</th>
                <th colspan="2">Remarks</th>
                <th>Price</th>
               
             
            </tr>
            @foreach ($services['extrachargesdata'] as $index => $diamondcard)

                
           
                <tr>
                <td>{{ $index + 1 }}</td>
                 
                    <td>{{ $diamondcard['serviceName'] }}</td>
                   
                    <td colspan="2">{{ $diamondcard['extracharges']['extra_comment'] }}</td>
                    <td>{{ $diamondcard['extracharges']['price'] }}</td>
                   
                </tr>
            @endforeach


            <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total Amount:</strong></td>
                <td><strong>{{ number_format($services['totalExtraCharges'], 2) }}</strong></td>
            </tr>
        </tfoot>


          
        </table>
    @endif




    <div class="total-section">
        <p><strong>SUB TOTAL:</strong> {{ number_format($services['sub_total'], 2) }}</p>
        <p><strong>EXTRA CHARGES TOTAL:</strong> {{number_format($services['totalExtraCharges'], 2) }}</p>
        <p><strong>GST (18%):</strong> {{ number_format($services['gst'], 2) }}</p>
        <p><strong>GRAND TOTAL:</strong>{{ number_format($services['total_final_amount'], 2) }}</p>
    </div>

    <div class="bank-details">
        <p><strong>Bank Name:</strong> Karur Vysya Bank</p>
        <p><strong>Branch Name:</strong> Abids, Hyderabad</p>
        <p><strong>Account No:</strong> 1443135000010425</p>
        <p><strong>Bank Account Type:</strong> Current</p>
        <p><strong>IFSC Code:</strong> KVBL0001443</p>
    </div>

    <div class="tax-details">
        <p>Interest @ 20% will be charged on overdue Invoice.</p>
        <p>Subject to Hyderabad Jurisdiction, Payment Due Date: 11-Jan-1970</p>
    </div>

    <div class="signature">
        <p>Authorized Signatory</p>
        <p>Email: gillabsindia@gmail.com</p>
    </div>
</body>
</html>
