@extends('layouts.dashboard')
@section('inside-content')
    <div class="card-wrapper container-fluid">

        <div class="row g-3">

            <!-- participant count -->
            <div class="col-xl-3 col-md-6 text-danger">
                <div class="card border border-5  border-top-0 border-bottom-0 shadow p-3 pb-0">
                    <div class="row align-items-center h6">
                        <div class="col-9 text-uppercase">
                            <div class="text-secondary"> participant <br> count</div>
                            <div class="my-2"> ALL</div>
                            <div class="h3">{{ $participantCount }}</div>
                        </div>
                        <div class="col-3">
                            <i class="fas fa-users-viewfinder fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>


            <!--  particpant count - current- year -->
            <div class="col-xl-3 col-md-6 text-warning  ">
                <div class="card border border-5 border-top-0 border-bottom-0 shadow p-3 pb-0">
                    <div class="row align-items-center h6">
                        <div class="col-9 text-uppercase">
                            <div class="text-secondary"> participant <br> count</div>
                            <div class="my-2"> current year</div>
                            <div class="h3">{{ $participantCount }}</div>
                        </div>
                        <div class="col-3">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- participant-count current month -->
            <div class="col-xl-3 col-md-6 text-success">
                <div class="card border border-5 border-top-0 border-bottom-0 shadow p-3  pb-0">
                    <div class="row align-items-center h6">
                        <div class="col-9 text-uppercase">
                            <div class="text-secondary"> participant <br> count</div>
                            <div class="my-2">current month</div>
                            <div class="h3">{{ $participantCount }}</div>
                        </div>
                        <div class="col-3">
                            <i class="fas fa-calendar-days fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- participant-count current day -->
            <div class="col-xl-3 col-md-6 text-primary">
                <div class="card border border-5 border-top-0 border-bottom-0 shadow p-3 pb-0">
                    <div class="row align-items-center h6">
                        <div class="col-9 text-uppercase">
                            <div class="text-secondary"> participant <br> count</div>
                            <div class="my-2"> today </div>
                            <div class="h3">{{ $participantCount }}</div>
                        </div>
                        <div class="col-3">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of cards -->
        </div>
        <br>
        <br>
        <br>
        <!-- <div class="row" -->
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Row 1 Data 1</td>
                    <td>Row 1 Data 2</td>
                </tr>
                <tr>
                    <td>Row 2 Data 1</td>
                    <td>Row 2 Data 2</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
