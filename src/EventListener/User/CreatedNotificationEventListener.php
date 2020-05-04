<?php
/**
 * @author José Jaime Ramírez Calvo <mr.ljaime@gmail.com>
 * @version 0.1
 * @since 0.1
 */

namespace App\EventListener\User;

use App\Event\UserCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * class CreatedNotificationEventListener
 * @package App\EventListener\User
 */
class CreatedNotificationEventListener implements EventSubscriberInterface
{
    /**
     * @var MailerInterface
     */
    private $mailerInterface;

    /**
     * CreatedNotificationEventListener constructor.
     * @param MailerInterface $mailerInterface
     */
    public function __construct(MailerInterface $mailerInterface)
    {
        $this->mailerInterface = $mailerInterface;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            UserCreatedEvent::NAME  => 'onEventReceive',
        ];
    }

    /**
     * @param UserCreatedEvent $event
     */
    public function onEventReceive(UserCreatedEvent $event)
    {
        $email = new Email();
        $email
            ->from('mr.ljaime@gmail.com')
            ->addTo($event->getUser()->getEmail())
            ->subject('Welcome')
            ->text('Welcome to the event dispatcher tutorial')

        ;

        try {
            $this->mailerInterface->send($email);
        } catch (\Exception $exception) { // Catch exception because there's so much problems with gmail authentication to send email
        }
    }
}