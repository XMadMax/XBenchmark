# XBenchmark
Benchmark trace & log any php, without modifying a single line of code. Usefull to trace access, monitoring run times & ram and debugging params (get / post / argv). 


## Install

Copy XBenchmark.php anywhere on your system.

Works either in Windows & Linux

-----------------------------------
### Method 1 (For any PHP)
-----------------------------------
Modify your php.ini:

auto_prepend_file = /absolute/path/to/XBenchmark.php

----------------------------------------
### Method 2 (For a virtual host)
----------------------------------------
Modify the .htaccess file under your DOCUMENT_ROOT dir, add:

php_value auto_prepend_file /absolute/path/to/XBenchmark.php

----------------------------------------
### Method 3 (For only one PHP)
----------------------------------------
Modify your PHP file, put on top:

include_once "/absolute/path/to/XBenchmark.php";

-------------------
In any case, verify that you have permissions on the XBENCHMARK_LOGS_DIR specified, and assign correct path to the XBenchmark.php file

--------
### Test 

After apache restart (only in "Method 1" needed), 

Go to any website under your apache envieronment.
You will have all logs saved under XBENCHMARK_LOGS_DIR/HOST.

