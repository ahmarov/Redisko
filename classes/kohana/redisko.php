<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Redisko class
 *
 * @author     Dmitri Ahmarov
 * @copyright  (c) 2011 Dmitri Ahmarov
 */
class Kohana_Redisko extends Redis {

	/**
	 * @var string default server
	 */
	public static $server = 'default';

	/**
	 * @var array redisko instances
	 */
	protected static $instances = array();

	/**
	 * Creates a singleton redisko of the given server.
	 *
	 * 		$redisko = Redisko::instance();
	 * 
	 * @param string $server
	 * @return Redis
	 */
	public static function instance($server = NULL)
	{
		if ($server === NULL)
		{
			// Use the default server
			$server = Redisko::$server;
		}

		if ( ! isset(Redisko::$instances[$server]))
		{
			// Load the configuration for this type
			$config = Kohana::config('redisko')->get($server);

			// Create a new session instance
			Redisko::$instances[$server] = new Redisko($config);
		}

		return Redisko::$instances[$server];
	}

	/**
	 * @var string server ip
	 */
	public $_host = 'localhost';

	/**
	 * @var int server port
	 */
	public $_port = 6379;

	/**
	 * @var null prefix for keys
	 */
	public $_prefix = NULL;

	/**
	 * @var string serializer engine, SERIALIZER_NONE, SERIALIZER_PHP, SERIALIZER_IGBINARY
	 */
	public $_serializer = Redis::SERIALIZER_NONE;


	public function __construct(array $config = NULL)
	{
		parent::__construct();

		if (isset($config['host']))
		{
			$this->_host = (string) $config['host'];
		}

		if (isset($config['port']))
		{
			$this->_port = (int) $config['port'];
		}

		if (isset($config['prefix']))
		{
			$this->_prefix = (string) $config['prefix'];
		}

		if (isset($config['serializer']))
		{
			$this->_serializer = $config['serializer'];
		}

		// Connect
		if (FALSE === $this->connect($this->_host))
		{
			throw new Kohana_Exception('Redis could not connect to host \':host\' using port \':port\'', array(':host' => $this->_host, ':port' => $this->_port));
		}

		// Set prefix
		if (NULL !== $this->_prefix)
		{
			$this->setOption(Redis::OPT_PREFIX, $this->_prefix);
		}

		// Set serializer engine
		$this->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_IGBINARY);
	}
} // End Kohana_Redisko