google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Вид оцінок');
        data.addColumn('number', 'Загальна');
        data.addRows([
          ['2', zag_2],
          ['3', zag_3],
          ['4', zag_4],
          ['5', zag_5]
        ]);
        var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'Вид оцінок');
            data2.addColumn('number', 'Бюджет');
            data2.addColumn('number', 'Контракт');
            data2.addRows([
           ['2', zag_2_b,zag_2_k],
           ['3', zag_3_b,zag_3_k],
           ['4', zag_4_b,zag_4_k],
           ['5', zag_5_b,zag_5_k]
        ]);
            
        
        var options = {
          title: 'Загальний графік успішності',
          hAxis: {title: 'Вид оцінок', titleTextStyle: {color: 'green'}}
        };
        var options2 = {
          title: 'Графік успішності по типу навчання',
          hAxis: {title: 'Вид оцінок', titleTextStyle: {color: 'green'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart2.draw(data2, options2);
      }
 