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
 * Property naming options
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Kyle Spraggs <theman@spiffyjr.me>
 */
class PropertyNaming extends AbstractOptions
{
    /**
     * @var string
     */
    protected $separator = '_';

    /**
     * @var bool
     */
    protected $lowerCase = true;

    /**
     * @var bool
     */
    protected $enableCache = true;

    /**
     * @param string $cache
     *
     * @return self
     */
    public function setSeparator($cache)
    {
        $this->separator = $cache;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param boolean $debug
     *
     * @return self
     */
    public function setLowercase($debug)
    {
        $this->lowerCase = $debug;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getLowercase()
    {
        return $this->lowerCase;
    }

    /**
     * @param boolean $inferTypesFromDoctrineMetadata
     *
     * @return self
     */
    public function setEnableCache($inferTypesFromDoctrineMetadata)
    {
        $this->enableCache = $inferTypesFromDoctrineMetadata;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getEnableCache()
    {
        return $this->enableCache;
    }
}
