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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class CreateAdminCommand extends ContainerAwareCommand
{
    /**
     * @var Adminstrator
     */
    private $admin;

    private $username   = "";
    private $firstname  = "";
    private $lastname   = "";
    private $email      = "";
    private $backemail  = "";
    private $birthday   = "";

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->admin = new Adminstrator();
    }

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
        $io = new SymfonyStyle($input, $output);

        $io->title("Welcome to the ChallengeMe Administrator Generator");
        $io->text("This command let you generate from the command line an administrator automatically.");
        $io->newLine();

        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        // Username
        $this->admin->setUsername("hamza");
        $question = new Question("<info>Username</info> [<comment>" . $this->admin->getUsername() . "</comment>]: ", null);
        $question
            ->setValidator(function($answer) {
                if (null === $answer) { throw new \RuntimeException("Username is mandatory"); }
                return $answer;
            })
            ->setMaxAttempts(2);
        $this->admin->setUsername($helper->ask($input, $output, $question));

        // Password
        $question = new Question("<info>Password: </info>", null);
        $question
            ->setValidator(function($answer) {
                if (trim($answer) == '') { throw new \RuntimeException("Password can not be empty");}
                return $answer;
            })
            ->setHiddenFallback(false)
            ->setHidden(true)
            ->setMaxAttempts(2);
        $this->admin->setPlainPassword($helper->ask($input, $output, $question));

        // Email
        $question = new Question("<info>Email</info> [<comment>" . $this->admin->getEmail() ."</comment>]: ", null);
        $question
            ->setValidator(function($answer) {
                if (null === $answer) { throw new \RuntimeException("Email is mandatory"); }
                return $answer;
            })
            ->setMaxAttempts(2);
        $this->admin->setEmail($helper->ask($input, $output, $question));

        // Firstname
        $question = new Question("<info>Firstname</info> [<comment>" . $this->admin->getInfoUser()->getFirstname() . "</comment>]: ", null);
        $this->admin->getInfoUser()->setFirstname($helper->ask($input, $output, $question));

        // Lastname
        $question = new Question("<info>Lastname</info> [<comment>" . $this->admin->getInfoUser()->getLastName() . "</comment>]: ", null);
        $this->admin->getInfoUser()->setLastName($helper->ask($input, $output, $question));

        // Email back
        $question = new Question("<info>Back email</info> [<comment>" . $this->admin->getEmailBack() ."</comment>]: ", null);
        $this->admin->setEmailBack($helper->ask($input, $output, $question));

        // Birthday
        $tempBirthday = $this->admin->getInfoUser()->getBirthday() == null ?
            $this->admin->getInfoUser()->getBirthday()->format('d-m-Y') : "";
        $output->writeln("<question>Birthday [" . $tempBirthday . "</comment>]: ");

        $question = new Question("\tBirthday year: ", null);
        $year = $helper->ask($input, $output, $question);

        $question = new Question("\tBirthday month: ", null);
        $month = $helper->ask($input, $output, $question);

        $question = new Question("\tBirthday month: ", null);
        $day = $helper->ask($input, $output, $question);

        if (null !== $year || null !== $month || null !== $day) {
            $this->admin->getInfoUser()->setBirthday(new \DateTime("$year-$month-$day"));
        }

        $input->setArgument("username", $this->admin->getUsername());
        $input->setArgument("password", $this->admin->getPlainPassword());
        $input->setArgument("email", $this->admin->getEmail());
    }
}