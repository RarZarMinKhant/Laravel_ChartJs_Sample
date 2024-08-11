<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Finance</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center"
        style="background-color: rgb(213, 213, 226);">
        <form action="{{ route('data.store') }}" class="container d-flex flex-wrap align-items-center mb-2"
            method="POST">
            @csrf
            <div class="flex flex-column">
                <input type="number" class="form-control me-3 my-1" placeholder="ငွေပမာဏ‌ရေးပါ" name="amount"
                    style="width: 200px">
                <x-atoms.error name="amount" />
            </div>

            <div class="flex flex-column">
                <input type="text" class="form-control me-3 my-1" placeholder="အ‌ကြောင်းအရာရေးပါ" name="note"
                    style="width: 200px">
                <x-atoms.error name="note" />
            </div>

            <div class="flex flex-column">
                <input type="date" class="form-control me-3 my-1" name="finance_date" style="width: 200px">
                <x-atoms.error name="finance_date" />
            </div>

            <div class="flex flex-column">
                <select class="form-select me-3 my-1" name="type" style="width: 200px">
                    <option value="">Choose Finance Type</option>
                    <option value="in">၀င်‌ငွေ</option>
                    <option value="out">ထွက်ငွေ</option>
                </select>
                <x-atoms.error name="type" />
            </div>

            <input type="submit" class="btn btn-primary rounded my-1" value="စာရင်းသွင်းမည်" style="width: 200px">
        </form>
        <div class="container row col-md-12">
            <div class="p-3 col-md-6">
                @if (session('success'))
                    <div class="alert bg-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-circle-check text-light me-2"></i>
                        <strong class="text-light">{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h5 class="mb-2 text-dark">စာရင်းများ</h5>
                <div style="height: 5px;"></div>
                @foreach ($datas as $data)
                    <div class="bg-light rounded p-2 mb-2 d-flex flex-row justify-content-between">
                        <div>
                            <h6>{{ $data->note }}</h6>
                            <p class="text-primary">{{ $data->finance_date }}</p>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            @if ($data->type == 'in')
                                <p class="text-success">+ {{ $data->amount }} ကျပ်</p>
                            @else
                                <p class="text-danger">- {{ $data->amount }} ကျပ်</p>
                            @endif
                            <form action="{{ route('data.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                            </form>
                        </div>
                    </div>
                @endforeach

                {{ $datas->links() }}
            </div>
            <div class="p-3 col-md-6">
                <div>
                    <h5 class="text-dark">Finance Chart</h5>
                    <div>
                        <p class="text-success">ယနေ့၀င်‌ငွေ +{{ $today_income }} Ks</p>
                        <p class="text-danger">ယနေ့ထွက်ငွေ -{{ $today_outcome }} Ks</p>
                    </div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Bootstrap Js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>

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
