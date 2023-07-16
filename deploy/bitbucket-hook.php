<?php
// https://github.com/katzueno/git-Webhooks-Auto-Deploy-PHP-Script/blob/master/deploy.php

$env = parse_ini_file('.env');

/**
 * The Options
 */
$options = array(
	// Enter your server's git repo location

	'directory' => $env['DIR'],
	'log' => $env['LOG_FILE'],
	// relative or absolute path where you save log file. Set it to false without quotation mark if you don't need to save log file.
	'branch' => $env['BRANCH'],
	// Indicate which branch you want to checkout
	'remote' => $env['REMOTE'],
	// Indicate which remote repo you want to fetch
	'date_format' => $env['DATE_FORMAT'],
	// Indicate date format of your log file
	'git_bin_path' => $env['GIT_BIN_PATH'],
);

/**
 * Main Section: No need to modify below this line
 */
if ($_REQUEST['key'] === $env['SECRET_KEY']) {
	$deploy = new Deploy($options);
	$deploy->execute();
}

class Deploy
{
	/**
	 * The name of the file that will be used for logging deployments. Set too
	 * FALSE to disable logging.
	 */
	private string $_log = 'deploy.log';

	/**
	 * The timestamp format used for logging.
	 *
	 * @link    http://www.php.net/manual/en/function.date.php
	 */
	private string $_date_format = 'Y-m-d H:i:sP';

	/**
	 * The path to git
	 */
	private string $_git_bin_path = 'git';

	/**
	 * The directory where your git repository is located, can be
	 * a relative or absolute path from this PHP script on server.
	 */
	private string $_directory;

	private string $_branch = 'master';
	private string $_remote = 'origin';

	/**
	 * Sets up defaults.
	 *
	 * @param array $options
	 */
	public function __construct($options = array())
	{
		$available_options = array('directory', 'log', 'date_format', 'branch', 'remote', 'git_bin_path');

		foreach ($options as $option => $value) {
			if (in_array($option, $available_options)) {
				$this->{'_' . $option} = $value;
			}
		}

		$this->log('Attempting deployment...');
	}

	public function log($message, $type = 'INFO'): void
	{
		if ($this->_log) {
			// Set the name of the log file
			$filename = $this->_log;

			if (!file_exists($filename)) {
				// Create the log file
				file_put_contents($filename, '');

				// Allow anyone to write to log files
				chmod($filename, 0666);
			}
			// Write the message into the log file
			// Format: time --- type: message
			file_put_contents(
				$filename,
				date($this->_date_format) . ' --- ' . $type . ': ' . $message . PHP_EOL,
				FILE_APPEND
			);
		}
	}

	public function execute(): void
	{
		try {
			$this->log('Start deployment');
			$this->checkout();
			$this->log('End deployment');
		} catch (Exception $e) {
			$this->log($e, 'ERROR');
		}
	}

	/**
	 * @return void
	 */
	public function checkout(): void
	{
		try {
			@umask(002);
			$command = "cd {$this->_directory} && umask 002 && {$this->_git_bin_path} fetch --all 2>/dev/null ".
				"&& {$this->_git_bin_path} reset --hard {$this->_remote}/{$this->_branch} 2>/dev/null ".
				"&& {$this->_git_bin_path} checkout {$this->_branch} 2>/dev/null";
			exec($command, $output);
			$this->log('Executing on shell: ' . $command);
			$this->log("Shell command returned: \n" . implode(", ", $output));

			$this->log('Deployment successful.');
		} catch (Exception $e) {
			$this->log($e, 'ERROR');
		}
		//123asdasd
	}
}