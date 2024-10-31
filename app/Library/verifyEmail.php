<?php

namespace App\Library;
//increase max execution time of this script to 150 min:
ini_set('max_execution_time', 9000);
//increase Allowed Memory Size of this script:
ini_set('memory_limit', '960M');

class verifyEmail
{

	protected $stream = false;

	/**
	 * SMTP port number
	 * @var int
	 */
	protected $port = 25;

	/**
	 * email address for request
	 * @var string
	 */
	protected $from = '';

	/**
	 * The connection timeout, in seconds.
	 * @var int
	 */
	protected $max_connection_timeout = 5;

	/**
	 * Timeout value on stream, in seconds.
	 * @var int
	 */
	protected $stream_timeout = 10;

	/**
	 * Wait timeout on stream, in seconds.
	 * * 0 - not wait
	 * @var int
	 */
	protected $stream_timeout_wait = 10;

	/**
	 * Whether to throw exceptions for errors.
	 * @type boolean
	 * @access protected
	 */
	protected $exceptions = false;

	/**
	 * The number of errors encountered.
	 * @type integer
	 * @access protected
	 */
	protected $error_count = 0;

	/**
	 * class debug output mode.
	 * @type boolean
	 */
	public $Debug = false;

	/**
	 * How to handle debug output.
	 * Options:
	 * * `echo` Output plain-text as-is, appropriate for CLI
	 * * `html` Output escaped, line breaks converted to `<br>`, appropriate for browser output
	 * * `log` Output to error log as configured in php.ini
	 * @type string
	 */
	public $Debugoutput = 'log';

	/**
	 * SMTP RFC standard line ending.
	 */
	const CRLF = "\r\n";

	/**
	 * Holds the most recent error message.
	 * @type string
	 */
	public $ErrorInfo = '';

	/**
	 * Constructor.
	 * @param boolean $exceptions Should we throw external exceptions?
	 */
	public function __construct($exceptions = false)
	{
		$this->exceptions = (bool) $exceptions;
	}

	/**
	 * Set email address for SMTP request
	 * @param string $email Email address
	 */
	public function setEmailFrom($email)
	{
		if (!self::validate($email)) {
			$this->set_error('');
			$this->edebug($this->ErrorInfo);
			if ($this->exceptions) {
				throw new verifyEmailException($this->ErrorInfo);
			}
		}
		$this->from = $email;
	}

	/**
	 * Set connection timeout, in seconds.
	 * @param int $seconds
	 */
	public function setConnectionTimeout($seconds)
	{
		if ($seconds > 0) {
			$this->max_connection_timeout = (int) $seconds;
		}
	}

	/**
	 * Sets the timeout value on stream, expressed in the seconds
	 * @param int $seconds
	 */
	public function setStreamTimeout($seconds)
	{
		if ($seconds > 0) {
			$this->stream_timeout = (int) $seconds;
		}
	}

	public function setStreamTimeoutWait($seconds)
	{
		if ($seconds >= 0) {
			$this->stream_timeout_wait = (int) $seconds;
		}
	}

