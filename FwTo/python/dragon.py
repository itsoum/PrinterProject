import logParserNET
import TotalPrintScraping
import datetime
import time
import sys

import MySQLdb

FORODIAFYGI = "MH DHLOMENH XREWSH"

ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg =  st + " Dragon. INFO: Tsouma Bekri dragonFoto is initializing...\n"
	f.write(msg)

job_parser = logParserNET.do_the_log_parse_job
billing_parser = TotalPrintScraping.do_the_billing_parse_job
f.close()


# ####################### Try the first parser #######################
ret = 0
ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg =  st+" Dragon. INFO: Dragon calls logParser...\n" 
	f.write(msg)

try:
	ret = job_parser()
except SystemExit as e:
	ret = e

if ret !=0:
	ts = time.time()
 	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
 		msg =  st+" Dragon. ERROR: Dragon failed to finish his job while calling logParser!\n"
		f.write(msg)
 	sys.stdout.flush()
 	sys.exit(1)


# ####################### Try the second parser #######################
ret = 0 
ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg =  st+" Dragon. INFO: Dragon calls totalPrintParser...\n" 
	f.write(msg)

try:
	ret = billing_parser()
except SystemExit as e:
	ret = e

if ret !=0  :
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
		msg = st+" Dragon. ERROR: Dragon failed to finish his job while calling totalPrintParser!\n"
		f.write(msg)
	sys.stdout.flush()
	sys.exit(1)


####################### Try the matching code here #######################
f = open('/opt/lampp/htdocs/FwTo/python/logger.log',"a")
ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg = st+" Dragon. INFO: Dragon starts matching...\n" 
	f.write(msg)

####### START: Take info from manual table ######## 
codes_A4 = {42: 0}
codes_A3 = {42: 0}

# Open database connection
try:        
	db = MySQLdb.connect("localhost","root","Web@dminUb","Fw.To", unix_socket="/opt/lampp/var/mysql/mysql.sock")

	# prepare a cursor object using cursor() method
	cursor = db.cursor()
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

	# Using the cursor as iterator 
	cursor.execute("SELECT * FROM ManualDebit")
	for row in cursor:
		user_id_temp = int(row[0])
		num_pages = int(row[2])
		if row[4] == "A4":
			#print "User is "+str(row[0]) +" and It is A4"
			if user_id_temp in codes_A4.keys():
  				#print "blah"
  				codes_A4[user_id_temp] += num_pages 
			else:
  				#print "boo"
  				codes_A4[user_id_temp] = num_pages 
			
		else:
			#print "User is "+str(row[0]) +" and It is A3"
			if user_id_temp in codes_A3.keys():
  				#print "blah"
  				codes_A3[user_id_temp] += num_pages
			else:
  				#print "boo"
  				codes_A3[user_id_temp] = num_pages
			
		
		# add in sums here

	# disconnect from server
	db.close()
except MySQLdb.Error, e:
	ts = time.time()

	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
		msg = st+" TotalPrintScraping. ERROR %d: %s\n" % (e.args[0],e.args[1])
		f.write(msg)
	sys.exit(1)


####### FINISH: Take info from manual table ########

ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg = st+" Dragon. INFO: Dragon finished taking info from manual table...\n" 
	f.write(msg)
'''
print "\n\nFinal A4 Sums:"
'''

codes_sum = {} 
for key, value in codes_A4.iteritems() :
    #print key, value
    codes_sum[key] = value 
'''
print "\n\nFinal A3 Sums:"
for key, value in codes_A3.iteritems() :
    print key, value
'''

#print "Final A3 Sums: \n"
 
for key, value in codes_A3.iteritems() :
	
	if key in codes_sum.keys():
		codes_sum[key] += value
	else:
		codes_sum[key] = value


#print "\n\nFinal Total for codes:"
'''
for key, value in codes_sum.iteritems() :
    print key, value
'''
#####  Find last_auto's prints ############
last_auto = {} 
try:        
	db = MySQLdb.connect("localhost","root","Web@dminUb","Fw.To", unix_socket="/opt/lampp/var/mysql/mysql.sock")

	# prepare a cursor object using cursor() method
	cursor = db.cursor()
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

	# Using the cursor as iterator 
	cursor.execute("SELECT * FROM Bill")
	for row in cursor:
		user_id_temp = int(row[0])
		last_sum = int(row[3])
		last_auto[user_id_temp] = last_sum
	# disconnect from server
	db.close()
except MySQLdb.Error, e:
	ts = time.time()

	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
		msg = st+" TotalPrintScraping. ERROR %d: %s\n" % (e.args[0],e.args[1])
		f.write(msg)
	sys.exit(1)
################ last_Autos's Prints ####### 

ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg = st+" Dragon. INFO: Dragon finished last_autos' update...\n" 
	f.write(msg)

'''
for key, value in last_auto.iteritems() :
    print key, value
'''
# ####### START: Take info from AUTO table ######## 


