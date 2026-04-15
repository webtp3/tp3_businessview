<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Thomas Ruta <support@r-p-it.de>, tp3
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/***
 *
 * This file is part of the "BusinsessView" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <support@r-p-it.de>, tp3
 *
 ***/
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * BusinessAdress
 */
class BusinessAdress extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Hidden
     *
     * @var bool
     */
    protected bool $hidden = false;

    /**
     * slug
     * @var string
     */
    protected string $slug;

    /**
     * Tp3BusinessView
     *
     * @var ?\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView
     */
    protected ?Tp3BusinessView $tp3businessview = null;

    /**
     * cid
     *
     * @var string
     */
    protected string $cid = '';

    /**
     * googleplus
     *
     * @var string
     */
    protected string $googleplus = '';

    /**
     * propertiesArray
     *
     */
    protected array $propertiesArray = [];

    /**
     * sorting
     *
     * @var string $sorting
     */
    protected string $sorting;

    /**
     * Returns the tp3businessviews
     *
     * @return ?\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview
     */
    public function getTp3Businessview(): ?Tp3BusinessView
    {
        return $this->tp3businessview;
    }

    /**
     * Sets the contact
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview
     * @return void
     */
    public function setTp3Businessview(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview): void
    {
        $this->tp3businessview = $tp3businessview;
    }

    /**
     * Adds a Tp3Businessview
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview
     * @return void
     */
    public function addTp3Businessview(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview): void
    {
        $this->tp3businessview->attach($tp3businessview);
    }

    /**
     * Removes a BusinessAdress
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewToRemove The Tp3Businessview to be removed
     * @return void
     */
    public function removeTp3Businessview(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewToRemove): void
    {
        $this->tp3businessview->detach($tp3businessviewToRemove);
    }
    /**
     * Setter for sorting
     *
     * @param string $sorting
     * @return void
     */
    public function setSorting(string $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * Getter for sorting
     *
     * @return string sorting
     */
    public function getSorting(): string
    {
        return $this->sorting;
    }
    /**
     * Returns the cid
     *
     * @return string $cid
     */
    public function getCid(): string
    {
        return $this->cid;
    }

    /**
     * Sets the cid
     *
     * @param string $cid
     * @return void
     */
    public function setCid(string $cid): void
    {
        $this->cid = $cid;
    }
    /**
     * Returns the googleplus
     *
     * @return string $googleplus
     */
    public function getGoogleplus(): string
    {
        return $this->googleplus;
    }

    /**
     * Sets the googleplus
     *
     * @param string $googleplus
     * @return void
     */
    public function setGoogleplus(string $googleplus): void
    {
        $this->googleplus = $googleplus;
    }
    /**
     * @return array
     */
    public function getPropertiesArray(): array
    {
        return $this->_getCleanProperties();
    }
    // copied stuff

    /**
     * Gender
     * @var string
     */
    protected string $gender;

    /**
     * Name
     * @var string
     */
    protected string $name;

    /**
     * First Name
     * @var string
     */
    protected string $firstName;

    /**
     * Middle Name
     * @var string
     */
    protected string $middleName;

    /**
     * Last Name
     * @var string
     */
    protected string $lastName;

    /**
     * Birthday
     * @var \DateTime
     */
    protected \DateTime $birthday;

    /**
     * Title
     * @var string
     */
    protected string $title;

    /**
     * Address
     * @var string
     */
    protected string $address;

    /**
     * Latitude
     * @var string
     */
    protected string $latitude;

    /**
     * Longitude
     * @var string
     */
    protected string $longitude;

    /**
     * Building
     * @var string
     */
    protected string $building;

    /**
     * Room
     * @var string
     */
    protected string $room;

    /**
     * Phone
     * @var string
     */
    protected string $phone;

    /**
     * Fax
     * @var string
     */
    protected string $fax;

    /**
     * Mobile
     * @var string
     */
    protected string $mobile;

    /**
     * www
     * @var string
     */
    protected string $www;

    /**
     * Skype
     * @var string
     */
    protected string $skype;

    /**
     * twitter
     * @var string
     */
    protected string $twitter;

    /**
     * Facebook
     * @var string
     */
    protected string $facebook;

    /**
     * LinkedIn
     * @var string
     */
    protected string $linkedin;

    /**
     * instagram
     * @var string
     */
    protected string $instagram;

    /**
     * Whatsapp
     * @var string
     */
    protected string $whatsapp;

    /**
     * Singal
     * @var string
     */
    protected string $signal;

    /**
     * Email
     * @var string
     */
    protected string $email;

    /**
     * Organization
     * @var string
     */
    protected string $company;

    /**
     * Position
     * @var string
     */
    protected string $position;

    /**
     * City
     * @var string
     */
    protected string $city;

    /**
     * Zipcode
     * @var string
     */
    protected string $zip;

    /**
     * Region/State
     * @var string
     */
    protected string $region;

    /**
     * Country
     * @var string
     */
    protected string $country;

    /**
     * Image
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected ?ObjectStorage $image = null;

    /**
     * Description
     * @var string
     */
    protected string $description;

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected ?ObjectStorage $categories;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->image = $this->image  ?? new ObjectStorage();
    }

    /**
     * sets the hidden attribute
     *
     * @param bool $hidden
     * @return void
     */
    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * returns the hidden attribute
     *
     * @return bool $hidden
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * sets the gender attribute
     *
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * returns the gender attribute
     *
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * sets the name attribute
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * returns the name attribute
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * sets the firstName attribute
     *
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * returns the firstName attribute
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * sets the middleName attribute
     *
     * @param string $middleName
     */
    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * returns the middleName attribute
     *
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * sets the lastName attribute
     *
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * returns the lastName attribute
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * sets the birthday attribute
     *
     * @param \DateTime $birthday
     */
    public function setBirthday(\DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * returns the birthday attribute
     *
     * @return \DateTime
     */
    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    /**
     * sets the title attribute
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * returns the title attribute
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * sets the address attribute
     *
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * returns the address attribute
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * sets the latitude attribute
     *
     * @param string $latitude
     */
    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * returns the latitude attribute
     *
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * sets the longitude attribute
     *
     * @param string $longitude
     */
    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * returns the longitude attribute
     *
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * sets the building attribute
     *
     * @param string $building
     */
    public function setBuilding(string $building): void
    {
        $this->building = $building;
    }

    /**
     * returns the building attribute
     *
     * @return string
     */
    public function getBuilding(): string
    {
        return $this->building;
    }

    /**
     * sets the room attribute
     *
     * @param string $room
     */
    public function setRoom(string $room): void
    {
        $this->room = $room;
    }

    /**
     * returns the room attribute
     *
     * @return string
     */
    public function getRoom(): string
    {
        return $this->room;
    }

    /**
     * sets the phone attribute
     *
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * returns the phone attribute
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * returns a cleaned version of the phone
     *
     * @return string
     */
    public function getCleanedPhone(): string
    {
        return $this->getCleanedNumber($this->phone);
    }

    /**
     * sets the fax attribute
     *
     * @param string $fax
     */
    public function setFax(string $fax): void
    {
        $this->fax = $fax;
    }

    /**
     * returns the fax attribute
     *
     * @return string
     */
    public function getFax(): string
    {
        return $this->fax;
    }

    /**
     * returns a cleaned version of the fax
     *
     * @return string
     */
    public function getCleanedFax(): string
    {
        return $this->getCleanedNumber($this->fax);
    }

    /**
     * sets the mobile attribute
     *
     * @param string $mobile
     */
    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * returns the mobile attribute
     *
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * returns a cleaned version of the mobile
     *
     * @return string
     */
    public function getCleanedMobile(): string
    {
        return $this->getCleanedNumber($this->mobile);
    }

    /**
     * sets the www attribute
     *
     * @param string $www
     */
    public function setWww(string $www): void
    {
        $this->www = $www;
    }

    /**
     * returns the www attribute
     *
     * @return string
     */
    public function getWww(): string
    {
        return $this->www;
    }

    public function getWwwSimplified()
    {
        $www = trim($this->www);
        if (!$www) {
            return '';
        }
        $parts = str_replace(['\\\\', '\\"'], ['\\', '"'], str_getcsv($www, ' '));
        return $parts[0];
    }

    /**
     * sets the slug attribute
     *
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * returns the slug attribute
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * sets the Skype attribute
     *
     * @param string $skype
     */
    public function setSkype(string $skype): void
    {
        $this->skype = $skype;
    }

    /**
     * returns the Skype attribute
     *
     * @return string
     */
    public function getSkype(): string
    {
        return $this->skype;
    }

    /**
     * sets the twitter attribute
     *
     * @param string $twitter
     */
    public function setTwitter(string $twitter): void
    {
        if ($twitter[0] !== '@') {
            throw new \InvalidArgumentException('twitter name must start with @', 1357530444);
        }

        $this->twitter = $twitter;
    }

    /**
     * returns the twitter attribute
     *
     * @return string
     */
    public function getTwitter(): string
    {
        return $this->twitter;
    }

    /**
     * sets the Facebook attribute
     *
     * @param string $facebook
     */
    public function setFacebook(string $facebook): void
    {
        if ($facebook[0] !== '/') {
            throw new \InvalidArgumentException('Facebook name must start with /', 1357530471);
        }

        $this->facebook = $facebook;
    }

    /**
     * returns the Facebook attribute
     *
     * @return string
     */
    public function getFacebook(): string
    {
        return $this->facebook;
    }

    /**
     * sets the instagram attribute
     *
     * @param string $instagram
     */
    public function setinstagram(string $instagram): void
    {

        $this->instagram = $instagram;
    }

    /**
     * returns the instagram attribute
     *
     * @return string
     */
    public function getinstagram(): string
    {
        return $this->instagram;
    }

    /**
     * sets the Whatsapp attribute
     *
     * @param string $whatsaoo
     */
    public function setWhatsapp(string $whatsaoo): void
    {

        $this->whatsapp = $whatsaoo;
    }

    /**
     * returns the Whatsapp attribute
     *
     * @return string
     */
    public function getWhatsapp(): string
    {
        return $this->whatsapp;
    }

    /**
     * sets the Signal attribute
     *
     * @param string $signal
     */
    public function setSignal(string $signal): void
    {

        $this->signal = $signal;
    }

    /**
     * returns the Signal attribute
     *
     * @return string
     */
    public function getSignal(): string
    {
        return $this->signal;
    }
    /**
     * sets the LinkedIn attribute
     *
     * @param string $linkedin
     */
    public function setLinkedin(string $linkedin): void
    {
        $this->linkedin = $linkedin;
    }

    /**
     * returns the LinkedIn attribute
     *
     * @return string
     */
    public function getLinkedin(): string
    {
        return $this->linkedin;
    }

    /**
     * sets the email attribute
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * returns the email attribute
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * sets the company attribute
     *
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * returns the company attribute
     *
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * sets the position attribute
     *
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * returns the position attribute
     *
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * sets the city attribute
     *
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * returns the city attribute
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * sets the zip attribute
     *
     * @param string $zip
     */
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * returns the zip attribute
     *
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * sets the region attribute
     *
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * returns the region attribute
     *
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * sets the country attribute
     *
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * returns the country attribute
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Adds a FileReference
     *
     * @param FileReference $image
     */
    public function addImage(FileReference $image): void
    {
        $this->image->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param FileReference $imageToRemove The FileReference to be removed
     */
    public function removeImage(FileReference $imageToRemove): void
    {
        $this->image->detach($imageToRemove);
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getImage(): ?ObjectStorage
    {
        return $this->image;
    }

    /**
     * Get first image
     *
     * @return FileReference|null
     */
    public function getFirstImage(): ?FileReference
    {
        $images = $this->getImage();
        if ($images) {
            foreach ($images as $image) {
                return $image;
            }
        }

        return null;
    }

    /**
     * Sets the images
     *
     * @param ObjectStorage<FileReference> $image
     */
    public function setImage(ObjectStorage $image): void
    {
        $this->image = $image;
    }

    /**
     * sets the description attribute
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * returns the description attribute
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * returns the categories
     *
     * @return ?ObjectStorage<Category> $categories
     */
    public function getCategories(): ?ObjectStorage
    {
        return $this->categories;
    }

    /**
     * sets the categories
     *
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Get cleaned number of a given telephone, fax or mobile number.
     * It removes all chars which are not possible to enter on your cell phone.
     *
     * @param string $number
     * @return string
     */
    protected function getCleanedNumber(string $number): string
    {
        $number = trim($number);

        // Remove 0 on +49(0)221, but keep 0 on (0)221
        if (strpos($number, '(0)') > 0) {
            $number = str_replace('(0)', '', $number);
        }

        return preg_replace('/[^0-9#+*]/', '', $number);
    }

    /**
     * Get full name including title, first, middle and last name
     *
     * @return string
     */
    public function getFullName(): string
    {
        $list = [
            $this->getTitle(),
            $this->getFirstName(),
            $this->getMiddleName(),
            $this->getLastName(),
        ];
        return implode(' ', array_filter($list));
    }
}
