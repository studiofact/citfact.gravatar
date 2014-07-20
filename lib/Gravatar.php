<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Citfact\Gravatar;

class Gravatar
{
    /**
     * @var string
     */
    const HTTP_URL = 'http://www.gravatar.com/avatar/';
    const HTTPS_URL = 'https://secure.gravatar.com/avatar/';

    /**
     * @var int
     */
    protected $avatarSize = 80;

    /**
     * @var array
     */
    protected $defaultImagePattern = array('404', 'mm' , 'identicon', 'monsterid', 'wavatar', 'retro');

    /**
     * @var mixed
     */
    protected $defaultImage = false;

    /**
     * @var array
     */
    protected $availableMaxRaiting = array('g', 'pg', 'r', 'x');

    /**
     * @var string
     */
    protected $maxRating = 'g';

    /**
     * @var bool
     */
    protected $secureUrl = false;

    /**
     * @param string $email
     * @return string
     */
    public function get($email)
    {
        return $this->generateGravatarUrl($email);
    }

    /**
     * @param string $email
     * @return string
     */
    protected function generateGravatarUrl($email)
    {
        $url = ($this->secureUrl) ? self::HTTPS_URL : self::HTTP_URL;
        $url .= $this->getEmailHash($email);

        $params['s'] = $this->avatarSize;
        $params['r'] = $this->maxRating;
        if ($this->defaultImage !== false) {
            $params['d'] = $this->defaultImage;
        }

        $url .= '?'.http_build_query($params, '', '&amp;');

        return $url;
    }

    /**
     * @param string $email
     * @return string
     */
    protected function getEmailHash($email)
    {
        return md5(strtolower(trim($email)));
    }

    /**
     * @param int $size
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setAvatarSize($size)
    {
        $size = (int)$size;
        if ($size > 512 || $size < 0) {
            throw new \InvalidArgumentException('Avatar size must between 0 pixels and 512 pixels');
        }

        $this->avatarSize = $size;

        return $this;
    }

    /**
     * @return int
     */
    public function getAvatarSize()
    {
        return $this->avatarSize;
    }

    /**
     * @param mixed $image
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setDefaultImage($image)
    {
        if (in_array($image, $this->defaultImagePattern)) {
            $this->defaultImage = $image;
        } elseif (is_bool($image) && $image === false) {
            $this->defaultImage = false;
        } else {
            if (!filter_var($image, FILTER_VALIDATE_URL)) {
                throw new \InvalidArgumentException('Image url is not a valid');
            }

            $this->defaultImage = $image;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    /**
     * @param string $rating
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setMaxRating($rating)
    {
        $rating = strtolower($rating);
        if (!in_array($rating, $this->availableMaxRaiting)) {
            throw new \InvalidArgumentException(sprintf('Rating %s does not exist', $rating));
        }

        $this->maxRating = $rating;

        return $this;
    }

    /**
     * @return string
     */
    public function getMaxRating()
    {
        return $this->maxRating;
    }

    /**
     * @param bool $flag
     * @return $this
     */
    public function setSecureUrl($flag)
    {
        $this->secureUrl = (bool)$flag;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSecureUrl()
    {
        return $this->secureUrl;
    }
}