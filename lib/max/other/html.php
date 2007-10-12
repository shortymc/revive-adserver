<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

function MAX_getDisplayName($name, $length = 60, $append = '...')
{
    $displayName = strlen($name) > $length ? rtrim(substr($name, 0, $maxLen-strlen($append))) . $append : $name;
    if (empty($displayName)) {
        $displayName = $GLOBALS['strUntitled'];
    }
    return $displayName;
}

function MAX_buildName($id, $name)
{
    return "<span dir='{$GLOBALS['phpAds_TextDirection']}'>[id$id]</span> $name";
}

function MAX_getEntityIcon($entity, $active=true, $type='')
{
    include_once MAX_PATH . '/www/admin/lib-zones.inc.php';

    $icon = '';
    switch ($entity) {
        case 'advertiser' : $icon = $active ? 'images/icon-advertiser.gif' : 'images/icon-advertiser-d.gif'; break;
        case 'placement'  : $icon = $active ? 'images/icon-campaign.gif' : 'images/icon-campaign-d.gif'; break;
        case 'publisher'  : $icon = 'images/icon-affiliate.gif'; break;
        case 'ad' :
            switch ($type) {
                case 'html' : $icon = $active ? 'images/icon-banner-html.gif' : 'images/icon-banner-html-d.gif'; break;
                case 'txt'  : $icon = $active ? 'images/icon-banner-text.gif' : 'images/icon-banner-text-d.gif'; break;
                case 'url'  : $icon = $active ? 'images/icon-banner-url.gif' : 'images/icon-banner-url-d.gif'; break;
                case 'web'  : $icon = $active ? 'images/icon-banner-stored.gif' : 'images/icon-banner-stored-d.gif'; break;
                default     : $icon = $active ? 'images/icon-banner-stored.gif' : 'images/icon-banner-stored-d.gif'; break;
            }
            break;
        case 'zone'       :
            switch ($type) {
                case phpAds_ZoneBanner       : $icon = 'images/icon-zone.gif'; break;
                case phpAds_ZoneInterstitial : $icon = 'images/icon-interstitial.gif'; break;
                case phpAds_ZonePopup        : $icon = 'images/icon-popup.gif'; break;
                case phpAds_ZoneText         : $icon = 'images/icon-textzone.gif'; break;
                case MAX_ZoneEmail           : $icon = 'images/icon-zone-email.gif'; break;
                case MAX_ZoneClick           : $icon = 'images/icon-zone-click.gif'; break;
                default                      : $icon = 'images/icon-zone.gif'; break;
            }
            break;
    }
    return $icon;
}

