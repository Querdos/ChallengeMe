<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/21/16
 * Time: 2:13 PM
 */

namespace Querdos\ChallengeMe\ConsoleBundle\Console;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

class ChallengeMeStyle implements StyleInterface {

    private $input;
    private $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input    = $input;
        $this->output   = $output;
    }

    /**
     * Formats a command title.
     *
     * @param string $message
     */
    public function title($message)
    {
        $style = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $this->output->getFormatter()->setStyle('fire', $style);
        
        $this->output->writeln("<fire>\n$message</fire>");
        $this->output->writeln("<fire></fire>");
    }

    /**
     * Formats a section title.
     *
     * @param string $message
     */
    public function section($message)
    {
        // TODO: Implement section() method.
    }

    /**
     * Formats a list.
     *
     * @param array $elements
     */
    public function listing(array $elements)
    {
        // TODO: Implement listing() method.
    }

    /**
     * Formats informational text.
     *
     * @param string|array $message
     */
    public function text($message)
    {
        // TODO: Implement text() method.
    }

    /**
     * Formats a success result bar.
     *
     * @param string|array $message
     */
    public function success($message)
    {
        // TODO: Implement success() method.
    }

    /**
     * Formats an error result bar.
     *
     * @param string|array $message
     */
    public function error($message)
    {
        // TODO: Implement error() method.
    }

    /**
     * Formats an warning result bar.
     *
     * @param string|array $message
     */
    public function warning($message)
    {
        // TODO: Implement warning() method.
    }

    /**
     * Formats a note admonition.
     *
     * @param string|array $message
     */
    public function note($message)
    {
        // TODO: Implement note() method.
    }

    /**
     * Formats a caution admonition.
     *
     * @param string|array $message
     */
    public function caution($message)
    {
        // TODO: Implement caution() method.
    }

    /**
     * Formats a table.
     *
     * @param array $headers
     * @param array $rows
     */
    public function table(array $headers, array $rows)
    {
        // TODO: Implement table() method.
    }

    /**
     * Asks a question.
     *
     * @param string $question
     * @param string|null $default
     * @param callable|null $validator
     *
     * @return string
     */
    public function ask($question, $default = null, $validator = null)
    {
        // TODO: Implement ask() method.
    }

    /**
     * Asks a question with the user input hidden.
     *
     * @param string $question
     * @param callable|null $validator
     *
     * @return string
     */
    public function askHidden($question, $validator = null)
    {
        // TODO: Implement askHidden() method.
    }

    /**
     * Asks for confirmation.
     *
     * @param string $question
     * @param bool $default
     *
     * @return bool
     */
    public function confirm($question, $default = true)
    {
        // TODO: Implement confirm() method.
    }

    /**
     * Asks a choice question.
     *
     * @param string $question
     * @param array $choices
     * @param string|int|null $default
     *
     * @return string
     */
    public function choice($question, array $choices, $default = null)
    {
        // TODO: Implement choice() method.
    }

    /**
     * Add newline(s).
     *
     * @param int $count The number of newlines
     */
    public function newLine($count = 1)
    {
        // TODO: Implement newLine() method.
    }

    /**
     * Starts the progress output.
     *
     * @param int $max Maximum steps (0 if unknown)
     */
    public function progressStart($max = 0)
    {
        // TODO: Implement progressStart() method.
    }

    /**
     * Advances the progress output X steps.
     *
     * @param int $step Number of steps to advance
     */
    public function progressAdvance($step = 1)
    {
        // TODO: Implement progressAdvance() method.
    }

    /**
     * Finishes the progress output.
     */
    public function progressFinish()
    {
        // TODO: Implement progressFinish() method.
    }
}