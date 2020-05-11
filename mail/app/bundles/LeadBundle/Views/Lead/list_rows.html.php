<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>
        <?php foreach ($items as $item): ?>
            <?php /** @var \Mautic\LeadBundle\Entity\Lead $item */ ?>
            <?php //$item = $item->getitem(); ?>
            <tr<?php if (!empty($highlight)): echo ' class="warning"'; endif; ?>>
                <td>
                    <?php
                    /*$hasEditAccess = $security->hasEntityAccess(
                        $permissions['lead:leads:editown'],
                        $permissions['lead:leads:editother'],
                        $item->getPermissionUser()
                    );
*/
                    $custom = [];
                    //if ($hasEditAccess && !empty($currentList)) {
                        //this lead was manually added to a list so give an option to remove them
                        $custom[] = [
                            'attr' => [
                                'href' => $view['router']->path('mautic_segment_action', [
                                    'objectAction' => 'removeLead',
                                    'objectId'     => $currentList['id'],
                                    'leadId'       => $item['id_customer'],
                                ]),
                                'data-toggle' => 'ajax',
                                'data-method' => 'POST',
                            ],
                            'btnText'   => 'mautic.lead.lead.remove.fromlist',
                            'iconClass' => 'fa fa-remove',
                        ];
                    //}

                    if (!empty($item['email'])) {
                        $custom[] = [
                            'attr' => [
                                'data-toggle' => 'ajaxmodal',
                                'data-target' => '#MauticSharedModal',
                                'data-header' => $view['translator']->trans('mautic.lead.email.send_email.header', ['%email%' => $item['email']]),
                                'href'        => $view['router']->path('mautic_contact_action', ['objectId' => $item['id_customer'], 'objectAction' => 'email', 'list' => 1]),
                            ],
                            'btnText'   => 'mautic.lead.email.send_email',
                            'iconClass' => 'fa fa-send',
                        ];
                    }

                    echo $view->render('MauticCoreBundle:Helper:list_actions.html.php', [
                        'item'            => $item,
                        'templateButtons' => [
                            'edit'   => $hasEditAccess,
                            'delete' => $security->hasEntityAccess($permissions['lead:leads:deleteown'], $permissions['lead:leads:deleteother'], 1),
                        ],
                        'routeBase'     => 'contact',
                        'langVar'       => 'lead.lead',
                        'customButtons' => $custom,
                    ]);
                    ?>
                </td>
                <td>
                    <a href="<?php echo $view['router']->path('mautic_contact_action', ['objectAction' => 'view', 'objectId' => $item['id_customer']]); ?>" data-toggle="ajax">
                        <?php if (in_array($item['id_customer'], array_keys($noContactList)))  : ?>
                            <div class="pull-right label label-danger"><i class="fa fa-ban"> </i></div>
                        <?php endif; ?>
                        <div><?php echo $item['firstname']; ?> <?php echo $item['lastname']; ?></div>
                        <div class="small"></div>
                    </a>
                </td>
                <td class="visible-md visible-lg"><?php echo $view->escape($item['email']); ?></td>
                <td class="visible-md visible-lg">
                    <?php/*
                    $flag = (!empty($item['core']['country'])) ? $view['assets']->getCountryFlag($item['core']['country']['value']) : '';
                    if (!empty($flag)):
                    ?>
                    <img src="<?php echo $flag; ?>" style="max-height: 24px;" class="mr-sm" />
                    <?php
                    endif;
                    $location = [];
                    if (!empty($item['core']['city']['value'])):
                        $location[] = $item['core']['city']['value'];
                    endif;
                    if (!empty($item['core']['state']['value'])):
                        $location[] = $item['core']['state']['value'];
                    elseif (!empty($item['core']['country']['value'])):
                        $location[] = $item['core']['country']['value'];
                    endif;
                    echo $view->escape(implode(', ', $location));*/
                    ?>
                    <div class="clearfix"></div>
                </td>
                <td class="text-center">
                    
                </td>
                <td class="visible-md visible-lg text-center">
                </td>
                <td class="visible-md visible-lg">
                    <abbr title="<?php echo $view['date']->toFull($item['date_upd']); ?>">
                        <?php echo $view['date']->toText($item['date_upd']); ?>
                    </abbr>
                </td>
                <td class="visible-md visible-lg"><?php echo $item['id_customer']; ?></td>
            </tr>
        <?php endforeach; ?>
