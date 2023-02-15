<!DOCTYPE html>
<html lang="en">

<head>
    <link charset="utf-8">
    <title>title</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />
    <style>

    </style>
    </link>

    <body>
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center" style="background-color: rgb(213, 213, 226);">
            <form action="{{route('add@Data')}}" class="container d-flex flex-wrap align-item-center mb-2" method="POST">
            @csrf
                <input type="text" class="form-control me-3 my-1" placeholder="အ‌ကြောင်းအရာရေးပါ" name="about" style="width: 200px">
                    <input type="number" class="form-control me-3 my-1" placeholder="ငွေပမာဏ‌ရေးပါ" name="amount" style="width: 200px">
                    <input type="date" class="form-control me-3 my-1" name="date" style="width: 200px">
                    <select class="form-select me-3 my-1" name="type" style="width: 200px">
                        <option value="in">၀င်‌ငွေ</option>
                        <option value="out">ထွက်ငွေ</option>
                    </select>
                <input type="submit" class="btn btn-primary rounded my-1" value="စာရင်းသွင်းမည်" style="width: 200px">
            </form>
            <div class="container row col-md-12">
                <div class="p-3 col-md-6">
                    @if (session('success'))
                    <div class="alert bg-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-circle-check text-light me-2"></i>
                        <strong class="text-light">{{session('success')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <h5 class="mb-2 text-dark">စာရင်းများ</h5>
                    <div style="height: 5px;"></div>
                    @foreach ($datas as $data)
                    <div class="bg-light rounded p-2 mb-2 d-flex flex-row justify-content-between">
                        <div>
                            <h6>{{$data->about}}</h6>
                            <p class="text-primary">{{$data->date}}</p>
                        </div>
                        <div>
                            @if ($data->type == 'in')
                                <p class="text-success">+ {{$data->amount}} ကျပ်</p>
                            @else
                                <p class="text-danger">- {{$data->amount}} ကျပ်</p>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    {{$datas->links()}}

                </div>
                <div class="p-3 col-md-6">
                    <div>
                        <h5 class="text-dark">Data Chart</h5>
                        <div>
                            <p class="text-success">ယနေ့၀င်‌ငွေ +{{$today_income}} Ks</p>
                            <p class="text-danger">ယနေ့ထွက်ငွေ -{{$today_outcome}} Ks</p>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
    </body>
    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($day_arr),
                datasets: [{
                    label: '၀င်ငွေ',
                    data: @json($income_amount),
                    borderWidth: 1,
                    backgroundColor: '#139C49'
                }, {
                    label: 'ထွက်ငွေ',
                    data: @json($outcome_amount),
                    borderWidth: 1,
                    backgroundColor: '#DC4C64'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</html>
