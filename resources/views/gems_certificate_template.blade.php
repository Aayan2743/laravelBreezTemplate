<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .page {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            page-break-after: always;
        }
        .certificate-small, .certificate-big {
            background-color: #fff;
            border: 2px solid #222;
            padding: 15px;
            box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            border-radius: 8px;
        }
        .certificate-small {
            width: 48%;
            margin: 5px;
        }
        .certificate-big {
            width: 100%;
            padding: 25px;
            margin-bottom: 25px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header img {
            width: 350px;
            height: 80px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 8px;
            color: #d35400;
            text-transform: uppercase;
        }
        .bold {
            font-weight: bold;
        }
        .highlight {
            color: #c0392b;
            font-weight: bold;
        }
        .image-box {
            text-align: center;
            margin-top: 15px;
        }
        .image-box img {
            width: 80px;
            height: 50px;
            border: 2px solid #ddd;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 6px;
        }
    </style>
</head>
<body>

@foreach($jobCards as $jobCard)
    @if($jobCard->big_js == 1) 
        <div class="certificate-big">
            <div class="header">
                <img src="{{ public_path('uploads/logo.png') }}" alt="Company Logo">
                <!-- <div class="title">GEMTECH INTERNATIONAL LABORATORIES</div> -->
            </div>
               
            <p><span class="bold">SUMMARY NO:</span> <span class="highlight">{{ $jobCard->summary_no }}</span></p>
            <p><span class="bold">Species:</span> {{ $jobCard->description }}</p>
            <p><span class="bold">Variety:</span> {{ $jobCard->description }}</p>
            <p><span class="bold">SHAPE/CUT:</span> {{ $jobCard->shape_cut }}</p>
            <p><span class="bold">Carat Weight:</span> {{ $jobCard->shape_cut }}</p>
            <p><span class="bold">Measurements:</span> {{ $jobCard->shape_cut }}</p>
            <p><span class="bold">Transparency:</span> {{ $jobCard->shape_cut }}</p>
            <p><span class="bold">Refractive Index:</span> {{ $jobCard->shape_cut }}</p>
            <p><span class="bold">Comments:</span> {{ $jobCard->shape_cut }}</p>
          

            <div class="image-box">
                @if($jobCard->image)
              
                    <img src="{{ public_path('uploads/' . $jobCard->image) }}" alt="Jewelry Image">
                @else
                    <p>No Image Available</p>
                @endif
            </div>
        </div>
    @endif
@endforeach

@foreach($jobCards->where('type', 0)->chunk(2) as $page)
    <div class="page">
        @foreach($page as $jobCard)

       
            <div class="certificate-small">
                <div class="header">
              
                <img src="{{ public_path('GIL.jpg') }}" alt="Company Logo">
               
               
               
               
                    <!-- <div class="title">GEMTECH INTERNATIONAL LABORATORIES</div> -->
                </div>
                @php
                       
                $desc = optional($jobCard->metal)->metal_name; // Avoids error if metal is null
                    $one = explode(',', $desc);
                    $item = $jobCard->item;
                    $diamonds = $jobCard->nol;

                    if ($diamonds == 0) {
                        $final = $one[0] . ' ' . $item . ', ' . ($one[1] ?? '') . ' Weighing in total ' . $jobCard->grwt . ' g. Containing Natural Diamond(s).';
                    } else if ($diamonds == 1) {
                        $final = $one[0] . ' ' . $item . ', ' . ($one[1] ?? '') . ' Weighing in total ' . $jobCard->grwt . ' g. Containing ' . $diamonds . ' Natural Diamond.';
                    } else {
                        $final = $one[0] . ' ' . $item . ', ' . ($one[1] ?? '') . ' Weighing in total ' . $jobCard->grwt . ' g. Containing ' . $diamonds . ' Natural Diamond(s).';
                    }


                       
                @endphp
                <p><span class="bold">SUMMARY NO:</span> <span class="highlight">{{ $jobCard->gjobcardid }}</span></p>
                    <p><span class="bold">Species:</span> {{ $jobCard->species }}</p>
                    <p><span class="bold">Variety:</span> {{ $jobCard->variety }}</p>
                    <p><span class="bold">SHAPE/CUT:</span> {{ $jobCard->cutss->cutname }}</p>
                    <p><span class="bold">Carat Weight:</span> {{ $jobCard->carat }}</p>
                    <p><span class="bold">Measurements:</span> {{ $jobCard->measure }}</p>
                    <p><span class="bold">Transparency:</span> {{ $jobCard->transperancy }}</p>
                    <p><span class="bold">Refractive Index:</span> {{ $jobCard->refindex }}</p>
                    <p><span class="bold">Comments:</span> {{ $jobCard->comments }}</p>


                <div class="image-box">
                    @if($jobCard->image)
                   
                    <img src="{{ storage_path('app/public/uploads/' . $jobCard->image) }}" alt="Jewelry Image">

                       
                    @else
                        <p>No Image Available</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endforeach

</body>
</html>