# Open database connection
try:        
	db = MySQLdb.connect("localhost","root","Web@dminUb","Fw.To", unix_socket="/opt/lampp/var/mysql/mysql.sock")

	# prepare a cursor object using cursor() method
	cursor = db.cursor()
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

	# Using the cursor as iterator 
	cursor.execute("SELECT * FROM AutoDebit")
	for row in cursor:
		user_id_temp = int(row[0])
		num_pages = int(row[2])
		difference = 0
		#print "numDebug"
		#print num_pages
		sql = "UPDATE Bill \
			              SET Last_Auto=%s \
			              WHERE IdUser=%d" % (num_pages, user_id_temp)
		#sql = "UPDATE Bill SET Last_Auto = '%s' WHERE IdUser = '%s'" % ('num_pages','user_id_temp')
		
		cursor.execute(sql)
		# Commit your changes in the database
		db.commit()
		# WRONNNG HERE??????????????????????
		if user_id_temp in last_auto.keys():
  			num_pages =  num_pages - last_auto[user_id_temp]
		else:
  			num_pages =  num_pages - 0
		
		# check if user has done any manual debts
		if user_id_temp in codes_sum.keys():
			#find the difference 
			difference = num_pages - codes_sum[user_id_temp]
			#print "Tsoumasssss000"
			#print difference
			# there is a gap here in billing. Cath the thief
			if difference>0:
				#print "Tsoumasssss"
				#print difference
				# Prepare SQL query to INSERT a record into the database.
				sql = "INSERT INTO ManualDebit \
			              (IdUser, DateLog, PrintedPages, ColorPages, Size, DescriptionOfJobs) \
			              VALUES ('%d', '%s', '%d', '%d', '%s', '%s')" % \
			                  (user_id_temp, st , difference, 0 , "A4", "Forodiafygi. Ksexases na xreoseis sto WEbAPP!!!")
				cursor.execute(sql)
				# Commit your changes in the database
				db.commit()
				if user_id_temp in codes_A4.keys():
					codes_A4[user_id_temp] += difference
				else:
					codes_A4[user_id_temp] = difference
		else: 
			# no manual debts. ADD them ALL to A4
			difference = num_pages
			codes_A4[user_id_temp] = difference
			#print "Tsoumasssss42"
			#print difference
			# Prepare SQL query to INSERT a record into the database.
			# Prepare SQL query to INSERT a record into the database.
			sql = "INSERT INTO ManualDebit \
			              (IdUser, DateLog, PrintedPages, ColorPages, Size, DescriptionOfJobs) \
			              VALUES ('%d', '%s', '%d', '%d', '%s', '%s')" % \
			                  (user_id_temp, st , difference, 0 , "A4", FORODIAFYGI )
			cursor.execute(sql)
			# Commit your changes in the database
			db.commit()

		
	# disconnect from server
	db.close()
except MySQLdb.Error, e:
	ts = time.time()

	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
		msg = st+" TotalPrintScraping. ERROR %d: %s\n" % (e.args[0],e.args[1])
		f.write(msg)
	sys.exit(1)


####### FINISH: Take info from AUTO table ########

ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg = st+" Dragon. INFO: Dragon finished auto prints matching...\n" 
	f.write(msg)
#print "Tsoumas1"
final_balance = {} 

for key, value in codes_A4.iteritems() :
    final_balance[key] = value*0.03 

 
for key, value in codes_A3.iteritems() :
	
	if key in final_balance.keys():
		final_balance[key] += value*0.06
	else:
		final_balance[key] = value*0.06


#print "\n\nFinal Total PRICE for codes"
'''
for key, value in final_balance.iteritems() :
    print key, value
'''
ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg = st+" Dragon. INFO: Dragon finished computation of new balances...\n" 
	f.write(msg)
# ####### START: Insert Prices into BILL table ######## 

# Open database connection
try:        
	db = MySQLdb.connect("localhost","root","Web@dminUb","Fw.To", unix_socket="/opt/lampp/var/mysql/mysql.sock")

	# prepare a cursor object using cursor() method
	cursor = db.cursor()
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

	for key, value in final_balance.iteritems() :  
			# Prepare SQL query to INSERT a record into the database.               
			#print "topopos"
			#print key, value
			sql = "UPDATE Bill \
			              SET Balance=Balance+%s \
			              WHERE IdUser=%d" % (value, key)
			cursor.execute(sql)
			# Commit your changes in the database
			db.commit()

	# disconnect from server
	db.close()
except MySQLdb.Error, e:
	ts = time.time()

	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
		msg = st+" TotalPrintScraping. ERROR %d: %s\n" % (e.args[0],e.args[1])
		f.write(msg)
	sys.exit(1)


####### FINISH: Insert Prices into BILL table ########
ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg = st+" Dragon. INFO: Dragon finished Inserting Prices into BILL table...\n" 
	f.write(msg)

# ####### START: Updating database's tables ######## 
#print "Tsoumas2"
# Open database connection
try:        
	db = MySQLdb.connect("localhost","root","Web@dminUb","Fw.To", unix_socket="/opt/lampp/var/mysql/mysql.sock")

	# prepare a cursor object using cursor() method
	cursor = db.cursor()
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

	cursor.execute("INSERT INTO History SELECT * FROM ManualDebit;")
	# Commit your changes in the database
	db.commit()
	
	cursor.execute("TRUNCATE TABLE `ManualDebit`;")
	# Commit your changes in the database
	db.commit()

	cursor.execute("TRUNCATE TABLE `AutoDebit`;")
	# Commit your changes in the database
	db.commit()
			
	# disconnect from server
	db.close()
except MySQLdb.Error, e:
	ts = time.time()

	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
		msg = st+" TotalPrintScraping. ERROR %d: %s\n" % (e.args[0],e.args[1])
		f.write(msg)
	sys.exit(1)


####### FINISH: Take info from AUTO table ########
ts = time.time()
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
with open('/opt/lampp/htdocs/FwTo/python/logger.log',"a") as f:
	msg = st+" Dragon. INFO: Dragon finished Updating database's tables...\n" 
	f.write(msg)
f.close()
