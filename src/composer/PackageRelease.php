<?php

namespace craftcom\composer;

use Composer\Semver\VersionParser;
use craft\base\Model;
use craft\helpers\Json;

/**
 * @property mixed $normalizedVersion
 * @property mixed $stability
 */
class PackageRelease extends Model
{
    /**
     * @var array
     */
    private static $_releaseJsonColumns = [
        'keywords',
        'license',
        'authors',
        'support',
        'conflict',
        'replace',
        'provide',
        'suggest',
        'autoload',
        'includePaths',
        'extra',
        'binaries',
        'source',
        'dist',
    ];

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $packageId;

    /**
     * @var string
     */
    public $sha;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $type = 'library';

    /**
     * @var string[]|null
     */
    public $keywords;

    /**
     * @var string|null
     */
    public $homepage;

    /**
     * @var string|null
     */
    public $time;

    /**
     * @var string[]|null
     */
    public $license;

    /**
     * @var array|null
     */
    public $authors;

    /**
     * @var array|null
     */
    public $support;

    /**
     * @var array|null
     */
    public $require;

    /**
     * @var array|null
     */
    public $conflict;

    /**
     * @var array|null
     */
    public $replace;

    /**
     * @var array|null
     */
    public $provide;

    /**
     * @var array|null
     */
    public $suggest;

    /**
     * @var array|null
     */
    public $autoload;

    /**
     * @var array|null
     */
    public $includePaths;

    /**
     * @var string|null
     */
    public $targetDir;

    /**
     * @var array|null
     */
    public $extra;

    /**
     * @var string|null
     */
    public $binaries;

    /**
     * @var array|null
     */
    public $source;

    /**
     * @var array|null
     */
    public $dist;

    /**
     * @var string|null
     */
    public $changelog;

    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        foreach (self::$_releaseJsonColumns as $column) {
            if (isset($config[$column]) && is_string($config[$column])) {
                $config[$column] = Json::decode($config[$column]);
            }
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (is_string($this->source)) {
            $this->source = Json::decode($this->source);
        }
        if (is_string($this->dist)) {
            $this->dist = Json::decode($this->dist);
        }
    }

    /**
     * Invalidates the version so it won't be available to Composer.
     */
    public function invalidate()
    {
        $this->valid = false;

        $this->description = null;
        $this->type = null;
        $this->keywords = null;
        $this->homepage = null;
        $this->time = null;
        $this->license = null;
        $this->authors = null;
        $this->support = null;
        $this->require = null;
        $this->conflict = null;
        $this->replace = null;
        $this->provide = null;
        $this->suggest = null;
        $this->autoload = null;
        $this->includePaths = null;
        $this->targetDir = null;
        $this->extra = null;
        $this->binaries = null;
        $this->source = null;
        $this->dist = null;
        $this->changelog = null;
    }

    /**
     * @return string
     */
    public function getNormalizedVersion(): string
    {
        return (new VersionParser())->normalize($this->version);
    }

    /**
     * @return string
     */
    public function getStability(): string
    {
        return VersionParser::parseStability($this->version);
    }
}
