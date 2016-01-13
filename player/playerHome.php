<!DOCTYPE html>
<html>
	<head>
		<title>
			player | home
		</title>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 	 	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  		<style>
  			ul { list-style-type:none;margin:0;padding: 0;}
  			li { margin:4px;padding:0;height:300px;background-color:#eee; }
  			#c2list li { margin:4px;padding:0;height:300px;background-color:#999;}
  		</style>
	</head>
	<body style="text-align:center;">
		<div>arrange the elements of col2 by drag and drop vertically to match the elements in col1</div>
		<br>
		<br>
		<div style="float:left;width:50%">
			column1
			<br>
			<ul id="c1list">
			</ul>
		</div>
		<div style="float:left;width:50%;">
			column2
			<br>
				<ul id="c2list">
				</ul>
		</div>
		<br>
		<br>
		<br>
		<input type="button" id="submitbtn" value="submit" onclick="submitbtnclicked()"/>
		<br>
		<br>
		<div id="score">
		</div>
		<script>
			var col1=[];
			var col2=[];
			var printed=[];
			var c1=document.getElementById('c1list');
			var c2=document.getElementById('c2list');
			var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
	            if(xhttp.readyState == 4 && xhttp.status == 200) {
	                var response = xhttp.responseText;
	                parseAndPrint(response);
	            }
            }       
        	xhttp.open("GET", "getPairs.php", true);
        	xhttp.send();
			
        	function printhtml(name,type,htmlelement,ID){
        		
        		if(type=="audio"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" style=\"height:300px;display:flex;align-items:center;\"><"+type+" controls><source src=\"/Matching-Game/assets/"+type+"/"+name+"\" type=\""+type+"/ogg\"/></"+type+"><br></div></li>";
        		}
        		if(type=="video"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" style=\"height:300px;display:flex;align-items:center;\"><"+type+" width=\"320\" height=\"240\" controls><source src=\"/Matching-Game/assets/"+type+"/"+name+"\" type=\""+type+"/mp4\"/></"+type+"><br></div></li>";
        		}
        		if(type=="image"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" style=\"height:300px;display:flex;align-items:center;\"><img width=\"320\" height=\"240\" src=\"/Matching-Game/assets/"+type+"/"+name+"\"/><br></div></li>";
        		}
        		if(type=="text"){
        			htmlelement.innerHTML+="<li><div data-src=\""+name+"\" style=\"height:300px;display:flex;align-items:center;\"><div width=\"320\" height=\"300\">"+name+"</div></div></li>";
        		}
        	}

			function parseAndPrint(response){
				var pieces1 = response.split(";;;");
				var index=0;

				//parsing and making the arrays of col1 and col2 data
				c1.innerHTML+="<ul>";
				while(index<(pieces1.length-1)){
					var pieces2=pieces1[index].split("::");
					col1.push(pieces2[0]);
					var pieces3=col1[index].split(";;");
					//c1.innerHTML+=pieces3[0]+pieces3[1]+"<br>";
					//c1.innerHTML+="<"+pieces3[1]+" controls><source src=\"/Matching-Game/assets/"+pieces3[1]+"/"+pieces3[0]+"\" type=\""+pieces3[1]+"/ogg\"/></"+pieces3[1]+"><br>";					
					printhtml(pieces3[0],pieces3[1],c1,"c1"+index);
					col2.push(pieces2[1]);
					index++;
				}
				c1.innerHTML+="</ul>";
				//printing
				index=0;
				var count=-1;
				
				while(printed.length!=5){
					var index2=Math.floor((Math.random() * col2.length) + 1)-1;
					if(!exists(index2,printed)){
						var pieces3=col2[index2].split(";;");
						//c2.innerHTML+=pieces3[0]+pieces3[1]+"<br>";
						//c2.innerHTML+="<"+pieces3[1]+" width=\"320\" height=\"240\" controls><source src=\"/Matching-Game/assets/"+pieces3[1]+"/"+pieces3[0]+"\" type=\""+pieces3[1]+"/mp4\"/></"+pieces3[1]+"><br>";
						printhtml(pieces3[0],pieces3[1],c2,"c2"+(count+1));
						count++;
						//c2.innerHTML+="<br>"+"<input type=\"text\" id=\""+count+"\"/>"+"<br>";
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
					var onpage = $("#c2list li:nth-child("+(index+1)+") div").data("src");
					
					var actual=col2[index].split(";;");
					var actual=actual[0];
					//document.getElementById('score').innerHTML+=" :: "+actual+" :: ";
					if(actual==onpage)
						score++;
					index++;
				}
				document.getElementById('score').innerHTML=score;
			}
		</script>
		<script>
			$("document").ready(function(){
				$("#c2list").sortable();
    			$("#c2list").disableSelection();
			});
		</script>
	</body>
</html>