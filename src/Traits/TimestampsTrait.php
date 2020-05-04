<?php
/**
 * @author José Jaime Ramírez Calvo <mr.ljaime@gmail.com>
 * @version 1
 * @since 1
 */

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TimestampsTrait
 * @package App\Traits
 */
trait TimestampsTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return TimestampsTrait
     */
    public function setCreatedAt(\DateTime $createdAt): TimestampsTrait
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return TimestampsTrait
     */
    public function setUpdatedAt(\DateTime $updatedAt): TimestampsTrait
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}