<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 07/05/16
 * Time: 17:38
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Command;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Adminstrator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class CreateAdminCommand extends ContainerAwareCommand
{
    private $username   = "";
    private $firstname  = "";
    private $lastname   = "";
    private $email      = "";
    private $backemail  = "";
    private $birthday   = "";

    public function configure()
    {
        $this->setName("challengeme:generate:admin")
            ->setDescription("Generate administrator user to persist in the database")

            ->addArgument("username", InputArgument::REQUIRED, "Username for the administrator")
            ->addArgument("password", InputArgument::REQUIRED, "Password for the administrator")
            ->addArgument("email", InputArgument::REQUIRED, "Email for the administrator")

            ->addOption("firstname", "fn", null, "Firstname for the administrator", null)
            ->addOption("lastname", "ln", null, "Lastname for the administrator")
            ->addOption("emailback", "emb", null, "Back email for the administrator")
            ->addOption("birthday", "b", null, "Birthday of the administrator");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        /** @var Adminstrator $admin */
        $admin = new Adminstrator();

        /** @var EncoderFactory $encoderFactory */
        $encoderFactory = $this->getContainer()->get('security.encoder_factory');

        /*$encoder = $encoderFactory->getEncoder($admin);
        $output->write($encoder->encodePassword('test', $admin->getSalt()));*/

        $question = new ConfirmationQuestion("Continue ? [Y/n] ", true);
        $continue = $helper->ask($input, $output, $question);
        if ($continue) {
            $output->writeln("Finished !");
        } else {
            $this->interact($input, $output);
        }
    }

    public function interact(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        // Username
        $question = new Question("Username [$this->username]: ", null);
        $question
            ->setValidator(function($answer) {
                if (null === $answer) { throw new \RuntimeException("Username is mandatory"); }
                return $answer;
            })
            ->setMaxAttempts(2);
        $this->username = $helper->ask($input, $output, $question);
        $input->setArgument('username', $this->username);

        // Password
        $question = new Question("Password: ", null);
        $question
            ->setValidator(function($answer) {
                if (trim($answer) == '') { throw new \RuntimeException("Password can not be empty");}
                return $answer;
            })
            ->setHiddenFallback(false)
            ->setHidden(true)
            ->setMaxAttempts(2);
        $plainPassword = $helper->ask($input, $output, $question);
        $input->setArgument('password', $plainPassword);

        // Email
        $question = new Question("Email [$this->email]: ", null);
        $question
            ->setValidator(function($answer) {
                if (null === $answer) { throw new \RuntimeException("Email is mandatory"); }
                return $answer;
            })
            ->setMaxAttempts(2);
        $this->email = $helper->ask($input, $output, $question);
        $input->setArgument('email', $this->email);

        // Firstname
        $question = new Question("Firstname [$this->firstname]: ", null);
        $this->firstname = $helper->ask($input, $output, $question);
        $input->setOption('firstname', $this->firstname);

        // Lastname
        $question = new Question("Lastname [$this->lastname]: ", null);
        $this->lastname = $helper->ask($input, $output, $question);
        $input->setOption('lastname', $this->lastname);

        // Email back
        $question = new Question("Back email [$this->backemail]: ", null);
        $this->backemail = $helper->ask($input, $output, $question);
        $input->setOption('emailback', $this->backemail);

        // Birthday
        $output->writeln("Birthday [$this->birthday]: ");

        $question = new Question("\tBirthday year: ", null);
        $year = $helper->ask($input, $output, $question);

        $question = new Question("\tBirthday month: ", null);
        $month = $helper->ask($input, $output, $question);

        $question = new Question("\tBirthday month: ", null);
        $day = $helper->ask($input, $output, $question);

        if (null !== $year || null !== $month || null !== $day) {
            $this->birthday = new \DateTime("$year-$month-$day");
        }
        $input->setOption('birthday', $this->birthday);
    }
}