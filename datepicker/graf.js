google.load('visualization', '1', {packages:['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
		
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'ʳ������ ��������');
        data.addColumn('number', 'ʳ������ ��������');
		for (var i=0;i<mas.length;i++){
		data.addRows([[String(i+1), parseFloat(mas[i])]]);
		}	
         var options = {legend: 'none',title: 'ʳ������ �������� ��������� �� ������', hAxis: { title: '̳����', titleTextStyle: {color: 'green'} }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }