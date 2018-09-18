<!DOCTYPE html>
<html>
<head>
    <title>Excel Reader</title>

    <style type="text/css">

        body{
            background-color: #1340E4;
        }

        h2{
            color: #FB09EB;
            text-align: center;
        }

    </style>


</head>
<body>

<h2>Multiple SMS Send Form</h2>

    <?php
    session_start();
        include 'excel_reader.php';
        include_once 'DBconnection.php';    
        $excel = new PhpExcelReader;
        
        if(isset($_FILES['file']))
        {
            $name_file = $_FILES['file']['name'];
            $tmp_name = $_FILES['file']['tmp_name'];
            $local_file = "uploaded/";
            $upload = move_uploaded_file ($_FILES['file'] ['tmp_name'], "uploaded/{$_FILES['file'] ['name']}");        

            // $test=mysqli_query($connection,"INSERT INTO `compaign`(`cmpinID`, `dates`, `userID`, `name`, `numbers`, `successful`, `fail`, `txt`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])");

            $sql=mysqli_query($connection,"INSERT INTO compaign(cmpinID, dates, userID, name,numbers, successful, fail, txt) VALUES ('','','".$_SESSION['usr_id']."','" . $name_file . "','01929326055','yes','no','nothing')");
        }

        $excel->read("uploaded\\" . $name_file);

        $nr_sheets = count($excel->sheets);       // gets the number of sheet_tabs

        $sheet_data = '';         // to store html tables with excel data, added in page


        // for selecting mobile number column

        for($sheet=0;$sheet<$nr_sheets;$sheet++) 
        {

            $combo_output[$sheet] = 'Select a column as mobile number : <select name="combo'.$sheet.'" onchange="function2(this)" id="mobile" >';

            for($col=1;$col<=$excel->sheets[$sheet]['numCols'];$col++) 
            {
                $combo_output[$sheet] .= '<option value= "'. $excel->sheets[$sheet]['cells'][1][$col] .'"> '. $excel->sheets[$sheet]['cells'][1][$col].'('.$sheet.'){'.$col.'}' .'</option>';
            }

            $combo_output[$sheet].= '</select>';
        }

        // for preview option

        $preview_data = array();
        
        for($sheet=0;$sheet<$nr_sheets;$sheet++) 
        {
        	$preview_data[$sheet] = array();
            
			for($row=1;$row<=$excel->sheets[$sheet]['numRows'];$row++) 
			{
				$preview_data[$sheet][$row] = array();

            	for($col=1;$col<=$excel->sheets[$sheet]['numCols'];$col++) 
            	{
            		$preview_data[$sheet][$row][$col] = $excel->sheets[$sheet]['cells'][$row][$col];
            	}
			}
        }



        // for message

        for($sheet=0;$sheet<$nr_sheets;$sheet++) 
        {
            $combo_output[$sheet] = $combo_output[$sheet].'</br>Select a column : </br><select name="sel'.$sheet.'" onchange="function1(this)" size="5" id="Colm">';

            for($col=1;$col<=$excel->sheets[$sheet]['numCols'];$col++) 
            {
                $combo_output[$sheet] .= '<option value= "'. $excel->sheets[$sheet]['cells'][1][$col] .'"> '. $excel->sheets[$sheet]['cells'][1][$col].'('.$sheet.'){'.$col.'}' .'</option>';
            }
            
            $combo_output[$sheet].= '</select>';
  
        }

        for($sheet=0;$sheet<$nr_sheets;$sheet++) 
        {
            $sheet_data .= '<div class="hide_div" id="sheet_div_'. $sheet .'">'. $combo_output[$sheet] ."</div>\n";
        }

        // Tabs witth WorkSheets Name

        $sheet_tabs = '<select class="table_body" name="tab_table" onchange="changeCombo(this)";>';
        $sheet_tabs.= '<option>Choose Your Desired Sheet</option>';

        for($sheet=0;$sheet<$nr_sheets;$sheet++) 
        {
             $sheet_tabs .= '<option class="tab_base" id="sheet_tab_'. $sheet. '">'. $excel->boundsheets[$sheet]['name'] .'</option>';
        }

        $sheet_tabs .= '</select>';

        // adds tabs and Divs with tables with worksheets data

        echo $sheet_tabs;
        echo $sheet_data;
        //echo '<script> var xx = '.json_encode($preview_data).'; </script>';  
    ?>



    <script>
        // For creating clickable sheet combobox

        
        var preview_data = <?php echo json_encode($preview_data); ?>;
        

        var find = [];
        var findIndex = 0;
        var shitnum = [];
        var colNum = [];
        var mobileNum = "";

        function changeCombo(selectObj) {
            var sheet=selectObj.selectedIndex-1;
            document.getElementById("selectSheet").value = sheet;

            for(i=0; i< <?php echo $nr_sheets; ?>; i++) 
            {
                document.getElementById('sheet_tab_' + i).className = 'tab_base';
                document.getElementById('sheet_div_' + i).className = 'hide_div';
            }

            document.getElementById('sheet_tab_' + sheet).className = 'tab_loaded';
            document.getElementById('sheet_div_' + sheet).className = 'show_div';
        }


        // for concatenate message

        function function1(selectObj) 
        {
            var area = document.getElementById("message");
            area.value += '[['+selectObj.options[selectObj.selectedIndex].text+']]';

            find[findIndex] = '[['+selectObj.options[selectObj.selectedIndex].text+']]';

            // for sheet no.

            var first = find[findIndex].indexOf("(");
            var last = find[findIndex].indexOf(")");
            last = last - first;
            shitnum[findIndex] = find[findIndex].substr(first+1, last-1);

            // for column no.
            
            first = find[findIndex].indexOf("{");
            last = find[findIndex].indexOf("}");
            last = last - first;
            colNum[findIndex] = find[findIndex].substr(first+1, last-1);
            
            findIndex++;
        } 

        // for mobile column

        function function2(selectObj) 
        {
            mobileNum = selectObj.options[selectObj.selectedIndex].text;
            document.getElementById("mobileArea").value = mobileNum;

            // for sheet no.

            var first = mobileNum.indexOf("(");
            var last = mobileNum.indexOf(")");
            last = last - first;
            shitnum[findIndex] = mobileNum.substr(first+1, last-1);

            // for column no.
            
            first = mobileNum.indexOf("{");
            last = mobileNum.indexOf("}");
            last = last - first;
            colNum[findIndex] = mobileNum.substr(first+1, last-1);
        } 

        // for show message

        function myFunction() 
        {
            var messageshow = document.getElementById("message").value;
            var messageshow1 = "";
            var preview_show = "";

            for (var i = 2; i <= <?php echo $excel->sheets[0]['numRows'] ; ?> ; i++)
            {
                messageshow1 = preview_data[shitnum[findIndex]][i][colNum[findIndex]] + "    "+ messageshow;
                for (var j = 0; j < findIndex ; j++) 
                {
                    messageshow1 = messageshow1.replace(find[j], " "+preview_data[shitnum[j]][i][colNum[j]]);
                }
                preview_show = preview_show + messageshow1 + "\n";
            }

            alert(preview_show);
        }	

    </script>

    

    
    <form method="post" action="pretest2.php"> 
   
       Enter your writing text :<br> <textarea id = "message" name="message" rows="5" cols="40" placeholder="Type your message ..." ></textarea>
       <br><br>
       <!--compaign name: -->
       Enter a compaign name:<br><textarea name="cmpinName" id="cmpinName" rows="1" cols="20" ></textarea><br>

       <button type="button" onclick="myFunction()">Preview</button>
       <!--File Name: -->
       <textarea name="fileName" rows="5" cols="20" style="display:none;"><?php echo $name_file;?></textarea>
       <!--Sheet: -->
       <textarea id="selectSheet" name="selectSheet" rows="5" cols="40" style="display:none;"></textarea>
       <!--Mobile: -->
       <textarea id="mobileArea" name="mobil" rows="5" cols="40" style="display:none;"></textarea>
       
       <input type="submit" name="submit" value="Submit"> 
    </form>

    <!doctype html>
    <html lang="en">
    <head>
    <meta charset="utf-8" />
    <title>Example PHP Excel Reader</title>

    <style>

        .table_data 
        {
            border:2px ridge #000;
            padding:1px 3px;
        }
        
        .tab_base  
        {
            background:#C8DaDD;
            font-weight:bold;
            border:2px ridge #000;
            cursor:pointer;
            padding: 2px 4px;
        }

        .table_sub_heading 
        {
            background:#CCCCCC;
            font-weight:bold;
            border:2px ridge #000;
            text-align:center;
        }
        
        .table_body 
        {
            background:#F0F0F0;
            font-wieght:normal;
            font-family:Calibri, sans-serif;
            font-size:16px;
            border:2px ridge #000;
            border-spacing: 0px;
            border-collapse: collapse;
        }

        .tab_loaded 
        {
            background:#222222;
            color:white;
            font-weight:bold;
            border:2px groove #000;
            cursor:pointer;
        }
        .hide_div 
        { 
            display:none;
        }

    </style>

    </head><body>

</body>
</html>