README.md
=========

How to get a program (pdf + metadata) from the larm API
--------------------------------------------------------

* Init session:

 	http://api.larm.fm/v6/Session/Create?format=json

* Range query (from 05051977 to 05051977)
	
	http://api.larm.fm/v6/View/Get?view=Search&sort=PubStartDate%2Bdesc&filter=%28PubStartDate:[1977-05-05T00:00:00Z%20TO%201977-05-05T00:00:00Z]%20AND%20%28Type%3ASchedule%20OR%20Type%3AScheduleNote%29%29&pageIndex=0&pageSize=20&sessionGUID=049da351-b81f-424e-82c4-1162926d3688&format=xml2&userHTTPStatusCodes=False


* Get the metedata 
	
	http://api.larm.fm/v6/View/Get?view=Object&query=0253e715-076f-0949-a7da-174eafa59c5a&pageIndex=0&pageSize=20&sessionGUID=049da351-b81f-424e-82c4-1162926d3688&format=xml2&userHTTPStatusCodes=False