function MAX_displayZoneHeader($pageName, $listorder, $orderdirection, $entityIds=null, $anonymous=false)
{
    global $phpAds_TextAlignRight;
    $column1 = _getHtmlHeaderColumn($GLOBALS['strName'], 'name', $pageName, $entityIds, $listorder, $orderdirection);
    $column2 = _getHtmlHeaderColumn($GLOBALS['strID'], 'id', $pageName, $entityIds, $listorder, $orderdirection, ($anonymous == false));
    $column3 = _getHtmlHeaderColumn($GLOBALS['strDescription'], 'description', $pageName, $entityIds, $listorder, $orderdirection);
    echo "
    <tr height='1'>
        <td><img src='images/spacer.gif' width='300' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td width='100%'><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
    </tr>
    <tr height='25'>
        <td>$column1</td>
        <td>$column2</td>
        <td>$column3</td>
    </tr>
    <tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

function MAX_displayStatsHeader($pageName, $listorder, $orderdirection, $entityIds=null, $anonymous=false)
{
    global $phpAds_TextAlignRight;
    $column1 = _getHtmlHeaderColumn($GLOBALS['strName'], 'name', $pageName, $entityIds, $listorder, $orderdirection);
    $column2 = _getHtmlHeaderColumn($GLOBALS['strID'], 'id', $pageName, $entityIds, $listorder, $orderdirection, ($anonymous == false));
    $column3 = _getHtmlHeaderColumn($GLOBALS['strRequests'], 'sum_requests', $pageName, $entityIds, $listorder, $orderdirection);
    $column4 = _getHtmlHeaderColumn($GLOBALS['strImpressions'], 'sum_views', $pageName, $entityIds, $listorder, $orderdirection);
    $column5 = _getHtmlHeaderColumn($GLOBALS['strClicks'], 'sum_clicks', $pageName, $entityIds, $listorder, $orderdirection);
    $column6 = _getHtmlHeaderColumn($GLOBALS['strCTRShort'], 'ctr', $pageName, $entityIds, $listorder, $orderdirection);
    $column7 = _getHtmlHeaderColumn($GLOBALS['strConversions'], 'sum_conversions', $pageName, $entityIds, $listorder, $orderdirection);
    $column8 = _getHtmlHeaderColumn($GLOBALS['strCNVRShort'], 'cnvr', $pageName, $entityIds, $listorder, $orderdirection);
    echo "
    <tr height='1'>
        <td><img src='images/spacer.gif' width='200' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
    </tr>
    <tr height='25'>
        <td width='30%'>$column1</td>
        <td align='$phpAds_TextAlignRight'>$column2</td>
        <td align='$phpAds_TextAlignRight'>$column3</td>
        <td align='$phpAds_TextAlignRight'>$column4</td>
        <td align='$phpAds_TextAlignRight'>$column5</td>
        <td align='$phpAds_TextAlignRight'>$column6</td>
        <td align='$phpAds_TextAlignRight'>$column7</td>
        <td align='$phpAds_TextAlignRight'>$column8</td>
    </tr>
    <tr height='1'><td colspan='8' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

function MAX_displayStatsHistoryHeader($pageName, $listorder, $orderdirection, $entityIds=null)
{
    global $phpAds_TextAlignRight;
    $column1 = _getHtmlHeaderColumn($GLOBALS['strDays'], 'name', $pageName, $entityIds, $listorder, $orderdirection);
    $column2 = _getHtmlHeaderColumn($GLOBALS['strImpressions'], 'sum_views', $pageName, $entityIds, $listorder, $orderdirection);
    $column3 = _getHtmlHeaderColumn($GLOBALS['strClicks'], 'sum_clicks', $pageName, $entityIds, $listorder, $orderdirection);
    $column4 = _getHtmlHeaderColumn($GLOBALS['strCTRShort'], 'ctr', $pageName, $entityIds, $listorder, $orderdirection);
    $column5 = _getHtmlHeaderColumn($GLOBALS['strConversions'], 'sum_conversions', $pageName, $entityIds, $listorder, $orderdirection);
    $column6 = _getHtmlHeaderColumn($GLOBALS['strCNVRShort'], 'cnvr', $pageName, $entityIds, $listorder, $orderdirection);
    echo "
        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr height='1'>
            <td><img src='images/spacer.gif' width='200' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        </tr>
        <tr height='25'>
            <td width='30%'>$column1</td>
            <td align='$phpAds_TextAlignRight'>$column2</td>
            <td align='$phpAds_TextAlignRight'>$column3</td>
            <td align='$phpAds_TextAlignRight'>$column4</td>
            <td align='$phpAds_TextAlignRight'>$column5</td>
            <td align='$phpAds_TextAlignRight'>$column6</td>
        </tr>
        <tr height='1'><td colspan='7' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
    ";
}

function MAX_displayNoStatsMessage()
{
    echo "
    <br /><br /><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>{$GLOBALS['strNoStats']}</div>";
}

function _getHtmlHeaderColumn($title, $name, $pageName, $entityIds, $listorder, $orderdirection, $showColumn = true)
{
    $str = '';
    $entity = _getEntityString($entityIds);
    if ($listorder == $name) {
        if (($orderdirection == '') || ($orderdirection == 'down')) {
            $str = "<a href='$pageName?{$entity}orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
        } else {
            $str = "<a href='$pageName?{$entity}orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>";
        }
    }
    return $showColumn ? "<b><a href='$pageName?{$entity}listorder=$name'>$title</a>$str</b>" : '';
}

function _getEntityString($entityIds)
{
    $entity = '';
    if (!empty($entityIds)) {
        $entityArr = array();
        foreach ($entityIds as $entityId => $entityValue) {
            $entityArr[] = "$entityId=$entityValue";
        }
        $entity = implode('&',$entityArr) . '&';
    }

    return $entity;
}

function MAX_displayDateSelectionForm($period, $period_start, $period_end, $pageName, &$tabindex, $hiddenValues = null)
{
    global $tabindex;
    require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

    $oDaySpan =& FieldFactory::newField('day-span');
    $oDaySpan->_name = 'period';
    $oDaySpan->_autoSubmit = true;
    $oDaySpan->setValueFromArray(array('period_preset' => $period, 'period_start' => $period_start, 'period_end' => $period_end));
    $oDaySpan->_tabIndex = $tabindex;
    echo "
    <form id='period_form' name='period_form' action='$pageName'>";
    $oDaySpan->display();
    $tabindex = $oDaySpan->_tabIndex;
    echo "
    <input type='button' value='Go' onclick='return periodFormSubmit()' style='margin-left: 1em' tabindex='".$tabindex++."' />";
    _displayHiddenValues($hiddenValues);
    echo "
    </form>";
}

function _displayHiddenValues($hiddenValues)
{
    if (!empty($hiddenValues) && is_array($hiddenValues)) {
        foreach ($hiddenValues as $name => $value) {
            echo "
    <input type='hidden' name='$name' value='$value'>";
        }
    }
}

function MAX_displayPeriodSelectionForm($period, $pageName, &$tabindex, $hiddenValues = null)
{
    global $phpAds_TextDirection;

    echo "
    <form action='$pageName'>
    <select name='period' onChange='this.form.submit();' tabindex='". $tabindex++ ."'>
        <option value='daily'".($period == 'daily' ? ' selected' : '').">{$GLOBALS['strDailyHistory']}</option>
        <option value='w'".($period == 'weekly' ? ' selected' : '').">{$GLOBALS['strWeeklyHistory']}</option>
        <option value='m'".($period == 'monthly' ? ' selected' : '').">{$GLOBALS['strMonthlyHistory']}</option>
    </select>
    &nbsp;&nbsp;
    <input type='image' src='images/$phpAds_TextDirection/go_blue.gif' border='0' name='submit'>
    &nbsp;";
    _displayHiddenValues($hiddenValues);
    echo "
    </form>
    ";
}

function MAX_displayHistoryStatsDaily($aHistoryStats, $aTotalHistoryStats, $pageName, $hiddenValues = null)
{
    $i = 0;
    $entity = _getEntityString($hiddenValues);
    foreach ($aHistoryStats as $day => $stats) {
        $bgColor = ($i++ % 2 == 0) ? '#F6F6F6' : '#FFFFFF';
        $views = phpAds_formatNumber($stats['sum_views']);
        $clicks = phpAds_formatNumber($stats['sum_clicks']);
        $conversions = phpAds_formatNumber($stats['sum_conversions']);
        $ctr = phpAds_buildRatioPercentage($stats['sum_clicks'], $stats['sum_views']);
        $cnvr = phpAds_buildRatioPercentage($stats['sum_conversions'], $stats['sum_clicks']);
        echo "
        <tr height='25' bgcolor='$bgColor'>
            <td>&nbsp;<img src='images/icon-date.gif' align='absmiddle' alt=''>&nbsp;<a href='$pageName?{$entity}'>$day</a></td>
            <td align='right'>$views</td>
            <td align='right'>$clicks</td>
            <td align='right'>$ctr</td>
            <td align='right'>$conversions</td>
            <td align='right'>$cnvr</td>
        </tr>
        <tr><td height='1' colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>
        ";
    }
    echo "
    </table>";
}

function MAX_displayPublisherZoneStats($aParams, $pageName, $anonymous, $aNodes, $expand, $listorder, $orderdirection, $hideinactive, $showPublisher, $entityIds)
{
    global $phpAds_TextAlignLeft, $phpAds_TextAlignRight, $phpAds_TextDirection;

    // Get the icons for all levels (publisher/zone)
    $entity = _getEntityString($entityIds);
    $publishersHidden = 0;

    $aPublishers = Admin_DA::fromCache('getPublishersStats', $aParams);
    if (!empty($aPublishers)) {
        echo "
        <br /><br />
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        MAX_displayStatsHeader($pageName, $listorder, $orderdirection, $entityIds);

        // Variable to determine if the row should be grey or white...
        $i=0;

        // Loop through publishers
        $totalRequests = 0;
        $totalViews = 0;
        $totalClicks = 0;
        $totalConversions = 0;
        MAX_sortArray($aPublishers, ($listorder == 'id' ? 'publisher_id' : $listorder), $orderdirection == 'up');
        foreach($aPublishers as $publisherId => $publisher) {
            $publisherRequests = phpAds_formatNumber($publisher['sum_requests']);
            $publisherViews = phpAds_formatNumber($publisher['sum_views']);
            $publisherClicks = phpAds_formatNumber($publisher['sum_clicks']);
            $publisherConversions = phpAds_formatNumber($publisher['sum_conversions']);
            $publisherCtr = phpAds_buildRatioPercentage($publisher['sum_clicks'], $publisher['sum_views']);
            $publisherSr = phpAds_buildRatioPercentage($publisher['sum_conversions'], $publisher['sum_clicks']);
            $publisherExpanded = MAX_isExpanded($publisherId, $expand, $aNodes, 'p');
            $publisherActive = true;
            $publisherIcon = MAX_getEntityIcon('publisher', $publisherActive);

            if (!$hideinactive || $publisherActive) {
                $bgcolor = ($i++ % 2 == 0) ? " bgcolor='#F6F6F6'" : '';
                echo "
            <tr height='25'$bgcolor>
                <td>";
                if (!empty($publisher['num_children'])) {
                    if ($publisherExpanded)
                        echo "&nbsp;<a href='$pageName?{$entity}collapse=p$publisherId'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
                    else
                        echo "&nbsp;<a href='$pageName?{$entity}expand=p$publisherId'><img src='images/$phpAds_TextDirection/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
                }
                else
                    echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";

                echo "
                    <img src='$publisherIcon' align='absmiddle'>&nbsp;
                    <a href='stats.php?entity=affiliate&breakdown=history&affiliateid=$publisherId'>{$publisher['name']}</a>
                </td>";
                if ($anonymous) {
                    echo "
                <td align='$phpAds_TextAlignRight'>&nbsp;</td>";
                } else {
                    echo "
                <td align='$phpAds_TextAlignRight'>$publisherId</td>";
                    }
                    echo "
                <td align='$phpAds_TextAlignRight'>$publisherRequests</td>
                <td align='$phpAds_TextAlignRight'>$publisherViews</td>
                <td align='$phpAds_TextAlignRight'>$publisherClicks</td>
                <td align='$phpAds_TextAlignRight'>$publisherCtr</td>
                <td align='$phpAds_TextAlignRight'>$publisherConversions</td>
                <td align='$phpAds_TextAlignRight'>$publisherSr</td>
            </tr>";

                if (!empty($publisher['num_children']) && $publisherExpanded) {
                    echo "
            <tr height='1'>
                <td$bgcolor><img src='images/spacer.gif' width='1' height='1'></td>
                <td colspan='8' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>
            </tr>";


                    // Loop through zones
                    $aZones = Admin_DA::fromCache('getZonesStats', $aParams);
                    MAX_sortArray($aZones, ($listorder == 'id' ? 'zone_id' : $listorder), $orderdirection == 'up');
                    foreach ($aZones as $zoneId => $zone) {
                        $zoneRequests = phpAds_formatNumber($zone['sum_requests']);
                        $zoneViews = phpAds_formatNumber($zone['sum_views']);
                        $zoneClicks = phpAds_formatNumber($zone['sum_clicks']);
                        $zoneConversions = phpAds_formatNumber($zone['sum_conversions']);
                        $zoneCtr = phpAds_buildRatioPercentage($zone['sum_clicks'], $zone['sum_views']);
                        $zoneSr = phpAds_buildRatioPercentage($zone['sum_conversions'], $zone['sum_clicks']);
                        $zoneActive = true;
                        $zoneIcon = MAX_getEntityIcon('zone', $zoneActive, $zone['type']);

                        echo "
            <tr height='25'$bgcolor>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;
                    <img src='$zoneIcon' align='absmiddle'>&nbsp;
                    <a href='stats.php?entity=zone&breakdown=history&affiliateid=$publisherId&zoneid=$zoneId'>{$zone['name']}</a>
                </td>
                <td align='$phpAds_TextAlignRight'>$zoneId</td>
                <td align='$phpAds_TextAlignRight'>$zoneRequests</td>
                <td align='$phpAds_TextAlignRight'>$zoneViews</td>
                <td align='$phpAds_TextAlignRight'>$zoneClicks</td>
                <td align='$phpAds_TextAlignRight'>$zoneCtr</td>
                <td align='$phpAds_TextAlignRight'>$zoneConversions</td>
                <td align='$phpAds_TextAlignRight'>$zoneSr</td>
            </tr>";
                    }
                }
                echo "
                <tr height='1'><td colspan='8' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
            } else {
                $publishersHidden++;
            }
            $totalRequests += $publisher['sum_requests'];
            $totalViews += $publisher['sum_views'];
            $totalClicks += $publisher['sum_clicks'];
            $totalConversions += $publisher['sum_conversions'];
        }

        // Total
        echo "
        <tr height='25'$bgcolor>
            <td>&nbsp;&nbsp;<b>{$GLOBALS['strTotal']}</b></td>
            <td>&nbsp;</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalRequests)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalViews)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalClicks)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_buildCTR($totalViews, $totalClicks)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalConversions)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_buildCTR($totalClicks, $totalConversions)."</td>
        </tr>
        <tr height='1'>
            <td colspan='8' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
        </tr>";
        if (!$anonymous) {
            $publisherIcon = MAX_getEntityIcon('publisher');
            echo "
        <tr>
            <td colspan='4' align='$phpAds_TextAlignLeft' nowrap>";

            if ($hideinactive == true) {
                echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=0'>{$GLOBALS['strShowAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;$publishersHidden {$GLOBALS['strInactivePublishersHidden']}";
            } else {
                echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=1'>{$GLOBALS['strHideInactivePublishers']}</a>";
            }

            echo "
            </td>
            <td colspan='4' align='$phpAds_TextAlignRight' nowrap><img src='images/triangle-d.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=all' accesskey='$keyExpandAll'>{$GLOBALS['strExpandAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<img src='images/$phpAds_TextDirection/triangle-l.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=none' accesskey='$keyCollapseAll'>{$GLOBALS['strCollapseAll']}</a>&nbsp;&nbsp;</td>
        </tr>
        <tr height='25'>";
            if ($showPublisher == 't') {
                echo "
            <td colspan='8' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='$publisherIcon' align='absmiddle'><a href='$pageName?{$entity}showpublisher=f'> Hide parent publisher</a></td>";
            } else {
                echo "
            <td colspan='8' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='$publisherIcon' align='absmiddle'><a href='$pageName?{$entity}showpublisher=t'> Show parent publisher</a></td>";
            }
            echo "
        </tr>";
        }
        echo "
        </table>
        <br /><br />";
    } else {
        MAX_displayNoStatsMessage();
    }
}

