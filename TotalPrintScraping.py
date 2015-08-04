'''
apt-get install python-bs4
'''
from urllib import URLopener
from bs4 import BeautifulSoup
from datetime import datetime
import pprint
import requests
import urllib, urllib2, cookielib
import _mysql
import sys
import datetime
import time

from urllib2 import HTTPError,URLError

import MySQLdb
# ****************** FUNCTIONS **************

# test the parser by printing the final result
def test_parser(tested_list):
	for log in tested_list:
		for key,value in log.iteritems():
			print (value),
			print "\t",
		print ""
		
	return

# remove slash characer from the values
def remove_slash(dicti,x):

	Key = dicti[x].split('/')
	clearnum = int(Key[0])
	dicti[x] = clearnum

	return dicti


# takes one log in dictionary morfat and fixes the values accordingly
def fix_new(dictio):
	
	#convert string into integer
	dictio['DepID'] = int(dictio['DepID'])
	
	'''
	#split string of copies and make it one interger
	TotalPrints = dictio['TotalPrints'].split('/')
	clearnum = int(TotalPrints[0])
	dictio ['TotalPrints'] = clearnum
	'''

	remove_slash(dictio,'TotalPrints')
	remove_slash(dictio,'Print')
	remove_slash(dictio,'Copy')
	remove_slash(dictio,'BWScan')
	remove_slash(dictio,'ColorScan')
	
	return dictio


def take_html_from_page():
	# TODO: fix the url !!! 
	URL = "http://192.168.1.48/_pnt_log.html"
	username = "11111"
	password ="1"

	cj = cookielib.CookieJar()
	opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
	login_data = urllib.urlencode({'username' : username, 'j_password' : password})
	# needs better checking here
	try:
		opener.open('http://192.168.1.48/_top.html', login_data)
		resp = opener.open('http://192.168.1.48/_pnt_log.html')
	except HTTPError as e:
		ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		print st,' TotalPrintScraping. ERROR:  The server couldn\'t fulfill the request. ','Error code: ', e.code
		return 1
	except URLError as e:
		ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		print st,' TotalPrintScraping.  ERROR:  We failed to reach the server. ', e.reason
		return 1
	else:
	# everything is fine
		return resp.read()

# ****************** MAIN FLOW **************
def do_the_billing_parse_job():
	# TODO: change it to take it from net 
	#html = open("./haratsi.html",'r').read()

	html = take_html_from_page()
	if html== 1 :
		ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		print st, " TotalPrintScraping. ERROR: (main flow) Error getting the source page\n"
		sys.stdout.flush()
		sys.exit(1)
	else:
		soup = BeautifulSoup(html)



	table = soup.find("table", cellspacing="1")
	rows = table.findAll('tr')

	data= []

	# taking all rows and fixes them in item-lists
	for row in rows[2:]:
		cols = row.findAll('td')
		cols = [ele.text.strip() for ele in cols] 
		data.append([ele for ele in cols if ele]) # Get rid of empty values

	#uncomment the line bellow to see the format
	#print data[0]

	# remove all internal blank lists from data list
	j=0
	k = len(data)
	for i in range(k):	
		if data[j] == []:
			data.pop(j)
			j-=1
		j+=1

	# remove last data line, no DepID
	data.pop(len(data)-1)

	final_logs = []
	keys = ["DepID","TotalPrints","Copy", "BWScan", "ColorScan", "Print"]

	#for each log line, enrich it into dictionary and fix its values 
	for log in data:
		new_log = dict(zip(keys,log))
		print new_log
		new_log = fix_new(new_log)	 
		final_logs.append(new_log)

	# and now test the parser
	test_parser(final_logs)



	keys = ["DepID","TotalPrints","Copy", "BWScan", "ColorScan", "Print"]
	# Open database connection
	try:        
		db = MySQLdb.connect("localhost","root","root1","Fw.To" )

		# prepare a cursor object using cursor() method
		cursor = db.cursor()
		ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		for new_job in final_logs:  
			# Prepare SQL query to INSERT a record into the database.
			sql = "INSERT INTO AutoDebit \
			              (IdUser, timestamp, PrintedPages) \
			              VALUES ('%d', '%s', '%d', '%s', '%s' , '%s', '%s' )" % \
			                  (new_job['DepID'], st , new_job['TotalPrints'])
			cursor.execute(sql)
			# Commit your changes in the database
			db.commit()

		# disconnect from server
		db.close()
	except MySQLdb.Error, e:
	  	ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		print st," TotalPrintScraping. ERROR %d: %s" % (e.args[0],e.args[1])
		sys.exit(1)



	print st," TotalPrintScraping. INFO: Billling page scanning completed. Database updated succesfully\n"
	return 0
