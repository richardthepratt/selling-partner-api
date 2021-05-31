<?php
/**
 * Configuration
 * PHP version 7.2
 *
 * @category Class
 * @package  SellingPartnerApi
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace SellingPartnerApi;

use Exception;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use RuntimeException;

/**
 * Configuration Class Doc Comment
 * PHP version 7.2
 *
 * @category Class
 * @package  SellingPartnerApi
 */
class Configuration
{
    /**
     * @var Configuration
     */
    private static $defaultConfiguration;

    /**
     * @var Authentication
     */
    private static $defaultAuthentication;

    /**
     * Auth object for the SP API
     *
     * @var Authentication
     */
    protected $auth;

    /**
     * Access token for OAuth
     *
     * @var string
     */
    protected $accessToken = '';

    /**
     * The host
     *
     * @var string
     */
    protected $spapiEndpoint = 'https://sellingpartnerapi-na.amazon.com';

    /**
     * User agent of the HTTP request, set to "OpenAPI-Generator/{version}/PHP" by default
     *
     * @var string
     */
    protected $userAgent = 'jlevers/selling-partner-api/2.1.0 (Language=PHP)';

    /**
     * Debug switch (default set to false)
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * Debug file location (log to STDOUT by default)
     *
     * @var string
     */
    protected $debugFile = 'php://output';

    /**
     * Debug file location (log to STDOUT by default)
     *
     * @var string
     */
    protected $tempFolderPath;

    /**
     * @var ConfigurationOptions|null
     */
    protected $configurationOptions;

    /**
     * Constructor
     * @param ConfigurationOptions|array|null $configurationOptions
     * @param string|null $spapiEndpoint Note: This will override the ConfigurationOptions and ENV spapiEndpoint
     * @throws Exception
     */
    public function __construct($configurationOptions = null, ?string $spapiEndpoint = null)
    {
        $this->tempFolderPath = sys_get_temp_dir();

        //If an array is passed in, we will initialize a ConfigurationOptions using the values passed.
        if ($configurationOptions !== null && is_array($configurationOptions)) {
            //Validate the passed array has at least the minimum requirements.
            //Required values.

            //Construct a new ConfigurationInstance
            $configurationOptions = new ConfigurationOptions(
                $configurationOptions["lwaClientId"] ?? $_ENV['LWA_CLIENT_ID'],
                $configurationOptions["lwaClientSecret"] ?? $_ENV['LWA_CLIENT_SECRET'],
                $configurationOptions["refreshToken"] ?? $_ENV['LWA_REFRESH_TOKEN'],
                $configurationOptions["awsAccessKey"] ?? $_ENV['AWS_ACCESS_KEY_ID'],
                $configurationOptions["awsSecretKey"] ?? $_ENV['AWS_SECRET_ACCESS_KEY'],
                $configurationOptions["spapiAwsRegion"] ?? $_ENV['SPAPI_AWS_REGION'],
                $configurationOptions["spapiEndpoint"] ?? $_ENV['SPAPI_ENDPOINT'],
                $configurationOptions['accessToken'] ?? null,
                $configurationOptions['accessTokenExpiration'] ?? null,
                $configurationOptions['onUpdateCredentials'] ?? null,
                $configurationOptions['roleArn'] ?? null,
            );
        }

        $this->configurationOptions = $configurationOptions;

        if ($this->configurationOptions === null) {
            loadDotenv();
            $this->spapiEndpoint = $_ENV["SPAPI_ENDPOINT"];
        }

        if ($spapiEndpoint !== null) {
            $this->spapiEndpoint = $spapiEndpoint;
        } else if ($this->configurationOptions !== null) {
            $this->spapiEndpoint = $this->configurationOptions->getSpapiEndpoint();
        }

        if ($this->configurationOptions !== null) {
            $this->auth = new Authentication($this->configurationOptions);
        } else {
            $this->auth = self::getDefaultAuthentication();
        }
    }

    /**
     * Sets the host
     *
     * @param string $spapiEndpoint Host
     *
     * @return $this
     */
    public function setSpapiEndpoint($spapiEndpoint)
    {
        $this->spapiEndpoint = $spapiEndpoint;
        return $this;
    }

    /**
     * Gets the host
     *
     * @return string Host
     */
    public function getHost()
    {
        return $this->spapiEndpoint;
    }

    /**
     * Gets the stripped-down host (no protocol or trailing slash)
     *
     * @return string Host
     */
    public function getBareHost()
    {
        $host = $this->getHost();
        $noProtocol = preg_replace("/.+\:\/\//", " ", $host);
        return trim($noProtocol, "/");
    }