function MAX_displayZoneStats($aParams, $pageName, $anonymous, $aNodes, $expand, $listorder, $orderdirection, $hideinactive, $showPublisher, $entityIds)
{
    global $phpAds_TextAlignLeft, $phpAds_TextAlignRight, $phpAds_TextDirection;

    // Get the icons for all levels (publisher/zone)
    $entity = _getEntityString($entityIds);
    $publishersHidden = 0;

    $aZones = Admin_DA::fromCache('getZonesStats', $aParams);
    if (!empty($aZones)) {
        echo "
        <br /><br />
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        MAX_displayStatsHeader($pageName, $listorder, $orderdirection, $entityIds, $anonymous);

        // Variable to determine if the row should be grey or white...
        $i=0;
        $totalRequests = 0;
        $totalViews = 0;
        $totalClicks = 0;
        $totalConversions = 0;

        // Loop through publishers
        MAX_sortArray($aZones, ($listorder == 'id' ? 'zone_id' : $listorder), $orderdirection == 'up');
        foreach($aZones as $zoneId => $zone) {
            $zoneRequests = phpAds_formatNumber($zone['sum_requests']);
            $zoneViews = phpAds_formatNumber($zone['sum_views']);
            $zoneClicks = phpAds_formatNumber($zone['sum_clicks']);
            $zoneConversions = phpAds_formatNumber($zone['sum_conversions']);
            $zoneCtr = phpAds_buildRatioPercentage($zone['sum_clicks'], $zone['sum_views']);
            $zoneSr = phpAds_buildRatioPercentage($zone['sum_conversions'], $zone['sum_clicks']);
            $zoneActive = true;
            $zoneIcon = MAX_getEntityIcon('zone', $zoneActive, $zone['type']);

            if (!$hideinactive || $zoneActive) {
                $bgcolor = ($i++ % 2 == 0) ? " bgcolor='#F6F6F6'" : '';
                echo "
        <tr height='25'$bgcolor>
            <td>&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;
                <img src='$zoneIcon' align='absmiddle'>&nbsp;";
                if ($anonymous) {
                    echo "
                Hidden zone {$zone['id']}";
                } else {
                    echo "
                <a href='stats.php?entity=zone&breakdown=history&affiliateid={$zone['publisher_id']}'>{$zone['name']}</a>";
                }
                echo "
            </td>";
                if ($anonymous) {
                    echo "
            <td align='$phpAds_TextAlignRight'>&nbsp;</td>";
                } else {
                    echo "
            <td align='$phpAds_TextAlignRight'>$zoneId</td>";
                }
                echo "
            <td align='$phpAds_TextAlignRight'>$zoneRequests</td>
            <td align='$phpAds_TextAlignRight'>$zoneViews</td>
            <td align='$phpAds_TextAlignRight'>$zoneClicks</td>
            <td align='$phpAds_TextAlignRight'>$zoneCtr</td>
            <td align='$phpAds_TextAlignRight'>$zoneConversions</td>
            <td align='$phpAds_TextAlignRight'>$zoneSr</td>
        </tr>
        <tr height='1'><td colspan='8' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
            } else {
                $publishersHidden++;
            }
            $totalRequests += $zone['sum_requests'];
            $totalViews += $zone['sum_views'];
            $totalClicks += $zone['sum_clicks'];
            $totalConversions += $zone['sum_conversions'];
        }

        // Total
        echo "
        <tr height='25'$bgcolor>
            <td>&nbsp;&nbsp;<b>{$GLOBALS['strTotal']}</b></td>
            <td>&nbsp;</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalRequests)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalViews)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalClicks)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_buildCTR($totalViews, $totalClicks)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_formatNumber($totalConversions)."</td>
            <td align='$phpAds_TextAlignRight'>".phpAds_buildCTR($totalClicks, $totalConversions)."</td>
        </tr>
        <tr height='1'>
            <td colspan='8' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
        </tr>";
        if (!$anonymous) {
            echo "
        <tr>
            <td colspan='4' align='$phpAds_TextAlignLeft' nowrap>";

            if ($hideinactive == true) {
                echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=0'>{$GLOBALS['strShowAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;$publishersHidden {$GLOBALS['strInactivePublishersHidden']}";
            } else {
                echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=1'>{$GLOBALS['strHideInactivePublishers']}</a>";
            }

            echo "
            </td>
            <td colspan='4' align='$phpAds_TextAlignRight' nowrap><img src='images/triangle-d.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=all'>{$GLOBALS['strExpandAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<img src='images/$phpAds_TextDirection/triangle-l.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=none'>{$GLOBALS['strCollapseAll']}</a>&nbsp;&nbsp;</td>
        </tr>
        <tr height='25'>";
            if ($showPublisher == 't') {
                echo "
            <td colspan='7' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='images/icon-affiliate.gif' align='absmiddle'><a href='$pageName?{$entity}showpublisher=f'> Hide parent publisher</a></td>";
            } else {
                echo "
            <td colspan='7' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='images/icon-affiliate.gif' align='absmiddle'><a href='$pageName?{$entity}showpublisher=t'> Show parent publisher</a></td>";
            }
            echo "
        </tr>";
        }
        echo "
        </table>
        <br /><br />";
    } else {
        MAX_displayNoStatsMessage();
    }
}

function MAX_displayNavigationCampaign($pageName, $aOtherAdvertisers, $aOtherCampaigns, $aEntities)
{
    global $phpAds_TextDirection;

    $advertiserId = $aEntities['clientid'];
    $placementId = $aEntities['campaignid'];
    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['campaignid']);
    $otherEntityString = _getEntityString($aOtherEntities);
    $advertiserName = MAX_buildName($advertiserId, $aOtherAdvertisers[$advertiserId]['name']);

    // Determine which tab is highlighted
    if (phpAds_isUser(phpAds_Client)) {
        if ($pageName == 'campaign-banners.php') {
            $tabValue = "2.1";
        }
        $tabSections = array('2.1');
    } else {
        switch ($pageName) {
            case 'campaign-edit.php'     : $tabValue = '4.1.3.2'; break;
            case 'campaign-zone.php'     : $tabValue = '4.1.3.3'; break;
            case 'campaign-banners.php'  : $tabValue = '4.1.3.4'; break;
            case 'campaign-trackers.php' : $tabValue = '4.1.3.5'; break;
        }

    // Get the tab sections
    $tabSections = array('4.1.3.2', '4.1.3.3', '4.1.3.4', '4.1.3.5');
    }
    foreach ($aOtherCampaigns as $otherCampaignId => $aOtherCampaign) {
        $otherCampaignName = MAX_buildName($otherCampaignId, $aOtherCampaign['name']);
        $page = "{$pageName}?{$otherEntityString}campaignid={$otherCampaignId}&";
        if ($otherCampaignId == $placementId) {
            $current = true;

            // mask campaign name if anonymous campaign
            $campaign_details = Admin_DA::getPlacement($otherCampaignId);
            $otherCampaignName = MAX_buildName($placementId, MAX_getPlacementName($campaign_details));

            $campaignName = $otherCampaignName;

        } else {
            $current = false;
        }
        phpAds_PageContext($otherCampaignName, $page, $current);
    }

    if (!phpAds_isUser(phpAds_Client)) {
        phpAds_PageShortcut($GLOBALS['strClientProperties'], "advertiser-edit.php?clientid=$advertiserId", 'images/icon-advertiser.gif');
    }
    phpAds_PageShortcut($GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&$entityString", 'images/icon-statistics.gif');

    if (!phpAds_isUser(phpAds_Client)) {
    $extra  = "
    <form action='campaign-modify.php'>
    <input type='hidden' name='clientid' value='$advertiserId'>
    <input type='hidden' name='campaignid' value='$placementId'>
    <input type='hidden' name='returnurl' value='$pageName'>
    <br /><br />
    <b>{$GLOBALS['strModifyCampaign']}</b><br />
    <img src='images/break.gif' height='1' width='160' vspace='4'><br />
    <img src='images/icon-move-campaign.gif' align='absmiddle'>&nbsp;<a href='campaign-modify.php?duplicate=1&$entityString&returnurl=$pageName'>{$GLOBALS['strDuplicate']}</a><br />
    <img src='images/break.gif' height='1' width='160' vspace='4'><br />
    <img src='images/icon-move-campaign.gif' align='absmiddle'>&nbsp;{$GLOBALS['strMoveTo']}<br />
    <img src='images/spacer.gif' height='1' width='160' vspace='2'><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select name='newclientid' style='width: 110;'>";
        $aOtherAdvertisers = _multiSort($aOtherAdvertisers,'name','advertiser_id');
        foreach ($aOtherAdvertisers as $aOtherAdvertiser) {
            $otherAdvertiserId = $aOtherAdvertiser['advertiser_id'];
            $otherAdvertiserName = MAX_buildName($otherAdvertiserId, $aOtherAdvertiser['name']);
            if ($otherAdvertiserId != $advertiserId) {
                $extra .= "
    <option value='$otherAdvertiserId'>$otherAdvertiserName</option>";
            }
        }
        $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteCampaign']);
        $extra .= "
            </select>
            <input type='image' src='images/$phpAds_TextDirection/go_blue.gif'><br />
            <img src='images/break.gif' height='1' width='160' vspace='4'><br />
            <img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='campaign-delete.php?$entityString&returnurl=advertiser-campaigns.php'$deleteConfirm>{$GLOBALS['strDelete']}</a><br />
            </form>";
    }

    phpAds_PageHeader($tabValue, $extra);
    echo "
<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;$advertiserName&nbsp;<img src='images/$phpAds_TextDirection/caret-rs.gif'>&nbsp;
<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>$campaignName</b><br /><br /><br />";
    phpAds_ShowSections($tabSections);
}

function MAX_displayNavigationBanner($pageName, $aOtherCampaigns, $aOtherBanners, $aEntities)
{
    global $phpAds_TextDirection;

    $advertiserId = $aEntities['clientid'];
    $campaignId = $aEntities['campaignid'];
    $bannerId = $aEntities['bannerid'];
    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['bannerid']);
    $otherEntityString = _getEntityString($aOtherEntities);

    // Determine which tab is highlighted
    if (phpAds_isUser(phpAds_Client)) {
        switch ($pageName) {
            case 'banner-edit.php'   : $tabValue = '2.1.1'; break;
        }
        // Get the tab sections
        $tabSections = array('2.1.1');
    } else {
        // Get the tab sections
        $tabSections = array('4.1.3.4.2', '4.1.3.4.3', '4.1.3.4.4', '4.1.3.4.6');

        switch ($pageName) {
            case 'banner-zone.php'     : $tabValue = '4.1.3.4.4'; break;
            case 'banner-acl.php'      : $tabValue = '4.1.3.4.3'; break;
            case 'banner-edit.php'     :
                if (empty($bannerId)) {
                    $tabValue = '4.1.3.4.1';
                    $tabSections = array('4.1.3.4.1');
                } else {
                    $tabValue = '4.1.3.4.2';
                }
                break;
            case 'banner-advanced.php' : $tabValue = '4.1.3.4.6'; break;
        }
    }
    $bannerName = '';
    foreach ($aOtherBanners as $otherBannerId => $aOtherBanner) {

        // mask banner name if anonymous campaign
        $campaign = Admin_DA::getPlacement($aOtherBanner['placement_id']);
        $campaignAnonymous = $campaign['anonymous'] == 't' ? true : false;
        $aOtherBanner['name'] = MAX_getAdName($aOtherBanner['name'], null, null, $campaignAnonymous, $otherBannerId);

        $otherBannerName = phpAds_buildName($otherBannerId, $aOtherBanner['name']);

        $page = "{$pageName}?{$otherEntityString}bannerid={$otherBannerId}&";
        if ($otherBannerId == $bannerId) {
            $current = true;
            $bannerName = $otherBannerName;
        } else {
            $current = false;
        }
        phpAds_PageContext($otherBannerName, $page, $current);
    }

    if (MAX_Permission::isAllowed(phpAds_ModifyInfo)) {
        phpAds_PageShortcut($GLOBALS['strClientProperties'], "advertiser-edit.php?clientid=$advertiserId", 'images/icon-advertiser.gif');
    }
    if (!phpAds_isUser(phpAds_Client)) {
        phpAds_PageShortcut($GLOBALS['strCampaignProperties'], "campaign-edit.php?clientid=$advertiserId&campaignid=$campaignId", 'images/icon-campaign.gif');
    }
    phpAds_PageShortcut($GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&$entityString", 'images/icon-statistics.gif');

    $extra  = "
<form action='banner-modify.php'>
<input type='hidden' name='clientid' value='$advertiserId'>
<input type='hidden' name='campaignid' value='$campaignId'>
<input type='hidden' name='bannerid' value='$bannerId'>
<input type='hidden' name='returnurl' value='$pageName'>
<br /><br />
<b>{$GLOBALS['strModifyBanner']}</b><br />
<img src='images/break.gif' height='1' width='160' vspace='4'><br />
<img src='images/icon-duplicate-banner.gif' align='absmiddle'>&nbsp;<a href='banner-modify.php?duplicate=true&$entityString&returnurl=$pageName'>{$GLOBALS['strDuplicate']}</a><br />
<img src='images/break.gif' height='1' width='160' vspace='4'><br />
<img src='images/icon-move-banner.gif' align='absmiddle'>&nbsp;{$GLOBALS['strMoveTo']}<br />
<img src='images/spacer.gif' height='1' width='160' vspace='2'><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name='moveto' style='width: 110;'>";
    $aOtherCampaigns = _multiSort($aOtherCampaigns,'name','placement_id');
    foreach ($aOtherCampaigns as $otherCampaignId => $aOtherCampaign) {

        // mask campaign name if anonymous campaign
        $aOtherCampaign['name'] = MAX_getPlacementName($aOtherCampaign);

        $otherCampaignName = MAX_buildName($aOtherCampaign['placement_id'], $aOtherCampaign['name']);

        if ($aOtherCampaign['placement_id'] != $campaignId) {
            $extra .= "
<option value='" . $aOtherCampaign['placement_id'] . "'>$otherCampaignName</option>";
        } else {
            $campaignName = $otherCampaignName;
        }
    }
    $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteBanner']);
    $extra .= "
</select>
<input type='image' name='moveto' src='images/$phpAds_TextDirection/go_blue.gif'><br />
<img src='images/break.gif' height='1' width='160' vspace='4'><br />
        ";
    if ($pageName == 'banner-acl.php') {
        $extra .= "<img src='images/icon-duplicate-acl.gif' align='absmiddle'>&nbsp;{$GLOBALS['strApplyLimitationsTo']}<br />";
        $extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br />";
        $extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $extra .= "<select name='applyto' style='width: 110;'>";

        $aOtherBanners = _multiSort($aOtherBanners,'name','ad_id');
        foreach ($aOtherBanners as $idx => $aOtherBanner) {
            if ($aOtherBanner['ad_id'] != $bannerId) {
                $extra .= "<option value='{$aOtherBanner['ad_id']}'>" . MAX_buildName($aOtherBanner['ad_id'], $aOtherBanner['name']) . "</option>";
            }
        }
        $extra .= "</select>&nbsp;<input type='image' name='applyto' src='images/".$phpAds_TextDirection."/go_blue.gif'><br />";
        $extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br />";
    }
    if (!phpAds_isUser(phpAds_Client)) {
        $extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='banner-delete.php?$entityString&returnurl=campaign-banners.php'$deleteConfirm>{$GLOBALS['strDelete']}</a><br />";
    }
    $extra .= "</form>";
    $advertiserName = phpAds_getClientName($advertiserId);

    // Build ad preview
    if ($bannerId) {
        require_once (MAX_PATH . '/lib/max/Delivery/adRender.php');
        $aBanner = Admin_DA::getAd($bannerId);
        $aBanner['storagetype'] = $aBanner['type'];
        $aBanner['bannerid'] = $aBanner['ad_id'];
        $bannerCode = MAX_adRender($aBanner, 0, '', '', '', true, false, false);
    } else {
        $extra = '';
        $bannerCode = '';
    }
    phpAds_PageHeader($tabValue, $extra);
    echo "
<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;$advertiserName&nbsp;<img src='images/$phpAds_TextDirection/caret-rs.gif'>&nbsp;
<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;$campaignName&nbsp;<img src='images/$phpAds_TextDirection/caret-rs.gif'>&nbsp;
<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>$bannerName</b><br /><br />
$bannerCode<br /><br /><br /><br />";
    phpAds_ShowSections($tabSections);
}

function MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities)
{

    global $phpAds_TextDirection;

    $extra = '';
    $publisherId = $aEntities['affiliateid'];
    $zoneId = $aEntities['zoneid'];
    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['zoneid']);
    $otherEntityString = _getEntityString($aOtherEntities);
    $aPublisher = $aOtherPublishers[$publisherId];
    $publisherName = MAX_buildName($publisherId, $aPublisher['name']);
    $zoneName = (empty($zoneId)) ? $GLOBALS['strUntitled'] : MAX_buildName($zoneId, $aOtherZones[$zoneId]['name']);

    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        $tabSections = array('4.2.3.2', '4.2.3.6', '4.2.3.3', '4.2.3.4', '4.2.3.5');
        // Determine which tab is highlighted
        switch ($pageName) {
            case 'zone-include.php'    : $tabValue = '4.2.3.3'; break;
            case 'zone-edit.php'       :
                if (empty($zoneId)) {
                    $tabValue = '4.2.3.1';
                    $tabSections = array('4.2.3.1');
                } else {
                    $tabValue = '4.2.3.2';
                }
                break;
            case 'zone-advanced.php'    : $tabValue = '4.2.3.6'; break;
            case 'zone-probability.php' : $tabValue = '4.2.3.4'; break;
            case 'zone-invocation.php'  : $tabValue = '4.2.3.5'; break;
        }
    } elseif (phpAds_isUser(phpAds_Affiliate)) {
        $tabSections = array();
        if (phpAds_isAllowed(phpAds_EditZone)) { $tabSections[] = '2.1.1'; }
        if (phpAds_isAllowed(phpAds_LinkBanners)) { $tabSections[] = '2.1.2'; }
        $tabSections[] = '2.1.3';
        if (phpAds_isAllowed(MAX_AffiliateGenerateCode)) { $tabSections[] = '2.1.4'; }
        switch($pageName) {
            case 'zone-edit.php': $tabValue = '2.1.1'; if (empty($zoneId)) $tabSections = array('2.1.1'); break;
            case 'zone-include.php': $tabValue = '2.1.2'; break;
            case 'zone-probability.php': $tabValue = '2.1.3'; break;
            case 'zone-invocation.php': $tabValue = '2.1.4'; break;
        }
    }
    // Sort the zones by name...
    require_once(MAX_PATH . '/lib/max/other/stats.php');
    MAX_sortArray($aOtherZones, 'name');

    foreach ($aOtherZones as $otherZoneId => $aOtherZone) {
        $otherZoneName = MAX_buildName($otherZoneId, $aOtherZone['name']);
        $page = "{$pageName}?{$otherEntityString}zoneid={$otherZoneId}&";
        $current = ($otherZoneId == $zoneId) ? true : false;
        phpAds_PageContext($otherZoneName, $page, $current);
    }

    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isAllowed(phpAds_ModifyInfo)) {
        phpAds_PageShortcut($GLOBALS['strAffiliateProperties'], "affiliate-edit.php?affiliateid=$publisherId", 'images/icon-affiliate.gif');
    }
    phpAds_PageShortcut($GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&$entityString", 'images/icon-statistics.gif');

    if (!empty($zoneId) && (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || (phpAds_isAllowed(phpAds_EditZone) || phpAds_isAllowed(phpAds_DeleteZone) || phpAds_isAllowed(phpAds_AddZone)))) {
        $extra = "
            <form action='zone-modify.php'>
            <input type='hidden' name='affiliateid' value='$publisherId'>
            <input type='hidden' name='zoneid' value='$zoneId'>
            <input type='hidden' name='returnurl' value='$pageName'>
            <br /><br />
            ";
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isAllowed(phpAds_DeleteZone)) {
            $extra .= "<b>{$GLOBALS['strModifyZone']}</b><br />
            <img src='images/break.gif' height='1' width='160' vspace='4'><br />";
        }
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isAllowed(phpAds_AddZone)) {
                $extra .= "
                    <img src='images/icon-duplicate-zone.gif' align='absmiddle'>&nbsp;<a href='zone-modify.php?duplicate=true&$entityString&returnurl=$pageName'>{$GLOBALS['strDuplicate']}</a><br />
                    <img src='images/break.gif' height='1' width='160' vspace='4'><br />
                ";
        }
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $extra .= "
            <img src='images/icon-move-zone.gif' align='absmiddle'>&nbsp;{$GLOBALS['strMoveTo']}<br />
            <img src='images/spacer.gif' height='1' width='160' vspace='2'><br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <select name='newaffiliateid' style='width: 110;'>";
                $aOtherPublishers = _multiSort($aOtherPublishers,'name','publisher_id');
                foreach ($aOtherPublishers as $otherPublisherId => $aOtherPublisher) {
                    $otherPublisherName = MAX_buildName($aOtherPublisher['publisher_id'], $aOtherPublisher['name']);
                    if ($aOtherPublisher['publisher_id'] != $publisherId) {
                        $extra .= "
                <option value='" . $aOtherPublisher['publisher_id'] . "'>$otherPublisherName</option>";
                    }
                }
        }
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isAllowed(phpAds_DeleteZone)) {
            $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteZone']);
            $extra .= "
                </select>
                <input type='image' src='images/$phpAds_TextDirection/go_blue.gif'><br />
                <img src='images/break.gif' height='1' width='160' vspace='4'><br />
                <img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='zone-delete.php?$entityString&returnurl=affiliate-zones.php'$deleteConfirm>{$GLOBALS['strDelete']}</a><br />
            ";
        }
        $extra .= "</form>";
    }
    phpAds_PageHeader($tabValue, $extra);
    if (!phpAds_isUser(phpAds_Affiliate)) {
        echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;$publisherName&nbsp;<img src='images/$phpAds_TextDirection/caret-rs.gif'>&nbsp;";
    }
    echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>$zoneName</b><br /><br /><br />";
    phpAds_ShowSections($tabSections);

}

function MAX_displayNavigationPublisher($pageName, $aOtherPublishers, $aEntities)
{
    global $phpAds_TextDirection;

    $publisherId = $aEntities['affiliateid'];
    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['affiliateid']);
    $otherEntityString = _getEntityString($aOtherEntities);

    $tabSections = array('4.2.2', '4.2.3', '4.2.4', '4.2.5');

    // Determine which tab is highlighted
    switch ($pageName) {
        case 'affiliate-channels.php' : $tabValue = '4.2.4'; break;
    }

    // Sort the publishers by name...
    require_once(MAX_PATH . '/lib/max/other/stats.php');
    MAX_sortArray($aOtherPublishers, 'name');

    foreach ($aOtherPublishers as $otherPublisherId => $aOtherPublisher) {
        $otherPublisherName = MAX_buildName($otherPublisherId, $aOtherPublisher['name']);
        $page = "{$pageName}?{$otherEntityString}affiliateid={$otherPublisherId}&";
        if ($otherPublisherId == $publisherId) {
            $current = true;
            $publisherName = $otherPublisherName;
        } else {
            $current = false;
        }
        phpAds_PageContext($otherPublisherName, $page, $current);
    }

    phpAds_PageShortcut($GLOBALS['strAffiliateHistory'], 'stats.php?entity=affiliate&breakdown=history&affiliateid='.$publisherId, 'images/icon-statistics.gif');

    phpAds_PageHeader($tabValue, $extra = '');
    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>$publisherName</b><br /><br /><br />";
    phpAds_ShowSections($tabSections);
}

function MAX_displayNavigationChannel($pageName, $aOtherAgencies, $aOtherPublishers, $aOtherChannels, $aEntities)
{
    global $phpAds_TextDirection;

    $agencyId = isset($aEntities['agencyid']) ? $aEntities['agencyid'] : null;
    $publisherId = isset($aEntities['affiliateid']) ? $aEntities['affiliateid'] : null;
    $channelId = $aEntities['channelid'];

    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['channelid']);
    $otherEntityString = _getEntityString($aOtherEntities);

    if (!empty($publisherId)) {
        $channelType = 'publisher';
    } elseif (!empty($agencyId)) {
        $channelType = 'agency';
    } else {
        $channelType = 'admin';
    }

    // Determine which set of tabs to show...
    if ($channelType == 'publisher') {
        // Determine which tab is highlighted
        switch ($pageName) {
            case 'channel-edit.php' : $tabValue = (!empty($channelId)) ? '4.2.4.2' : '4.2.4.1'; break;
            case 'channel-acl.php' : $tabValue = '4.2.4.3'; break;
        }
        $tabSections = (!empty($channelId)) ? array('4.2.4.2', '4.2.4.3') : array('4.2.4.1');
    } else {
        // Determine which tab is highlighted
        if (phpAds_isUser(phpAds_Admin)) {
            if ($channelType == 'agency') {
                switch ($pageName) {
                    case 'channel-edit.php' : $tabValue = (!empty($channelId)) ? '5.5.3.2' : '5.5.3.1'; break;
                    case 'channel-acl.php' : $tabValue = '5.5.3.3'; break;
                }
                $tabSections = (!empty($channelId)) ? array('5.5.3.2', '5.5.3.3') : array('5.5.3.1');
            } else {
                switch ($pageName) {
                    case 'channel-edit.php' : $tabValue = (!empty($channelId)) ? '5.6.2' : '5.6.1'; break;
                    case 'channel-acl.php' : $tabValue = '5.6.3'; break;
                }
                $tabSections = (!empty($channelId)) ? array('5.6.2', '5.6.3') : array('5.6.1');
            }
        } else {
            switch ($pageName) {
                case 'channel-edit.php' : $tabValue = (!empty($channelId)) ? '5.2.2' : '5.2.1'; break;
                case 'channel-acl.php' : $tabValue = '5.2.3'; break;
            }
            $tabSections = (!empty($channelId)) ? array('5.2.2', '5.2.3') : array('5.2.1');
        }
    }

    // Sort the channels by name...
    require_once(MAX_PATH . '/lib/max/other/stats.php');
    MAX_sortArray($aOtherChannels, 'name');

    foreach ($aOtherChannels as $otherChannelId => $aOtherChannel) {
        $otherChannelName = MAX_buildName($otherChannelId, $aOtherChannel['name']);
        $page = "{$pageName}?{$otherEntityString}channelid={$otherChannelId}&";
        if ($otherChannelId == $channelId) {
            $current = true;
            $channelName = $otherChannelName;
        } else {
            $current = false;
        }
        phpAds_PageContext($otherChannelName, $page, $current);
    }

    if ($channelType == 'publisher') {
        phpAds_PageShortcut($GLOBALS['strAffiliateProperties'], "affiliate-edit.php?affiliateid=$publisherId", 'images/icon-affiliate.gif');
        phpAds_PageShortcut($GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid=$publisherId", 'images/icon-statistics.gif');
    }

    $extra  = "
<form action='channel-modify.php'>
<input type='hidden' name='affiliateid' value='$publisherId'>
<input type='hidden' name='channelid' value='$channelId'>
<input type='hidden' name='returnurl' value='$pageName'>
<br /><br />
<b>{$GLOBALS['strChannel']}</b><br />
<img src='images/break.gif' height='1' width='160' vspace='4'><br />
<img src='images/icon-duplicate-channel.gif' align='absmiddle'>&nbsp;<a href='channel-modify.php?duplicate=true&{$entityString}returnurl=$pageName'>{$GLOBALS['strDuplicate']}</a><br />";

    $deleteReturlUrl = '';
    if ($channelType == 'publisher') {
        $deleteReturlUrl = 'affiliate-channels.php';

        $extra .= "
<img src='images/break.gif' height='1' width='160' vspace='4'><br />
<img src='images/icon-move-channel.gif' align='absmiddle'>&nbsp;{$GLOBALS['strMoveTo']}<br />
<img src='images/spacer.gif' height='1' width='160' vspace='2'><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name='newaffiliateid' style='width: 110;'>";
        $aOtherPublishers = _multiSort($aOtherPublishers,'name','publisher_id');
        foreach ($aOtherPublishers as $otherPublisherId => $aOtherPublisher) {
            $otherPublisherName = MAX_buildName($otherPublisherId, $aOtherPublisher['name']);
            if ($otherPublisherId != $publisherId) {
                $extra .= "
<option value='$otherPublisherId'>$otherPublisherName</option>";
            } else {
                $publisherName = $otherPublisherName;
            }
        }

        $extra .= "
</select>
<input type='image' src='images/$phpAds_TextDirection/go_blue.gif'><br />";
    } elseif (phpAds_isUser(phpAds_Admin) && $channelType == 'agency') {
        $deleteReturlUrl = 'channel-index.php';

        $extra .= "
<img src='images/break.gif' height='1' width='160' vspace='4'><br />
<img src='images/icon-move-channel-agency.gif' align='absmiddle'>&nbsp;{$GLOBALS['strMoveTo']}<br />
<img src='images/spacer.gif' height='1' width='160' vspace='2'><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name='newagencyid' style='width: 110;'>";
        $aOtherAgencies = _multiSort($aOtherAgencies,'name','agency_id');
        foreach ($aOtherAgencies as $otherAgencyId => $aOtherAgency) {
            $otherAgencyName = MAX_buildName($otherAgencyId, $aOtherAgency['name']);
            if ($otherAgencyId != $agencyId) {
                $extra .= "
<option value='$otherAgencyId'>$otherAgencyName</option>";
            } else {
                $agencyName = $otherAgencyName;
            }
        }

        $extra .= "
</select>
<input type='image' src='images/$phpAds_TextDirection/go_blue.gif'><br />";
    }

    $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteChannel']);
    $extra .= "
<img src='images/break.gif' height='1' width='160' vspace='4'><br />
<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='channel-delete.php?{$entityString}returnurl={$deleteReturlUrl}'{$deleteConfirm}>{$GLOBALS['strDelete']}</a><br />
</form>";

    if (!empty($publisherId)) {
        // Determine which tab is highlighted
        if (!empty($channelId)) {
            phpAds_PageHeader($tabValue, $extra);
        } else {
            phpAds_PageHeader($tabValue);
            $channelName = $GLOBALS['strUntitled'];
        }
        $publisherName = phpAds_getAffiliateName($publisherId);
        echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;$publisherName&nbsp;<img src='images/$phpAds_TextDirection/caret-rs.gif'>&nbsp;";
    } else {
        if (!empty($channelId)) {
            phpAds_PageHeader($tabValue, $extra);
        } else {
            phpAds_PageHeader($tabValue);
            $channelName = $GLOBALS['strUntitled'];
        }
    }

    echo "<img src='images/icon-channel.gif' align='absmiddle'>&nbsp;<b>$channelName</b><br /><br /><br />";
    phpAds_ShowSections($tabSections);

}

