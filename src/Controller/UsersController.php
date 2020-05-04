<?php
/**
 * @author José Jaime Ramírez Calvo <mr.ljaime@gmail.com>
 * @version 0.1
 * @since 0.1
 */

namespace App\Controller;

use App\Entity\User;
use App\Event\UserCreatedEvent;
use App\Util\ArrayUtil;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Use to allow http server to make crud operations over users entity
 *
 * class UsersController
 * @package App\Controller
 *
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    /**
     * Use to create an user
     * @Route("/", methods={"POST"})
     *
     * @param EntityManagerInterface $em
     * @param EventDispatcher $eventDispatcher
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger,
        Request $request
    ) {
        /** @var array $requestContent */
        $requestContent = json_decode($request->getContent(), true);
        $email = ArrayUtil::safe($requestContent, 'email');
        $password = ArrayUtil::safe($requestContent, 'password');

        if (is_null($email)) {
            return $this->json([
                'code'  => Response::HTTP_BAD_REQUEST,
                'error' => 'Email field is required',
            ], Response::HTTP_BAD_REQUEST);
        }

        if (is_null($password)) {
            return $this->json([
                'code'  => Response::HTTP_BAD_REQUEST,
                'error' => 'The password field is required',
            ]);
        }

        /**
         * ************
         * BEGIN TRANSACTION
         * ************
         */
        $em->beginTransaction();
        try {
            $user = new User();
            $user
                ->setEmail($email)
                ->setPassword(password_hash($password, PASSWORD_BCRYPT))
            ;
            $em->persist($user);
            $em->flush();

            // Dispatch event just next is persisted on database
            $userCreatedEvent = new UserCreatedEvent($user);
            $eventDispatcher->dispatch($userCreatedEvent, UserCreatedEvent::NAME);

            /**
             * ************
             * COMMIT
             * ************
             */
            $em->commit();
        } catch (UniqueConstraintViolationException $exception) { // Just email is unique for now
            /**
             * ************
             * ROLLBACK
             * ************
             */
            $em->rollback();

            $logger->error($exception->getMessage());
            $logger->error($exception->getTraceAsString());

            return $this->json([
                'code'  => Response::HTTP_BAD_REQUEST,
                'error' => 'The email is registered yet'
            ], Response::HTTP_BAD_REQUEST);

        } catch (\Exception $exception) {
            /**
             * ************
             * ROLLBACK
             * ************
             */
            $em->rollback();

            $logger->error($exception->getMessage());
            $logger->error($exception->getTraceAsString());

            return $this->json([
                'code'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => "There's an internal server error. Contact admin",
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return $this->json([
            'code'  => Response::HTTP_CREATED,
            'data'  => $user,
        ], Response::HTTP_CREATED);
    }
}