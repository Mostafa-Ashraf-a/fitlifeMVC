<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Material Design for Bootstrap</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />

    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }} " />

    <style>
        .datatable-color-picker {
            width: 25px;
            height: 25px;
            border-radius: 2px;
            cursor: pointer;
        }

        .white {
            background-color: #fff !important;
        }

        .blue-grey {
            background-color: #eceff1 !important;
        }

        .light-blue {
            background-color: #e3f2fd !important;
        }

        .deep-purple {
            background-color: #ede7f6 !important;
        }

        .grey {
            background-color: #eeeeee !important;
        }

        .dark {
            background-color: #212121 !important;
        }

        .blue-grey-dark {
            background-color: #37474f !important;
        }

        .teal-dark {
            background-color: #004d40 !important;
        }

        .deep-purple-dark {
            background-color: #4527a0 !important;
        }

        .grey-dark {
            background-color: #424242 !important;
        }
    </style>
</head>

<body>

    <!-- Start your project here-->


    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Food Exchange</h1>
            </div>
        </div>


        <div class="table-responsive">


            <table class="table table-hover text-nowrap table-bordered text-center">
                <thead>
                    <tr>
                        <th scope="col"># ID</th>
                        <th scope="col">English Name</th>
                        <th scope="col">Arabic Name</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($foods as $food)
                        <tr>
                            <th scope="row">{{ $food->id }}</th>
                            <td>{{ $foods_translations->where('food_exchange_id', $food->id)->where('locale', 'en')->first()->title }}
                            </td>
                            <td>
                                {{ $foods_translations->where('food_exchange_id', $food->id)->where('locale', 'ar')->first()->title }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>



    <script type="text/javascript" src="{{ asset('mdb/js/mdb.min.js') }}"></script>
</body>

</html>
