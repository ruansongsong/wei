<?php
/**
 * list-tab
 *
 * Copyright (c) 2008-2010 Twin Huang. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package     Common
 * @subpackage  View
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2011-01-04 17:20:53
 */

$tabSetting[] = array(
    'url' => $url->createUrl($set, array('action' => 'Post')),
    'title' => $lang->t('LBL_ACTION_POST'),
    'icon' => 'ui-icon-script',
    'target' => null,
    'id' => null,
    'class' => null,
);
$output = '';
foreach ($tabSetting as $tab) {
    $output .= Qwin_Helper_Html::jQueryLink($tab['url'], $tab['title'], $tab['icon'], $tab['class'], $tab['target'], $tab['id']);
}
echo $output;