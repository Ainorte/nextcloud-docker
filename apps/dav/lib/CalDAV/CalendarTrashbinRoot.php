<?php

declare(strict_types=1);

/*
 * @copyright 2021 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @author 2021 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace OCA\DAV\CalDAV;

use OCP\IConfig;
use OCP\IL10N;
use OCP\IUserSession;
use Sabre\CalDAV\CalendarRoot;
use Sabre\DAV\Exception\Forbidden;
use Sabre\DAVACL\PrincipalBackend\BackendInterface;
use function is_null;

class CalendarTrashbinRoot extends CalendarRoot {

	/** @var CalDavBackend */
	protected $customCaldavBackend;

	/** @var IUserSession */
	private $userSession;

	/** @var IL10N */
	private $l10n;

	/** @var IConfig */
	private $config;

	public function __construct(BackendInterface $principalBackend,
								CalDavBackend $caldavBackend,
								IUserSession $userSession,
								IL10N $l10n,
								IConfig $config,
								$principalPrefix = 'principals') {
		parent::__construct($principalBackend, $caldavBackend, $principalPrefix);

		$this->customCaldavBackend = $caldavBackend;
		$this->userSession = $userSession;
		$this->l10n = $l10n;
		$this->config = $config;
	}

	public function getChildForPrincipal(array $principal) {
		[, $name] = \Sabre\Uri\split($principal['uri']);
		$user = $this->userSession->getUser();
		if (is_null($user) || $name !== $user->getUID()) {
			throw new Forbidden();
		}
		return new CalendarTrashbinHome(
			$this->customCaldavBackend,
			$this->l10n,
			$this->config,
			$principal
		);
	}

	public function getName() {
		return 'calendars-trashbin';
	}
}
