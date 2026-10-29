<?php

namespace App\EventSubscriber;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class LogoutEventSubscriber implements EventSubscriberInterface
{
	
	  public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
		$this->urlGenerator = $urlGenerator;
    }

	
	
    public function onLogoutEvent(LogoutEvent $event): void
    {
       // dd($event);
	   $event->getRequest()->getSession()->getFlashBag()->add(
	   'success'
	   ,'logged Out successefully');
	   $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_home')));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