function MAX_displayZoneEntitySelection($entity, $aOtherAdvertisers, $aOtherPlacements, $aOtherAds, $advertiserId, $placementId, $adId, $publisherId, $zoneId, $title, $pageName, &$tabIndex)
{
    echo "
<br />$title<br /><br />
<table cellpadding='0' cellspacing='0' border='0'>
<tr>";
    $aSavedEntities = array('affiliateid' => $publisherId, 'zoneid' => $zoneId);
    _displayZoneEntitySelectionCell('advertiser', $advertiserId, $aOtherAdvertisers, 'clientid', $aSavedEntities, ($entity != 'advertiser'), $pageName, $tabIndex);

    if (!empty($advertiserId) && $entity != 'advertiser') {
        $aSavedEntities['clientid'] = $advertiserId;
        _displayZoneEntitySelectionCell('placement', $placementId, $aOtherPlacements, 'campaignid', $aSavedEntities, ($entity != 'placement'), $pageName, $tabIndex);

        if (!empty($placementId) && $entity != 'placement') {
            $aSavedEntities['campaignid'] = $placementId;
            _displayZoneEntitySelectionCell('ad', $adId, $aOtherAds, 'bannerid', $aSavedEntities, ($entity != 'ad'), $pageName, $tabIndex);
        }
    }
    echo "
</tr>
</table>
<br /><br />";
}

function _displayZoneEntitySelectionCell($entity, $entityId, $aOtherEntities, $entityIdName, $aSavedEntities, $autoSubmit, $pageName, &$tabIndex)
{
    global $phpAds_TextDirection;

    $onChange = $autoSubmit ? " onChange='this.form.submit();'" : '';
    $submitIcon = $autoSubmit ? '' : "&nbsp;<input type='hidden' name='action' value='set'><input type='image' src='images/$phpAds_TextDirection/go_blue.gif' border='0' tabindex='".($tabIndex++)."'>";
    $tabInfo = " tabindex='" . ($tabIndex++) . "'";
    $entityIcon = MAX_getEntityIcon($entity);
    echo "
<form name='zonetypeselection' method='get' action='$pageName'>";
    foreach($aSavedEntities as $savedEntityName => $savedEntityId) {
        echo "
<input type='hidden' name='$savedEntityName' value='$savedEntityId'>";
    }
    echo "
<td>
    &nbsp;&nbsp;<img src='$entityIcon' align='absmiddle'>&nbsp;
    <select name='$entityIdName'{$onChange}{$tabInfo}>";
    // Show an empty value in the dropdown if none is selected
    if (empty($entityId)) {
        switch ($entity) {
            case 'advertiser' : $description = "-- {$GLOBALS['strSelectAdvertiser']} --"; break;
            case 'placement'  : $description = "-- {$GLOBALS['strSelectPlacement']} --"; break;
            case 'ad' : $description = "-- {$GLOBALS['strSelectAd']} --"; break;
            default : $description = '';
        }
        echo "
        <option value='' selected>$description</option>";
    }

    $aOtherEntities = _multiSort($aOtherEntities, 'name', 'advertiser_id');
    foreach ($aOtherEntities as $aOtherEntity) {
        switch ($entity) {
            case 'advertiser':
                $otherEntityId = $aOtherEntity['advertiser_id'];
                break;
            case 'placement':
                $otherEntityId = $aOtherEntity['placement_id'];
                break;
            case 'ad':
                $otherEntityId = $aOtherEntity['ad_id'];
                break;
        }
        $selected = $otherEntityId == $entityId ? ' selected' : '';

        if ($entity == 'placement') {
            $aParams = array('placement_id' => $otherEntityId);
            $aParams += MAX_getLinkedAdParams($GLOBALS['zoneId']);

            $adsCount = "(" . count(Admin_DA::getAds($aParams)) . ")";
        } else {
            $adsCount = '';
        }

        $name = MAX_buildName($otherEntityId, $aOtherEntity['name']);
        echo "
        <option value='$otherEntityId'{$selected}>$name $adsCount</option>";
    }
    echo "
    </select>
    $submitIcon
</td>
</form>";
}

