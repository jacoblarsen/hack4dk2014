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
				<li><a href="http://localhost:8888/hack4dk/search.php?from=1977-05-06&to=1977-05-06&format=json">Søg Json</a></li>
				<li><a href="http://localhost:8888/hack4dk/object.php?guid=80f4e0a2-1dfb-af48-b12f-629c23eb99fc&format=xml">Hent XML (fuldtekst ikke tilgængelig via json)</a></li>
			</ul>
			<hr />
				<p>Fødselsdato: <div type="text" id="datepicker"></div>
				<button id="getit">hent data</button>
			</p>

			<p>
				<div id="pdfplaceholder" ></div>
			</p>	
			<p>
				<iframe src="" width="600" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" id="pdfembed" ></iframe>
			</p>
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
  					var date = $( "#datepicker" ).val();
  					if(date === ""){
  						alert("Du skal indtaste din fødselsdag");
  					}
  					$.ajax({
  						url: "search.php?from="+date+"&to="+date+"&format=json",
  						type: "json"
  					}).done(function(data) 
					{
  						$.each(data.ModuleResults[0].Results, function(item,val){
  							var type = val.Type;
  							var url = val.Url;
  							var guid = val.Id;
  							// If there are multiple pdf's. Link to them all
  							$( "#pdfplaceholder").append("<a href='" + url+"' target='_blank'>"+type+"</a><br/>");
	  						// IFrame the first pdf
	  						// Only 'Schedule' since 'ScheduleNotes are borring'
	  						if (type === 'Schedule'){
	  							$("#pdfembed").attr("src",url);
	  							
	  							$.ajax({
  									url: "object.php?guid="+guid+"&format=xml",
  									type: "xml"
  								}).done(function(xml) 
								{
									var text = $(xml).find("MetadataXml").text()
										.replace(/^(.*)CDATA./g,'').replace(/.....AllText(.*)$/g,'');
  									$("#textplaceholder").html("<pre>" + text + "</pre>");
  						
				  				});
	  						}
	  					});
	  				});
  				});

  				
  			});
  		</script>
	</body>
</html>