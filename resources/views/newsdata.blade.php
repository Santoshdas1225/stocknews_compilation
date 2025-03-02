<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
    
    .wrap-text {
        word-wrap: break-word; 
        white-space: normal; 
        vertical-align: middle;
        /* width: 50px; 
        height: 50px; */
        
    }
    
    .logo{
        width: 70px;
        height: 50px;
    }
</style>
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">All News</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Sl No.</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col">Link</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($alldata as $item)
                        <tr>
                            <td class="wrap-text">{{ $i++ }}</td>
                            <td>
                                @if ($item->source == 'Economic Times')
                                    <img src="{{ asset('/economictimes.png') }}" alt="Economic Times Logo" class="logo">
                                @elseif ($item->source == 'LiveMint')
                                    <img src="{{ asset('/livemint.png') }}" alt="LiveMint Logo" class="logo">
                                @elseif ($item->source == 'Zeebusiness')
                                    <img src="{{ asset('/zeebusiness.png') }}" alt="ZeeBusiness Logo" class="logo">
                                @elseif ($item->source == 'Money Control')
                                    <img src="{{ asset('/moneycontrol.png') }}" alt="Money Control Logo" class="logo">
                                @endif
                            </td>
                            <td class="">{{ $item->date }}</td>
                            <td class="wrap-text">{{ $item->title }}</td>
                            <td><a href="{{ $item->link }}" target="_blank" class="btn btn-primary btn-sm">Read More</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>