function MAX_displayLinkedAdsPlacements($aParams, $publisherId, $zoneId, $hideInactive, $showParentPlacements, $pageName, &$tabIndex)
{
    global $phpAds_TextDirection, $phpAds_TextAlignRight;

    echo "
<table id='linked-banners' width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>
<tr height='25'>
<td width='40%'><b>&nbsp;&nbsp;{$GLOBALS['strName']}</b></td>
<td><b>{$GLOBALS['strID']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
<td>&nbsp;</td>
</tr>
<tr height='1'>
<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
</tr>";
    $i = 0;
    $inactive = 0;
    $aPlacements = !empty($aParams) ? Admin_DA::getPlacements($aParams) : array();
    foreach ($aPlacements as $placementId => $aPlacement) {
        $aAds = Admin_DA::getAds($aParams + array('placement_id' => $placementId), true);
        $placementActive = $aPlacement['active'] == 't';
        if (!$hideInactive || $placementActive) {
            $bgcolor = $i % 2 == 0 ? " bgcolor='#F6F6F6'" : '';
            if ($showParentPlacements) {
                $placementIcon = MAX_getEntityIcon('placement', $placementActive);
                $placementName = MAX_getDisplayName($aPlacement['name']);
                $placementLink = (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) ? "<a href='campaign-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId'>$placementName</a>" : $placementName;
                if ($i > 0) {
                    echo "
<tr height='1'>
<td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>
</tr>";
            }
            echo "
<tr height='25'$bgcolor>
<td>
    &nbsp;&nbsp;<img src='$placementIcon' align='absmiddle'>
    &nbsp;$placementLink
</td>
<td>$placementId</td>
<td>&nbsp;</td>
</tr>";
            }
            foreach ($aAds as $adId => $aAd) {
                $adActive = ($aAd['active'] == 't' && $aPlacement['active'] == 't');
                if (!$hideInactive || $adActive) {
                    $adIcon = MAX_getEntityIcon('ad', $adActive, $aAd['type']);
                    $adName = MAX_getDisplayName($aAd['name']);
                    $adLink = (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) ? "<a href='banner-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId&bannerid=$adId'>$adName</a>" : $adName;
                    $adWidth = $aAd['contenttype'] == 'txt' ? 300 : $aAd['width'] + 64;
                    $adHeight = $aAd['contenttype'] == 'txt' ? 200 : $aAd['height'] + (!empty($aAd['bannertext']) ? 90 : 64);
                    echo "
<tr height='1'>
<td$bgcolor><img src='images/spacer.gif' width='1' height='1'></td>
<td colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td>
</tr>
<tr height='25'$bgcolor>
<td>
    &nbsp;&nbsp;<a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&bannerid=$adId&action=remove'><img src='images/caret-l.gif' border='0' align='absmiddle'></a>
    &nbsp;&nbsp;&nbsp;&nbsp;<img src='$adIcon' align='absmiddle'>&nbsp;$adLink</td>
<td>$adId</td>
<td align='$phpAds_TextAlignRight'>
    <a href='banner-htmlpreview.php?bannerid=$adId' target='_new' onClick=\"return openWindow('banner-htmlpreview.php?bannerid=$adId', '', 'status=no,scrollbars=no,resizable=no,width=$adWidth,height=$adHeight');\"><img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;{$GLOBALS['strShowBanner']}</a>&nbsp;&nbsp;
</td>
</tr>";
                } else {
                    $inactive++;
                }
            }
            $i++;
        } else {
            $inactive += count($aAds);
        }
    }
    $showParentText = $showParentPlacements ? $GLOBALS['strHideParentCampaigns'] : $GLOBALS['strShowParentCampaigns'];
    $showParentValue = $showParentPlacements ? '0': '1';
    $hideInactiveText = $hideInactive ? $GLOBALS['strShowAll'] : $GLOBALS['strHideInactiveBanners'];
    $hideInactiveStats = $hideInactive ? "&nbsp;&nbsp;|&nbsp;&nbsp;$inactive {$GLOBALS['strInactiveBannersHidden']}" : '';
    $hideInactiveValue = $hideInactive ? '0' : '1';
    $hideInactiveIcon = $hideInactive ? 'images/icon-activate.gif' : 'images/icon-hideinactivate.gif';
    echo "
<tr height='1'>
<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
</tr>
<tr height='25'>
<td colspan='2'>
    <img src='$hideInactiveIcon' align='absmiddle' border='0'>
    <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&hideinactive=$hideInactiveValue'>$hideInactiveText</a>$hideInactiveStats
</td>
<td align='right'>
    <img src='images/icon-campaign-d.gif' align='absmiddle' border='0'>
    <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&showcampaigns=$showParentValue'>$showParentText</a>
</table>";
}

function MAX_displayLinkedPlacementsAds($aParams, $publisherId, $zoneId, $hideInactive, $showMatchingAds, $pageName, &$tabIndex, $directLinkedAds=false)
    {
        echo "
    <br /><strong>{$GLOBALS['strCampaignLinkedAds']}:</strong><br />
    <table id='linked-campaigns' width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>
    <tr height='25'>
        <td width='40%'><b>&nbsp;&nbsp;{$GLOBALS['strName']}</b></td>
        <td><b>{$GLOBALS['strID']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
        <td>&nbsp;</td>
    </tr>
    <tr height='1'>
        <td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
    </tr>";

        $i = 0;
        $inactive = 0;
        $aPlacements = (!empty($aParams)) ? Admin_DA::getPlacements($aParams) : array();
        foreach ($aPlacements as $placementId => $aPlacement) {
            $placementActive = $aPlacement['active'] == 't';
            if (!$hideInactive || $placementActive) {
                $pParams = $aParams;
                $pParams['placement_id'] = $placementId;
                $aAds = Admin_DA::getAds($pParams, true);
                $bgcolor = $i % 2 == 0 ? " bgcolor='#F6F6F6'" : '';
                // Remove these ad(s) from the direct linked ads
                foreach ($aAds as $dAdId) {
                    unset($directLinkedAds[$dAdId['ad_id']]);
                }

                // Remove from array any ads not linked to the zone.
                // These might exist if campaign has been linked to zone
                // and indivual ads have then been unlinked
                $pParams = array('zone_id' => $zoneId);
                $aAdZones = Admin_DA::getAdZones($pParams, true);
                $aAdZoneLinks = array();
                foreach($aAdZones as $aAdZone) {
                    $aAdZoneLinks[] = $aAdZone['ad_id'];
                }
                foreach($aAds as $adId => $aAd) {
                    if (!in_array($adId, $aAdZoneLinks)) {
                        unset($aAds[$adId]);
                    }
                }

                $placementIcon = MAX_getEntityIcon('placement', $placementActive);
                $placementName = MAX_getDisplayName($aPlacement['name']);
                $placementLink = (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) ? "<a href='campaign-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId'>$placementName</a>" : $placementName;
                $adCount = empty($aAds) ? 0 : count($aAds);
                $placementDescription = $showMatchingAds ? '&nbsp;' : str_replace('{count}', $adCount, $GLOBALS['strMatchingBanners']);
                if ($i > 0) {
                    echo "
    <tr height='1'>
        <td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>
    </tr>";
                }
                echo "
    <tr height='25'$bgcolor>
        <td>
            &nbsp;&nbsp;<a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&campaignid=$placementId&action=remove'><img src='images/caret-l.gif' border='0' align='absmiddle'></a>
            &nbsp;&nbsp;<img src='$placementIcon' align='absmiddle'>
            &nbsp;$placementLink
        </td>
        <td>$placementId</td>
        <td>$placementDescription</td>
    </tr>";
                if ($showMatchingAds && !empty($aAds)) {
                    foreach ($aAds as $adId => $aAd) {
                        $adActive = ($aAd['active'] == 't' && $aPlacement['active'] == 't');
                        if (!$hideInactive || $adActive) {
                            $adIcon = MAX_getEntityIcon('ad', $adActive, $aAd['type']);
                            $adName = MAX_getDisplayName($aAd['name']);
                            $adLink = (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) ? "<a href='banner-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId&bannerid=$adId'>$adName</a>" : $adName;
                            $adWidth = $aAd['contenttype'] == 'txt' ? 300 : $aAd['width'] + 64;
                            $adHeight = $aAd['contenttype'] == 'txt' ? 200 : $aAd['height'] + (!empty($aAd['bannertext']) ? 90 : 64);
                            echo "
    <tr height='1'>
        <td$bgcolor><img src='images/spacer.gif' width='1' height='1'></td>
        <td colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td>
    </tr>
    <tr height='25'$bgcolor>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='$adIcon' align='absmiddle'>&nbsp;$adLink</td>
        <td>$adId</td>
        <td align=".$GLOBALS['phpAds_TextAlignRight'].">
            <a href='banner-htmlpreview.php?bannerid=$adId' target='_new' onClick=\"return openWindow('banner-htmlpreview.php?bannerid=$adId', '', 'status=no,scrollbars=no,resizable=no,width=$adWidth,height=$adHeight');\"><img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;{$GLOBALS['strShowBanner']}</a>&nbsp;&nbsp;
        </td>
    </tr>";
                        } else {
                            $inactive++;
                        }
                    }
                }
                $i++;
            } else {
                $inactive++;
            }
        }
        $showMatchingText = $showMatchingAds ? $GLOBALS['strHideMatchingBanners'] : $GLOBALS['strShowMatchingBanners'];
        $showMatchingValue = $showMatchingAds ? '0' : '1';
        $hideInactiveText = $hideInactive ? $GLOBALS['strShowAll'] : $GLOBALS['strHideInactiveCampaigns'];
        $hideInactiveStats = $hideInactive ? "&nbsp;&nbsp;|&nbsp;&nbsp;$inactive {$GLOBALS['strInactiveCampaignsHidden']}" : '';
        $hideInactiveValue = $hideInactive ? '0' : '1';
        $hideInactiveIcon = $hideInactive ? 'images/icon-activate.gif' : 'images/icon-hideinactivate.gif';
        echo "
    <tr height='1'>
        <td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
    </tr>
    <tr height='25'>
        <td colspan='2'>
            <img src='$hideInactiveIcon' align='absmiddle' border='0'>
            <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&hideinactive=$hideInactiveValue'>$hideInactiveText</a>$hideInactiveStats
        </td>
        <td align='right'>
            <img src='images/icon-banner-stored-d.gif' align='absmiddle' border='0'>
            <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&showbanners=$showMatchingValue'>$showMatchingText</a>
    </table>";
        if (!empty($directLinkedAds)) {
            echo "<br /><strong>{$GLOBALS['strBannerLinkedAds']}:</strong><br />";
            $aParams = array('ad_id' => implode(',', array_keys($directLinkedAds)));
            MAX_displayLinkedAdsPlacements($aParams, $publisherId, $zoneId, $hideInactive, $showParentPlacements, $pageName, $tabIndex);
        }
    }

function MAX_displayPlacementAdSelectionViewForm($publisherId, $zoneId, $view, $pageName, &$tabIndex, $aOtherZones = array())
{
    global $phpAds_TextDirection;

    $disabled = null;
    $disabledHidden = null;
    if (!empty($aOtherZones[$zoneId]['type'])) {
        if ($aOtherZones[$zoneId]['type'] == MAX_ZoneEmail) {
            $view = 'ad';
            $disabled = ' disabled';
            $disabledHidden = "<input type='hidden' name='view' value='ad' />";
        }
    }
    $placementSelected = $view == 'placement' ? ' selected' : '';
    $categorySelected = $view == 'category' ? ' selected' : '';
    $adSelected = $view == 'ad' ? ' selected' : '';

    echo "
<form name='zoneview' method='post' action='$pageName'>
<input type='hidden' name='zoneid' value='$zoneId'>
<input type='hidden' name='affiliateid' value='$publisherId'>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<tr height='25'>
<td colspan='3'><b>{$GLOBALS['strSelectZoneType']}</b></td>
</tr>
<tr height='25'>
<td>
    <select name='view' onchange='this.form.submit();' $disabled>
        <option value='placement'$placementSelected>{$GLOBALS['strCampaignDefaults']}</option>
        <!--option value='category'$categorySelected>{$GLOBALS['strLinkedCategories']}</option-->
        <option value='ad'$adSelected>{$GLOBALS['strLinkedBanners']}</option>
    </select>
    &nbsp;<input type='image' src='images/$phpAds_TextDirection/go_blue.gif' border='0'>
    $disabledHidden
</td>
</tr>
</table>";
    phpAds_ShowBreak();
    echo "
</form>
<br />";
}

function MAX_displayAcls($acls, $aParams) {
    $tabindex =& $GLOBALS['tabindex'];
    $page = basename($_SERVER['PHP_SELF']);
    $conf = $GLOBALS['_MAX']['CONF'];

    if (!empty($GLOBALS['action'])) {
        // We are part way through making changes, show a message
        //echo "<br>";
        echo "<div class='errormessage'><img class='errormessage' src='images/warning.gif' align='absmiddle'>";
        echo "<span class='tab-s'>You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished</span><br>";
        echo "</div>";
    } elseif (!MAX_AclValidate($page, $aParams)) {
        echo "<div class='errormessage'><img class='errormessage' src='images/warning.gif' align='absmiddle'>";
        echo "<span class='tab-r'>WARNING: The delivery engine limitations <strong>DO NOT AGREE</strong> with the limitations shown below<br />Please hit save changes to update the delivery engine's rules</span><br>";
        echo "</div>";
    }

    echo "<form action='{$page}' method='post'>";
    foreach ($aParams as $name => $value) {
        echo "<input type='hidden' name='{$name}' value='{$value}' />";
    }
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr><td height='25' colspan='4' bgcolor='#FFFFFF'><b>{$GLOBALS['strDeliveryLimitations']}</b></td></tr>";
    echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

    if (empty($acls)) {
        echo "<tr><td height='24' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$GLOBALS['strNoLimitations']}</td></tr>";
        echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    } else {
        echo "<tr><td height='25' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$GLOBALS['strOnlyDisplayWhen']}</td></tr>";
        echo "<tr><td colspan='4'><img src='images/break-el.gif' width='100%' height='1'></td></tr>";

        foreach ($acls as $aclId => $acl) {
            list($package, $name) = explode(':', $acl['type']);
            $deliveryLimitationPlugin = MAX_Plugin::factory('deliveryLimitations', ucfirst($package), ucfirst($name));
            $deliveryLimitationPlugin->init($acl);
            $deliveryLimitationPlugin->count = count($acls);
            if ($deliveryLimitationPlugin->isAllowed($page)) {
                $deliveryLimitationPlugin->display();
            }
        }
    }

    echo "<tr><td height='30' colspan='2'>";

    if (!empty($acls)) {
        $url = $page . '?';
        foreach ($aParams as $name => $value) {
            $url .= "{$name}={$value}&";
        }
        $url .= "action[clear]=true";
        echo "<img src='images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;
                <a href='{$url}'>{$GLOBALS['strRemoveAllLimitations']}</a>&nbsp;&nbsp;&nbsp;&nbsp;
        ";
    }

    echo "</td><td height='30' colspan='2' align='{$GLOBALS['phpAds_TextAlignRight']}'>";
    echo "<img src='images/icon-acl-add.gif' align='absmiddle'>&nbsp;";
    echo "<select name='type' accesskey='{$GLOBALS['keyAddNew']}' tabindex='".($tabindex++)."'>";

    $deliveryLimitations = MAX_Plugin::getPlugins('deliveryLimitations', null, false);
    foreach ($deliveryLimitations as $pluginName => $plugin) {
        if ($plugin->isAllowed($page)) {
            echo "<option value='{$pluginName}'>" . $plugin->package . ' - ' . $plugin->getName() . "</option>";
        }
    }

    echo "</select>";
    echo "&nbsp;";
    echo "<input type='image' name='action[new]' src='images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' align='absmiddle' alt='{$GLOBALS['strSave']}'>";
    echo "</td></tr>";

    echo "</table>";
}

function MAX_displayChannels($channels, $aParams) {
    $entityString = _getEntityString($aParams);

    echo "<br /><br />";
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

    echo "<tr height='25'><td height='25'><b>&nbsp;&nbsp;{$GLOBALS['strName']}</a></b></td>";

    echo "<td height='25'><b>{$GLOBALS['strID']}</a></td>";
    echo "<td height='25'>&nbsp;</td>";
    echo "</tr>";

    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

    if (empty($channels)) {
        echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='3'>";
        echo "&nbsp;&nbsp;{$GLOBALS['strNoChannels']}</td></tr>";

        echo "<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    } else {
        $i = 0;
        foreach ($channels as $channelId => $channel) {
            if ($i > 0) echo "<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
            echo "<td height='25'>&nbsp;&nbsp;";
            echo "<img src='images/icon-channel.gif' align='absmiddle'>&nbsp;";

            // set channel ownership info for display
            if ($GLOBALS['pageName'] != 'affiliate-channels.php') {
                if (!empty($channel['publisher_id'])) {
                    $ownerTypeStr = 'Publisher: ';
                    $publisher = Admin_DA::getPublisher($channel['publisher_id']);
                    $ownerNameStr = '[id'.$channel['publisher_id'].'] '.$publisher['name'];
                } else if (!empty($channel['agency_id']) && empty($channel['publisher_id'])
                       && !phpAds_isUser(phpAds_Agency)) {
                    $ownerTypeStr = 'Agency: ';
                    $agency = Admin_DA::getAgency($channel['agency_id']);
                    $ownerNameStr = '[id'.$channel['agency_id'].'] '.$agency['name'];
                } else {
                    $ownerTypeStr = '';
                    $ownerNameStr = '';
                }
            }
            $ownerStr = !empty($ownerTypeStr) ? '&nbsp&nbsp<i>'.$ownerTypeStr.'</i>'.$ownerNameStr : '';

            echo "<a href='channel-edit.php?{$entityString}channelid={$channel['channel_id']}'>{$channel['name']}$ownerStr</a>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
            echo "<td height='25'>{$channel['channel_id']}</td>";
            echo "<td>&nbsp;</td></tr>";

            // Description
            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
            echo "<td>&nbsp;</td>";
            echo "<td height='25' colspan='3'>".stripslashes($channel['description'])."</td>";
            echo "</tr>";

            echo "<tr height='1'>";
            echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
            echo "<td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
            echo "</tr>";
            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

            // Empty
            echo "<td>&nbsp;</td>";

            // Buttons
            echo "<td height='25' colspan='3'>";

            echo "<a href='channel-acl.php?{$entityString}channelid={$channel['channel_id']}'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='{$GLOBALS['strIncludedBanners']}'>&nbsp;{$GLOBALS['strEditChannelLimitations']}</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<a href='channel-delete.php?{$entityString}channelid={$channel['channel_id']}&returnurl=".(empty($aParams['affiliateid']) ? 'channel-index.php' : 'affiliate-channels.php')."'".phpAds_DelConfirm($GLOBALS['strConfirmDeleteChannel'])."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='{$GLOBALS['strDelete']}'>&nbsp;{$GLOBALS['strDelete']}</a>&nbsp;&nbsp;&nbsp;&nbsp;";

            echo "</td></tr>";
            $i++;
        }
        if (!empty($channels)) {
            echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
        }
    }
    echo "</table>";
}

// Determine whether an advertiser has an active placement/ad running under it...
function _isAdvertiserActive($aAdvertiserPlacementAd)
{
    $active = false;
    if (isset($aAdvertiserPlacementAd['children'])) {
        foreach($aAdvertiserPlacementAd['children'] as $aPlacementAd) {
            if (_isPlacementActive($aPlacementAd)) {
                $active = true;
                break;
            }
        }
    }
    return $active;
}

// Determine whether a placement has an active ad running under it...
function _isPlacementActive($aPlacementAd)
{
    $active = false;
    if ($aPlacementAd['active'] == 't') {
        if (isset($aPlacementAd['children'])) {
            foreach($aPlacementAd['children'] as $aAd) {
                if ($aAd['active'] == 't') {
                    $active = true;
                    break;
                }
            }
        }
    }
    return $active;
}

// Determine whether a publisher is active...
function _isPublisherActive($aPublisherZone)
{
    return true;  // for now, all publishers are active.
}

// Determine whether a zone is active...
function _isZoneActive($aZone)
{
    return true;  // for now, all zones are active.
}

function _multiSort($array, $arg1, $arg2){
        $arr1 = array();
        $arr2 = array();

        foreach ($array as $key => $value){
            $arr1[$key] = strtolower( $value[$arg1] );
            $arr2[$key] = $value[$arg2];
        }

        array_multisort($arr1, $arr2, $array);
        return $array;
}

?>