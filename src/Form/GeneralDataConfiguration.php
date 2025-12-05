<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    Axelweb <contact@axelweb.fr>
 * @copyright 2007-2024 Axelweb
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

declare(strict_types=1);

namespace Axelweb\AwPrintLabel\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class GeneralDataConfiguration implements DataConfigurationInterface
{
    public const AWPRINTLABEL_STATE_TO_UPDATE = 'AWPRINTLABEL_STATE_TO_UPDATE';
    public const AWPRINTLABEL_STATE_TO_CHECK = 'AWPRINTLABEL_STATE_TO_CHECK';

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration(): array
    {
        return [
            'state_to_update' => (int) $this->configuration->get(static::AWPRINTLABEL_STATE_TO_UPDATE),
            'state_to_check' => (int) $this->configuration->get(static::AWPRINTLABEL_STATE_TO_CHECK),
        ];
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        // Normalize values
        $stateToUpdate = isset($configuration['state_to_update']) ? (int) $configuration['state_to_update'] : 0;
        $stateToCheck = isset($configuration['state_to_check']) ? (int) $configuration['state_to_check'] : 0;

        if (!$this->validateConfiguration(['state_to_update' => $stateToUpdate, 'state_to_check' => $stateToCheck])) {
            $errors[] = 'Invalid configuration payload.';

            return $errors;
        }

        // Validate order states exist
        if ($stateToUpdate > 0) {
            $orderStateUpdate = new \OrderState($stateToUpdate);
            if (!\Validate::isLoadedObject($orderStateUpdate)) {
                $errors[] = 'Invalid order state to update.';
            }
        }

        if ($stateToCheck > 0) {
            $orderStateCheck = new \OrderState($stateToCheck);
            if (!\Validate::isLoadedObject($orderStateCheck)) {
                $errors[] = 'Invalid order state to check.';
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        // Persist
        $this->configuration->set(static::AWPRINTLABEL_STATE_TO_UPDATE, $stateToUpdate);
        $this->configuration->set(static::AWPRINTLABEL_STATE_TO_CHECK, $stateToCheck);

        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['state_to_update']) && isset($configuration['state_to_check']);
    }
}
