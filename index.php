<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		<title>JAC4DK</title>
	</head>
	<body>
		<h1>JAC4DK</h1>
			<ul>
				<li><a href="http://www.danskkulturarv.dk/programoversigter/">Dokumetation</a></li>
				<li><a href="search.php?from=1977-05-06&to=1977-05-06&format=json" target="_blank">Søg Json</a></li>
				<li><a href="object.php?guid=80f4e0a2-1dfb-af48-b12f-629c23eb99fc&format=xml" target="_blank">Hent XML (fuldtekst ikke tilgængelig via json)</a></li>
			</ul>
			<hr />
				<p>Fødselsdato: <div type="text" id="datepicker"></div>
				<button id="getit">hent data</button>
			</p>

			<p>
				<div id="pdfplaceholder" ></div>
			</p>	
			<!-- p>
				<iframe src="" width="600" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" id="pdfembed" ></iframe>
			</p -->
			<p>
			
				<div id="textplaceholder" ></div>
			</p>

			



  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>	
  		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  		<script>
  			$(function() {
    			
    			// Add a datepicker
    			$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd", 
    											defaultDate: "1977-05-05", 
    											changeMonth: true,
      											changeYear: true,
      											minDate: "1925-04-01", 
      											maxDate: "1983-12-31"
    										});

  				// Get the pdf of the day
  				$( "#getit" ).on('click', function() {
  					$( "#pdfplaceholder").html("");
  					$( "#textplaceholder").html("");

  					var date = $( "#datepicker" ).val();
  					if(date === ""){
  						alert("Du skal indtaste din fødselsdag");
  					}
  					$.ajax({
  						url: "search.php?from="+date+"&to="+date+"&format=json",
  						type: "json"
  					}).done(function(data) 
					{
						// Flag that we have no 'Schedule' yet
						var notDoneYetFlag = true;
  						$.each(data.ModuleResults[0].Results, function(item,val){
  							var type = val.Type;
  							var url = val.Url;
  							var guid = val.Id;
  							// If there are multiple pdf's. Link to them all
  							$( "#pdfplaceholder").append("<a href='" + url+"' target='_blank'>"+type+"</a><br/>");
	  						// IFrame the first pdf
	  						// Only 'Schedule' since 'ScheduleNotes are borring'
	  						if (type === 'Schedule' && notDoneYetFlag){
	  							//$("#pdfembed").attr("src",url);
	  							//notDoneYetFlag = false;
	  							$.ajax({
  									url: "object.php?guid="+guid+"&format=xml",
  									type: "xml"
  								}).done(function(xml) 
								{
									var text = $(xml).find("MetadataXml").text()
										.replace(/^(.*)CDATA./g,'').replace(/.....AllText(.*)$/g,'');
									var htmlText = "<p>" + text.replace(/(?:\r\n|\r|\n)/g, '<br/>') + "</p>";
									console.log(text);
  									var show = "";
  									$(htmlText).find("br").each(function(){
  										try {
  											var line = this.previousSibling.nodeValue;
  											if(line.match(/^program/gi)){
  												$("#textplaceholder").append("<h2>" + line + "</h2>");
  											} else {

  												// Program starte eg. 13.15 or 9,30
  												var time = line.match(/^[0-9][0-9]?(,|\.)[0-9][0-9]/g);
  												if (time){
  													var normalizedTime = (time+"").replace(",",".");
  													var lineNoTime = line.replace(/^[0-9][0-9]?(,|\.)[0-9][0-9]/g,'');
  													$("#textplaceholder").append("<p>" + show + "</p>");
  													show = "<strong>" + normalizedTime + ": " + lineNoTime + "</strong><br/>";	
  												} else {
  													show += line + "<br/>";		
  												}
  											}
  										
  										} catch(err) {
  											// Last time the above selector finds <br/>
  											// there is no nextSibling.nodeValue it throws 'null'
  											// This just catches that, at do nothing

  										}
  										
  									});
  									$("#textplaceholder").append("<hr/>");
  									
				  				});
	  						}
	  					});
	  				});
  				});

  				
  			});
  		</script>
	</body>
</html>