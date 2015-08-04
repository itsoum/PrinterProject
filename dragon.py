import logParserNET
import TotalPrintScraping
import datetime
import time
import sys

job_parser = logParserNET.do_the_log_parse_job
billing_parser = TotalPrintScraping.do_the_billing_parse_job



####################### Try the first parser #######################
ret = 0 
try:
	ret = job_parser()
except SystemExit as e:
	ret = e


if ret !=0:
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	print st," Dragon. ERROR: Dragon failed to finish his job!\n"
	sys.stdout.flush()
	sys.exit(1)


####################### Try the second parser #######################
ret = 0 
try:
	ret = billing_parser()
except SystemExit as e:
	ret = e

if ret !=0  :
	ts = time.time()
	st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
	print st," Dragon. ERROR: Dragon failed to finish his job!\n"
	sys.stdout.flush()
	sys.exit(1)


####################### Try the matching code here #######################
print "Matching is under construction\n"
