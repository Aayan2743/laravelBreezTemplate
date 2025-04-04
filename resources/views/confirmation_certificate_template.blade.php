<html>
  <head>
    <title></title>
  </head>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    h4 {
      margin-top: 5px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th,
    td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    .tablehead {
      border: 0;
      text-align: center;
    }
    .custom-table {
      border-collapse: separate; /* Makes each cell have its own box */
      border-spacing: 10px; /* Adds space between the boxes */
      width: 100%;
    }
    .tablecell{
        padding:6px;
    }
    @media print {
  * {
    -webkit-print-color-adjust: exact; /* For Safari/Chrome */
    print-color-adjust: exact; /* Standard property */
  }
}
  </style>
  <body>
   
    <div style="padding: 5px">
      

    <img src="{{ public_path('GIL.jpg') }}" alt="Company Logo">
        <h3 style="text-align: center; margin-top: 10px; margin-bottom: 10px">
          CONFIRMATION
        </h3>
      <div style="display: flex; justify-content: space-between">
        <div>
          <h4>
            Confirmation No : <span style="font-weight: 300"> {{$jobCards[0]->confirmid}}</span>
          </h4>
          <h4>Received By : Mr. {{$jobCards[0]->confirmEntryDetails->reciever}} <span></span></h4>
        </div>
        <div>
          <h4>
            Print Date :
            <span style="font-weight: 300">{{now()}}</span>
          </h4>
          <h4>
            Received On :
            <span style="font-weight: 300"> {{$jobCards[0]->confirmEntryDetails->recievedate}}</span>
          </h4>
        </div>
      </div>
      <div style="margin-top: 5px">
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
      </div>
      <div style="margin-top: 10px; margin-bottom: 10px">
        <h4>Total No. of Pieces :  {{$totalNop}}</h4>
        <h4>Comments :</h4>
        <h4>Delivery Details : {{$jobCards[0]->confirmEntryDetails->deliverydate}}</h4>
      </div>
      <div>
        <h4>Terms and Conditions :</h4>
        <p style="margin-top: 5px">
          There are many variations of passages of Lorem Ipsum available, but
          the majority have suffered alteration in some form, by injected
          humour, or randomised words which don't look even slightly believable.
          If you are going to use a passage of Lorem Ipsum, you need to be sure
          there isn't anything embarrassing hidden in the middle of text.
        </p>
        <p style="margin-top: 5px; margin-left: 300px">
          There are many variations of passages of Lorem Ipsum available, but
          the majority have suffered alteration in some form, by injected
          humour, or randomised words which don't look even slightly believable.
          If you are going to use a passage of Lorem Ipsum, you need to be sure
          there isn't anything embarrassing hidden in the middle of text.
        </p>
      </div>
      <div
        style="display: flex; justify-content: space-around; margin-top: 10px"
      >
        <div>
          <h4>Receiver's Signature</h4>
        </div>
        <div>
          <h4>Depositor's Signature</h4>
          <p style="margin-top: 10px">Deposited By</p>
        </div>
      </div>
      <div style="margin-top: 5px">
        <table class="custom-table">
          <tr>
            <th class="tablehead">Sr No.</th>
            <th class="tablehead">Retailer</th>
            <th class="tablehead">Supplier</th>
            <th class="tablehead">Item</th>
            <th class="tablehead">No of Pcs.</th>
          </tr>
          <tr>
            <td class="tabelcell"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
      <div style="margin-top:5px;background-color:#be9b55 ;color:white;text-align: center;padding: 10px;">
        <p style="font-weight: 600;margin-top: 10px;">Head Office : # Door no. 107, C-Block, First Floor, Mayur Kushal Complex,</p>
        <p style="font-weight: 600;margin-top: 5px;">Gunfoundary, Abids, Hyderabad - 500001, Telangana.</p>
        <p style="font-weight: 600;margin-top: 5px; margin-bottom: 10px;">Mobile: +91-6301761854 | Email: gillabsIndia@gmail.com | www.gil-labs.com</p>
      </div>
    </div>
  </body>
</html>
