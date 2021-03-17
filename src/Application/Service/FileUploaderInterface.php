<?php

namespace App\Application\Service;

/**
 * Interface FileUploaderInterface.
 */
interface FileUploaderInterface
{
    /**
     * @param string $bucketName
     * @param string $objectName
     * @param string $imageUrl
     * @return mixed
     */
    public function upload(string $bucketName, string $objectName, string $imageUrl);

    /**
     * @return mixed
     */
    public function getImageUrl();
}
