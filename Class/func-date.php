<?
 function Parse_date($time)
 {
 if ($time[2]=="."){
  $end_time=$time[6].$time[7].$time[8].$time[9]."-".$time[3].$time[4]."-".$time[0].$time[1];}
  else if ($time[2]=="/"){
  $end_time=$time[6].$time[7].$time[8].$time[9]."-".$time[3].$time[4]."-".$time[0].$time[1];
  }else{
  $end_time=$time[5].$time[6].$time[7].$time[8]."-".$time[2].$time[3]."-0".$time[0];}
  return $end_time;
  //return $time;
 }
 
 function date_parse_vupuska($time)
 {
  $end_time=$time[8].$time[9]."-".$time[5].$time[6]."-".$time[0].$time[1].$time[2].$time[3];
  return $end_time;
 }
function Parse_time($d_start,$d_end)
	{
			$d_start = new DateTime($d_start);
			$d_end = new DateTime($d_end);
			$hour_s = $d_start->format('G');
			$min_s = $d_start->format('i');
			$sec_s = $d_start->format('s');
			
			$hour_e = $d_end->format('G');
			$min_e = $d_end->format('i');
			$sec_e = $d_end->format('s');
			$rizn_hour=($hour_e-$hour_s)*60-$min_s+$min_e;
			return $rizn_hour;
	}
?>