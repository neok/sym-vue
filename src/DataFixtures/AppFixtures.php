<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Organizer;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AppFixtures extends Fixture
{


    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@gmail.com');
        $pass = $this->hasher->hashPassword($user, 'strange!');
        $user->setPassword($pass);
        $manager->persist($user);
        // Create Organizers
        $organizer1 = new Organizer();
        $organizer1->setName('Organizer One');
        $organizer1->setEmail('organizer1@example.com');
        $manager->persist($organizer1);

        $organizer2 = new Organizer();
        $organizer2->setName('Organizer Two');
        $organizer2->setEmail('organizer2@example.com');
        $manager->persist($organizer2);

        // Create Events
        $event1 = new Event();
        $event1->setName('Event One');
        $event1->setDate(new \DateTime('2024-08-15'));
        $event1->setLocation('Location One');
        $event1->setOrganizer($organizer1);
        $manager->persist($event1);

        $event2 = new Event();
        $event2->setName('Event Two');
        $event2->setDate(new \DateTime('2024-09-10'));
        $event2->setLocation('Location Two');
        $event2->setOrganizer($organizer1);
        $manager->persist($event2);

        $event3 = new Event();
        $event3->setName('Event Three');
        $event3->setDate(new \DateTime('2024-10-05'));
        $event3->setLocation('Location Three');
        $event3->setOrganizer($organizer2);
        $manager->persist($event3);

        // Create Tickets
        $ticket1 = new Ticket();
        $ticket1->setName('VIP Ticket');
        $ticket1->setPrice('100.00');
        $ticket1->setQuantity(50);
        $ticket1->setEvent($event1);
        $manager->persist($ticket1);

        $ticket2 = new Ticket();
        $ticket2->setName('General Admission');
        $ticket2->setPrice('50.00');
        $ticket2->setQuantity(200);
        $ticket2->setEvent($event1);
        $manager->persist($ticket2);

        $ticket3 = new Ticket();
        $ticket3->setName('VIP Ticket');
        $ticket3->setPrice('120.00');
        $ticket3->setQuantity(30);
        $ticket3->setEvent($event2);
        $manager->persist($ticket3);

        $ticket4 = new Ticket();
        $ticket4->setName('General Admission');
        $ticket4->setPrice('60.00');
        $ticket4->setQuantity(150);
        $ticket4->setEvent($event2);
        $manager->persist($ticket4);

        $ticket5 = new Ticket();
        $ticket5->setName('VIP Ticket');
        $ticket5->setPrice('150.00');
        $ticket5->setQuantity(20);
        $ticket5->setEvent($event3);
        $manager->persist($ticket5);

        $ticket6 = new Ticket();
        $ticket6->setName('General Admission');
        $ticket6->setPrice('70.00');
        $ticket6->setQuantity(100);
        $ticket6->setEvent($event3);
        $manager->persist($ticket6);

        // Flush to database
        $manager->flush();
    }
}
