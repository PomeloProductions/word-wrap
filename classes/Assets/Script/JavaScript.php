<?php
/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 1:56 PM
 */

namespace WordWrap\Assets\Script;

use WordWrap\Assets\BaseAsset;

Class JavaScript extends BaseAsset{

    /**
     * Overrider parent constructor in order to indicate js asset
     * @param \WordWrap\LifeCycle $lifeCycle
     * @param string $templateName
     */
    public function __construct($lifeCycle, $templateName) {
        parent::__construct($lifeCycle, $templateName, "js");
    }

    /**
     * @return string any content that needs to be echoed before export
     */
    public function onPreExport() {
        return "<script type='application/javascript'>";
    }

    /**
     * @return string any content that needs to be echoed after export
     */
    public function onPostExport() {
        return "</script>";
    }
}
