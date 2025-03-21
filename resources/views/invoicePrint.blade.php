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
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
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
    <div class="invoice-header">INVOICE</div>
    <div class="invoice-details">
        <p>Invoice No: {{$invoice_number}}</p>
        <p>Invoice To: {{$clientName}} , {{$clientAddress}}</p>
        <p>Date: {{$receivedDate}}</p>
    </div>
    
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

  
        <tr>
            <td>1</td>
            <td>{{$services['range']}}</td>
            <td>{{$services['service']}}</td>
            <td>{{$services['rate']}} {{$services['extension']}}</td>
            <td>{{$services['quantity']}} </td>
            <td>{{$services['grwt']}} </td>
            <td>{{$services['amount']}} </td>
          
          
          
          
        </tr>
     
    </table>
    
    <div class="total-section">
        <p>SUB TOTAL: 13,548.50</p>
        <p>GST (18%): 2,438.73</p>
        <p>GRAND TOTAL: 15,988.00</p>
    </div>
    
    <div class="bank-details">
        <p><b>Bank Name:</b> Karur Vysya Bank</p>
        <p><b>Branch Name:</b> Abids, Hyderabad</p>
        <p><b>Account No:</b> 1443135000010425</p>
        <p><b>Bank Account Type:</b> Current</p>
        <p><b>IFSC Code:</b> KVBL0001443</p>
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
