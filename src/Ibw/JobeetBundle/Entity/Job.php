<?php

namespace Ibw\JobeetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Ibw\JobeetBundle\Utils\Jobeet;

/**
 * Job
 */
class Job
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $how_to_apply;

    /**
     * @var string
     */
    private $token;

    /**
     * @var boolean
     */
    private $is_public;

    /**
     * @var boolean
     */
    private $is_activated;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $expires_at;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Ibw\JobeetBundle\Entity\Category
     */
    private $category;

    /**
     * @var UploadedFile
     */
    public $file; // The virtual field

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Job
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Job
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Job
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Job
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Job
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Job
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Job
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set how_to_apply
     *
     * @param string $howToApply
     * @return Job
     */
    public function setHowToApply($howToApply)
    {
        $this->how_to_apply = $howToApply;

        return $this;
    }

    /**
     * Get how_to_apply
     *
     * @return string
     */
    public function getHowToApply()
    {
        return $this->how_to_apply;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Job
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set is_public
     *
     * @param boolean $isPublic
     * @return Job
     */
    public function setIsPublic($isPublic)
    {
        $this->is_public = $isPublic;

        return $this;
    }

    /**
     * Get is_public
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->is_public;
    }

    /**
     * Set is_activated
     *
     * @param boolean $isActivated
     * @return Job
     */
    public function setIsActivated($isActivated)
    {
        $this->is_activated = $isActivated;

        return $this;
    }

    /**
     * Get is_activated
     *
     * @return boolean
     */
    public function getIsActivated()
    {
        return $this->is_activated;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Job
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set expires_at
     *
     * @param \DateTime $expiresAt
     * @return Job
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expires_at = $expiresAt;

        return $this;
    }

    /**
     * Get expires_at
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Job
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Job
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set category
     *
     * @param \Ibw\JobeetBundle\Entity\Category $category
     * @return Job
     */
    public function setCategory(\Ibw\JobeetBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Ibw\JobeetBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set is_activated
     *
     * @return Job
     */
    public function publish()
    {
        $this->setIsActivated(true);

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }

    /**
     * Get company slug
     *
     * @return string
     */
    public function getCompanySlug()
    {
        return Jobeet::slugify($this->getCompany());
    }

    /**
     * Get location slug
     *
     * @return string
     */
    public function getLocationSlug()
    {
        return Jobeet::slugify($this->getLocation());
    }

    /**
     * Get postion slug
     *
     * @return string
     */
    public function getPositionSlug()
    {
        return Jobeet::slugify($this->getPosition());
    }

    /**
     * @ORM\PrePersist
     */
    public function setExpiresAtValue()
    {
        if (!$this->getExpiresAt()) {
            $now = $this->getCreatedAt() ? $this->getCreatedAt()->format('U') : time();
            $this->expires_at = new \DateTime(date('Y-m-d H:i:s', $now + 86400 * 30));
        }
    }

    public static function getTypes()
    {
        return array(
            'full-time' => 'Full Time',
            'part-time' => 'Part Time',
            'freelance' => 'Freelance'
        );
    }

    public static function getTypeValues()
    {
        return array_keys(self::getTypes());
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     * @return Job
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    // used by Ibw\JobeetBundle\Resources\views\Job\admin.html.twig
    public function isExpired()
    {
        return $this->getDaysBeforeExpires() < 0;
    }

    // used by Ibw\JobeetBundle\Resources\views\Job\admin.html.twig
    public function expiresSoon()
    {
        return $this->getDaysBeforeExpires() < 5;
    }

    // used by Ibw\JobeetBundle\Resources\views\Job\admin.html.twig
    public function getDaysBeforeExpires()
    {
        return ceil(($this->getExpiresAt()->format('U') - time()) / 86400);
    }

    public function extend()
    {
        if (!$this->expiresSoon()) {
            return false;
        }

        $this->expires_at = new \DateTime(date('Y-m-d H:i:s', time() + 86400 * 30));

        return true;
    }

    public function asArray($host)
    {
        return array(
            'category'     => $this->getCategory()->getName(),
            'type'         => $this->getType(),
            'company'      => $this->getCompany(),
            'logo'         => $this->getLogo() ? 'http://' . $host . '/uploads/jobs/' . $this->getLogo() : null,
            'url'          => $this->getUrl(),
            'position'     => $this->getPosition(),
            'location'     => $this->getLocation(),
            'description'  => $this->getDescription(),
            'how_to_apply' => $this->getHowToApply(),
            'expires_at'   => $this->getCreatedAt()->format('Y-m-d H:i:s'),
        );
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/jobs';
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // files should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadTmpDir()
    {
        return 'uploads/jobs/tmp';
    }

    protected function getUploadTmpRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadTmpDir();
    }

    public function getWebPath()
    {
        return null === $this->logo ? null : $this->getUploadDir().'/'.$this->logo;
    }

    public function getAbsolutePath()
    {
        return null === $this->logo ? null : $this->getUploadRootDir().'/'.$this->logo;
    }

    public function getWebTmpPath()
    {
        return null === $this->logo ? null : $this->getUploadTmpDir().'/'.$this->logo;
    }

    public function getAbsoluteTmpPath()
    {
        return null === $this->logo ? null : $this->getUploadTmpRootDir().'/'.$this->logo;
    }

    /**
     * Get abosolute path of the thumbnail image
     *
     * @param string $image The original image with relative path
     * @param string $filterSet one of filter_sets of LiipImagineBundle defined in config.yml
     * @return string
     */
    private function getThumbnail($image, $filterSet)
    {
        if (!$this->container) {
            return null;
        }

        // RedirectResponse object
        $imagemanagerResponse = $this->container
            ->get('liip_imagine.controller')
                ->filterAction(
                    $this->container->get('request'), // http request
                    $image, // original image you want to apply a filter to
                    $filterSet // filter defined in config.yml
                );

        // string to put directly in the "src" of the tag <img>
        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        return $cacheManager->getBrowserPath($image, $filterSet);
    }

    /**
     * Get abosolute path of the thumbnail image
     *
     * @param string $filterSet one of filter_sets of LiipImagineBundle in config.yml
     * @return string
     */
    public function getLogoThumbnail($filterSet = 'thumb_small')
    {
        return $this->getThumbnail($this->getUploadDir().'/'.$this->getLogo(), $filterSet);
    }

    /**
     * Write a thumbnail image using the LiipImagineBundle
     *
     * @param string $filter the Imagine filter to use
     * @see http://stackoverflow.com/a/15669193/1179841
     */
    private function moveAndResizeImage($filter = 'primary')
    {
        $path = $this->getWebTmpPath(); // domain relative path to full sized image
        $target = $this->getAbsolutePath(); // absolute path of saved thumbnail

        if (file_exists($path) && $this->container) {
            $container = $this->container;                                  // the DI container
            $dataManager = $container->get('liip_imagine.data.manager');    // the data manager service
            $filterManager = $container->get('liip_imagine.filter.manager');// the filter manager service

            $image = $dataManager->find($filter, $path);                    // find the image and determine its type
            $thumb = $filterManager->applyFilter($image, $filter);          // run the filter

            file_put_contents($target, $thumb->getContent()); // create and write thumbnail file

            unlink($path); // remove the temp client original image
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function setTokenValue()
    {
        if (!$this->getToken()) {
            $this->token = sha1($this->getEmail().rand(11111, 99999));
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $this->logo = uniqid() . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target tmp directory and then the
        // target filename to move to
        if ($this->getFile()->move($this->getUploadTmpRootDir(), $this->logo)) {
            // resize the uploaded image in the tmp directory and move it to the actual target directory
            $this->moveAndResizeImage();
        }

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @ORM\PostPersist
     * This function is the primary purpose without image resizing
     * just for reference
     * @see upload()
     */
    private function __upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move($this->getUploadRootDir(), $this->logo);

        // set the path property to the filename where you've saved the file
        $this->logo = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    public static function getLuceneIndex()
    {
        if (file_exists($index = self::getLuceneIndexFile())) {
            return \Zend_Search_Lucene::open($index);
        }

        return \Zend_Search_Lucene::create($index);
    }

    public static function getLuceneIndexFile()
    {
        return __DIR__.'/../../../../web/data/job.index';
    }

    /**
     * @ORM\PostPersist
     */
    public function updateLuceneIndex()
    {
        $index = self::getLuceneIndex();

        // remove existing entries
        foreach ($index->find('pk:'.$this->getId()) as $hit) {
            $index->delete($hit->id);
        }

        // don't index expired and non-activated jobs
        if ($this->isExpired() || !$this->getIsActivated()) {
            return;
        }

        $doc = new \Zend_Search_Lucene_Document();

        // store job primary key to identify it in the search results
        $doc->addField(\Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));

        // index job fields
        $doc->addField(\Zend_Search_Lucene_Field::UnStored('position', $this->getPosition(), 'utf-8'));
        $doc->addField(\Zend_Search_Lucene_Field::UnStored('company', $this->getCompany(), 'utf-8'));
        $doc->addField(\Zend_Search_Lucene_Field::UnStored('location', $this->getLocation(), 'utf-8'));
        $doc->addField(\Zend_Search_Lucene_Field::UnStored('description', $this->getDescription(), 'utf-8'));

        // add job to the index
        $index->addDocument($doc);
        $index->commit();
    }

    /**
     * @ORM\PostRemove
     */
    public function deleteLuceneIndex()
    {
        $index = self::getLuceneIndex();

        foreach ($index->find('pk:'.$this->getId()) as $hit) {
            $index->delete($hit->id);
        }
    }
}
