<?php
/**
 * This file is a part of the Oseille framework
 *
 * @package Oseille\Db\Exception
 */
namespace Oseille\Db\Exception;

/**
 * Exception thrown if an argument does not match with the expected value.
 * This represents error in the program logic and should be detected at compile time.
 * This kind of exceptions should directly lead to a fix in the code.
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
}
