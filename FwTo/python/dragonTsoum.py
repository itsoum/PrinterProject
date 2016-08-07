#!/usr/bin/env python
from datetime import datetime

msg =  "\nTsouma Bekri " + str(datetime.now()) 
print msg

f = open('/opt/lampp/htdocs/FwTo/python/myfile',"a")
f.write(msg) # python will convert \n to os.linesep
f.close() # you can omit in most cases as the destructor will call it
