<!DOCTYPE html>
<html>
	<head>
		<title>
			player | home
		</title>
	</head>
	<body style="text-align:center;">
		<div style="float:left;width:50%">
			column1
			<br>
			<div id="c1e"></div>
		</div>
		<div style="float:left;width:50%;">
			column2
			<br>
			<div id="c2e"></div>
		</div>
		<br>
		<br>
		<br>
		<input type="button" id="submitbtn" value="submit" onclick="submitbtnclicked()"/>
		<br>
		<br>
		<div id="score"></div>
		<script>
			var col1=[];
			var col2=[];
			var c1=document.getElementById('c1e');
			var c2=document.getElementById('c2e');
			var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
	            if(xhttp.readyState == 4 && xhttp.status == 200) {
	                var response = xhttp.responseText;
	                parseAndPrint(response);
	            }
            }       
        	xhttp.open("GET", "getPairs.php", true);
        	xhttp.send();
			
			function parseAndPrint(response){
				var pieces1 = response.split(";;;");
				var index=0;

				//parsing and making the arrays of col1 and col2 data
				while(index<(pieces1.length-1)){
					var pieces2=pieces1[index].split("::");
					c1.innerHTML+=pieces2[0]+"<br>";
					col1.push(pieces2[0]);
					col2.push(pieces2[1]);
					index++;
				}

				var printed=[];
				//printing
				index=0;
				while(printed.length!=5){
					var index2=Math.floor((Math.random() * col2.length) + 1)-1;
					if(!exists(index2,printed)){
						c2.innerHTML+=col2[index2]+"<input type=\"text\" id=\""+(index2)+"\"/><br>";
						printed.push(index2);
					}
					index++;
					if(index==col2.length)
						index=0;
				}
			}

			function exists(value,array){
				var index=0;
				var len=array.length;
				while(index<len){
					if(array[index]==value){
						//echo "found";
						return true;
					}
					//echo "searching";
					index++;
				}
				return false;
			}

			function submitbtnclicked(){
				var score=0;
				var index=0;
				while(index<5){
					var value=document.getElementById(index).value;
					document.getElementById('score').innerHTML+=col1[value-1]+":::"+col2[index];
					var p1=col1[value-1].split("a");
					var p2=col2[index].split("b");
					if(p1[1].localeCompare(p2[1])==0)
						score++;
					index++;
				}
				document.getElementById('score').innerHTML=score;
			}
		</script>
	</body>
</html>