<!DOCTYPE html>
<html>
	<head>
		<title>
			player | home
		</title>
	</head>
	<body style="text-align:center;">
		<font> in column 2 , there is a text box given , every text box belongs to element above it , write the number of element 1-5 in column1 to match and press submit</font>
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
			var printed=[];
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
			
        	function printhtml(name,type,htmlelement){
        		if(type=="audio"){
        			htmlelement.innerHTML+="<"+type+" controls><source src=\"/Matching-Game/assets/"+type+"/"+name+"\" type=\""+type+"/ogg\"/></"+type+"><br><hr>";
        		}
        		if(type=="video"){
        			htmlelement.innerHTML+="<"+type+" width=\"320\" height=\"240\" controls><source src=\"/Matching-Game/assets/"+type+"/"+name+"\" type=\""+type+"/mp4\"/></"+type+"><br><hr>";
        		}
        		if(type=="image"){
        			htmlelement.innerHTML+="<img width=\"320\" height=\"240\" src=\"/Matching-Game/assets/"+type+"/"+name+"\"/><br><hr>";
        		}
        		if(type=="text"){
        			htmlelement.innerHTML+="<div width=\"320\" height=\"240\">"+name+"</div><hr>";
        		}
        	}

			function parseAndPrint(response){
				var pieces1 = response.split(";;;");
				var index=0;

				//parsing and making the arrays of col1 and col2 data
				while(index<(pieces1.length-1)){
					var pieces2=pieces1[index].split("::");
					col1.push(pieces2[0]);
					var pieces3=col1[index].split(";;");
					//c1.innerHTML+=pieces3[0]+pieces3[1]+"<br>";
					//c1.innerHTML+="<"+pieces3[1]+" controls><source src=\"/Matching-Game/assets/"+pieces3[1]+"/"+pieces3[0]+"\" type=\""+pieces3[1]+"/ogg\"/></"+pieces3[1]+"><br>";					
					printhtml(pieces3[0],pieces3[1],c1);
					col2.push(pieces2[1]);
					index++;
				}

				//printing
				index=0;
				var count=-1;
				while(printed.length!=5){
					var index2=Math.floor((Math.random() * col2.length) + 1)-1;
					if(!exists(index2,printed)){
						var pieces3=col2[index2].split(";;");
						//c2.innerHTML+=pieces3[0]+pieces3[1]+"<br>";
						//c2.innerHTML+="<"+pieces3[1]+" width=\"320\" height=\"240\" controls><source src=\"/Matching-Game/assets/"+pieces3[1]+"/"+pieces3[0]+"\" type=\""+pieces3[1]+"/mp4\"/></"+pieces3[1]+"><br>";
						printhtml(pieces3[0],pieces3[1],c2);
						count++;
						c2.innerHTML+="<br>"+"<input type=\"text\" id=\""+count+"\"/>"+"<br>";
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
					var assigned=printed[index];
					if(value==(assigned+1))
						score++;
					index++;
				}
				document.getElementById('score').innerHTML=score;
			}
		</script>
	</body>
</html>