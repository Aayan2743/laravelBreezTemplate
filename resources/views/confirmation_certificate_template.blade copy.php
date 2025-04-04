<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 40px;
            background-color: #f8f8f8;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            border: 2px solid #000;
            padding: 20px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header img {
            width: 120px;
            margin-bottom: 10px;
        }
        .header h2 {
            font-weight: 600;
            color: #333;
        }
        .header h3 {
            font-weight: 400;
            color: #555;
        }
        .details {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background: #f4f4f4;
        }
        .terms {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 14px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.png" alt="Company Logo">  
            <h2>GEMTECH INTERNATIONAL LABORATORIES</h2>
            <h3>CONFIRMATION</h3>
        </div>
        
        
      
        <div class="details">
            <p><strong>Confirmation No:</strong> {{$jobCards[0]->confirmid}}</p>
            <p><strong>Received By:</strong> Mr. {{$jobCards[0]->confirmEntryDetails->reciever}}</p>
            <p><strong>Print Date:</strong> {{now()}}</p>
            <p><strong>Received On:</strong>  {{$jobCards[0]->confirmEntryDetails->recievedate}}</p>
        </div>
        <table>
            <tr>
                <th>Sr No.</th>
                <th>Retailer</th>
                <th>Supplier</th>
                <th>Item</th>
                <th>No of Pcs.</th>
                <th>Weight</th>
                <th>Services</th>
            </tr>

            @foreach($jobCards as $key=> $details)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$details->retailer}}</td>
                <td>{{$details->supplier}}</td>
                <td>{{$details->item}}</td>
                <td>{{$details->nop}}</td>
                <td>{{$details->weight}}</td>
                <td>{{$details->serviceDetails->service_name}}</td>
                
            </tr>   
            @endforeach
        </table>
        <p><strong>Total No. of Pieces:</strong> {{$totalNop}}</p>
        <p><strong>Comments:</strong></p>
        <p><strong>Delivery Details:</strong> {{$jobCards[0]->confirmEntryDetails->deliverydate}}</p>
        <div class="terms">
            <h4>Terms and Conditions:</h4>
            <p>GIL shall not be held responsible for any damage or loss of the above listed stones/jewellery...</p>
        </div>
        <div class="signature">
            <p>Receiver's Signature</p>
            <p>Depositor's Signature</p>
        </div>
        <p><strong>Deposited By:</strong> Mr. {{$jobCards[0]->confirmEntryDetails->depositer_name}}</p>
    </div>
</body>
</html>
