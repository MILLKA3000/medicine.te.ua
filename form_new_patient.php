
<style type="text/css">
       input[type=submit][value='����������'] { font-weight:bold; color:red; font-size: 16pt; }
       input[type=submit][value='³����'] { font-weight:bold;  font-size: 14pt; } 
       input[type=text]{font-weight:bold;  font-size: 14pt;}
       select{font-weight:bold; height:30px; font-size: 20pt;}
       option{font-size: 16pt;}
</style>

<?php
function form_er()
{
echo "<FONT color=red size=4 style='border: 1px solid #666;padding: 5px' >������� ������� ���������� ����� � ���� </FONT><br><br>";	
}
function form_er2()
{
echo "<FONT color=red size=4 style='border: 1px solid #666;padding: 5px'>���� ������� ������ ���� ������ ������ ���� � ���� </FONT><br><br>";	
}
function form_old()
{
echo "<FONT color=red size=4 style='border: 1px solid #666;padding: 5px'>�������� ��������� ���� (*) </FONT><br><br>";
}
function form()
{
echo "
		<div class='auth-form'>
		<b><FONT size=5 color=green> <DIV style='display: block; border: 1px solid #B2BCD9; margin: 5px; padding: 15px'>������ ��� ���. ϳ��� ���� �������� ������ '����������' � ����� �������� ��� </div></FONT></b>
		<table>
		<form action='new_patient.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."' method='post'>
			 <b>
			<tr><td>
            <table><tr>
			<td><b>�������</td><td><input onClick='scrollBy(0,400); return false;' name='family' maxlength='50' size='41' class='input-text' type='text' value='".$_POST['family']."'><FONT color=red> *</FONT></td></tr>
			<td><b>��'�</td><td><input onClick='scrollBy(0,400); return false;' name='name' maxlength='50' size='41' class='input-text' type='text' value='".$_POST['name']."'><FONT color=red> *</FONT></td></tr>
			<td><b>��-�������</td><td><input onClick='scrollBy(0,400); return false;' name='first_name' maxlength='50' size='41' class='input-text' type='text' value='".$_POST['first_name']."'><FONT color=red> *</FONT></td></tr>
			<td><b>���� ����������</td><td><b>
			";			
$ind=1;
echo " ���� <select  class='text' name='date'> ";
while($ind<32)
{	   
if($ind==$_POST['date']) {
 echo "<option selected value='".$ind."'>".$ind."</option>";
}
else
echo "<option value='".$ind."'>".$ind."</option>";
    $ind++;
}

$ind=1;
echo "</select> ̳���� <select class='text' name='mis'> ";
while($ind<13)
{	
if($ind==$_POST['mis']) {
 echo "<option selected value='".$ind."'>".$ind."</option>";
}
else
   echo "<option value='".$ind."'>".$ind."</option>";
    $ind++;
}

$ind=date('Y');
echo "</select> г� <select class='text' name='year'>";
while($ind>1900)
{	 
if($ind==$_POST['year']) {
 echo "<option selected value='".$ind."'>".$ind."</option>";
}
else
  echo "<option value='".$ind."'>".$ind."</option>";
    $ind--;
}

echo "		</select><FONT color=red> *</FONT></td></tr>	
			<tr><td><b>������ </td><td><input onClick='scrollBy(0,400); return false;' name='adress' maxlength='50' size='41' class='input-text' type='text' value='".$_POST['adress']."'><FONT color=red> *</FONT></td></tr>
			<tr><td><b>e-mail (��� ��������) </td><td><input onClick='scrollBy(0,400); return false;' name='email' maxlength='50' size='41' class='input-text' type='text' value='".$_POST['email']."'></td></tr>
            </table></td><td valign='top'><table><tr><td>
			<tr><td COLSPAN=2 style='border-bottom: 1px solid #666'><br><FONT color=red><b>����'������ ������� ���� ���������� ���� � ���� ����� ��������</FONT></td></tr>
			<tr><td></td><td><b>��� ���� �� ����� 0x��������</td></tr>";
			if ($_GET['id_hosp']==3){

			echo"<tr><td><b>������� </td><td><b>0352<input onClick='scrollBy(0,400); return false;' name='tel1' maxlength='11' size='40' class='input-text' type='text' value='".$_POST['tel1']."'><FONT color=red><span class='jQtooltip mini' title='������ ��������� ������� �� ����� �� ����� ������ ������� � �������'>!</span></FONT></td></tr>";
			}else{
			echo"<tr><td><b>������� </td><td><input onClick='scrollBy(0,400); return false;' name='tel1' maxlength='11' size='40' class='input-text' type='text' value='".$_POST['tel1']."'><FONT color=red><span class='jQtooltip mini' title='������ ��������� ������� �� ����� �� ����� ������ ������� � �������'>!</span></FONT></td></tr>";}

			echo"<tr><td></td><td><b>��� ��������� �� ����� (0��) (�������)</td></tr>
			<tr><td><b>������� (���) </td><td><input onClick='scrollBy(0,400); return false;' name='tel_cut2' maxlength='3' size='3' class='input-text' type='text' value='".$_POST['tel_cut2']."'> <input onClick='scrollBy(0,400); return false;' name='tel2' maxlength='7' size='33' class='input-text' type='text' value='".$_POST['tel2']."'></b><FONT color=red><span class='jQtooltip mini' title='������ ��������� ������� �� ����� �� ����� ������ ������� � �������'>!</span></FONT></td></tr>
            </table><tr>
			<td><b><input type='submit' value='����������'></b></td><td>
			
			<input type='submit'  name='back' value='³����' style='float:right;'></td></tr>
			</a>
		</form>
		</table>
		</div>
		
		";
}

function form_end()
{
echo "
		<br><br><br><FONT color=red size=4 style='float:left;'>* </FONT><FONT color=black style='float:left;'> - ��������� ���� ��� ���������� </FONT>
		";
        for ($i=0;$i<10;$i++){echo "<br>";}
}
?>