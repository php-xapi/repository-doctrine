CHANGELOG
=========

0.2.1
-----

* fixed namespace for base unit test case class `MappedStatementRepositoryTest`

0.2.0
-----

* moved base functional `StatementRepositoryTest` test case class to the
  `XApi\Repository\Doctrine\Test\Functional` namespace

* changed base namespace of all classes from `Xabbuh\XApi\Storage\Doctrine` to
  `XApi\Repository\Doctrine`

* added compatibility for version 0.2 of `php-xapi/repository-api`

0.1.0
-----

First release providing common functions for Doctrine based xAPI learning
record store backends.

This package replaces the `xabbuh/xapi-doctrine-storage` package which is now
deprecated and should no longer be used.
