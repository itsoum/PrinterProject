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

# takes one log in dictionary morfat and fixes the values accordingly
def fix_new(dictio):
	#convert string into integer
	dictio['JobNO'] = int(dictio['JobNO'])
	dictio['DepID'] = int(dictio['DepID'])
	#convert unicode string into datetime python format
	dictio['Time'] = datetime.strptime(dictio['Time'], '%d/%m/%Y %H:%M:%S')
	#split string of copies and make it one interger
	PagesCopies = dictio['PagesCopies'].split()
	copies = int(PagesCopies[0])*int(PagesCopies[2])
	dictio ['PagesCopies'] = copies

	file_type = "other"
	file_name = dictio['DocName']
	if file_name.endswith('.cdr'):
		file_type = "corel"
	elif file_name.endswith('.xlsx'):
		file_type = "excel"
	elif file_name.endswith('.pdf'):
		file_type = "pdf"
	elif file_name.endswith('.jpg'):
		file_type = "jpeg"
	elif file_name.endswith('.png'):
		file_type = "png"
	elif file_name.endswith('.psd'):
		file_type = "psd"
	elif file_name.endswith('.docx'):
		file_type = "word"


	dictio ['FileType'] = file_type
	
	return dictio

def take_html_from_page():

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
		print st,' LogPageParser. ERROR: Server couldn\'t fulfill the request. ' , 'Error code: ', e.code
		return 1
	except URLError as e:
		ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		print st,' LogPageParser.  ERROR:  We failed to reach the server. ', e.reason
		return 1
	else:
	# everything is fine
		return resp.read()




# ****************** MAIN FLOW **************
def do_the_log_parse_job():
	# this is the testing process
	#html = open("./log.html",'r').read()
	# this is the production process
	html = take_html_from_page()
	if html== 1 :
		ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		print st, " LogPageParser. ERROR: (main flow) Error getting the source page\n"
		sys.stdout.flush()
		sys.exit(1)
	else:
		soup = BeautifulSoup(html)

	table = soup.find("table", attrs={"summary":"test"})
	rows = table.findAll('tr')

	data= []
	# taking all rows and fixes them in item-lists
	for row in rows[1:]:
		cols = row.findAll('td')
		cols = [ele.text.strip() for ele in cols] 
		data.append([ele for ele in cols if ele]) # Get rid of empty values

	#uncomment the line bellow to see the format
	#print data[1]

	final_logs = []
	keys = ["JobNO","DocName","DepID", "PagesCopies", "Time", "PrintResult" , "FileType"]


	#for each log line, enrich it into dictionary and fix its values 
	for log in data:
		new_log = dict(zip(keys,log))
		new_log = fix_new(new_log)	 
		final_logs.append(new_log)

	# and now test the parser
	test_parser(final_logs)

	#test_job = final_logs[1]



	# Open database connection
	try:        
		db = MySQLdb.connect("localhost","root","root1","Fw.To" )

		# prepare a cursor object using cursor() method
		cursor = db.cursor()

		for new_job in final_logs:
			j_id = new_job['JobNO']

			sqlq = "SELECT COUNT(1) FROM jobs WHERE job_id = '%d'" % j_id
			cursor.execute(sqlq)

			#check if this job has already been stored

			if not cursor.fetchone()[0]:  
				# Prepare SQL query to INSERT a record into the database.
				sql = "INSERT INTO jobs \
				              (job_id, dep_id, no_copies, doc_name, doc_type, job_status, timestamp) \
				              VALUES ('%d', '%d', '%d', '%s', '%s' , '%s', '%s' )" % \
				                  (new_job['JobNO'], new_job['DepID'], new_job['PagesCopies'], new_job['DocName'], new_job['FileType'], new_job['PrintResult'], new_job['Time'])

				cursor.execute(sql)
				# Commit your changes in the database
				db.commit()

		# disconnect from server
		db.close()
	except MySQLdb.Error, e:
	  	ts = time.time()
		st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
		print st," LogPageParser.  ERROR %d: %s" % (e.args[0],e.args[1])
		sys.exit(1)


	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	print st," LogPageParser.  INFO: Jobs' page scanning completed. Database updated succesfully\n"
	return 0 
    






