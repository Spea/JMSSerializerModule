<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace JMSSerializerModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Metadata options
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Kyle Spraggs <theman@spiffyjr.me>
 */
class Metadata extends AbstractOptions
{
    /**
     * Directories to locate the metadata
     *
     * @var array
     */
    protected $directories = array();

    /**
     * @var string
     */
    protected $cache = null;

    /**
     * @var string
     */
    protected $annotationCache = 'array';

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var array
     */
    protected $fileCache = array('dir' => 'data/JMSSerializerModule/cache');

    /**
     * @var bool
     */
    protected $inferTypesFromDoctrineMetadata = true;

    /**
     * @param string $cache
     *
     * @return self
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return string
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param array $directory
     *
     * @return self
     */
    public function setDirectories($directory)
    {
        $this->directories = $directory;

        return $this;
    }

    /**
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * @param boolean $debug
     *
     * @return self
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @param array $fileCache
     *
     * @return self
     */
    public function setFileCache($fileCache)
    {
        $this->fileCache = $fileCache;

        return $this;
    }

    /**
     * @return array
     */
    public function getFileCache()
    {
        return $this->fileCache;
    }

    /**
     * @param boolean $inferTypesFromDoctrineMetadata
     *
     * @return self
     */
    public function setInferTypesFromDoctrineMetadata($inferTypesFromDoctrineMetadata)
    {
        $this->inferTypesFromDoctrineMetadata = $inferTypesFromDoctrineMetadata;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getInferTypesFromDoctrineMetadata()
    {
        return $this->inferTypesFromDoctrineMetadata;
    }

    /**
     * @param string $annotationCache
     */
    public function setAnnotationCache($annotationCache)
    {
        $this->annotationCache = $annotationCache;
    }

    /**
     * @return string
     */
    public function getAnnotationCache()
    {
        return "doctrine.cache.{$this->annotationCache}";;
    }

}
