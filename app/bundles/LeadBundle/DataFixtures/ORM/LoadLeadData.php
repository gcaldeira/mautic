<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\LeadBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mautic\LeadBundle\Entity\LeadFieldValue;
use Mautic\CoreBundle\Entity\IpAddress;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Mautic\LeadBundle\Entity\Lead;

/**
 * Class LoadLeadData
 *
 * @package Mautic\LeadBundle\DataFixtures\ORM
 */
class LoadLeadData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $today = new \DateTime();

        $lead = new Lead();
        $ipAddress = new IpAddress();
        $ipAddress->setIpAddress("208.110.200.3", $this->container->get('mautic.factory')->getSystemParameters());
        $lead->addIpAddress($ipAddress);
        $lead->setOwner($this->getReference('sales-user'));
        $lead->setDateAdded($today);

        $fields = array(
            'firstname'  => "John",
            'lastname'   => "Smith",
            'company'    => "John's Bait and Tackle Shop",
            'email'      => "john@baitandtackleshop.com",
            'position'   => "Owner",
            'phone'      => "111-111-1111",
            'mobile'     => "222-222-2222",
            'fax'        => "333-333-3333",
            'address1'   => "1234 Bait and Tackle Rd",
            'address2'   => "",
            'city'       => "Galveston",
            'state'      => "TX",
            'zipcode'    => "77551",
            'country'    => "US",
            'website'    => "www.baitandtackleshop.com",
            'twitter'    => "jbaitme",
            'facebook'   => "jbaitme",
            'googleplus' => "jbaitme",
            'skype'      => "jbaitme"
        );

        foreach ($fields as $name => $value) {
            $fieldValue = new LeadFieldValue();
            $fieldValue->setField($this->getReference('leadfield-' . $name));
            $fieldValue->setValue($value);
            $fieldValue->setLead($lead);
            $lead->addField($fieldValue);
        }

        $manager->persist($lead);
        $this->setReference('lead1', $lead);

        $lead = new Lead();
        $lead->addIpAddress($ipAddress);
        $lead->setOwner($this->getReference('sales-user'));
        $lead->setDateAdded($today);

        $fields = array(
            'firstname' => "Jack",
            'lastname'  => "Smith",
            'company'   => "John's Bait and Tackle Shop",
            'email'     => "jack@baitandtackleshop.com",
            'position'  => "Sales Rep",
            'phone'     => "111-111-1111",
            'address1'  => "1234 Main St",
            'address2'  => "",
            'city'      => "Galveston",
            'state'     => "TX",
            'zipcode'   => "77551",
            'country'   => "US",
            'website'   => "www.baitandtackleshop.com",
        );

        foreach ($fields as $name => $value) {
            $fieldValue = new LeadFieldValue();
            $fieldValue->setField($this->getReference('leadfield-' . $name));
            $fieldValue->setValue($value);
            $fieldValue->setLead($lead);
            $lead->addfield($fieldValue);
        }

        $manager->persist($lead);
        $this->setReference('lead2', $lead);

        $lead = new Lead();
        $lead->addIpAddress($ipAddress);
        $lead->setOwner($this->getReference('admin-user'));
        $lead->setDateAdded($today);

        $fields = array(
            'firstname' => "Susie",
            'lastname'  => "Jane",
            'company'   => "Susie Jane's Cosmetics",
            'email'     => "susie@susiejanecosmetics.com",
            'position'  => "Sales Rep",
            'phone'     => "123-456-1111",
            'address1'  => "1234 Main St",
            'address2'  => "",
            'city'      => "Galveston",
            'state'     => "TX",
            'zipcode'   => "77551",
            'country'   => "US",
            'website'   => "susiejanecosmetics.com",
        );

        foreach ($fields as $name => $value) {
            $fieldValue = new LeadFieldValue();
            $fieldValue->setField($this->getReference('leadfield-' . $name));
            $fieldValue->setValue($value);
            $fieldValue->setLead($lead);
            $lead->addfield($fieldValue);
        }

        $manager->persist($lead);
        $this->setReference('lead3', $lead);

        $lead = new Lead();
        $lead->setDateAdded($today);
        $lead->addIpAddress($ipAddress);
        $lead->setOwner($this->getReference('admin-user'));
        $fields = array(
            'firstname' => "Jane",
            'lastname'  => "Doe",
            'company'   => "",
            'position'  => "",
            'email'     => "janedoe@example.com",
            'address1'  => "",
            'address2'  => "",
            'city'      => "",
            'state'     => "",
            'country'   => ""
        );

        foreach ($fields as $name => $value) {
            $fieldValue = new LeadFieldValue();
            $fieldValue->setField($this->getReference('leadfield-' . $name));
            $fieldValue->setValue($value);
            $fieldValue->setLead($lead);
            $lead->addfield($fieldValue);
        }

        $manager->persist($lead);
        $this->setReference('lead4', $lead);

        $lead = new Lead();
        $lead->setDateAdded($today);
        $lead->addIpAddress($ipAddress);
        $fields = array(
            'firstname' => "",
            'lastname'  => "",
            'company'   => "",
            'position'  => "",
            'email'     => "",
            'address1'  => "",
            'address2'  => "",
            'city'      => "",
            'state'     => "",
            'country'   => ""
        );

        foreach ($fields as $name => $value) {
            $fieldValue = new LeadFieldValue();
            $fieldValue->setField($this->getReference('leadfield-' . $name));
            $fieldValue->setValue($value);
            $fieldValue->setLead($lead);
            $lead->addfield($fieldValue);
        }

        $manager->persist($lead);
        $this->setReference('lead5', $lead);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }
}