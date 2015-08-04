<?php

echo "Before starting python dragon\n";
# which python ??? Set the path here!
putenv('PYTHONPATH=/usr/bin/python');


# execute the dragon here
$output = array();
exec("python dragon.py", $output, $ret_code);
echo "Python dragon finished\n";

# print the returning values here 
var_dump( $output);
echo $ret_code;
echo "\n";


# Check return status and go on accordingly
if ($ret_code==1) {
	echo "We had error in dragon, handle it here Ilia\n";
	}
else{
	echo " All fine\n";
}


?>


