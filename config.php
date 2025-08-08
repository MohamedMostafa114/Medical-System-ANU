<?php

// Specify the form field names your form will accept
$whitelist = array( 'new', 'child', 'fname', 'lname', 'phone', 'email', 'you-add', 'reason', 'app-add', 'address', 'pharmacy', 'pharm-number', 'pharm-fax-number', 'pharm-address');

// Set the from email address
$from = 'no-reply@dundurn.com';

// Set the from name
$fromName = 'Dundurn Medical Centre';

// Set the email address submissions will be sent from
$email_address = 'testpython413@gmail.com';

// Set the password of the email
$password = '*************';

// Set the subject line for email messages
$subject = 'Dundurn Medical Centre Appointment';

// Table name
$table = 'mysqlemail';

// Database name
define( 'DB_NAME', 'snippets' );

// Database username
define( 'DB_USERNAME', 'root' );

// Database password
define( 'DB_PASSWORD', '' );

// Database gethostname
define( 'DB_HOST', 'localhost' );

?>
