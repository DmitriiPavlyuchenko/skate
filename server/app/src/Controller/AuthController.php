<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\User\UserSignUpDto;
use App\Normalizer\UserNormalizer;
use App\Service\UserSignUpService;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/auth")
 */
class AuthController extends BaseController
{
    private Serializer $serializer;
    private ValidatorInterface $validator;
    private UserSignUpService $signUpService;
    private UserNormalizer $userNormalizer;


    public function __construct(
        ValidatorInterface $validator,
        UserSignUpService $signUpService,
        UserNormalizer $userNormalizer
    ) {
        $this->serializer = new Serializer(
            [
                new ArrayDenormalizer(),
                new ObjectNormalizer(null, null, null, new ReflectionExtractor()),
            ],
            [new JsonEncoder()]
        );
        $this->validator = $validator;
        $this->signUpService = $signUpService;
        $this->userNormalizer = $userNormalizer;
    }

    #[Route('/sign_up', name: 'sign_up', methods: [Request::METHOD_POST])]
    public function signUp(Request $request): JsonResponse
    {
        try {
            $rawData = $request->getContent();

            if (!$rawData) {
                throw new BadRequestHttpException("request is empty");
            }

            $userSignUpDto = $this->serializer->deserialize($rawData, UserSignUpDto::class, 'json');
            $violations = $this->validator->validate($userSignUpDto);
            if ($violations->count() > 0) {
                return $this->badRequest($violations);
            }
            $user = $this->signUpService->signUp($userSignUpDto);

            return new JsonResponse(
                $this->userNormalizer->normalize($user, 'json'),
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return new JsonResponse(["errors" => [$exception->getMessage()]], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/sign_in', name: 'sign_in', methods: [Request::METHOD_POST])]
    public function signIn(UserInterface $user, JWTTokenManagerInterface $JWTTokenManager): JsonResponse
    {
        return new JsonResponse(['token' =>$JWTTokenManager->create($user)]);
    }
}
