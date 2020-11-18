@extends('layouts.app')

@section('content')
<div style="width: 100%;height: 15px;background: rgb(131,58,180);background: linear-gradient(90deg, rgba(131,58,180,0.6671043417366946) 0%, rgba(253,29,29,0.7287289915966386) 50%, rgba(252,176,69,0.6502976190476191) 100%);"></div>
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

  <div class="container">
      <div class="row justify-content-center" style="padding : 60px 0;">
            <div class="col-xs-12 col-md-6 " >
              <h1>Visualizzazioni Totali: {{$visitTOT}}</h1>
                  <h4 style="margin:20px 0;">Visualizzazioni di oggi : {{$visitTOTtoday}}</h4>


                    <div style="width: auto;">
                    <canvas id="Chartvisite" width="500" height="350"></canvas>
                    </div>

                  </div>

                  <div class="col-xs-12 col-md-6" >

                    <h1>Messaggi Totali: {{$messageTOT}}</h1>
                    <h4 style="margin:20px 0;">Messaggi di oggi : {{$massageTOTtoday}}</h4>


                    <div style="width: auto;">
                    <canvas id="Chartmessaggi" width="500" height="350"></canvas>
                    </div>
                    </div>
          </div>


      <script type="text/javascript">
          var strdata = <?php echo json_encode($datavisit); ?>;
          var data = strdata.split(' ');
          var ctx = document.getElementById('Chartvisite');
          var today = moment(new Date()).format("HH");
          var start = moment().startOf('hour');
          var last12mon1 = [];
          for (i = 0; i < 23; i++){
            var res = start.subtract(1, 'hour').format('HH');
            last12mon1.push(res);

          }
          var last12mon = last12mon1.reverse();
          last12mon1.push(today);

          var Chartvisite = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: ['00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00'],
                  datasets: [{
                      label: ' Visualizzazioni ',
                      data: data,
                      backgroundColor: ['rgba(255, 99, 132, 0.8)'],
                      borderColor: ['rgba(255, 99, 132, 1)'],
                      borderWidth: 4
                  }]
              },
              options: {
                pointBackgroundColor: ['rgba(255, 99, 132, 1)'],
                  scales: { pointLabels :{fontStyle: "bold",} , y: {beginAtZero: true} }
              }
          });

      </script>
      <script type="text/javascript">
          var strdata = <?php echo json_encode($datamessage); ?>;
          var data = strdata.split(' ');
          var ctx = document.getElementById('Chartmessaggi');
          var today = moment(new Date()).format("HH");
          var start = moment().startOf('hour');
          var last12mon1 = [];
          for (i = 0; i < 23; i++){
            var res = start.subtract(1, 'hour').format('HH');
            last12mon1.push(res);

          }
          var last12mon = last12mon1.reverse();
          last12mon1.push(today);

          var Chartmessaggi = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: ['00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00'],
                  datasets: [{
                      label: ' Messaggi ',
                      data: data,
                      backgroundColor: ['rgba(173, 120, 199,0.8)',
                      'rgba(173, 120, 199,0.8)',
                      'rgba(173, 120, 199,0.8)',
                      'rgba(173, 120, 199,0.8)',
                      'rgba(186, 115, 182,0.8)',
                      'rgba(186, 115, 182,0.8)',
                      'rgba(199, 110, 163,0.8)',
                      'rgba(199, 110, 163,0.8)',
                      'rgba(205, 107, 155,0.8)',
                      'rgba(205, 107, 155,0.8)',
                      'rgba(230, 100, 122,0.8)',
                      'rgba(230, 100, 122,0.8)',
                      'rgba(248, 91, 95,0.8)',
                      'rgba(248, 91, 95,0.8)',
                      'rgba(252, 115, 100,0.8)',
                      'rgba(252, 115, 100,0.8)',
                      'rgba(252, 134, 107,0.8)',
                      'rgba(252, 134, 107,0.8)',
                      'rgba(251, 155, 115,0.8)',
                      'rgba(251, 155, 115,0.8)',
                      'rgba(251, 184, 126,0.8)',
                      'rgba(251, 184, 126,0.8)',
                      'rgba(252, 200, 133,0.8)',
                      'rgba(252, 200, 133,0.8)'
                    ],
                      borderColor: [
                        'rgba(173, 120, 199,1)',
                        'rgba(173, 120, 199,1)',
                        'rgba(173, 120, 199,1)',
                        'rgba(173, 120, 199,1)',
                        'rgba(186, 115, 182,1)',
                        'rgba(186, 115, 182,1)',
                        'rgba(199, 110, 163,1)',
                        'rgba(199, 110, 163,1)',
                        'rgba(205, 107, 155,1)',
                        'rgba(205, 107, 155,1)',
                        'rgba(230, 100, 122,1)',
                        'rgba(230, 100, 122,1)',
                        'rgba(248, 91, 95,1)',
                        'rgba(248, 91, 95,1)',
                        'rgba(252, 115, 100,1)',
                        'rgba(252, 115, 100,1)',
                        'rgba(252, 134, 107,1)',
                        'rgba(252, 134, 107,1)',
                        'rgba(251, 155, 115,1)',
                        'rgba(251, 155, 115,1)',
                        'rgba(251, 184, 126,1)',
                        'rgba(251, 184, 126,1)',
                        'rgba(252, 200, 133,1)',
                        'rgba(252, 200, 133,1)'
                      ],
                      borderWidth: 4
                  }]
              },
              options: {
                pointBackgroundColor: ['rgba(255, 99, 132, 1)'],
                  scales: { pointLabels :{fontStyle: "bold",} , y: {beginAtZero: true} }
              }
          });

      </script>
  </div>

@endsection
