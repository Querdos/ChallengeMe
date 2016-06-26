<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/26/16
 * Time: 7:46 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Validator\Constraints;


use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UsernameExistsValidator extends ConstraintValidator
{
    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    /**
     * @var ModeratorManager $moderatorManager
     */
    private $moderatorManager;

    /**
     * @var RedactorManager $redactorManager
     */
    private $redactorManager;

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (
            // Check from admin repository
            null !== $this->adminManager->checkUsername($value) ||

            // Check from moderator repository
            null !== $this->moderatorManager->checkUsername($value) ||

            // Check from redactor repository
            null !== $this->redactorManager->checkUsername($value)
        ) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }

    /**
     * @param AdministratorManager $adminManager
     */
    public function setAdminManager($adminManager)
    {
        $this->adminManager = $adminManager;
    }

    /**
     * @param ModeratorManager $moderatorManager
     */
    public function setModeratorManager($moderatorManager)
    {
        $this->moderatorManager = $moderatorManager;
    }

    /**
     * @param RedactorManager $redactorManager
     */
    public function setRedactorManager($redactorManager)
    {
        $this->redactorManager = $redactorManager;
    }
}