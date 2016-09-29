UPGRADE
=======

Upgrading from 0.2 to 0.3
-------------------------

* The requirements for `php-xapi/model` and `php-xapi/test-fixtures` have
  been bumped to `^1.0` to make use of their stable releases.

* The required version of the `php-xapi/repository-api` package has been
  raised to `^0.3`.

Upgrading from 0.1 to 0.2
-------------------------

* Moved base functional `StatementRepositoryTest` test case class to the
  `XApi\Repository\Doctrine\Test\Functional` namespace.

* The base namespace was changed from `Xabbuh\XApi\Storage\Doctrine` to
  `XApi\Repository\Doctrine`.
