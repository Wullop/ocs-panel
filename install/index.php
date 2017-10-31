<?php
session_start();
error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

$db_config_path = '../application/config/database.php';
// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();
	

	// Validate the post data
	if($core->validate_post($_POST) == true)
	{

		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
			
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
		    $success = $core -> show_message('success', "Installasi berhasil mohon untuk menghapus folder 'install' ");
		    /*
			$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
			$redir .= "://".$_SERVER['HTTP_HOST'];
			$redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
			$redir = str_replace('install/','',$redir); 
		//	header( 'Location: ' . $redir . 'join' ) ;
			header( 'Location: admin.php?dbhost='.$_POST['hostname']. '&dbuser='. $_POST['username'] . '&dbpwd='. $_POST['password']. '&dbname='. $_POST['database']);
			*/
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Install | Your App</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		
	</head>
	<body>
	<center><h1>Installation</h1></center>
	<?php if(is_writable($db_config_path)){?>
		<div class="container">
		    <div class="row">
		        	<?php if(isset($_SESSION['success'])) {echo'<div class="alert alert-success">'.$_SESSION['success']. '</div>';} ?>
					<?php if(isset($message)) {echo '<p class="alert alert-danger">' . $message . '</p>';}?>
					<?php if(isset($success)) {echo '<p class="alert alert-success">' . $success . '</p>';}?>
		        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		        <div class="col-xs-6">
		            <div class="panel panel-default">
		                <div class="panel-heading"> Database Settings </div>
		                <div class="panel-body">
		                    <div class="form-group">
		                        <label for="hostname">Hostname</label>
		                        <input type="text" id="hostname" value="localhost" class="form-control" name="hostname"/>
		                    </div>
		                    <div class="form-group">
		                        <label for="username">Username</label><input type="text" id="username" class="form-control" placeholder="DATABASE USERNAME" name="username" />
		                    </div>
		                    <div class="form-group">
		                        <label for="password">Password</label><input type="text" id="password" class="form-control" placeholder ="DATABASE PASSWORD" name="password" />
		                    </div>
		                    <div class="form-group">
		                        <label for="database">Database Name</label><input type="text" id="database" class="form-control" placeholder="DATABASE NAME" name="database" />
		                    </div>
		                </div>
		                <div class="panel-footer"></div>
		            </div>
		            
		        </div>
		        <div class="col-xs-6">
		            <div class="panel panel-default">
		                <div class="panel-heading"> Administrator Settings</div>
		                <div class="panel-body">
		                    <div class="form-group">
		                        <label for="username">Admin username</label><input type="text" id="user" class="form-control" placeholder="Enter admin user" name="user" />
		                    </div>
					        <div class="form-group">
					            <label for="password">Admin password</label><input type="text" id="pwd" class="form-control" placeholder ="Enter Admin password" name="pwd" />
					       </div>
					       <div class="form-group">
						        <label for="database">Email</label><input type="email" id="email" class="form-control" placeholder="Enter email" name="email" />
						  </div>
		                </div>
		                <div class="panel-footer"></div>
		            </div>
		            
		        </div>
		        <div class="form-group">
		            <input type="submit" value="Install" id="submit" class="btn btn-default form-control"/>
		        </div>
		
		        </form>
    <?php } else { ?>
      <p class="alert alert-danger">Please make the application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></p>
	<?php } ?>
		    </div>
		</div>
	</body>
</html>
