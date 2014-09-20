README.md
=========

How to get a program (pdf + metadata) from the larm API
--------------------------------------------------------

* Init session:
	
	http://api.larm.fm/v6/Session/Create?format=json

* Range query (from 05051977 to 05051977)
	
	http://api.larm.fm/v6/View/Get?view=Search&sort=PubStartDate%2Bdesc&filter=%28PubStartDate:[1977-05-05T00:00:00Z%20TO%201977-05-05T00:00:00Z]%20AND%20%28Type%3ASchedule%20OR%20Type%3AScheduleNote%29%29&pageIndex=0&pageSize=20&sessionGUID=049da351-b81f-424e-82c4-1162926d3688&format=xml2&userHTTPStatusCodes=False


* Get the metedata 
	
	http://api.larm.fm/v6/View/Get?view=Search&sort=PubStartDate%2Bdesc&filter=%28Type%3ASchedule%20OR%20Type%3AScheduleNote%29&pageIndex=0&pageSize=20&sessionGUID=c0b231e9-7d98-4f52-885e-af4837faa352&format=xml2&userHTTPStatusCodes=False

