from urllib import URLopener
from bs4 import BeautifulSoup
from datetime import datetime
import urllib, urllib2, cookielib
import time

URL = "http://192.168.1.13/FwTo"
username = "11111"
password ="1"
cj = cookielib.CookieJar()
opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
login_data = urllib.urlencode({'username' : username, 'j_password' : password})
# needs better checking here
ts = time.time()
st = datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/net_logger.log',"a") as f:
		msg = st+' sysNEtMaintainer. INFO: Net_sys bot maintainer trying to reache the server...\n'
		f.write(msg)
try:
	
	resp = opener.open(URL)

except HTTPError as e:
	ts = time.time()
	st = datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	
	with open('/opt/lampp/htdocs/FwTo/python/net_logger.log',"a") as f:
		msg = st+' sysNEtMaintainer. ERROR: Server couldn\'t fulfill the request. ' + 'Error code: '+ str(e.code) +"\n"
		f.write(msg)

except URLError as e:
	ts = time.time()
	st = datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		
	with open('/opt/lampp/htdocs/FwTo/python/net_logger.log',"a") as f:
		msg = st+' sysNEtMaintainer.  ERROR:  We failed to reach the server. '+ str(e.reason)+"\n"
		f.write(msg)

ts = time.time()
st = datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/net_logger.log',"a") as f:
		msg = st+' sysNEtMaintainer. INFO: Net_sys bot maintainer succeed\n'
		f.write(msg)