	/**
	 * Validate email address.
	 * @param string $email
	 * @return boolean  True if valid.
	 */
	public static function validate($email)
	{
		return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Get array of MX records for host. Sort by weight information.
	 * @param string $hostname The Internet host name.
	 * @return array Array of the MX records found.
	 */
	public function getMXrecords($hostname)
	{
		$mxhosts = array();
		$mxweights = array();
		if (getmxrr($hostname, $mxhosts, $mxweights) === FALSE) {
			$this->set_error('');
			$this->edebug($this->ErrorInfo);
		} else {
			array_multisort($mxweights, $mxhosts);
		}
		/**
		 * Add A-record as last chance (e.g. if no MX record is there).
		 * Thanks Nicht Lieb.
		 * @link http://www.faqs.org/rfcs/rfc2821.html RFC 2821 - Simple Mail Transfer Protocol
		 */
		if (empty($mxhosts)) {
			$mxhosts[] = $hostname;
		}
		return $mxhosts;
	}

	/**
	 * Parses input string to array(0=>user, 1=>domain)
	 * @param string $email
	 * @param boolean $only_domain
	 * @return string|array
	 * @access private
	 */
	public static function parse_email($email, $only_domain = TRUE)
	{
		sscanf($email, "%[^@]@%s", $user, $domain);
		return ($only_domain) ? $domain : array($user, $domain);
	}

	/**
	 * Add an error message to the error container.
	 * @access protected
	 * @param string $msg
	 * @return void
	 */
	protected function set_error($msg)
	{
		$this->error_count++;
		$this->ErrorInfo = $msg;
	}

	/**
	 * Check if an error occurred.
	 * @access public
	 * @return boolean True if an error did occur.
	 */
	public function isError()
	{
		return ($this->error_count > 0);
	}

	/**
	 * Output debugging info
	 * Only generates output if debug output is enabled
	 * @see verifyEmail::$Debugoutput
	 * @see verifyEmail::$Debug
	 * @param string $str
	 */
	protected function edebug($str)
	{
		if (!$this->Debug) {
			return;
		}
		switch ($this->Debugoutput) {
			case 'log':
				//Don't output, just log
				error_log($str);
				break;
			case 'html':
				//Cleans up output a bit for a better looking, HTML-safe output
				echo htmlentities(
					preg_replace('/[\r\n]+/', '', $str),
					ENT_QUOTES,
					'UTF-8'
				)
					. "<br>\n";
				break;
			case 'echo':
			default:
				//Normalize line breaks
				$str = preg_replace('/(\r\n|\r|\n)/ms', "\n", $str);
				echo gmdate('Y-m-d H:i:s') . "\t" . str_replace(
					"\n",
					"\n                   \t                  ",
					trim($str)
				) . "\n";
		}
	}

	/**
	 * check up e-mail
	 * @param string $email Email address
	 * @return boolean True if the valid email also exist
	 */

	public function checkSiteStatus($host)
	{
		$headers = @get_headers($host);
		// echo "<pre>";
		// print_r($headers);
		$status = true;
		if (($headers && strpos($headers[0], '200')) ||  ($headers && strpos($headers[0], '301')) || ($headers && strpos($headers[0], '302'))) {
			$status = true;
		} else {
			$status = false;
		}
		return $status;
	}

	public function check($email)
	{
		$emailArray = explode("@", $email);

		if (!checkdnsrr(array_pop($emailArray), "MX")) {
			return "Invalid Domain";  
		} 

		if (!self::validate($email)) {
			$this->set_error("");
			$this->edebug($this->ErrorInfo);
			if ($this->exceptions) {
				throw new verifyEmailException($this->ErrorInfo);
			}
			return "Invalid";
		}
		$this->error_count = 0; // Reset errors
		$this->stream = FALSE;
		//print_r($this->getMXrecords(self::parse_email($email))); exit;
		$mxs = $this->getMXrecords(self::parse_email($email));
		//print_r($mxs); exit;
		if (count($mxs) < 1) {
			return "BadMX";
		}

		$timeout = ceil($this->max_connection_timeout / count($mxs));
		$timeout = 10;

		$headers = "Connection: close\r\n" .
		"User-Agent: MyCustomUserAgent\r\n";

		try {
			// $mxs = array('smtp-mail.outlook.com', 'smtp-mail2.outlook.com');
			foreach ($mxs as $host) {
				// Define a custom error handler
				set_error_handler(function ($errno, $errstr) {
				    // Handle the error as needed
				    // You can log the error or display a user-friendly message
				    return true;
				});
				$context = stream_context_create([
					'ssl' => [
						'verify_peer' => false,
						'verify_peer_name' => false,
					],
					'http' => [
						'header' => $headers,
					],
				]);
				$this->stream = stream_socket_client("tcp://" . $host . ":" . $this->port, $errno, $errstr,  $timeout, STREAM_CLIENT_CONNECT, $context) ?? FALSE;
				restore_error_handler();

				if ($this->stream === FALSE) {
					if ($errno == 0) {
						$this->set_error("");
						$this->edebug($this->ErrorInfo);
						if ($this->exceptions) {
							throw new verifyEmailException($this->ErrorInfo);
						}
						return "Suspected Email";
					} else {
						$this->edebug($host . ":" . $errstr);
					}
				} else {
					stream_set_timeout($this->stream, $this->stream_timeout);
					stream_set_blocking($this->stream, 1);

					if ($this->_streamCode($this->_streamResponse()) == '220') {
						$this->edebug("Connection success {$host}");
						break;
					} else {
						fclose($this->stream);
						$this->stream = FALSE;
					}
				}
			}
			if ($this->stream === FALSE) {
				$this->set_error("");
				$this->edebug($this->ErrorInfo);
				if ($this->exceptions) {
					throw new verifyEmailException($this->ErrorInfo);
				}
				return "Suspected Email";
			}
		} catch (Exception $e) {
			// Log the technical error to file / database
			// Display a nice error message
		}

		$this->_streamQuery("HELO " . self::parse_email($this->from));
		$this->_streamResponse();
		$this->_streamQuery("MAIL FROM: <{$this->from}>");
		$this->_streamResponse();
		$this->_streamQuery("RCPT TO: <{$email}>");
		$code = $this->_streamCode($this->_streamResponse());
		$this->_streamResponse();
		$this->_streamQuery("RSET");
		$this->_streamResponse();
		$this->_streamQuery("QUIT");

		switch ($code) {
			case '':
				return 'Suspected Email';
			case '510':
			case '511':
			case '550':
				// return "BadMX";
				return 'Invalid Email';
			case '250':
				/**
				 * http://www.ietf.org/rfc/rfc0821.txt
				 * 250 Requested mail action okay, completed
				 * email address was accepted
				 */
			case '450':
			case '451':
			case '452':
				/**
				 * http://www.ietf.org/rfc/rfc0821.txt
				 * 450 Requested action not taken: the remote mail server
				 *     does not want to accept mail from your server for
				 *     some reason (IP address, blacklisting, etc..)
				 *     Thanks Nicht Lieb.
				 * 451 Requested action aborted: local error in processing
				 * 452 Requested action not taken: insufficient system storage
				 * email address was greylisted (or some temporary error occured on the MTA)
				 * i believe that e-mail exists
				 */
				return "Valid";
			case '421':
				return "Timeout";
			case '540':
			case '530':
			case '501':
			default:
				return "Invalid";
		}
	}

	public function checkcatch($email, $domain)
	{
		$result = "V";

		if (!self::validate($email)) {
			$this->set_error("");
			$this->edebug($this->ErrorInfo);
			if ($this->exceptions) {
				throw new verifyEmailException($this->ErrorInfo);
			}
			return "V1";
		}
		$this->error_count = 0; // Reset errors
		$this->stream = FALSE;

		$mxs = $this->getMXrecords(self::parse_email($email));
		$timeout = ceil($this->max_connection_timeout / count($mxs));
		try {
			foreach ($mxs as $host) {
				$this->stream = stream_socket_client("tcp://" . $host . ":" . $this->port, $errno, $errstr, $timeout);
				if ($this->stream === FALSE) {
					if ($errno == 0) {
						$this->set_error("");
						$this->edebug($this->ErrorInfo);
						if ($this->exceptions) {
							throw new verifyEmailException($this->ErrorInfo);
						}
						return "V3";
					} else {
						$this->edebug($host . ":" . $errstr);
					}
				} else {
					stream_set_timeout($this->stream, $this->stream_timeout);
					stream_set_blocking($this->stream, 1);
					if ($this->_streamCode($this->_streamResponse()) == '220') {
						$this->edebug("Connection success {$host}");
						break;
					} else {
						fclose($this->stream);
						$this->stream = FALSE;
					}
				}
			}
			if ($this->stream === FALSE) {
				$this->set_error("");
				$this->edebug($this->ErrorInfo);
				if ($this->exceptions) {
					throw new verifyEmailException($this->ErrorInfo);
				}
				return "Invalid";
			}
		} catch (Exception $e) {
			// Log the technical error to file / database
			// Display a nice error message
		}

		$this->_streamQuery("HELO " . self::parse_email($this->from));
		$this->_streamResponse();
		$this->_streamQuery("MAIL FROM: <{$this->from}>");
		$this->_streamResponse();
		$test = 'fdsgsdgwert' . time() . $domain;
		$this->_streamQuery("RCPT TO: <{$test}>");

		$code = $this->_streamCode($this->_streamResponse());
		$this->_streamResponse();
		$this->_streamQuery("RSET");
		$this->_streamResponse();
		$this->_streamQuery("QUIT");
		fclose($this->stream);
		switch ($code) {
			case '250':
				/**
				 * http://www.ietf.org/rfc/rfc0821.txt
				 * 250 Requested mail action okay, completed
				 * email address was accepted
				 */
			case '450':
			case '451':
			case '452':
				/**
				 * http://www.ietf.org/rfc/rfc0821.txt
				 * 450 Requested action not taken: the remote mail server
				 *     does not want to accept mail from your server for
				 *     some reason (IP address, blacklisting, etc..)
				 *     Thanks Nicht Lieb.
				 * 451 Requested action aborted: local error in processing
				 * 452 Requested action not taken: insufficient system storage
				 * email address was greylisted (or some temporary error occured on the MTA)
				 * i believe that e-mail exists
				 */
				return "CatchAll";
			case '501':
			case '503':
			case '512':
			case '521':
				return "Bounce";
			default:
				return "Valid";
		}
	}

	/**
	 * writes the contents of string to the file stream pointed to by handle
	 * If an error occurs, returns FALSE.
	 * @access protected
	 * @param string $string The string that is to be written
	 * @return string Returns a result code, as an integer.
	 */
	protected function _streamQuery($query)
	{
		$this->edebug($query);
		return stream_socket_sendto($this->stream, $query . self::CRLF);
	}

	/**
	 * Reads all the line long the answer and analyze it.
	 * If an error occurs, returns FALSE
	 * @access protected
	 * @return string Response
	 */
	protected function _streamResponse($timed = 0)
	{
		$reply = stream_get_line($this->stream, 1);
		$status = stream_get_meta_data($this->stream);

		if (!empty($status['timed_out'])) {
			$this->edebug("");
		}

		if ($reply === FALSE && $status['timed_out'] && $timed < $this->stream_timeout_wait) {
			return $this->_streamResponse($timed + $this->stream_timeout);
		}

		if ($reply !== FALSE && $status['unread_bytes'] > 0) {
			$reply .= stream_get_line($this->stream, $status['unread_bytes'], self::CRLF);
		}
		$this->edebug($reply);
		return $reply;
	}

	/**
	 * Get Response code from Response
	 * @param string $str
	 * @return string
	 */
	protected function _streamCode($str)
	{
		preg_match('/^(?<code>[0-9]{3})(\s|-)(.*)$/ims', $str, $matches);
		$code = isset($matches['code']) ? $matches['code'] : false;
		return $code;
	}
}

/**
 * verifyEmail exception handler
 */
class verifyEmailException extends Exception
{

	/**
	 * Prettify error message output
	 * @return string
	 */
	public function errorMessage()
	{
		//$errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
		$errorMsg = $this->getMessage();
		return $errorMsg;
	}
}

class Exception extends \Exception
{

}
