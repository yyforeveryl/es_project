<?php

namespace EasySwoole\DoctrineAnnotation\Tests\Fixtures;

use EasySwoole\DoctrineAnnotation\Tests\Fixtures\Annotation\Route;
use EasySwoole\DoctrineAnnotation\Tests\Fixtures\EmptyInterface;

/**
 * @Route("/someprefix")
 */
interface InterfaceThatExtendsAnInterface extends EmptyInterface
{
}