    /**
     * Sets the user agent of the api client
     *
     * @param string $userAgent the user agent of the api client
     *
     * @throws InvalidArgumentException
     * @return $this
     */
    public function setUserAgent($userAgent)
    {
        if (!is_string($userAgent)) {
            throw new InvalidArgumentException('User-agent must be a string.');
        }

        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * Gets the user agent of the api client
     *
     * @return string user agent
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Sets debug flag
     *
     * @param bool $debug Debug flag
     *
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * Gets the debug flag
     *
     * @return bool
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Sets the debug file
     *
     * @param string $debugFile Debug file
     *
     * @return $this
     */
    public function setDebugFile($debugFile)
    {
        $this->debugFile = $debugFile;
        return $this;
    }

    /**
     * Gets the debug file
     *
     * @return string
     */
    public function getDebugFile()
    {
        return $this->debugFile;
    }

    /**
     * Sets the temp folder path
     *
     * @param string $tempFolderPath Temp folder path
     *
     * @return $this
     */
    public function setTempFolderPath($tempFolderPath)
    {
        $this->tempFolderPath = $tempFolderPath;
        return $this;
    }

    /**
     * Gets the temp folder path
     *
     * @return string Temp folder path
     */
    public function getTempFolderPath()
    {
        return $this->tempFolderPath;
    }

    /**
     * Gets the default configuration instance
     *
     * @return Configuration
     */
    public static function getDefaultConfiguration()
    {
        if (self::$defaultConfiguration === null) {
            $config = new Configuration();
            self::getDefaultAuthentication();

            if (!allVarsLoaded()) {
                loadDotenv();
            }

            $config->setSpapiEndpoint($_ENV["SPAPI_ENDPOINT"]);
            self::$defaultConfiguration = $config;
        }

        return self::$defaultConfiguration;
    }

    /**
     * Sets the default configuration instance
     *
     * @param Configuration $config An instance of the Configuration Object
     *
     * @return void
     */
    public static function setDefaultConfiguration(Configuration $config)
    {
        self::$defaultConfiguration = $config;
    }

    /**
     * Gets the default authentication instance
     *
     * @return Authentication
     */
    public static function getDefaultAuthentication()
    {
        if (self::$defaultAuthentication === null) {
            self::setDefaultAuthentication();
        }
        return self::$defaultAuthentication;
    }

    /**
     * Sets the default authentication instance
     *
     * @param Authentication $auth An instance of the Authentication class
     *
     * @return void
     */
    public static function setDefaultAuthentication($auth = null)
    {
        if ($auth !== null) {
            self::$defaultAuthentication = $auth;
        } else if (self::$defaultAuthentication === null) {
            self::$defaultAuthentication = new Authentication();
        }
    }

    /**
     * Get the datetime string that was used to sign the most recently signed Selling Partner API request
     *
     * @return \DateTime The current time
     */
    public function getRequestDatetime()
    {
        return $this->auth->formattedRequestTime();
    }

    /**
     * Sign a request to the Selling Partner API using the AWS Signature V4 protocol.
     *
     * @param Request $request The request to sign
     * @param string $scope The scope of the request, if it's grantless
     *
     * @return Request The signed request
     */
    public function signRequest($request, $scope = null)
    {
        return $this->auth->signRequest($request, $scope);
    }

    /**
     * Gets the essential information for debugging
     *
     * @param string|null $tempFolderPath The path to the temp folder.
     * @return string The report for debugging
     */
    public static function toDebugReport(?string $tempFolderPath = null)
    {
        if ($tempFolderPath === null) {
            $tempFolderPath = self::getDefaultConfiguration()->getTempFolderPath();
        }
        $report  = 'PHP SDK (SellingPartnerApi) Debug Report:' . PHP_EOL;
        $report .= '    OS: ' . php_uname() . PHP_EOL;
        $report .= '    PHP Version: ' . PHP_VERSION . PHP_EOL;
        $report .= '    The version of the OpenAPI document: 2020-11-01' . PHP_EOL;
        $report .= '    SDK Package Version: 2.1.0' . PHP_EOL;
        $report .= '    Temp Folder Path: ' . $tempFolderPath . PHP_EOL;

        return $report;
    }

    /**
     * Get API key (with prefix if set)
     *
     * @param  string $apiKeyIdentifier name of apikey
     *
     * @return null|string API key with the prefix
     */
    public function getApiKeyWithPrefix($apiKeyIdentifier)
    {
        $prefix = $this->getApiKeyPrefix($apiKeyIdentifier);
        $apiKey = $this->getApiKey($apiKeyIdentifier);

        if ($apiKey === null) {
            return null;
        }

        if ($prefix === null) {
            $keyWithPrefix = $apiKey;
        } else {
            $keyWithPrefix = $prefix . ' ' . $apiKey;
        }

        return $keyWithPrefix;
    }

    /**
     * Returns an array of host settings
     *
     * @return array an array of host settings
     */
    public function getHostSettings()
    {
        return [
            [
                "url" => "https://sellingpartnerapi-na.amazon.com",
                "description" => "No description provided",
            ]
        ];
    }

    /**
     * Returns URL based on the index and variables
     *
     * @param int        $index     index of the host settings
     * @param array|null $variables hash of variable and the corresponding value (optional)
     * @return string URL based on host settings
     */
    public function getHostFromSettings($index, $variables = null)
    {
        if (null === $variables) {
            $variables = [];
        }

        $hosts = $this->getHostSettings();

        // check array index out of bound
        if ($index < 0 || $index >= count($hosts)) {
            throw new InvalidArgumentException("Invalid index $index when selecting the host. Must be less than ".count($hosts));
        }

        $host = $hosts[$index];
        $url = $host["url"];

        // go through variable and assign a value
        foreach ($host["variables"] ?? [] as $name => $variable) {
            if (array_key_exists($name, $variables)) { // check to see if it's in the variables provided by the user
                if (in_array($variables[$name], $variable["enum_values"], true)) { // check to see if the value is in the enum
                    $url = str_replace("{".$name."}", $variables[$name], $url);
                } else {
                    throw new InvalidArgumentException("The variable `$name` in the host URL has invalid value ".$variables[$name].". Must be ".implode(',', $variable["enum_values"]).".");
                }
            } else {
                // use default value
                $url = str_replace("{".$name."}", $variable["default_value"], $url);
            }
        }

        return $url;
    }

    /**
     * @return ConfigurationOptions|null
     */
    public function getConfigurationOptions()
    {
        return $this->configurationOptions;
    }

    /**
     * @param ConfigurationOptions|null $configurationOptions
     */
    public function setConfigurationOptions(?ConfigurationOptions $configurationOptions)
    {
        $this->configurationOptions = $configurationOptions;
    }
}
