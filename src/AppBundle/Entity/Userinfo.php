<?php

namespace AppBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Userinfo
 * @UniqueEntity(
 *     fields={"cin"}
 * )
 * @ORM\Table(name="userinfo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserinfoRepository")
 */
class Userinfo
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Regex(
     *     
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     * 
     * @ORM\Column(name="firstname", type="string", length=50)
     */
    private $firstname;

    /**
     * @var string
     * @Assert\Regex(
     *     
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )     
     * 
     * @ORM\Column(name="lastname", type="string", length=50)
     */
    private $lastname;

    /**
     * @var string
     * 
     * @ORM\Column(name="genre", type="string", length=50)
     */
    private $genre;

    /**
     * @var string
     * 
     * 
     * @ORM\Column(name="cin", type="string", length=10)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *  
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string
     * 
     * @ORM\Column(name="adresse", type="text" , nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="float", nullable=true)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="float", nullable=true)
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="integer", nullable=true)
     */
    private $zipCode;
    
    /**
     * 
     *@ORM\OneToOne(targetEntity="AppBundle\Entity\User", mappedBy="userinfo")
     *
     */
    private  $user;


    /**
     * @ORM\Column(name="image",type="string", length=255, nullable=true)
     */
    public $profile;    

    /**
     * @Assert\File(maxSize="1M")
     */
    private $file;
 
    

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Userinfo
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Userinfo
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return Userinfo
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return Userinfo
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set birthday
     *
     * @param string $birthday
     *
     * @return Userinfo
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Userinfo
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Userinfo
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set profile
     *
     * @param string $profile
     *
     * @return Userinfo
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    public function getAbsolutePath()
    {
        return null === $this->profile
            ? null
            : $this->getUploadRootDir().'/'.$this->profile;
    }

    public function getWebPath()
    {
        return null === $this->profile
            ? null
            : $this->getUploadDir().'/'.$this->profile;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/profile';
    }
  
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
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
   
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        if ($this->removeUpload($this->getAbsolutePath())) {
            // use the original file name here but you should
            // sanitize it at least to avoid any security issues

            // move takes the target directory and then the
            // target filename to move to
            $filename = uniqid().$this->getFile()->getClientOriginalName();
            $this->getFile()->move(
                $this->getUploadRootDir(),
                $filename
            );

            // set the path property to the filename where you've saved the file
            $this->profile = $filename;

            // clean up the file property as you won't need it anymore
            $this->file = null;
        }

    }

    public function removeUpload($image)
    {
        if (!empty($image)) {
            unlink($image);
            return true;
        }
        return true;
    }



    /**
     * Set city
     *
     * @param string $city
     *
     * @return Userinfo
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Userinfo
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set lat
     *
     * @param float $lat
     *
     * @return Userinfo
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lang
     *
     * @param float $lang
     *
     * @return Userinfo
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return float
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set zipCode
     *
     * @param integer $zipCode
     *
     * @return Userinfo
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return integer
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
}
