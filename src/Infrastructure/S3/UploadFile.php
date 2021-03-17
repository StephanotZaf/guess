<?php

namespace App\Infrastructure\S3;

use App\Application\Service\FileUploaderInterface;
use Aws\S3\S3Client;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UploadFile implements FileUploaderInterface
{
    private string $s3Object;
    private S3Client $s3Client;
    private string $bucketName;

    /**
     * UploadFile constructor.
     * @param S3Client $s3Client
     */
    public function __construct(S3Client $s3Client)
    {
        $this->s3Client = $s3Client;
        $this->s3Object = '';
        $this->bucketName = '';
    }

    /**
     * @param string $bucketName
     * @param string $objectName
     * @param string $imageUrl
     * @return mixed
     */
    public function upload(string $bucketName, string $objectName, string $imageUrl)
    {
        $slugger = new AsciiSlugger();
        $this->s3Object = strtolower($slugger->slug($objectName).'.png');
        $this->bucketName = $bucketName;

        $this->s3Client->putObject([
           'Bucket' => $this->bucketName,
           'key' => $this->s3Object,
           'Body' => file_put_contents($imageUrl),
           'ACL' => 'public-read',
        ]);
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return 'https://'.$this->bucketName.'s3.eu-central-1-amazonaws.com/'.$this->s3Object;
    }
}
