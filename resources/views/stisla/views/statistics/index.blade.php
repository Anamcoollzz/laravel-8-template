@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Statistik' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item">{{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-certificate"></i> Dalam Sebulan 1-15</h4>
            <div class="card-header-action">

            </div>
          </div>
          <div class="card-body">
            <canvas id="myChart3"></canvas>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-certificate"></i> Dalam Sebulan 16-akhir bulan</h4>
            <div class="card-header-action">

            </div>
          </div>
          <div class="card-body">
            <canvas id="myChart4"></canvas>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-certificate"></i>Dalam Setahun</h4>

          </div>
          <div class="card-body">

            <canvas id="myChart2"></canvas>
          </div>
        </div>



      </div>

    </div>
  </div>
@endsection

@push('css')
@endpush

@push('js')
  <script src="{{ asset('stisla/node_modules/chart.js/dist/Chart.min.js') }}"></script>
@endpush

@push('scripts')
  <script>
    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
          label: 'Laki-laki',
          data: [260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000],
          borderWidth: 2,
          backgroundColor: '#6777ef',
          borderColor: '#6777ef',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }, {
          label: 'Perempuan',
          data: [460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000],
          borderWidth: 2,
          backgroundColor: 'rgba(58,216,99,1)',
          borderColor: 'rgba(58,216,99,1)',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: true
        },
        scales: {
          yAxes: [{
            gridLines: {
              drawBorder: false,
              color: '#f2f2f2',
            },
            // ticks: {
            //   beginAtZero: true,
            //   stepSize: 150
            // }
          }],
          xAxes: [{
            ticks: {
              display: true
            },
            gridLines: {
              display: true
            }
          }]
        },
      }
    });

    var ctx2 = document.getElementById("myChart3").getContext('2d');
    var myChart2 = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: Array.from({
          length: 15
        }, (_, i) => i + 1),
        datasets: [{
          label: 'Laki-laki',
          data: [260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000,
            358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000
          ],
          borderWidth: 2,
          backgroundColor: '#6777ef',
          borderColor: '#6777ef',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }, {
          label: 'Perempuan',
          data: [460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000,
            458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000
          ],
          borderWidth: 2,
          backgroundColor: 'rgba(58,216,99,1)',
          borderColor: 'rgba(58,216,99,1)',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: true
        },
        scales: {
          yAxes: [{
            gridLines: {
              drawBorder: false,
              color: '#f2f2f2',
            },
            // ticks: {
            //   beginAtZero: true,
            //   stepSize: 150
            // }
          }],
          xAxes: [{
            ticks: {
              display: true
            },
            gridLines: {
              display: true
            }
          }]
        },
      }
    });

    var ctx3 = document.getElementById("myChart4").getContext('2d');
    var myChart3 = new Chart(ctx3, {
      type: 'bar',
      data: {
        labels: Array.from({
          length: 30
        }, (_, i) => i + 1).splice(15),
        datasets: [{
          label: 'Laki-laki',
          data: [260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000,
            358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000, 260000, 358000, 530000, 902000, 130000, 910000, 188000
          ],
          borderWidth: 2,
          backgroundColor: '#6777ef',
          borderColor: '#6777ef',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }, {
          label: 'Perempuan',
          data: [460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000,
            458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000, 460000, 458000, 330000, 502000, 430000, 610000, 488000
          ],
          borderWidth: 2,
          backgroundColor: 'rgba(58,216,99,1)',
          borderColor: 'rgba(58,216,99,1)',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: true
        },
        scales: {
          yAxes: [{
            gridLines: {
              drawBorder: false,
              color: '#f2f2f2',
            },
            // ticks: {
            //   beginAtZero: true,
            //   stepSize: 150
            // }
          }],
          xAxes: [{
            ticks: {
              display: true
            },
            gridLines: {
              display: true
            }
          }]
        },
      }
    });
  </script>
@endpush

@push('modals')
  @include('stisla.includes.modals.modal-import-excel', ['formAction'=>route('payment-types.import-excel'),
  'downloadLink'=>route('payment-types.import-excel-example')])
@endpush
