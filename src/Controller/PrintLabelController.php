<?php
/**
 * Copyright since 2024 Axel Paillaud - Axelweb
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 *
 * @author    Axel Paillaud - Axelweb <contact@axelweb.fr>
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Axelweb\AwPrintLabel\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class PrintLabelController extends FrameworkBundleAdminController
{
    public function index(): Response
    {
        return $this->render('@Modules/awprintlabel/views/templates/admin/print-label.html.twig');
    }
}
